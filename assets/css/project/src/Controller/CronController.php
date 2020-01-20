<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Controller\Controller;

use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Error\Debugger;
use Cake\Routing\Router;
use Cake\Http\Exception;
use App\Model\Entity\User;
use Cake\Controller\ShypliteController;

class CronController extends RestController
{
	function beforeFilter(Event $event) {
	    // parent::beforeFilter($event);
         // $this->getEventManager()->off($this->Csrf);
	    $this->viewBuilder()->setLayout(false);
	    // $this->request->withData('data',array_map('trim',$this->request->getData()));
	}
	function returnexpire()
	{
		$connection = ConnectionManager::get('default');
		// $order	=	$quote_item_table->find()->where(['order_expire'=>'n','order_status NOT IN '=>[4,5,6,7,8,11]])->order(['expire_utc'=>'ASC'])->toArray();
		$q="select i.*,s.delay_penalty,s.manual_ship as s_manual_ship from  sales_flat_quote_item as i inner join users as s on s.id=i.seller_id where order_status='6' and return_time='y' order by item_id asc limit 0,30";
		$order = $connection->execute($q)->fetchAll('assoc');
		if(count($order)>0)
		{
			// pr($order);
			// die;
			$date = date('Y-m-d H:i:s');
			$current_utc=strtotime($date);
			foreach($order as $o)
			{
				$item_id=$o['item_id'];
				$deliver_date=$o['deliver_date'];
				$extra_date=date('Y-m-d H:i:s', strtotime($deliver_date. ' + 5 days'));
				$extra_utc=strtotime($extra_date);
				if($current_utc>$extra_utc)
				{
					// return time expire
					echo $query="UPDATE `sales_flat_quote_item` SET is_return_applicable='expire',return_time='n' where item_id='$item_id'";
					echo "</br>";
					$q2 = $connection->execute($query);
				}
			}
		}
		die;
	}
	function deleteorder($o,$order_utc)
	{
		// pr($o);
		// die;
		$connection = ConnectionManager::get('default');
		$o_status=false;
		if($o['order_status']==1)
		{
			// pr($o);
			// die;
			$delay_penalty=$o['delay_penalty'];
			$item_id=$o['item_id'];
			 $item_order_id=$o['item_order_id'];
			$Tras = TableRegistry::get('Transaction');
			$usertras=$Tras->find()->where(['item_order_id'=>$item_order_id,'user_type'=>'1','order_status'=>'onprocess'])->first();
			// pr($usertras);
			// die;
			if($delay_penalty>0)
			{
				// cancel benfit from user
				$ct['user_id']=$o['seller_id'];
				$ct['amount']=$delay_penalty;
				$ct['user_type']=2;
				$ct['item_order_id']=$item_order_id;
				$ct['created_date']=$order_utc;
				$ct['payment_type']="deduct";
				$ct['payment_status']="declinesupplier";
				$ct['comment']="Order Rejected Due to Delay in Acceptance";
				// $usertras->payment_status="declinesupplier";
				// $usertras->order_status="onprocess";
				// $Tras->save($usertras);
				$this->addtransaction($ct);
			}
			if($usertras)
			{
				$usertras->payment_status="declinesupplier";
				// $usertras->order_status="onprocess";
				$Tras->save($usertras);
			}
			echo $query="UPDATE `sales_flat_quote_item` SET `order_status` = '11',cancel_type='supplierreject',cancel_utc='$order_utc',order_expire='y',process_status='declinesupplier' where item_id='$item_id'";
			$q2 = $connection->execute($query);
			$o_status=true;
		}
		// die;
		return $o_status;
	}
	public function addtransaction($t)
	{
		// pr($t);
		// die;
		$Tras = TableRegistry::get('Transaction');
		$entity =	$Tras->newEntity($t);
		$trasresult	=	$Tras->save($entity);
	}

