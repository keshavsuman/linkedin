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

class ApiorderController extends RestController
{
	function beforeFilter(Event $event) {
	    // parent::beforeFilter($event);
         // $this->getEventManager()->off($this->Csrf);
	    $this->viewBuilder()->setLayout(false);
	    // $this->request->withData('data',array_map('trim',$this->request->getData()));
	}
	function orderlist()
	{
		if($this->request->is('post')){
			$request = $this->request->getData();
			extract($request);
			// $user_type=1;
			// user_type 1 for reseller & 2 for wholeseller
			if($user_type=='')
				$user_type=1;
			if($customer_id && $user_type)
			{
				$bonus=$this->bonusprogram($customer_id);
				$connection = ConnectionManager::get('default');
				// user type 1 for reselle 2 for supplier 
				$current_date=date('Y-m-d H:i:s');
				$current_utc=strtotime($current_date);
				if($user_type==1)
				{
					$query="select i.*,p.name_en,p.pic as product_pic from sales_flat_quote_item as i inner join catalog_product_entity as p on p.id=i.product_id
						where i.process_status='orderplace' and i.customer_id='$customer_id' order by i.order_utc asc limit 0,100"; 
					
				}
				else
				{
					  $query="select i.*,p.name_en,p.pic as product_pic,p.share_text from sales_flat_quote_item as i inner join catalog_product_entity as p on p.id=i.product_id
						where i.process_status='orderplace' and i.seller_id='$customer_id' order by i.order_utc asc limit 0,100"; 
					// die;
				}   
				$orderlist = $connection->execute($query)->fetchAll('assoc');
				if(count($orderlist)>0)
				{
					$s=0;
					foreach($orderlist as $sitem)
					{
						// pr($sitem);
						// die;
						$d[$s]['item_id']=$sitem['item_order_id'];
						$d[$s]['market_price']=(int)$sitem['base_price'];
						$d[$s]['my_earning']=(int)$sitem['my_earning'];
						$d[$s]['primary_price']=(int)$sitem['primary_price'];
						$d[$s]['selling_price']=(int)$sitem['base_price'];
						$d[$s]['product_id']=$sitem['product_id'];
						$d[$s]['base_price']=(int)$sitem['base_price'];
						$d[$s]['amount']=(int)$sitem['price'];
						$d[$s]['qty']=$sitem['qty'];
						$d[$s]['off']=$sitem['off'];
						$d[$s]['extra_text']=$sitem['extra_text'];
						$d[$s]['cod_text']=$sitem['cod_text'];
						$d[$s]['share_text']=$sitem['share_text'];
						// $d[$s]['market_price']=$sitem['product']['market_price'];
						// $d[$s]['my_earning']=$sitem['product']['my_earning'];
						$d[$s]['min_range']=0;
						$d[$s]['max_range']=0;
						$d[$s]['order_status']=$sitem['order_status'];
						$d[$s]['order_id']=1;
						$d[$s]['show_msg']="APPORVAL PENDING";
						$d[$s]['time_left']="23";
						$d[$s]['product_name']=$sitem['name_en'];   
						$d[$s]['order_date']=$sitem['order_date'];
						$d[$s]['order_utc']=$sitem['order_utc'];
						$d[$s]['image']=Router::url('image/',true).$sitem['product_pic'];
						$s++;
					}
					$reponse['status'] =true;
					$reponse['bonus'] =$bonus;
					$reponse['data'] =$d;
					$reponse['bonus_exit'] ='y';
					$reponse['msg'] ="Order list found";
					$address =$this->addresslist($customer_id);
					if($user_type==2)
					{
						$reponse['address_count']=$address['address_count'];
						$reponse['address']=$address['address'];
					}
					
				}
				else
				{
					$reponse['status'] =true;
					$reponse['bonus'] =$bonus;
					$reponse['data'] =[];
					$reponse['bonus_exit'] ='y';
					$reponse['msg'] ="Order list found";
					
				}
			}
			else
			{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Paramter missing";
			}
		}
		else{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invaid Type";
		}
		
		echo json_encode($reponse);
		die;
	}
	function addresslist($customer_id)
	{
		$table 	=	TableRegistry::get('Address');
		$result=$table->find()->where(['customer_id'=>$customer_id,'is_active'=>'1','address_for'=>'supplier'])->toArray();
			$simple=array();
		if(count($result)>0)
		{
			$d['address_count']=count($result);
		
			foreach ($result as $key => $value) {
				$data['entity_id'] = $value['entity_id'];
				$data['name'] = $value['name'];
				$data['contact'] = $value['contact'];  
				$data['address'] = $value['address'];
				$data['address2'] = $value['address2'];
				$data['state'] = $value['state'];
				$data['city'] = $value['city'];
				$data['zipcode'] = $value['zipcode'];
				// $data['is_active'] = $value['is_active']; 
				$data['is_active'] = $value['is_active'];
				$data['customer_id'] = $value['customer_id'];
				$data['sellerAddressId'] = $value['sellerAddressId'];
				$simple[]=$data;
			}
			$d['address']=$simple;
		}
		else
		{
			$d['address_count']=0;
			$d['address']=$simple;
		}
		return $d;
	}
	function bonusprogram($customer_id)
	{
		$d['bonus_exit']="y";
		$d['bonus_title']="Bonus Point 1 Week ";
		$d['bonus_sale']=500;
		$d['bonus_target']=1000;
		return $d;
		
	}
	function changeorderstatus()
	{
		// 1 for order place , 2 for order accept , 3 for order reject 
		if($this->request->is('post')){
			$request = $this->request->getData();
			extract($request);
			if($customer_id && $item_id && $status_id)
			{
				$err=false;
				$quote_item_table=TableRegistry::get('QuoteItem');
				$itemorder	=	$quote_item_table->find()->where(['item_order_id'=>$item_id])->contain(['Product']) ->first();
				$UserTable = TableRegistry::get('Users');
				$user	=	$UserTable->find()->where(['id'=>$customer_id])->contain(['Address']) ->first();
				// pr($user);
				// die;
				switch ($status_id) {
					 case 2:
					 {
						 if($sellerAddressId)
						 {
							
							if($itemorder->order_status==1)
							{
								$o['orderId']=$itemorder['item_order_id'];
								$o['customerName']=$user['fullname'];
								$o['customerAddress']=$user['addres']['address'].",".$user['address']['address2'];
								$o['customerCity']=$user['addres']['city'];
								$o['customerPinCode']=$user['addres']['zipcode'];
								$o['customerContact']=$user['mobile'];
								$o['quantity']=$itemorder['qty'];
								$o['categoryName']="Cameras Audio and Video";
								$o['packageLength']=$itemorder['packageLength'];
								$o['packageWidth']=$itemorder['packageWidth'];
								$o['packageHeight']=$itemorder['packageHeight'];
								$o['packageWeight']=$itemorder['packageWeight'];
								$o['packageName']=$itemorder['Product']['name_en'];
								$o['totalValue']=$itemorder['base_price'];
								$o['orderDate']=date('Y-m-d');
								// pr($o);
								// die;
								$orderplace=$this->shypliteplaceorder($o);
								if($orderplace['status']=true)
								{
									$itemorder->shyplite_order_id=$shyplite_order_id;
									$itemorder->shyplite_status="pass";
									$itemorder->shyplite_selected_mode=$orderplace['shyplite_selected_mode'];
								}
								else
								{
									$itemorder->shyplite_status="fail";
								}
								$itemorder->order_status='2';
								// api to take order from shylite 
								
							}
							else
							{
								$err_msg="Without place order cant able to Accpet";
								$err=true;
							}
						 }
						 else
						 {
							$err_msg="Without Address id cant able to accept order";
							$err=true; 
						 }
						
					 }
					 case 13: 
					 {
						 // order rejected
						if($itemorder->order_status==13)
						{
							$itemorder->order_status='4';
						}
						else
						{
							$err_msg="Without place order cant able to Accpet";
							$err=true;
						}
					 }
					 case 14: 
					 {
						 // order rejected
						if($itemorder->order_status==14)
						{
							$itemorder->order_status='4';
						}
						else
						{
							$err_msg="Without place order cant able to Accpet";
							$err=true;
						}
					 }
					  case 15: 
					 {
						 // order rejected
						if($itemorder->order_status==15)
						{
							$itemorder->order_status='5';
						}
						else
						{
							$err_msg="Without place order cant able to Accpet";
							$err=true;
						}
					 }
					  case 8: 
					 {
						 // order rejected
						if($itemorder->order_status==8)
						{
							$itemorder->order_status='8';
						}
						else
						{
							$err_msg="Without place order cant able to Accpet";
							$err=true;
						}
					 }
				}
				
				if($err==true)
				{
					
					$reponse['status']	=	false;
					$reponse['data']	=	"";
					$reponse['msg'] 	=	$err_msg;
				}
				else
				{
					
					if($quote_item_table->save($itemorder))
					{
						$reponse['status']	=	true;
						$reponse['data']	=	"";
						$reponse['msg'] 	=	"order Proceed to next stage";	
					}
					else
					{
						$reponse['status']	=	false;
						$reponse['data']	=	"";
						$reponse['msg'] 	=	"Something Went Wrong";	
					}
					
				}
			}
			else
			{
				$reponse['status']	=	false;
				$reponse['data']	=	"";
				$reponse['msg'] 	=	"Required Parametr Missing";	
			}
		}
		else{
			$reponse['status']	=	false;
			$reponse['data']	=	"";
			$reponse['msg'] 	=	"Invalid Data Type";	
		}
		echo json_encode($reponse);die;
		
	}
	public function shypliteplaceorder()
	{  
		$d['shyplite_order_id']=188047;
		$d['shyplite_amount']=148;
		$d['shyplite_selected_mode']="Air";
		$d['status']=true;
        return $d;
	}
}
?>