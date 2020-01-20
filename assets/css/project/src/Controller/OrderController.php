<?php
namespace App\Controller;
use Cake\Core\Configure;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Error\Debugger;
use Cake\Http\Exception;
class OrderController extends AppController
{
		function beforeFilter(Event $event) {
	    parent::beforeFilter($event);
	    // $this->getEventManager()->off($this->Csrf);
	    $this->viewBuilder()->setLayout('admin');
		
		  
		}
		public function neworder()
		{
			$connection = ConnectionManager::get('default');
			if(!$this->Auth->user('id')){
    		return $this->redirect($this->Auth->logout());
			}
			$order_table = TableRegistry::get('Order');
			$userdata=$this->Auth->user();
			$user_id=$userdata['id'];
			$accept_time=$userdata['accept_time'];
			$current_date=date('Y-m-d H:i:s');
			$current_utc=strtotime($current_date);
			 $query="select i.*,p.name_en,p.pic as product_pic from sales_flat_quote_item as i inner join catalog_product_entity as p on p.id=i.product_id
			where i.process_status='orderplace' and order_utc<=$current_utc and i.seller_id='$user_id' order by i.order_utc asc limit 0,100"; 
			$orderlist = $connection->execute($query)->fetchAll('assoc');
			$this->set(compact('orderlist'));
		  
		}
	function authenticatShyplite($timestamp) {
    $email =  "sam.sourabh@gmail.com";
    $password = "12345678";

   
    $appID = 2383;
    $sellerid = 9600;
    $key = 'WWu9nhly2i0=';
    $secret = 'G8zu5XIDJyqBNcZEOpnq7b6XbCXPYABWG3yR+JvOkXS67P3I6zruusw4Z7f2Qt5wbncrhuCIKNqPZzqnIk84rw==';

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
		public function mainfest()
		{
			$connection = ConnectionManager::get('default');
			$order_data=[];
			$user_id=$this->Auth->user('id');
			$login_role=$this->Auth->user('login_role');
			// echo "select i.manifestID,i.mainfest_pdf from sales_flat_quote_item as i where i.seller_id='$user_id' and manifestID!='' group by manifestID";
			// die;
			$orderlist = $connection->execute("select i.carrierName,i.add_utc,i.item_order_id,i.item_id,i.manifestID,i.mainfest_pdf from sales_flat_quote_item as i where i.seller_id='$user_id' and manifestID!='' group by manifestID")->fetchAll('assoc');
			// pr($orderlist);
			// die;
			$i=0;
			foreach($orderlist as $s)
			{
				$mainfest_pdf=$s['mainfest_pdf'];
				$orderId=$s['item_order_id'];
				$item_id=$s['item_id'];
				 $manifestID=$s['manifestID'];
				
				
					$pdf_link=$this->mainfestdata($manifestID,$orderId);
					if($pdf_link['status'])
					{
						$mainfest_pdf=$order_data[$i]['mainfest_pdf']=$pdf_link['mainfest_pdf'];
						$connection->execute("update sales_flat_quote_item set mainfest_pdf='$mainfest_pdf' where item_id='$item_id'");
					}
				
				// else
				// {
					// $order_data[$i]['mainfest_pdf']=$mainfest_pdf;
				// }
				$order_data[$i]['manifestID']=$s['manifestID'];
				$order_data[$i]['carrierName']=$s['carrierName'];
				$order_data[$i]['add_utc']=$s['add_utc'];
				$i++;
			}
			// pr($order_data);
			// die;
			$this->set(compact('order_data'));
		}
		public function mainfestdata($manifestID,$orderId)
		{
			$timestamp = time();
			$auth=$this->authenticatShyplite($timestamp);
			$data['status']=false;
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
							"x-sellerid:9600",
							"Authorization: $authtoken"
						);
				// pr($header);
				// die;
				if($manifestID)
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
							$data['mainfest_pdf']=$this->downloadfile("mainfest",$url,$uni_id);
							$data['status']=true;
						}
						else
						{
							$data['status']=false;
						}
					}
				}
			}
			return $data;
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
			$f_url="http://52.66.195.100/".$dest."/".$uni_id.".pdf";
			return  $f_url; 
		}
		public function orderdetail()
		{
			$this->viewBuilder()->setLayout(false);    
			$item_id =$this->request->getQuery('id');
			
			$conn = ConnectionManager::get('default');
			if($item_id)
			{
				 
				 $query="select i.*,i.base_price as sale_base,p.percantage_value,p.primary_price as orignal_value,p.*,o.discount_amount,o.billing_address_id,o.shipping_amount,o.cod_amount,r.mobile as reseller_mobile,r.display_name as reseller_name,r.fullname as reseller_fullname,s.display_name as supllier_name,s.user_rating as supplier_rating,s.mobile as supplier_mobile,
				 u.fullname as user_name,u.mobile as user_mobile from sales_flat_quote_item as i inner join catalog_product_entity as 
				 p on p.id=i.product_id inner join sales_flat_order as o on o.increment_id=i.order_id inner join users as s on s.id=p.seller_id inner join users as r on r.id=i.customer_id inner join users as u on u.id=i.customer_id where i.item_order_id='$item_id'  order by i.order_utc desc limit 0,1"; 
			
				$o = $conn->execute($query)->fetch('assoc');
				$showordermsg=$this->showordermsg2($o['order_status'],$o['cancel_type']);
				$o['show_status']=$showordermsg['show_status'];
				$o['s_color']=$showordermsg['s_color'];
				$arr=array('8','10');
				if(in_array($data['order_status'],$arr)==true)
				$o['color']="white";
				else
				$o['color']="black";	  
				$seller_address_id=$o['seller_address_id'];
				$billing_address_id=$o['billing_address_id'];
				$AddresTable 	=	TableRegistry::get('Address');
				$s_address = $AddresTable->find()->where(['entity_id'=>$seller_address_id])->first();
				$cus_address = $AddresTable->find()->where(['entity_id'=>$billing_address_id])->first();
				// pr($o);
				// die;
				$this->set(compact('o','s_address','cus_address'));
			}
			
			
		}
		public function addextra()
		{
			$Tras = TableRegistry::get('Transaction');
			if ($this->request->is('post')) {
				$request = $this->request->getData();
				// pr($request);
				// die;
				extract($request);
				if($status_type=="waiver")
				{
					
					$ct['payment_type']="weiver";
					if($wav_type=="bonus")
					$ct['comment']="Bonus";
					else
					$ct['comment']="weiver";
				}
				else if($status_type=="penlty")
				{
					$ct['payment_type']="penlty";
					if($wav_type=="extra")
					$ct['comment']="Pently";
					else
					$ct['comment']="Pently";
					
				}
				if($comment)
				{
					$ct['comment']=$comment;
				}
				$order_date=date('Y-m-d H:i:s');
				$order_utc=strtotime($order_date);
				$amount=abs($amount);
				$ct['amount']=(int)$amount;
				$ct['bill_amount']=(int)$amount;
				$ct['user_type']=$wav_for;
				if($process_order_id)
				$ct['item_order_id']=$process_order_id;
				
				if($process_order_id)
				{
					$quote_item_table=TableRegistry::get('QuoteItem');
					$itemorder	=	$quote_item_table->find()->where(['item_order_id'=>$process_order_id]) ->first();
					if($wav_for==1)
					{
						if($reseller_id=='')
						$ct['user_id']=$itemorder->customer_id;	
						else
						$ct['user_id']=$reseller_id;
					}
					else
					{
						if($supplier_id=='')
						$ct['user_id']=$itemorder->seller_id;	
						else
						// $ct['user_id']=$reseller_id;
						$ct['user_id']=$supplier_id;
					}
				}
				if($user_id && $user_id!="all")
					$ct['user_id']=$user_id;
				$ct['created_date']=$order_date;
				$ct['process_date']=$order_date;
				$ct['created_utc']=$order_utc;
				$ct['payment_status']="approved";
				$ct['payment_process']="n";
				$ct['order_status']="completed";
				// pr($ct);
				// die;
				$entity =	$Tras->newEntity($ct);
		$trasresult	=	$Tras->save($entity);
			//$ct['comment']="New order Placed";
			}
			if($status_type=="waiver")
			$this->redirect(['action' => 'weiver']);
			if($status_type=="penlty")
			$this->redirect(['action' => 'penlty']);
		}
		public function checkwaiver()
		{
			$Tras = TableRegistry::get('Transaction');
			if ($this->request->is('post')) {
				$request = $this->request->getData();
				extract($request);
				$quote_item_table=TableRegistry::get('QuoteItem');
				$itemorder	=	$quote_item_table->find()->where(['item_order_id'=>$id]) ->first();
				if($itemorder)
				{
				$user_tra = $Tras->find();
				$orderlist =$user_tra->select(['sum' => $user_tra->func()->sum('Transaction.amount')])->where(['item_order_id'=>$id,'payment_type'=>'weiver'])->first();
				// pr($orderlist);
				// die;
				$total = $orderlist->sum; //your total sum result
				// $orderlist = $Tras
						// ->find()
						
						// ->where(['item_order_id'=>$id])
						// ->order(['id'=>'desc'])
						// ->first();
				// pr($orderlist);
				if($total)
				{
					$quote_item_table=TableRegistry::get('QuoteItem');
					$quotedata = $quote_item_table
						->find()
						// ->select(['id','fullname'])
						->where(['item_order_id'=>$id])
						// ->order(['item'=>'desc'])
						->first();
					// $r['amount']=$orderlist->amount;
					$r['amount']=$total;
					$r['supplier_id']=$quotedata->seller_id;
					$r['reseller_id']=$quotedata->customer_id;
					$r['status']=true;
				}
				else
				{
					$r['status']=false;
					$r['msg']="No Past Weiver Found";
				}
				}
				else
				{
					$r['status']=false;
					$r['msg']="Invalid order id";
				}
				
			}
			echo json_encode($r);
			die;
		}
		public function checkpenlty()
		{
			$Tras = TableRegistry::get('Transaction');
			if ($this->request->is('post')) {
				$request = $this->request->getData();
				extract($request);
				$user_tra = $Tras->find();
				$orderlist =$user_tra->select(['sum' => $user_tra->func()->sum('Transaction.amount')])->where(['item_order_id'=>$id,'payment_type'=>'penlty'])->first();
				// pr($orderlist);
				// die;
				$total = $orderlist->sum; //your total sum result
				// $orderlist = $Tras
						// ->find()
						
						// ->where(['item_order_id'=>$id])
						// ->order(['id'=>'desc'])
						// ->first();
				// pr($orderlist);
				if($total)
				{
					$quote_item_table=TableRegistry::get('QuoteItem');
					$quotedata = $quote_item_table
						->find()
						// ->select(['id','fullname'])
						->where(['item_order_id'=>$id])
						// ->order(['item'=>'desc'])
						->first();
					// $r['amount']=$orderlist->amount;
					$r['amount']=$total;
					$r['supplier_id']=$quotedata->seller_id;
					$r['reseller_id']=$quotedata->customer_id;
					$r['status']=true;
				}
				else
				{
					$r['status']=false;
					$r['msg']="Invalid Order Id";
				}
			}
			echo json_encode($r);
			die;
		}
		public  function paynow()
		{
			$current_date=date('Y-m-d H:i:s');
			if ($this->request->is('post')) {
				$Payoff = TableRegistry::get('Payoff');
				$request=$this->request->getData();
				extract($this->request->getData());
				// pr($this->request->getData());
				// die;
				$conn = ConnectionManager::get('default');
				if($user_id)
				{
					$table = TableRegistry::get('Users');
					$result	=	$table->find()->where(['id'=>$user_id])->first();
					if($start_date=="ALL")
					{
					   	$request['start_date']=$result->created_date;
					}
					
					if($total_wavies=='')
						$request['total_wavies']=0;
					if($total_penlty=='')
						$request['total_penlty']=0;
					if($total_wavies=='')
						$request['total_wavies']=0;
					if($past_hold=='')
						$request['past_hold']=0;
					$extrafilter='';
					$filter='';
					if($start_date && $start_date!='ALL')
					{
						$s_date=strtotime($start_date);
						$extrafilter.="and t.created_utc>='$s_date'";
					}
					if($end_date)
					{
						$e_date=strtotime($end_date);
						$extrafilter.="and t.created_utc<='$e_date'";
					}
					$q="select t.id,t.item_order_id from user_transaction as t  where t.payment_status not in('requested','credited','hold','decline') and user_id='$user_id'
						$filter $extrafilter order by t.id desc";
					$traslist = $conn->execute($q)->fetchAll('assoc');
					if(count($traslist)>0)
					{
						$tcount=0;
						$scount=0;
						$sarray=[];
						$item_id_array=[];
						$trasarray=[];
						foreach($traslist as $t)
						{
							$trasarray[$tcount]=$t['id'];
							$item_order_id=$item_id_array[$tcount]=$t['item_order_id'];
							if($item_order_id)
							{
								$sarray[$scount]=$item_order_id;
								$scount++;
							}
							$tcount++;
						}
					}
					else
					{
						// $request['']
					}
					$cur_date=date('Y-m-d H:i:s');
					if(count($trasarray)>0)
					{
						$tras_str=implode(',',$trasarray);
						// echo "update user_transaction set payment_status='requestedpayment',payment_invoice_date='$cur_date' where id in($tras_str)";
						// die;
						$traslist = $conn->execute("update user_transaction set comment='Payment Process',payment_status='requestedpayment',payment_invoice_date='$cur_date' where payment_status not in('requested','credited','hold','decline') and id in($tras_str) and hold_status='n' and tras_status='1'");
					  $request['tras_ids']=$tras_str;   
					  $request['invoice_count']=count($trasarray);
					}
					if(count($item_id_array)>0)
					{
						$item_str=implode(',',$item_id_array);
						$request['item_order_ids']=$item_str;
					}
					// pr($trasarray);
					// pr(array_unique($sarray));
					// die;
					$entity = $Payoff->newEntity($request);
					if($Payoff->save($entity))
					{
						$result->last_payment_date=$current_date;
						// pr($result);
						// die;
						$table->save($result);
					}
				}
			}
			return $this->redirect(['action' => 'report']);
		}
		public function confirmbankpayment()
		{
			$conn = ConnectionManager::get('default');
			if ($this->request->is('post')) {
				$Payoff = TableRegistry::get('Payoff');
				$request=$this->request->getData();
				extract($request);
				$pdetail=$Payoff->find()->where(['id'=>$payoff_id,'user_id'=>$user_id,'total_amount'=>$total_amount])->first();
				if($pdetail)
				{
					$cur_date=date('Y-m-d H:i:s');
					$cur_utc=strtotime($cur_date);
					// pr($pdetail);
					// die;
					$tras_str=$pdetail->tras_ids;
					$item_str=$pdetail->item_order_ids;
					$pdetail->payment_status="paid";
					$pdetail->payment_date=$cur_date;
					if($bank_ref_id)
					$pdetail->bank_ref_id=$bank_ref_id;
					if($Payoff->save($pdetail))
					{
						// echo "update user_transaction set comment='Previous Hold',hold_status='n' where user_id='$user_id' and hold_status='n' and id in($tras_str)";
						// die;
					
						$trasarray=explode(',',$tras_str);
						$item_id_array=explode(',',$item_str);
						if(count($trasarray)>0)
						{
							// $tras_str=implode(',',$trasarray);
							// echo "update user_transaction set comment='Payment Done',payment_status='paymentdone',payment_date='$cur_date' where id in($tras_str)";
							// die;
							$traslist = $conn->execute("update user_transaction set comment='Payment Done',payment_status='paymentdone',payment_date='$cur_date'  where user_id='$user_id' and id in($tras_str) and hold_status='n' and tras_status='1'");
						 
						}   
							$unholdlist = $conn->execute("update user_transaction set comment='Previous Hold',process_date='$cur_date',hold_status='n' where user_id='$user_id' and hold_status='y'  and id in($tras_str)");
						
						if(count($item_id_array)>0)
						{
							$item_str=implode(',',$item_id_array);
							$traslist = $conn->execute("update sales_flat_quote_item set payment_status='made',payment_process_utc='$cur_utc',order_status='10' where item_order_id in($item_str) and order_status='9'");
						 
						}
					}
					else
					{
						
					}
					
				}
				else
				{
					
				}
			}
			return $this->redirect(['action' => 'payoff']);
		}
		public function acceptorder()
		{   
			// if ($this->request->is('post')) {
				$seller_id=$this->Auth->user('id');
				$seller_id=3;
				$Order = TableRegistry::get('Order');
			    $orderdata = $Order->find()->contain(['QuoteItem'=>function($q){
    				return $q->select(['primary_price','share_text','name','item_id','product_id','price','base_price','quote_id','qty','off','extra_text','cod_text','market_price','my_earning','market_string','shipping_charges','cod'])
					->where(['process_status'=>'oncart']);
				}])
				->all();
				pr($orderdata);
				die;
			// }   
			
		}
		
		public function trackorder()
		{
			$this->viewBuilder()->setLayout(false);
			$id=$this->request->query['id'];
			$manual_ship=$this->request->query['manual_ship'];
			$quote_item_table=TableRegistry::get('QuoteItem');
			$i	=	$quote_item_table->find()->where(['item_order_id'=>$id])->first();
			// pr($i);
			// die;
			$this->set(compact('i','manual_ship'));
		
		}
		public function trackurl()
		{
			$this->viewBuilder()->setLayout(false);
			$quote_item_table=TableRegistry::get('QuoteItem');
			
				if ($this->request->is('post')) {
				// pr($this->request->getData());
				// die;
				$select_order_id=$this->request->getData('select_order_id');
				$i	=	$quote_item_table->find()->where(['item_order_id'=>$select_order_id])->first();
				// pr($i);
				// die;
				if($i)
				{
					$track_url=$this->request->getData('track_url');
					$awbNo=$this->request->getData('awbNo');
					$carrierName=$this->request->getData('carrierName');
					$i->track_url=$track_url;
					$i->awbNo=$awbNo;
					if($carrierName)
					$i->carrierName=$carrierName;	
					// pr($i);
					// die;
					if($quote_item_table->save($i))
					{
						$this->Flash->success(__('Track Status Updated'));
					}
					else
					{
						$this->Flash->error(__('Fail to Save'));
					}
					$this->redirect(['action'=>'index']);
				}
			}
		}
		public function makeprepayment()
		{
			if ($this->request->is('post')) {
				$request=$this->request->getData();
				extract($request);
				$quote_item_table=TableRegistry::get('QuoteItem');
				 $itemorder = $quote_item_table
						->find()
						// ->select(['id','fullname'])
						->where(['item_order_id'=>$select_order_id,'return_time'=>'n','order_status'>'6'])
						->first();
				if($itemorder)
				{
					$customer_id=$itemorder->customer_id;
					$seller_id=$itemorder->seller_id;
					$order_date=date('Y-m-d H:i:s');
					$order_utc=strtotime($order_date);
					$itemorder->makeprepayment="y";
					$itemorder->is_return_applicable="n";
					$itemorder->approve_by=$approve_by;
					// $itemorder->payment_process_utc=$order_utc;
				
					if($quote_item_table->save($itemorder))
					{
						// payment processing for both reseller and supplier side
						// $connection = ConnectionManager::get('default');
						// $q1 = $connection->execute("update user_transaction set payment_status='approved',order_status='completed',process_date='$order_date' where user_id='$customer_id' and user_type='1'");
						// $q2 = $connection->execute("update user_transaction set payment_status='approved',order_status='completed',process_date='$order_date' where user_id='$seller_id' and user_type='2'");
						$res['status']=true;
						$res['msg']="Order Process For Payment";
						
					}   
				}   
				else
				{
					$res['status']=false;
					$res['msg']="Invalid Order Id";
				}
			}
			$this->redirect(['action'=>'d5order']);
		}
		public function makepayment()
		{
			if ($this->request->is('post')) {
				$request=$this->request->getData();
				extract($request);
				$quote_item_table=TableRegistry::get('QuoteItem');
				 $itemorder = $quote_item_table
						->find()
						// ->select(['id','fullname'])
						->where(['item_order_id'=>$select_order_id,'return_time'=>'n','order_status'>'6'])
						->first();
				if($itemorder)
				{
					$customer_id=$itemorder->customer_id;
					$seller_id=$itemorder->seller_id;
					$order_date=date('Y-m-d H:i:s');
					$order_utc=strtotime($order_date);
					$itemorder->final_approve_by=$final_approve_by;
					$itemorder->payment_status="requested";
					$itemorder->order_status="9";
					$itemorder->is_return_applicable="expire";
					$itemorder->payment_process_utc=$order_utc;
				
					if($quote_item_table->save($itemorder))
					{
						// payment processing for both reseller and supplier side
						$connection = ConnectionManager::get('default');
						$q1 = $connection->execute("update user_transaction set payment_status='approved',order_status='completed',process_date='$order_date' where user_id='$customer_id' and user_type='1' and item_order_id='$select_order_id'");
						$q2 = $connection->execute("update user_transaction set payment_status='approved',order_status='completed',process_date='$order_date' where user_id='$seller_id' and user_type='2' and item_order_id='$select_order_id'");
						$res['status']=true;
						$res['msg']="Order Process For Payment";
						
					}   
				}   
				else
				{
					$res['status']=false;
					$res['msg']="Invalid Order Id";
				}
			}
			$this->redirect(['action'=>'d5order2']);
		}
		public function index()
		{
			$product_data=[];
			$user_id=$this->Auth->user('id');
			$login_role=$this->Auth->user('login_role');
			$s_filter='';
			if($login_role==2)
				$s_filter="and i.customer_id='$user_id'";
			if($login_role==3)
				$s_filter="and i.seller_id='$user_id'";
			if ($this->request->is('post')) {
				// pr($this->request->getData());die;  
				$daterang=$this->request->getData('daterange');
				// $daterang=$this->request->getData('daterange');
				$request=$this->request->getData();
				extract($request);
				$filter='';

				if($seller_id && $seller_id!='all')
					$filter="and i.seller_id='$seller_id'";
				if($reseller_id && $reseller_id!='all')
					$filter.="and i.customer_id='$reseller_id'";
				if($status_id && $status_id!='all')
					$filter.="and i.order_status='$status_id'";
				$d_a=explode('-',$daterang);
				$start_date=strtotime($d_a[0]);
				$end_date=strtotime($d_a[1]);

				$this->set(compact('status_id'));
				if($start_date!=$end_date){
					$q="select i.*,i.base_price as sale_base,p.percantage_value,p.primary_price as orignal_value,p.*,o.discount_amount,o.shipping_amount,o.cod_amount,
					s.manual_ship,s.id as sid,s.display_name as seller_name,r.display_name as r_name,r.id as rid,p.pic as pic,a.name as aname,a.zipcode from sales_flat_quote_item as i inner join users as s 
					on s.id=i.seller_id  inner join sales_flat_order as o on o.increment_id=i.order_id inner join users as r on r.id=i.customer_id inner join catalog_product_entity as p on p.id=i.product_id inner join customer_address_entity as a on i.billing_address_id=a.entity_id where i.add_utc >= '$start_date'
					AND i.add_utc <='$end_date' $filter $s_filter order by item_order_id desc";
				} else{
					$q="select i.*,i.base_price as sale_base,p.percantage_value,p.primary_price as orignal_value,p.*,o.discount_amount,o.shipping_amount,o.cod_amount,
					s.manual_ship,s.id as sid,s.display_name as seller_name,r.display_name as r_name,r.id as rid,p.pic as pic,a.name as aname,a.zipcode from sales_flat_quote_item as i inner join users as s 
					on s.id=i.seller_id  inner join sales_flat_order as o on o.increment_id=i.order_id inner join users as r on r.id=i.customer_id inner join catalog_product_entity as p on p.id=i.product_id inner join customer_address_entity as a on i.billing_address_id=a.entity_id where 
					i.item_id!='' $filter $s_filter order by item_order_id desc";
				}
			// die;
			} else{
				$q="select i.*,i.base_price as sale_base,p.percantage_value,p.primary_price as orignal_value,p.*,o.discount_amount,o.shipping_amount,o.cod_amount,
				s.manual_ship,s.id as sid,s.display_name as seller_name,r.display_name as r_name,r.id as rid,p.pic as pic,a.name as aname,a.zipcode from sales_flat_quote_item as i inner join users as s 
				on s.id=i.seller_id  inner join sales_flat_order as o on o.increment_id=i.order_id inner join users as r on r.id=i.customer_id inner join catalog_product_entity as p on p.id=i.product_id inner join customer_address_entity as a on i.billing_address_id=a.entity_id where 1=1 $s_filter order by item_order_id desc";
			}
			// die;
			$conn = ConnectionManager::get('default');
			$table = TableRegistry::get('Users');

			$query = $conn->execute($q)->fetchAll('assoc');

			$count=0;
			foreach ($query as $key=>$data) {
				// pr($data);
				// die;
				$showordermsg=$this->showordermsg2($data['order_status'],$data['cancel_type']);
				$data['show_status']=$showordermsg['show_status'];
				$data['s_color']=$showordermsg['s_color'];
				$arr=array('8','10');
				
				if(in_array($data['order_status'],$arr)==true)
					$data['color']="white";
				else
					$data['color']="black";	

				// $data['show_status']=$this->showordermsg($data['order_status'],$data['cancel_type']);
				$product_data[$key]=$data;
				// $product_data['category']=
				$count++;
			}	

			// pr($product_data);die;
			if($login_role==1){
				$resellerdata	=	$table->find()->where(['role'=>'2','status'=>'active'])->toArray();
				$sellerdata	=	$table->find()->where(['is_suplier'=>'y','status'=>'active'])->toArray();
				$this->set(compact('product_data','daterang','resellerdata','sellerdata'));
			}else{
				$this->set(compact('product_data','daterang'));
			}
			
		}
		function d5order2()
		{
			if ($this->request->is('post')) {
		   // pr($this->request->getData());die;  
		   $daterang=$this->request->getData('daterange');
		   $d_a=explode('-',$daterang);
		   $start_date=strtotime($d_a[0]);
		   $end_date=strtotime($d_a[1]);
			
			$q2="select i.*,s.manual_ship,s.display_name as seller_name,s.id as sid,r.display_name as r_name,r.id as rid,p.pic as pic from sales_flat_quote_item as i inner join users as s on s.id=i.seller_id
			inner join users as r on r.id=i.customer_id inner join catalog_product_entity as p on p.id=i.product_id where i.add_utc >= '$start_date'
			AND i.add_utc <='$end_date' and i.makeprepayment='y' order by add_utc asc";
			
			}
			else
			{ 
				
			   $q2="select i.*,s.manual_ship,s.id as sid,s.display_name as seller_name,r.display_name as r_name,r.id as rid,p.pic as pic,p.percantage_value,a.name as aname,a.zipcode from sales_flat_quote_item as i inner join users as s 
				on s.id=i.seller_id inner join users as r on r.id=i.customer_id inner join catalog_product_entity as p on p.id=i.product_id inner join customer_address_entity as a on i.billing_address_id=a.entity_id where i.order_status='6'   and i.makeprepayment='y' order by add_utc desc";
			   
			}
			
			$conn = ConnectionManager::get('default');
			
			// $query = $conn->execute($q)->fetchAll('assoc');
			$pproduct_data = $conn->execute($q2)->fetchAll('assoc');
			// pr($query);
			// die;
			$count=0;
				
			
			// pr($product_data);die;
			$this->set(compact('daterang','pproduct_data'));
		}
		function d5order()
		{
			if ($this->request->is('post')) {
		   // pr($this->request->getData());die;  
		   $daterang=$this->request->getData('daterange');
		   $d_a=explode('-',$daterang);
		   $start_date=strtotime($d_a[0]);
		   $end_date=strtotime($d_a[1]);
			
			$q="select i.*,s.manual_ship,s.display_name as seller_name,s.id as sid,r.display_name as r_name,r.id as rid,p.pic as pic from sales_flat_quote_item as i inner join users as s on s.id=i.seller_id
			inner join users as r on r.id=i.customer_id inner join catalog_product_entity as p on p.id=i.product_id where i.add_utc >= '$start_date'
			AND i.add_utc <='$end_date' and i.makeprepayment='n' order by add_utc asc";
			
			}
			else
			{ 
				 $q="select i.*,s.manual_ship,s.id as sid,s.display_name as seller_name,r.display_name as r_name,r.id as rid,p.pic as pic,p.percantage_value,a.name as aname,a.zipcode from sales_flat_quote_item as i inner join users as s 
				on s.id=i.seller_id inner join users as r on r.id=i.customer_id inner join catalog_product_entity as p on p.id=i.product_id inner join customer_address_entity as a on i.billing_address_id=a.entity_id where i.order_status='6'  and i.makeprepayment='n' order by add_utc desc";
			   
			 
			}
			
			$conn = ConnectionManager::get('default');
			
			$query = $conn->execute($q)->fetchAll('assoc');
			
			$count=0;
			foreach ($query as $key=>$data) {
				// pr($data);
				// die;
			// $data['show_status']=$this->showordermsg($data['order_status'],$data['cancel_type']);
			$product_data[$key]=$data;
			   // $product_data['category']=
			   $count++;
			}	
			
			// pr($product_data);die;
			$this->set(compact('product_data','daterang'));
		}
		public function returnupdate()
		{
			$this->viewBuilder()->setLayout(false);
			$quote_item_table=TableRegistry::get('QuoteItem');
			
				if ($this->request->is('post')) {
				// pr($this->request->getData());
				// die;
				$select_order_id=$this->request->getData('return_order_id');
				$i	=	$quote_item_table->find()->where(['item_order_id'=>$select_order_id])->first();
				// pr($i);
				// die;
				if($i)
				{
					$return_awbNo=$this->request->getData('return_awbNo');
					$return_carrierName=$this->request->getData('return_carrierName');
					$return_track_url=$this->request->getData('return_track_url');
					$awbNo=$this->request->getData('awbNo');
					$i->return_carrierName=$return_carrierName;
					$i->return_awbNo=$return_awbNo;
					$i->return_track_url=$return_track_url;
					if($quote_item_table->save($i))
					{
						$this->Flash->success(__('Track Status Updated'));
					}
					else
					{
						$this->Flash->error(__('Fail to Save'));
					}
					$this->redirect(['action'=>'rbycustomer']);
				}
			}
			$this->redirect(['action'=>'rbycustomer']);
		}
		public function rbycustomer()
		{
		
			if ($this->request->is('post')) {
		   // pr($this->request->getData());die;  
		   $daterang=$this->request->getData('daterange');
		   // $daterang=$this->request->getData('daterange');
		   $request=$this->request->getData();
		   $product_data=[];
		   extract($request);
		   $filter='';
		    if($seller_id && $seller_id!='all')
		  $filter="and i.seller_id='$seller_id'";
	      if($reseller_id && $reseller_id!='all')
		  $filter.="and i.customer_id='$reseller_id'";
	       if($status_id && $status_id!='all')
		  $filter.="and i.order_status='$status_id'";
		   $d_a=explode('-',$daterang);
		   $start_date=strtotime($d_a[0]);
		   $end_date=strtotime($d_a[1]);
			
			$q="select i.*,s.manual_ship,s.display_name as seller_name,s.id as sid,r.display_name as r_name,r.id as rid,p.pic as pic from sales_flat_quote_item as i inner join users as s on s.id=i.seller_id
			inner join users as r on r.id=i.customer_id inner join catalog_product_entity as p on p.id=i.product_id where i.is_return_applicable  in('y','n','expire') and i.add_utc >= '$start_date'
			AND i.add_utc <='$end_date' $filter order by add_utc asc";
			}
			else
			{
				$q="select i.*,s.manual_ship,s.id as sid,s.display_name as seller_name,r.display_name as r_name,r.id as rid,p.pic as pic,a.name as aname,a.zipcode from sales_flat_quote_item as i inner join users as s 
				on s.id=i.seller_id inner join users as r on r.id=i.customer_id inner join catalog_product_entity as p on p.id=i.product_id inner join customer_address_entity as a on i.billing_address_id=a.entity_id where i.is_return_applicable not in('y','n','expire') order by add_utc desc";
			}
			// echo $q;
			// die;
			$conn = ConnectionManager::get('default');
			$table = TableRegistry::get('Users');
			$resellerdata	=	$table->find()->where(['role'=>'2','status'=>'active'])->toArray();
			$sellerdata	=	$table->find()->where(['is_suplier'=>'y','status'=>'active'])->toArray();
			$query = $conn->execute($q)->fetchAll('assoc');
					
			$count=0;
			foreach ($query as $key=>$data) {
				// pr($data);
				// die;
			$data['show_status']=$this->returnstatus($data['is_return_applicable']);
			$product_data[$key]=$data;
			   // $product_data['category']=
			   $count++;
			}	
			
			// pr($product_data);die;
			$this->set(compact('product_data','daterang','resellerdata','sellerdata'));
		
		}
		public function rto()
		{
		
			if ($this->request->is('post')) {
		   // pr($this->request->getData());die;  
		   $daterang=$this->request->getData('daterange');
		   // $daterang=$this->request->getData('daterange');
		   $request=$this->request->getData();
		   $product_data=[];
		   extract($request);
		   $filter='';
		    if($seller_id && $seller_id!='all')
		  $filter="and i.seller_id='$seller_id'";
	      if($reseller_id && $reseller_id!='all')
		  $filter.="and i.customer_id='$reseller_id'";
	       if($status_id && $status_id!='all')
		  $filter.="and i.order_status='$status_id'";
		   $d_a=explode('-',$daterang);
		   $start_date=strtotime($d_a[0]);
		   $end_date=strtotime($d_a[1]);
			
			$q="select i.*,s.manual_ship,s.display_name as seller_name,s.id as sid,r.display_name as r_name,r.id as rid,p.pic as pic from sales_flat_quote_item as i inner join users as s on s.id=i.seller_id
			inner join users as r on r.id=i.customer_id inner join catalog_product_entity as p on p.id=i.product_id where i.order_status='7' and i.add_utc >= '$start_date'
			AND i.add_utc <='$end_date' $filter order by add_utc asc";
			}
			else
			{
				$q="select i.*,s.manual_ship,s.id as sid,s.display_name as seller_name,r.display_name as r_name,r.id as rid,p.pic as pic,a.name as aname,a.zipcode from sales_flat_quote_item as i inner join users as s 
				on s.id=i.seller_id inner join users as r on r.id=i.customer_id inner join catalog_product_entity as p on p.id=i.product_id inner join customer_address_entity as a on i.billing_address_id=a.entity_id where i.order_status='7' order by add_utc desc";
			}
			
			$conn = ConnectionManager::get('default');
			$table = TableRegistry::get('Users');
			$resellerdata	=	$table->find()->where(['role'=>'2','status'=>'active'])->toArray();
			$sellerdata	=	$table->find()->where(['is_suplier'=>'y','status'=>'active'])->toArray();
			$query = $conn->execute($q)->fetchAll('assoc');
					
			$count=0;
			foreach ($query as $key=>$data) {
				// pr($data);
				// die;
			$data['show_status']=$this->rtostatus($data['is_return_applicable']);
			$product_data[$key]=$data;
			   // $product_data['category']=
			   $count++;
			}	
			
			// pr($product_data);die;
			$this->set(compact('product_data','daterang','resellerdata','sellerdata'));
		
		}
		public function returnstatus($status)
		{
			if($status=="applied")
			$s_msg="RETURN APPLIED";
			if($status=="pickup")
			$s_msg="PICKUP FOR RETURN";
			if($status=="completed")
			$s_msg="REFUND COMPLETED";
		    return $s_msg;
		}
		public function rtostatus($status)
		{
			if($status=="applied")
			$s_msg="RTO APPLIED";
			if($status=="pickup")
			$s_msg="PICKUP FOR RTO";
			if($status=="completed")
			$s_msg="REFUND COMPLETED";
		    return $s_msg;
		}
		public function trascation()
		{
			
			$orderlist=[];
			$conn = ConnectionManager::get('default');
			$user_id=$this->Auth->user('id');
			$login_role=$this->Auth->user('login_role');
			
			if($login_role!=1)
				$filter="and t.user_id='$user_id'";
			$table = TableRegistry::get('Users');
			$resellerdata	=	$table->find()->where(['role'=>'2','status'=>'active'])->toArray();
			$sellerdata	=	$table->find()->where(['is_suplier'=>'y','status'=>'active'])->toArray();
			if ($this->request->is('post')) {
				   $daterang=$this->request->getData('daterange');
		   // $daterang=$this->request->getData('daterange');
				   $request=$this->request->getData();
				   // pr($request);
				   // die;
				   extract($request);
				   $filter='';
				   $extrafilter='';
					if($seller_id && $seller_id!='all')
					$filter="and t.user_id='$seller_id' and user_type='2'";
					if($reseller_id && $reseller_id!='all')
						$filter="and t.user_id='$reseller_id' and user_type='1'";
					if($status_id && $status_id!='all')
					$filter.="and t.payment_status='$status_id'";
				   $d_a=explode('-',$daterang);
				   $s_date=strtotime($d_a[0]);
				   $e_date=strtotime($d_a[1]);
				   if($s_date && $e_date)
				   {
					   
					   $filter.=" and t.created_utc>='$s_date' and t.created_utc<='$e_date'";
				   }
			
			}  
			
			   
			if($this->request->query['s_date'])
			{
				$extrafilter='';
				$s_date=$this->request->query['s_date'];
				$e_date=$this->request->query['e_date'];
				$u_id=$this->request->query['u_id'];
				
				$u_type=$this->request->query['u_type'];
				if($u_id)
				{
					$extrafilter.="and t.user_id='$u_id' and t.user_type='$u_type'";
				}
				if($s_date && $s_date!='ALL')
				{
					$s_date=strtotime($s_date);
					$extrafilter.="and t.created_utc>='$s_date'";
				}
				if($e_date && $e_date!='ALL')
				{
					$e_date=strtotime($e_date);
					$extrafilter.="and t.created_utc<='$e_date'";
				}
				
				// $q="select t.*,i.cancel_type,i.order_status,i.cancel_utc,u.display_name,u.mobile from user_transaction as t inner join sales_flat_quote_item as i on i.item_order_id=t.item_order_id inner join users as u on u.id=t.user_id where t.payment_status in('approved','hold','decline','credited') $extrafilter order by t.id desc";
			}
			  $q="select t.*,i.cancel_type,i.order_status,i.cancel_utc,i.delay_penalty,u.display_name,u.mobile from user_transaction as t left join sales_flat_quote_item as i on t.item_order_id=i.item_order_id inner join users as u on u.id=t.user_id where t.payment_status not in('requested')
				$filter $extrafilter group by id order by t.id desc";
			// die;
			// $Tras = TableRegistry::get('Transaction');
			// $status=array('approved','hold','decline');
			// $orderlist = $Tras
						// ->find()
						
						// ->where(['payment_status IN'=>$status])
						// ->order(['id'=>'desc'])
						// ->toArray();
			// pr($orderlist);
			// die;
			$query = $conn->execute($q)->fetchAll('assoc');
			foreach ($query as $key=>$data) {
				// pr($data);
				// die;
			// $data['show_status']=$this->showordermsg($data['order_status'],$data['cancel_type']);
			$showordermsg=$this->showordermsg2($data['order_status'],$data['cancel_type']);
			$data['show_status']=$showordermsg['show_status'];
			$data['s_color']=$showordermsg['s_color'];
			$arr=array('8','10');
			if(in_array($data['order_status'],$arr)==true)
			$data['color']="white";
			else
			$data['color']="black";	  
			$orderlist[$key]=$data;
			   // $product_data['category']=
			   $count++;
			}	
			// pr($orderlist);
			// die;
			$this->set(compact('orderlist','resellerdata','sellerdata','s_date','e_date'));
		}
		public function trascationreject()
		{
			if ($this->request->is('post')) {
			 // pr($this->request->getData());die;	
				$request=$this->request->getData();
				extract($request);
				$Tras = TableRegistry::get('Transaction');
				$orderlist = $Tras
						->find()
						// ->select(['id','fullname'])
						->where(['id'=>$select_order_id])
						// ->order(['id'=>'desc'])
						->first();
				if($orderlist)
				{
					$orderlist->hold_status="y";   
					$orderlist->comment="Hold Order";
					$Tras->save($orderlist);
					
				}
			}
			$this->redirect(['action'=>'trascation']);
		}
		public function changetrascation($tras_id,$t_type)
		{
			if ($tras_id) {
			 
				$Tras = TableRegistry::get('Transaction');
				$orderlist = $Tras
						->find()
						// ->select(['id','fullname'])
						->where(['id'=>$tras_id])
						// ->order(['id'=>'desc'])
						->first();
				if($orderlist)
				{
					// $orderlist->payment_status="approved";   
					if($t_type=="unhold")
					{
						$orderlist->hold_status="n"; 
					}
					  
					if($t_type=="approve")
					{
						$orderlist->tras_status="1"; 
					}
					$orderlist->comment="Reprocess By Admin";
					$Tras->save($orderlist);
					
				}
			}
			$this->redirect(['action'=>'trascation']);
		}
		public function trascationdecline()
		{
			if ($this->request->is('post')) {
			 // pr($this->request->getData());die;	
				$request=$this->request->getData();
				extract($request);
				$Tras = TableRegistry::get('Transaction');
				$orderlist = $Tras
						->find()
						// ->select(['id','fullname'])
						->where(['id'=>$select_order_id])
						// ->order(['id'=>'desc'])
						->first();
				if($orderlist)
				{
					$orderlist->tras_status="0";   
					$orderlist->comment="Decline";
					$Tras->save($orderlist);
					
				}
			}
			$this->redirect(['action'=>'trascation']);
		}
		public function penlty()
		{
			$Tras = TableRegistry::get('Transaction');
			$table = TableRegistry::get('Users');
			$status=array('approved','hold','credited');
			$orderlist = $Tras
						->find()
						// ->select(['id','fullname'])
						->where(['payment_status IN'=>$status,'payment_type'=>'penlty'])
						->order(['id'=>'desc'])
						->toArray();
			if ($this->request->is('post')) {
		   // pr($this->request->getData());die;  
		   $daterang=$this->request->getData('daterange');
		   $d_a=explode('-',$daterang);
		   $start_date=strtotime($d_a[0]);
		   $end_date=strtotime($d_a[1]);
			$connection = ConnectionManager::get('default');
			 $q="select * from user_transaction where payment_status in('approved','hold') and payment_type='penlty' and created_utc>=$start_date and created_utc<=$end_date";
			   $orderlist = $connection->execute($q)->fetchAll('assoc');
			}
			else
			{
				 $conditions = array('payment_status IN'=>$status,'payment_type'=>'penlty');
				 $orderlist = $Tras->find('all',array('conditions'=>$conditions))->order(['id'=>'DESC'])->toArray(); 
			
			}
			
			// pr($orderlist);
			// die;
			$users	=	$table->find()->where(['status'=>'active'])->select(['id','display_name','mobile'])->order(['display_name'=>'ASC'])->toArray();
			
			$this->set(compact('orderlist','users'));
		}
		public function weiver()
		{
			$Tras = TableRegistry::get('Transaction');
			$table = TableRegistry::get('Users');
			$status=array('approved','hold','credited');
			$orderlist = $Tras
						->find()
						// ->select(['id','fullname'])
						->where(['payment_status IN'=>$status,'payment_type'=>'weiver'])
						->order(['id'=>'desc'])
						->toArray();
			if ($this->request->is('post')) {
		   // pr($this->request->getData());die;  
		   $daterang=$this->request->getData('daterange');
		   $d_a=explode('-',$daterang);
		   $start_date=strtotime($d_a[0]);
		   $end_date=strtotime($d_a[1]);
			$connection = ConnectionManager::get('default');
			 $q="select * from user_transaction where payment_status in('approved','hold') and payment_type='weiver' and created_utc>=$start_date and created_utc<=$end_date";
			   $orderlist = $connection->execute($q)->fetchAll('assoc');
			}
			else
			{
				 $conditions = array('payment_status IN'=>$status,'payment_type'=>'weiver');
				 $orderlist = $Tras->find('all',array('conditions'=>$conditions))->order(['id'=>'DESC'])->toArray(); 
			
			}
			
			// pr($orderlist);
			// die;
			$users	=	$table->find()->where(['status'=>'active'])->select(['id','display_name','mobile'])->order(['display_name'=>'ASC'])->toArray();
			
			$this->set(compact('orderlist','users'));
		}
		public function payoff()
		{
			$table = TableRegistry::get('Users');
			$Payoff = TableRegistry::get('Payoff');
			$login_user_id=$this->Auth->user('id');
			$login_role=$this->Auth->user('login_role');
			$users	=	$table->find()->where(['status'=>'active'])->select(['id','display_name','mobile'])->order(['display_name'=>'ASC'])->toArray();
			if ($this->request->is('post')) {
				$request=$this->request->getData();
				if($user_id)
				{
					$allpayoff	=	$Payoff->find()->where(['user_id'=>$user_id])->order(['created'=>'DESC'])->toArray();
				}
			}
			else
			{
				if($login_role==1)
				$allpayoff	=	$Payoff->find()->order(['created'=>'DESC'])->toArray();
				else
				$allpayoff	=	$Payoff->find()->where(['user_id'=>$login_user_id])->order(['created'=>'DESC'])->toArray();	
			}
			
			$this->set(compact('users','allpayoff'));
		}
		public function report()
		{
			$connection = ConnectionManager::get('default');
			$userlist = $connection->execute("select user_id,user_type from user_transaction where payment_status='approved' group by user_id")->fetchAll('assoc');
			$UserTable = TableRegistry::get('Users');
			$i=0;
			foreach($userlist as $user)
			{
				$filter='';
				$last_payment_date='';
				$u_id=$user['user_id'];
				$suser=$UserTable->find()->select(['last_payment_date','display_name','mobile'])->where(['id'=>$user['user_id']])->first();
				if($suser)
				{
					$cur_date=date('Y-m-d H:i:s');
					 $las_date=$suser->last_payment_date;
					 if($las_date)
					 $last_payment_date=date('Y-m-d H:i:s',strtotime($las_date));
					
					// $end_date=$cur_date;
					if($last_payment_date)
					{
						 $filter="and process_date>='$last_payment_date'";
						$start_show=$last_payment_date;
					}
					else
					{
						$start_show="ALL";
					}
					// echo "select sum(amount) as total_sale from user_transaction where payment_status='approved' and order_status='completed' and payment_type='add' and user_id='$u_id' $filter";
					// die;
					// echo "select sum(amount) as total_sale from user_transaction where payment_status='approved' and order_status='completed' and payment_type='penlty' and user_id='$u_id' $filter";
					// die;
					// echo "select sum(amount) as total_sale from user_transaction where payment_status='approved' and tras_status='1' and hold_status='n' and order_status='completed' and payment_type='add' and user_id='$u_id' $filter";
					// die;
					$total_sale=$connection->execute("select sum(amount) as total_sale from user_transaction where payment_status='approved' and tras_status='1' and hold_status='n' and order_status='completed' and payment_type='add' and user_id='$u_id' $filter")->fetch('assoc')['total_sale'];
					$total_deduct=$connection->execute("select sum(amount) as total_sale from user_transaction where payment_status='approved'  and tras_status='1' and hold_status='n' and tras_status='1' and order_status='completed' and payment_type='deduct' and user_id='$u_id' $filter")->fetch('assoc')['total_sale'];
					$total_waiver=$connection->execute("select sum(amount) as total_sale from user_transaction where payment_status='approved' and tras_status='1'  and hold_status='n' and order_status='completed' and payment_type='weiver' and user_id='$u_id' $filter")->fetch('assoc')['total_sale'];
					 $total_penlty=$connection->execute("select sum(amount) as total_sale from user_transaction where payment_status='approved' and tras_status='1' and hold_status='n' and order_status='completed' and payment_type='penlty' and user_id='$u_id' $filter")->fetch('assoc')['total_sale'];
					$total_hold=$connection->execute("select sum(amount) as total_sale from user_transaction where hold_status='y' and tras_status='1' and order_status='completed'  and user_id='$u_id' $filter")->fetch('assoc')['total_sale'];
					$total_order=$connection->execute("select count(user_id) as total_sale from user_transaction where  order_status='completed' and payment_type='add' and user_id='$u_id' $filter")->fetch('assoc')['total_sale'];  
					$u[$i]['user_id']=$u_id;
					
					$u[$i]['user_type']=$user['user_type'];
					$u[$i]['display_name']=$suser['display_name'];
					$u[$i]['mobile']=$suser['mobile'];
					$u[$i]['start_date']=$start_show;
					$u[$i]['end_date']=$cur_date;
					$u[$i]['total_sale']=$total_sale-$total_deduct;
					$u[$i]['total_deduct']=$total_deduct;
					$u[$i]['total_penlty']=$total_penlty;
					$u[$i]['total_waiver']=$total_waiver;
					$u[$i]['total_hold']=$total_hold;
					$u[$i]['total_order']=$total_order;
					$filter='';
					// pr($u);
					
					// die;
					// $u[$i]['user_type']=$user['user_type'];
				}
				
				$i++;
			}
			// pr($u);
					// die;
			$this->set(compact('u'));
		}
		function changeorderstatus()
		{
			
			if ($this->request->is('post')) {
			$connection = ConnectionManager::get('default');
			 // pr($this->request->getData());die;	
			 $request=$this->request->getData();
			 extract($request);
			 $quote_item_table=TableRegistry::get('QuoteItem');
			 $Tras = TableRegistry::get('Transaction');
			 $itemorder	=	$quote_item_table->find()->where(['item_order_id'=>$select_order_id])->contain(['Product']) ->first();
			
			// pr($itemorder);
			// die;
			if($itemorder)
			{
				$customer_id=$itemorder['customer_id'];
				 $seller_id=$itemorder['seller_id'];
				
				$UserTable = TableRegistry::get('Users');
				$user	=	$UserTable->find()->where(['id'=>$customer_id])->contain(['Address']) ->first();
				$supplierdata	=	$UserTable->find()->select(['id','manual_ship','delay_penalty','per_value','mobile'])->where(['id'=>$seller_id])->first();
				$reseller_mobile=$user['mobile'];
				$user_id=$user['id'];
				$supplier_mobile=$supplierdata['mobile'];
				// pr($supplierdata);    
				// die;
				$supplier_fine="n";
				$item_id=$select_order_id;
				$item_order_id=$select_order_id;
				$product_id=$itemorder->product_id;
				$current_date=date('Y-m-d H:i:s');
				$size_name=$itemorder['size_name'];
				$qty=(int)$itemorder['qty'];
				$p_name=$itemorder['product']['name_en'];
				$save_Date=date('d-m-y h:i A',strtotime($current_date));
				$awbNo=$itemorder['awbNo'];
				$carrierName=$itemorder['carrierName'];
				$current_utc=strtotime($current_date);
					$UserTable = TableRegistry::get('Users');
				$seller_id=$itemorder['seller_id'];
				if($status_type=="reject")
				 {
					$itemorder->order_status='4'; 
					$itemorder->cancel_type='rejectbyadmin'; 
					$itemorder->comment=$comment; 
					$size_id=$itemorder->size_id;
					$items_qty=$itemorder->items_qty;
					$items_qty=(int)$itemorder->items_qty;
					$s_type="cancel";
					$seller_id=$itemorder->seller_id;
					$product_id=$itemorder->product_id;
					$this->stockupdate($size_id,$items_qty,$s_type,$seller_id,$product_id);
					
				 }
				 else  if($status_type=="rejectrto")
				 {
					// case for reject rto
					$itemorder->order_status='6';
					$itemorder->comment="Rto Rejected"; 	 
					$itemorder->is_return_applicable="rejected"; 	 
					 
				 } else if($status_type=="rtoaccept")
				 {
					 $itemorder->comment="Pickup For Rto Schudule"; 	 
					$itemorder->is_return_applicable=$change_status; 	 
				 } else if($status_type=="rejectreturn")
				 {
					
						$itemorder->order_status='6'; 
						$itemorder->return_time='n'; 
					
				 } else if($status_type=="returnaccept")
				 {
					if($change_status=="returnpickup")
					{
						$itemorder->is_return_applicable="pickup"; 
					} else if($change_status=="completed")
					{
						$itemorder->is_return_applicable="completed"; 
						// make refund 100% for reseller and for supplier check conditions
					    $itemorder->order_status=12; 
						if($itemorder->reason=="Product Quality is not good" || $itemorder->reason=="Wrong product delivered")
						{
							
							// make fine to supplier 
							$supplier_fine="y";
						}
						
					}						
				 }
				 else 
				 {
					if($change_status!='-1')
						$itemorder->order_status=$change_status;
						if($change_status=="7")
						{
							// change both side tras to rto rejected 
							$u1 = $connection->execute("UPDATE user_transaction SET payment_status='rto',amount='0',comment='RTO' WHERE item_order_id='$item_id'");
							
							
							
						}
						if($change_status=="6")
						{
							$itemorder->deliver_date=date('Y-m-d H:i:s');
							$itemorder->delivery_date=date('Y-m-d H:i:s');
							$table = TableRegistry::get('Product');
							$result = $table->find()->where(['id'=>$product_id])->first();
							$return_applicable=$result->return_applicable;
							if($return_applicable)
							{
								 $itemorder->is_return_applicable="y"; 	 
							}
							$itemorder->is_feedback_applicable="y";
							if($awbNo)
							$reseller_sms="*Order Delivered* :\n*".$p_name."* \nSize : *".$size_name."* \nQuantity : *".$qty."* \nOrder Number *".$item_order_id."* is Successfully Delivered. Your Order Tracking No. *".$awbNo."* (".$carrierName.") ".$track_url."Please Provide Feedback As Soon As Possible And Get Offer Coupon Code For Next Order."; 
								$supplier_sms="*Order Delivered* :\n*".$p_name."* \nSize : *".$size_name."* \nQuantity : *".$qty."* \nOrder Number *".$item_order_id."* is Successfully Delivered."; 
							
							$n['title']="Order Delivered";
							$n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
							$n['user_id']=$user_id;
							$n['order_id']=$item_id;
							$n['created']=$current_date;
							$this->addnotification($n);
							$n['user_id']=$seller_id;
							$this->addnotification($n);
							
							$reg_ids='';
							if($reseller_mobile)
							{
								$this->sendsms($reseller_sms,$reseller_mobile,$reg_ids);
							} 
							if($supplier_mobile)
							{
								$this->sendsms($supplier_sms,$supplier_mobile,$reg_ids);
							}
							$push_msg=array('u_id'=>array($user_id),'user_type'=>1,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Delivered','body'=>"(".$item_order_id.") ".$p_name);
							$push_msg_2=array('u_id'=>array($seller_id),'user_type'=>2,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Delivered','body'=>"(".$item_order_id.") ".$p_name);
							$this->sendpush($push_msg);
						}
						if($change_status==7)
						{
							if($awbNo)
							$reseller_sms="*Order RTO* : \n*".$p_name."*\nSize : *".$size_name."* \nQuantity : *".$qty."* \nOrder Number *".$item_order_id."* is RTO. Your Order Tracking No. *".$awbNo."* (".$carrierName.") ".$track_url; 
							else 
							$reseller_sms="*Order RTO* : \n*".$p_name."*\nSize : *".$size_name."* \nQuantity : *".$qty."* \nOrder Number *".$item_order_id."* is RTO."; 
							$supplier_sms="*Order RTO* : \n*".$p_name."*\nSize : *".$size_name."* \nQuantity : *".$qty."* \nOrder Number *".$item_order_id."* is RTO."; 
							
							$n['title']="Order RTO";
							$n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
							$n['user_id']=$user_id;
							$n['order_id']=$item_id;
							$n['created']=$current_date;
							$this->addnotification($n);
							$n['user_id']=$seller_id;
							$this->addnotification($n);
							
							$reg_ids='';
							if($reseller_mobile)
							{
								$this->sendsms($reseller_sms,$reseller_mobile,$reg_ids);
							} 
							if($supplier_mobile)
							{
								$this->sendsms($supplier_sms,$supplier_mobile,$reg_ids);
							}
							$push_msg=array('u_id'=>array($user_id,$seller_id),'user_type'=>1,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order RTO','body'=>"(".$item_order_id.") ".$p_name);
							$push_msg_2=array('u_id'=>array($seller_id),'user_type'=>2,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order RTO','body'=>"(".$item_order_id.") ".$p_name);
							$this->sendpush($push_msg);
							$this->sendpush($push_msg_2);
						}
							$itemorder->comment=$comment; 	
				 }
				 // echo $supplier_fine;
				 // die;
				 // pr($itemorder);
				 // die;
				 if($quote_item_table->save($itemorder))
				 {
					 if($change_status==3)
					 {
						 // dispatch product 
						 
						 $track_url=$itemorder['track_url'];
						 if($awbNo && $carrierName)
						$reseller_sms="*Order Dispatched* :\n*".$p_name."* \nSize : *".$size_name."* \nQuantity : *".$qty."* \nOrder Number *".$item_order_id."* is Dispatched. Your Order Tracking No. *".$awbNo."* (".$carrierName.") ".$track_url; 
						else
						$reseller_sms="*Order Dispatched* :\n*".$p_name."* \nSize : *".$size_name."* \nQuantity : *".$qty."* \nOrder Number *".$item_order_id."* is Dispatched.";
						$n['title']="Order Dispatched";
						$n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
						$n['user_id']=$user_id;
						$n['order_id']=$item_id;
						$n['created']=$current_date;
						$this->addnotification($n);
						
						$reg_ids='';
						if($reseller_mobile)
						{
							$this->sendsms($reseller_sms,$reseller_mobile,$reg_ids);
						}
						$push_msg=array('u_id'=>array($user_id),'user_type'=>1,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Dispatched','body'=>"(".$item_order_id.") ".$p_name);
							$this->sendpush($push_msg);
					 }
					 if($status_type)
					 {
						 
						if($status_type=="reject" || $status_type="returnaccept")
						{
							if($status_type=="reject")
							{
								$reseller_sms="*Order Rejected By Admin* :*".$p_name."*,Size :*".$size_name."*, Quantity :*".$qty."* \nOrder Number *".$item_order_id."* is is rejected. Sorry For Inconvenience.";
									  $n['title']="Order Rejected By Admin";
									  $n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
									   $n['user_id']=$user_id;
									   $n['order_id']=$item_id;
									   $n['created']=$current_date;
									   $this->addnotification($n);
										$n['title']="Order Rejected By Admin";
										$n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
									   $n['user_id']=$seller_id;
									   $n['order_id']=$item_id;
										 $n['created']=$current_date;
										$this->addnotification($n);
									 $reg_ids='';
									 if($reseller_mobile)
									 {
										$this->sendsms($reseller_sms,$reseller_mobile,$reg_ids);
									 }
									  if($supplier_mobile)
									 {
										$this->sendsms($reseller_sms,$supplier_mobile,$reg_ids);
									 }
									 $push_msg=array('u_id'=>array($user_id),'user_type'=>1,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Rejected By Admin','body'=>"(".$item_order_id.") ".$p_name);
									 $push_msg_2=array('u_id'=>array($seller_id),'user_type'=>2,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Rejected By Admin','body'=>"(".$item_order_id.") ".$p_name);
							$this->sendpush($push_msg);
							$this->sendpush($push_msg_2);
							}
							$supplierdata=$UserTable->find()->select(['id','manual_ship','delay_penalty'])->where(['id'=>$seller_id])->first();
							$delay_penalty=$supplierdata['delay_penalty'];
							$usertras=$Tras->find()->where(['item_order_id'=>$item_id,'user_type'=>'1','order_status'=>'onprocess'])->first();
							$suppliertra=$Tras->find()->where(['item_order_id'=>$item_id,'user_type'=>'2','order_status'=>'onprocess'])->first();
							if($change_status=="completed")
							{  
								if($usertras)
								{
									$usertras->order_status="completed";
									$usertras->payment_status="approved";
									$usertras->payment_type="weiver";
									$usertras->amount=$usertras->bill_amount;
									$usertras->process_date=$current_date;
									$usertras->comment="Return Weiver for "."O".$item_id;
									$Tras->save($usertras);
								}
								if($suppliertra)
								{
									if($supplier_fine=="y")
									{
										$suppliertra->order_status="completed";
										$suppliertra->payment_status="approved";
										$suppliertra->payment_type="penlty";
										$suppliertra->process_date=$current_date;
										$suppliertra->amount=$delay_penalty;
										$suppliertra->comment="Return penlty for "."O".$item_id;
										
										$itemorder->delay_penalty=$delay_penalty;
										$quote_item_table->save($itemorder);
									}
									else
									{ 
										$suppliertra->payment_status="rejectbyadmin";
										$suppliertra->comment="Return for "."O".$item_id;
									}
									$Tras->save($suppliertra);
								}
							}  
							else
							{	
								if($status_type=="reject")
								{
									if($penlty=="y")
									{
										
										
										if($suppliertra)
										{
											$suppliertra->payment_type="deduct";
											$suppliertra->payment_status="credited";
											$suppliertra->order_status="completed";
											$suppliertra->comment="Order Rejected By Admin";
											$suppliertra->created_date=$current_date;
											$suppliertra->process_date=$current_date;
											if($delay_penalty>0)
											{
												$suppliertra->amount=$delay_penalty;
											}
											$Tras->save($suppliertra);
										}
										else
										{
											if($delay_penalty>0)
											{
												$ct['user_id']=$itemorder->seller_id;
												$ct['amount']=$delay_penalty;
												$ct['user_type']=2;
												$ct['item_order_id']=$item_id;
												$ct['created_date']=$current_date;
												$ct['process_date']=$current_date;
												$ct['payment_type']="deduct";
												$ct['payment_status']="credited";
												$ct['order_status']="completed";
												$ct['payment_process']="n";
												$ct['comment']="Order Rejected By Admin";   
												$entity =	$Tras->newEntity($ct);
												$trasresult	=	$Tras->save($entity);
											}
										}
										
										$itemorder->delay_penalty=$delay_penalty;
										$itemorder->cancel_utc=$current_utc;
										$quote_item_table->save($itemorder);
									}
									if($usertras)
									{
									$usertras->payment_status="rejectbyadmin";
									$usertras->order_status="cancelled";
									$usertras->payment_process="n";
									$Tras->save($usertras);
								}
								}
							} 
						}
					 }
					$this->Flash->success(__('The data has been saved.'));
					$this->redirect(['action' => 'index']);  
				 }
				 else
				 {
					 $this->Flash->error(__('Failed, try again.'));
					$this->redirect(['action' => 'index']); 
				 }
				 
			}
			else
			{
				$this->redirect(['action' => 'index']);
			}
			 
			}
			
		}
	public function addnotification($n)
	{
		$Noti = TableRegistry::get('Notification');
		$entity =	$Noti->newEntity($n);
		$trasresult	=	$Noti->save($entity);
	}
	function stockupdate($size_id,$items_qty,$s_type,$seller_id,$product_id)
	{ 
		$connection = ConnectionManager::get("default");
		$StockTable = TableRegistry::get('Stock');
		$stockdata = $StockTable
					->find()
					->where(['id'=>$size_id])
					->first();
		$old_count=$stockdata->pending_stock;
		if($s_type=="reject" || $s_type=="canceluser" || $s_type=="cancel")
		$new_count=$old_count+$items_qty;
		else
		$new_count=$old_count-$items_qty;	
		$stockdata->pending_stock=$new_count;
		$StockTable->save($stockdata);
		// echo "INSERT INTO stock_data(user_id,product_id,stock_id,stock_value,s_type) VALUES ('$seller_id','$product_id','$size_id','$items_qty','$s_type')";
		// die;
		$connection->execute("INSERT INTO stock_data(user_id,product_id,stock_id,stock_value,s_type) VALUES ('$seller_id','$product_id','$size_id','$items_qty','$s_type')");
		$totalcount=$connection->execute("select sum(pending_stock) as total_stock from catelog_product_stock where product_id='$product_id'")->fetch('assoc')['total_stock'];
		if($totalcount<=0)
		{
			// make produc
		   $product=$connection->execute("update catalog_product_entity set on_stock='n' where id='$product_id'");	
		   // $totalcount=$connection->execute();	
		}
	}
		
}
?>