	function trackdetail()
	{
		$quote_item_table=TableRegistry::get('QuoteItem');
		$miss_ids=array('4');
		$order	=	$quote_item_table->find()->where(['order_status >'=>'1','awbNo'=>'','order_status NOT IN '=>[3,4,5,6,7,8,9,10,11]])->order(['item_id'=>'DESC'])->toArray();

		// pr($order);
		// die;
		if(count($order)>0)
		{
			$i=0;
			foreach($order as $itemorder)
			{
				$track_status=$itemorder['track_status'];
				 $awbNo=$itemorder['awbNo'];
				 $order_status=$itemorder['order_status'];
				  $shyplite_order_id=$itemorder['item_order_id'];
				// die;
				if($shyplite_order_id)
				{
					if($awbNo=='')
					{
						$timestamp = time();
						$auth=$this->authenticatShyplite($timestamp);
						if($auth['status'])
						{
							$appID=$auth['appID'];
							$sellerid=$auth['sellerid'];
							$userToken=$auth['userToken'];
							$key=$auth['key'];
							$sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
							$authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $userToken, true)));
							$ch = curl_init();
							$header = array(
									"x-appid: $appID",
									"x-timestamp: $timestamp",
									"x-sellerid:15288",
									"Authorization: $authtoken"
								);
							// pr($header);
							// die;
							// echo $shyplite_order_id;
							curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/getSlip?orderID='.urlencode($shyplite_order_id));
							curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$cresponse = curl_exec($ch);
							$slip_json=json_decode($cresponse,true);
							// pr($slip_json);
							// die;
							if($slip_json['carrierName'] && ($slip_json['status']=="success" || $slip_json['status']=="pending"))
							{
								if($slip_json['carrierName'] && $itemorder->carrierName=='')
								{
										$itemorder->carrierName=$slip_json['carrierName'];
								}
								if($slip_json['awbNo'] && $itemorder->awbNo=='')
								{
									$awbNo=$itemorder->awbNo=$slip_json['awbNo'];
								}
								if($slip_json['manifestID'] && $itemorder->manifestID=='')
								{
									$itemorder->manifestID=$slip_json['manifestID'];
								}
								if($slip_json['s3Path'] && $itemorder->shipment_pdf=='')
								{
									$url=$slip_json['s3Path'][0];
									$uni_id=$shyplite_order_id."_shipment";
									// echo $url;
									// die;
									if($url)
									$itemorder->shipment_pdf=$this->downloadfile("shipment",$url,$uni_id);

								}
							}
						}

						$i++;
					}
				}
				// pr($itemorder);
				// die;
				$quote_item_table->save($itemorder);


			}
			echo "Total Order Updated ".$i;
		}
		else
		{
			echo "No order Now to fetch";
			die;
		}
		die;
	}
	public function statusupdate()
	{
		$quote_item_table=TableRegistry::get('QuoteItem');
		$miss_ids=array('4');
		$connection = ConnectionManager::get('default');
		// $order	=	$quote_item_table->find()->where(['order_expire'=>'n','order_status NOT IN '=>[4,5,6,7,8,11]])->order(['expire_utc'=>'ASC'])->toArray();
		 $q="select i.*,s.delay_penalty,s.manual_ship as s_manual_ship from  sales_flat_quote_item as i inner join users as s on s.id=i.seller_id where order_expire='n' and `last_track_time` < (NOW() - INTERVAL 60 MINUTE)
		 and order_status not in('6','12','7','8','4') order by expire_utc asc limit 0,50";
			$order = $connection->execute($q)->fetchAll('assoc');
		// pr($order);
		// die;
		if(count($order)>0)
		{

			$date = date('Y-m-d H:i:s');
			$current_utc=strtotime($date);
			$c=0;
			$quote_item_table=TableRegistry::get('QuoteItem');
			foreach($order as $o)
			{
				// pr($o);
				// die;
				$orderId=$o['item_order_id'];
				$itemorder	=	$quote_item_table->find()->where(['item_order_id'=>$orderId])->first();
				extract($o);
				$awbNo=$o['awbNo'];

				$order_status=$o['order_status'];
				$manifestID=$o['manifestID'];
				$mainfest_pdf=$o['mainfest_pdf'];
				$shyplite_order_id=$o['item_order_id'];
				// echo $order_status;
				// die;

				if($order_status==1)
				{
					if($expire_utc<$current_utc)
					{

						// delete non accepted order
						$this->deleteorder($o,$current_utc);
					}
				} else
				{
					// $manual_ship=$o['manual_ship'];
					$manual_ship=$o['s_manual_ship'];
					$delivery_date=$itemorder->delivery_date;
					if($manual_ship=="n")
					{
						$timestamp = time();
						$auth=$this->authenticatShyplite($timestamp);

						if($auth['status'])
						{
							$appID=$auth['appID'];
							$sellerid=$auth['sellerid'];
							$userToken=$auth['userToken'];
							$key=$auth['key'];
							$sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
							$authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $userToken, true)));
							$ch = curl_init();
							$header = array(
									"x-appid: $appID",
									"x-timestamp: $timestamp",
									"x-sellerid:15288",
									"Authorization: $authtoken"
								);
						}

						if($awbNo=='' || $manifestID=='')
						{
							// echo "blank";
							// die;
							// pr($header);
								// die;
								// echo $shyplite_order_id;
								curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/getSlip?orderID='.urlencode($shyplite_order_id));
								curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								$cresponse = curl_exec($ch);
								$slip_json=json_decode($cresponse,true);
								// pr($slip_json);
								// die;
								if($slip_json['carrierName'] && ($slip_json['status']=="success" || $slip_json['status']=="pending"))
								{
									if($slip_json['carrierName'] && $itemorder->carrierName=='')
									{
											$itemorder->carrierName=$slip_json['carrierName'];
									}
									if($slip_json['awbNo'] && $itemorder->awbNo=='')
									{
										$awbNo=$itemorder->awbNo=$slip_json['awbNo'];
									}
									if($slip_json['manifestID'] && $itemorder->manifestID=='')
									{
										$manifestID=$itemorder->manifestID=$slip_json['manifestID'];

									}
									if($slip_json['s3Path'] && $itemorder->shipment_pdf=='')
									{
										$url=$slip_json['s3Path'][0];
										$uni_id=$shyplite_order_id."_shipment";
										// echo $url;
										// die;
										if($url)
										$itemorder->shipment_pdf=$this->downloadfile("shipment",$url,$uni_id);

									}
								}
								else
								{

								}


							$quote_item_table->save($itemorder);
						}
						// echo $manifestID;
						// echo $mainfest_pdf;
						// die;
						if($manifestID && $mainfest_pdf=='')
										{
											curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/getManifestPDF/'.$manifestID);
											curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
											$server_output = curl_exec($ch);
											$mainfest_json=json_decode($server_output, true);
											// pr($mainfest_json);
											// die;
											if($mainfest_json['s3Path'])
											{
												$url=$mainfest_json['s3Path'];
												$uni_id=$orderId."_mainfest";
												if($url)
												{
													$mainfest_pdf=$data['mainfest_pdf']=$this->downloadfile("mainfest",$url,$uni_id);
													$data['status']=true;
												}
												else
												{
													$data['status']=false;
												}
											}
										}
						if($awbNo)
						{

							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/track/'.$awbNo);
							curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$track_output = curl_exec($ch);
							$res=json_decode($track_output,true);

							$events=$res['data']['events'];
							// pr($events);
							// die;
							$countall=count($events);
							$track_s=$events[0];
							$is_return_applicable='n';
							$is_feedback_applicable='n';
							if($track_s)
							{
								$track_status=$track_s['status'];

								$Remarks=$track_s['Remarks'];
								$Time=$track_s['Time'];
								// $last_track_utc_time=strtotime($Time);
								$current_date=date('Y-m-d H:i:s');
								$last_track_utc_time=strtotime($current_date);
								if($track_status=="OD" || $track_status=="IT")
								{
									$order_status=3;
								}
								if($track_status=="DL")
								{
									$order_status=6;
									$is_return_applicable="y";
									$is_feedback_applicable="y";
									$delivery_date=$date;
									$quote_item_table=TableRegistry::get('QuoteItem');
									$Tras = TableRegistry::get('Transaction');
									$itemorder	=	$quote_item_table->find()->where(['item_order_id'=>$select_order_id])->contain(['Product']) ->first();
									$awbNo=$itemorder['awbNo'];
									$product_id=$itemorder->product_id;
									$current_date=date('Y-m-d H:i:s');
									$size_name=$itemorder['size_name'];
									$qty=(int)$itemorder['qty'];
									$p_name=$itemorder['product']['name_en'];
									$save_Date=date('d-m-y h:i A',strtotime($current_date));
									$awbNo=$itemorder['awbNo'];
									$carrierName=$itemorder['carrierName'];
								}
							}
							   echo $query="UPDATE `sales_flat_quote_item` SET is_return_applicable='$is_return_applicable',is_feedback_applicable='$is_feedback_applicable',delivery_date='$delivery_date',deliver_date='$delivery_date',last_track_time='$current_date',track_code='$track_status',track_status='$track_output',manifestID='$manifestID',mainfest_pdf='$mainfest_pdf',awbNo='$awbNo',`order_status` = '$order_status',track_remark='$Remarks',last_track_utc_time='$last_track_utc_time',track_code='$track_status' where item_order_id='$shyplite_order_id'";
							echo "</br>";
							$q2 = $connection->execute($query);
							// die;
						}
					}
					else
					{
						$current_date=date('Y-m-d H:i:s');
						$last_track_utc_time=strtotime($current_date);
						 echo $query="UPDATE `sales_flat_quote_item` SET last_track_time='$current_date',
						 last_track_utc_time='$last_track_utc_time' where item_order_id='$shyplite_order_id'";
							echo "</br>";
							$q2 = $connection->execute($query);
					}
				}
				$c++;
			}
		}
		echo "Total order Process".$c;
		die;

	}
	public function shypliteplaceorderdummy()
	{
		$d['shyplite_order_id']=188047;
		$d['shyplite_amount']=148;
		$d['shyplite_selected_mode']="Air";
		$d['status']=true;
        return $d;
	}
	public function downloadfile($dest,$url,$uni_id)
	{
		$destination_folder = WWW_ROOT.$dest."/";
		// $url ="http://www.africau.edu/images/default/sample.pdf";
		// $newfname = $destination_folder . basename($url);
		$newfname = $destination_folder .$uni_id.".pdf";

		$file = fopen ($url, "rb");
		if ($file) {
		  $newf = fopen ($newfname, "wb");

		  if ($newf)
		  while(!feof($file)) {
			fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
		  }
		}

		if ($file) {
		  fclose($file);
		}

		if ($newf) {
		  fclose($newf);
		}
		$f_url="http://resellermantra.com/".$dest."/".$uni_id.".pdf";
		return  $f_url;
	}
	function authenticatShyplite($timestamp) {
     $email =  "resellermantra@gmail.com";
    $password = "goldopium*1";


    $appID = 2812;
    $sellerid = 15288;
    $key = 'IQl7NMvNFTw=';
    $secret = '6blpiawaAKCgo804JU95aOsh0bPu63ibBFVZRycr+/G+4/SEX8kM+TQA6liAExsHlNRO45wQzeh0raimrqVMjw==';

    $sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
    $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
    $ch = curl_init();

    $header = array(
        "x-appid: $appID",
        // "x-sellerid   : $sellerid",
        "x-timestamp: $timestamp",
        "Authorization: $authtoken"
    );

    curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/login');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "emailID=$email&password=$password");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
	$server_output=json_decode($server_output, true);
	// print_R($server_output);
	// die;
	   if($server_output['userToken'])
	   {
		   $s['userToken']=$server_output['userToken'];
		   $s['authtoken']=$authtoken;
		   $s['sellerid']=$sellerid;
		   $s['appID']=$appID;
		   $s['key']=$key;
		   $s['status']=true;

	   }
	   else
	   {
		     $s['status']=false;
	   }
	   return $s;
		curl_close($ch);
	}
}
?>
