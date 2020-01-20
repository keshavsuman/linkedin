<?php
namespace App\Controller;  
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception;
use Cake\ORM\TableRegistry;
use Cake\Network\Email\Email;  

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController
{
	function beforeFilter(Event $event) {
	    parent::beforeFilter($event);
	    // $this->getEventManager()->off($this->Csrf);
	    $this->viewBuilder()->setLayout('admin');
		 $this->Auth->allow(['home','terms','notification','offer']);
	}
    var $helpers = array('Html'); 
	public function warehouse()
    {
		$user_id=$this->Auth->user('id');
		$AddresTable 	=	TableRegistry::get('Address');
		$list = $AddresTable->find()->where(['customer_id'=>$user_id,'address_for'=>'supplier'])->toArray();
		$this->set(compact('list'));
    }
	
	function updateaddress()
	{
		$this->viewBuilder()->setLayout(false);
		$save_status=false;
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			// pr($request);
			// die;   
			$AddresTable 	=	TableRegistry::get('Address');
			if($request['add_by']==1)
			{
				$request['address_status']="approved";
				$request['is_active']="1";
			}
			else
			{				
				$request['address_status']="requested";
				$request['is_active']="0";				
			}
			$request['address_for']="supplier";
			
			extract($request);
			if($type=="add")
			{
				$session_user_id=$request['user_id'];
				$request['customer_id']=$session_user_id;
				if($_FILES['add_address_prof'])
				{
					$add_address_prof = $this->uploadImage($_FILES['add_address_prof']);
					$request['add_address_prof']='http://resellermantra.com/profile/'.$add_address_prof;
				}
				$pastcount = $AddresTable->find()->where(['customer_id'=>$session_user_id,'address_for'=>'supplier'])->count();
				if($pastcount==0)
					$request['is_default']='y';
				$addr = $AddresTable->newEntity($request);
				// pr($user);die;
				if ($AddresTable->save($addr)) {
				//	$this->Flash->set('New Addresss is Added', ['element' => 'success','class'=>'success']);
					$save_status=true;
				}
				
			}
			else  if($type=="edit")
			{
				$session_user_id=$request['user_id'];
				$address_id=$request['address_id'];
				$pastadd = $AddresTable->find()->where(['customer_id'=>$session_user_id,'address_for'=>'supplier','entity_id'=>$address_id])->first();
				
				if($pastadd>0)
				{
					if($name)
					$pastadd->name=$name;
					if($address)
					$pastadd->address=$address;
					if($address2)
					$pastadd->address2=$address2;
					if($contact)
					$pastadd->contact=$contact;
					if($city)
					$pastadd->city=$city;
					if($zipcode)
					$pastadd->zipcode=$zipcode;
					if($state)
					$pastadd->state=$state;
					if($_FILES['edit_address_prof'])
					{
						$edit_address_prof = $this->uploadImage($_FILES['edit_address_prof']);
						$pastadd->add_address_prof='http://resellermantra.com/profile/'.$edit_address_prof;
					}
					if($alternate_contact)
					$pastadd->alternate_contact=$alternate_contact;
					if($sellerAddressId)
						$pastadd->sellerAddressId=$sellerAddressId;
					
						$pastadd->address_status="approved";
					if($is_default=="on" && $is_active)
						$pastadd->is_default="y";
					else
					$pastadd->is_default="n";	
					// echo $is_edit_active;
					// die;
						$pastadd->is_active=$is_edit_active;
					// pr($pastadd);
				// die;
					if($AddresTable->save($pastadd))
					{
						$save_status=true;
						//$this->Flash->set('Address Updated Successfully', ['element' => 'success','class'=>'success']);
					}
					
			
				}
				
			}
			
			if($save_status)
			{
				$r=array('status'=>true,'msg'=>'Address Save Successfully');	
			}
			else
			{
				$r=array('status'=>false,'msg'=>'Failed,Try Again');	
			}
			
		}     
		$this->redirect(['action' => 'userdetail',$session_user_id]);                
		// echo json_encode($r);
		// die;
	}
	function changeuserstatus($status,$id,$user_type)
	{
		$conn = ConnectionManager::get('default');
		$UserTable = TableRegistry::get('Users');
		$user=$UserTable->find()
						->where(['Users.id'=>$id])
					  ->first();
		if($user)
		{
			$user_email=$user->email;
			$display_name=$user->display_name;
			
			$cat_list = $conn->execute("UPDATE users SET `status` = '$status' WHERE `users`.`id`='$id'");
			
		}
		$this->redirect(['action' => 'userlist',$user_type]);
	}
    public function login()
    {
		extract($this->request->data);
		// pr($this->request->data);
		// die;
    	$this->viewBuilder()->setLayout('login');
		$UserTable = TableRegistry::get('Users');
		if ($this->request->is('post')) {
			$validate_entity=$UserTable->newEntity($this->request->data,['validate'=>'default']);
			
			if(!$validate_entity->errors())
			{
				date_default_timezone_set("UTC");
				$utcdate=date('Y-m-d');
				$current_utc=strtotime($utcdate);
				$encry="Jy5d1F4JC0p11YA8W1adqZ0KjC3Q85AB".$password;
				  $newpass=sha1($encry);
				// die;
				$checkuserstatus=$UserTable->find()
						->where(['Users.mobile'=>$username,'Users.pass'=>$password])
					  ->first();
				// pr($checkuserstatus);
				// die;   
				if(count($checkuserstatus)>0)
				{
						
					$user_status=$checkuserstatus->status;
					if($user_status=="active")
					{
						$role=$checkuserstatus->role;
						$user['name']=$checkuserstatus->display_name;
						$user['mobile']=$checkuserstatus->mobile;
						$user['id']=$checkuserstatus->id;
						$user['store_image']=$checkuserstatus->store_image;
						// login role 1 for admin , 2 reseller ,3 supplier , 4 staff 
						if($user_role=="staff" && $role=="1")
						$login_role=1;
						if($user_role=="supplier")
						$login_role=3;
						if($user_role=="reseller")
						$login_role=2;
						if($user_role=="staff" && $role=="4")
						$login_role=4;
						$user['role_id']=$checkuserstatus->role;
						$user['login_role']=$login_role;
						$this->Auth->setUser($user);
						// echo $login_role;
						// die;
						if(($user_role=="reseller") && ($role=='2'))
						{
							// reseller login 
							return $this->redirect([ 'action' => 'dashboard']);	
						} else if(($user_role=="supplier"))
						{
							 $is_suplier=$checkuserstatus->is_suplier;
							
							if($is_suplier=="y")
							{
								// supplier login 
								return $this->redirect([ 'action' => 'dashboard']);	
							}
							else
							{
								$this->Flash->set('Your Profile For Supplier is Not Active,Contact Support', ['element' => 'error','class'=>'error']);
								return $this->redirect([ 'action' => 'login']);	
							}
						} else if($user_role=="staff")
						{
							if(($role=='1') || ($role=='4'))
							{
								// super admin login 
								if($role=="1")
								{
									return $this->redirect([ 'action' => 'dashboard']);	
								}
								else  if($role=='4')
								{
									return $this->redirect([ 'action' => 'selectclient']);	
								}
							} else 
							{
								$this->Flash->set('Invaild Login Access', ['element' => 'error','class'=>'error']);
								return $this->redirect([ 'action' => 'login']);	
							}
						}
					}
					else if($user_status=="block")
					{
						$this->Flash->set('Your Account is Blocked,Contact Support', ['element' => 'error','class'=>'error']);
						return $this->redirect([ 'action' => 'login']);	
					}
				}
				else
					{
					   $this->Flash->set('Invalid Username or password', ['element' => 'error','class'=>'error']);
						return $this->redirect([ 'action' => 'login']);	
					}
			}
			else
				{	
					foreach($validate_entity->errors() as $key=>$err)
						{
							foreach($err as $e)
							{
								$errors[]=$key.":".$e;
								if(!$message)
								$message=$e;
							}
							foreach($errors as $e)
							{
								$this->Flash->set($e, ['element' => 'error','class'=>'error']);
							}
						}
						return $this->redirect(['action' => 'login']);
				}
			
		}
    }
	public function home()
	{
		
		$this->viewBuilder()->setLayout(false);
	}
    function register()
    {
		$this->viewBuilder()->setLayout('register');
		if ($this->request->is('post')) {
			$user = $this->Users->newEntity($this->request->getData());
			// pr($user);die;
		    if ($this->Users->save($user)) {
		        $this->Auth->setUser($user->toArray());
		        return $this->redirect([
		            'controller' => 'Users',
		            'action' => 'login'
		        ]);
		    }
		}	
		
	}
	public function  adduser($user_type)
	{
		if(($user_type=="supplier") || ($user_type=="reseller"))
		{
				$this->set(compact('user_type'));  
		}
		else
		{
			 return $this->redirect(['action' => 'dashboard']);	
		}
		
	}
	public function usercheck()
	{
		$mobile=$this->request->query['number'];
		if($mobile)
		{
			$UserTable = TableRegistry::get('Users');
				$userdata = $UserTable
				->find()
				// ->select(['id','fullname'])
				->where(['mobile'=>$mobile])->first();
			if($userdata)
			{
				
				$res['status']=true;
				$res['code']=200;
				$res['is_new']='n';
				$res['message']="Mobile no is Already Register";
				
				
			}
			else
			{
				$res['is_new']='y';
				$res['status']=false;
				$res['code']=404;
				$res['message']="No data found";
			}
		}
		
		echo json_encode($res);
		die;
		
		
	}
	public function addsupplier()
	{
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			// pr($request);
			// die;
			extract($request);
			if($mobile)
			{
				$UserTable = TableRegistry::get('Users');
				$userdata = $UserTable
				->find()
				->select(['id','fullname'])
				->where(['mobile'=>$mobile])->first();
				if($userdata)
				{
					$this->Flash->set('Mobile No is Already Register Acitvate that', ['element' => 'error','class'=>'error']);
								
				}
				else
				{
				  // new mobile no 
				  $u['username']=$mobile;
				  $u['display_name']=$display_name;
				  $u['role']="3";
				  $u['mobile']=$mobile;
				  $u['created']=date('Y-m-d h:i');
				  $u['fullname']=$display_name;
				  $u['city']=$city;
				  $u['delay_penalty']=$delay_penalty;
				  $u['per_value']=$per_value;
				  $u['user_rating']=$user_rating;
				  $u['status']="inactive";
				  $u['is_suplier']="adminadd";
				  if($manual_ship=="on")
				  $u['manual_ship']="y";
				  $u['created_utc']=strtotime(date('Y-m-d h:i'));
				  $entity =	$UserTable->newEntity($u);
					$result	=	$UserTable->save($entity);
					if($result)
					{
						$ue['user_id']=$result->id;
						$ue['alternative_mobile']=$alternative_mobile;
						if($_FILES['supplier_pic']['name'])
						{
						  $supplier_pic = $this->uploadImage($_FILES['supplier_pic']);
						  $ue['supplier_pic']='http://resellermantra.com/profile/'.$supplier_pic;
						}
						// $ue['full_address']=$full_address;
						$ue['bank_name']=$bank_name;
						$ue['account_holder_name']=$account_holder_name;
						$ue['account_number']=$account_number;
						$ue['ifsc_code']=$ifsc_code;
						$ue['bank_city']=$bank_city;
						$ue['bank_address']=$bank_address;
						
						$ue['gst_number']=$gst_number;
						if($_FILES['gst_doc']['name'])
						{
						  $gst_doc = $this->uploadImage($_FILES['gst_doc']);
						  $ue['gst_doc']='http://resellermantra.com/profile/'.$gst_doc;
						}
						if($_FILES['pan_doc']['name'])
						{
						  $pan_doc = $this->uploadImage($_FILES['pan_doc']);
						  $ue['pan_doc']='http://resellermantra.com/profile/'.$pan_doc;
						}
						if($_FILES['address_prof']['name'])
						{
						  $address_prof = $this->uploadImage($_FILES['address_prof']);
						  $ue['address_prof']='http://resellermantra.com/profile/'.$address_prof;
						}
						$Userextratable 	=	TableRegistry::get('Userextra');
						$entity2 =	$Userextratable->newEntity($ue);
						$result2	=	$Userextratable->save($entity2);
						if($result2)
						{
							$this->Flash->set('New Supplier Created', ['element' => 'success','class'=>'success']);
							
						}
					}
				}
			}
			else
			{
				$this->Flash->set('Required Parameter missed', ['element' => 'error','class'=>'error']);
								
			}
		}
		$this->redirect(['action' => 'userlist',3]);  
	} 
	public function performaction()
	{
		$UserTable = TableRegistry::get('Users');
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			pr($request);
			die;
			extract($request);
		}
	}
	public function userdetail($id)
	{
		 $this->viewBuilder()->setLayout('admin');
		 $login_role=$this->Auth->user('login_role');
		if($id)
		{
			 $AddresTable 	=	TableRegistry::get('Address');
			 $user = $this->Users
			->find()
			
			->where(['id'=>$id])
			->first();
			if($user->is_suplier=="y" ||  $user->is_suplier=="requested" || $user->is_suplier=="adminadd")
			{
				$customeradd = $AddresTable->find()->where(['customer_id'=>$id,'address_for'=>'supplier'])->toArray();
				$is_suplier_p="y";
			}
			else 
			{
				$customeradd = $AddresTable->find()->where(['customer_id'=>$id,'address_for'=>'customer'])->toArray();
				$is_suplier_p="n";
			}
		  // pr($customeradd);
		  // die;
			$user = $this->Users
			->find()
			
			->where(['id'=>$id])
			->first();
			if($user)
			{
				$UserextraTable = TableRegistry::get('Userextra');
				$ue = $UserextraTable
					->find()
					
					->where(['user_id'=>$id])
					->first();
					
			}
			// echo $is_suplier_p;
			// die;
		  $this->set(compact('user','ue','customeradd','is_suplier_p'));
		}
		else
		{
		   return $this->redirect(['action' => 'dashboard']);	
		}
	}
	public function userlist($id)
    {

      $this->viewBuilder()->setLayout('admin');
	  if($id)
	  {
		 
		if($id==2)
		{
			// indicate reseller
			$list = $this->Users
			->find()
			->where(['role'=>'2','is_suplier'=>'n'])
			->order(['id'=>'DESC'])
			->toArray();
		}
		if($id==3)
		{
			// supllier requrested or supllier
			$list = $this->Users
			->find()
			->order(['id'=>'desc'])
			->where(['is_suplier !='=>'n'])
			
			->toArray();	
		}
		 // pr($list);
		// die;    
		$this->set(compact('list','id'));
		
	  }
	  else
	  {
		  return $this->redirect(['action' => 'dashboard']);
	  }
    }
	public function dashboard()
	{
		
		// echo "d";
		// die;     
	  // $this->viewBuilder()->setLayout('admin');
	}
	public function logout()
	{
	    return $this->redirect($this->Auth->logout());
	}
	public function wholeseller()
    {
      $this->viewBuilder()->setLayout('admin');
    }
	 public function reseller()
    {
       $this->viewBuilder()->setLayout('admin');
    }
	public function sellerlist()
	{
		// $userTable = TableRegistry::get('Users');
		$conn = ConnectionManager::get('default');
		$search = $this->request->query('query');   
		$stmt = $conn->execute("SELECT users.*,a.sellerAddressId FROM users inner join customer_address_entity as a on a.user_id=users.id WHERE display_name LIKE '%$search%' and role='3'");
		$results = $stmt ->fetchAll('assoc');
		
		foreach($results as $u)
		{
			$UserResult['name'] = $u["fullname"];
			$UserResult['sellerAddressId'] = $u["sellerAddressId"]; 
			$UserResult['id'] = $u["id"];   
		}
		echo json_encode($UserResult);
		die;
	}
	public function selleraddress()
	{
		$this->viewBuilder()->setLayout(false);
		 $id=$this->request->query['id'];
		 // $id=$this->request->query['select_catelog_id'];
		// $=$this->request->query['id'];
		if($id)
		{
			$AddressTable = TableRegistry::get('Address');
			$singleaddress = $AddressTable
				->find()
				// ->select(['id','fullname'])
				->where(['entity_id'=>$id])->first();
			$customer_id=$singleaddress->customer_id;
			$data = $AddressTable
				->find()
				// ->select(['id','fullname'])
				->where(['customer_id'=>$customer_id,'address_for'=>'supplier'])->order(['is_active'=>"DESC"])->toArray();
			// pr($data);
			// die;
		}
		$this->set(compact('data','singleaddress','id')); 
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			$entity_id=$request['entity_id'];
			$select_catelog_id=$request['select_catelog_id'];
			$CatelogTable = TableRegistry::get('Catelog');
			$data = $CatelogTable
				->find()
				// ->select(['id','fullname'])
				->where(['id'=>$select_catelog_id])->first();
			if($data)
			{
				$data->seller_address_id=$entity_id;
				$CatelogTable->save($data);
			}
			$this->redirect(['controller'=>'catelog']);
		}			
	}
	public function sellerdetail()
	{
		$id=$this->request->query['id'];
		if($id)
		{
			$UserTable = TableRegistry::get('Users');
				$userdata = $UserTable
				->find()
				// ->select(['id','fullname'])
				->where(['id'=>$id])->first();
			if($userdata)
			{
				$table 	=	TableRegistry::get('Address');
				$addressr = $table->find()->where(['customer_id'=>$id,'is_default'=>'y'])->first();
				$res['status']=true;
				$res['code']=200;
				$res['message']="data found";
				$res['seller_name']=$userdata->fullname;
				$res['seller_address_id']=$addressr->entity_id;
				$res['per_value']=$userdata->per_value;
				$res['total_catelog']=$this->totalcatelog($userdata->id);
				
			}
			else
			{
				$res['status']=false;
				$res['code']=404;
				$res['message']="No data found";
			}
		}
		else
		{
			$res['status']=false;
				$res['code']=404;
				$res['message']="No data found";
		}
		echo json_encode($res);
		die;
		
		
	}
	public function totalcatelog($seller_id)
	{
		$CatelogTable = TableRegistry::get('Catelog');
		$total = $CatelogTable->find()->where(['seller_id'=>$seller_id])->count();
		return $total;
	}
	public function testpush2()
	{
		$customer_id=70;
		$table = TableRegistry::get('Users');
		$UserextraTable = TableRegistry::get('Userextra');
		$userdata =$table
				->find()
				// ->select(['mobile','id','is_suplier','fullname','email','mobile','city'])
				->where(['id ='=>$customer_id])->first();
		// pr($userdata);
		// die;
		$reg_ids=$userdata->device_id;
		$table 	=	TableRegistry::get('Users');
				$Userextratable 	=	TableRegistry::get('Userextra');
		 $userextra =$Userextratable
					->find()
					// ->select(['id','path','level','children_count','position','name','is_active'])
					->where(['user_id ='=>$customer_id])->first();
		// pr($userextra);
		// die;
		$userextra->name=$userdata->fullname;
		$userextra->fullname=$userdata->fullname;
		$userextra->email=$userdata->email;
		$userextra->mobile=$userdata->mobile;
		$userextra->city=$userdata->city;
		$reponse['data']	=	$userdata;
		$reponse['data']['profile'] 	=$userextra;  
		
		// $message="";
		$pushMessage="Your Profile is updated";
		$push_title="Your Profile is updated";
		// $this->sendMessageThroughGCM2($registrationIds,$reponse);
		$gcmRegIds[] = $reg_ids;
		// pr($gcmRegIds);
		// die;
		if (isset($gcmRegIds) && isset($pushMessage)) {	
						$regIdChunk=array_chunk($gcmRegIds,1000);
						// $message = array("title" => $push_title,"body"=>$pushMessage,"type"=>$select_type,"link"=>$img_link,"icon"=>'',"sound"=>'','timestamp'=>date('Y-m-d G:i:s'));	
					   $message=    array(
														"body"=>$pushMessage,
														"title"=>$push_title,
														"type"=>"updateProfile",
														"itemid"=>"10017",
														"user_type"=>"1",
														"img"=>$imagge_link,
														"is_background"=>false,
														 'link'=>$url_link,
														// "payload"=>array("my-data-item"=>"my-data-value"),
														"timestamp"=>date('Y-m-d G:i:s')
														);
						
						foreach($regIdChunk[0] as $RegId){
							// print_R($RegId);
							// die;   
							// $fcm="f1znZrWQm4g:APA91bHl_aqfi7GKCKuU2FY1ETt9U1a3cDu0vY-eHaJ2i6gQ_nWBi138RBj3kReEgg4_1Yl8IXNf37oFhoiD_0w6DFBss5lvpQ-wgF0G5t-yuZc4NbEN_8u7CmuhU-WNwi6iaSdUKkMx";
							 $pushStatus =$this->sendMessageThroughGCM2($RegId,$message);
							// break;
						}
						$gcmRegIDs = implode(",",$gcmRegIds);
					$deviceids = implode(",",$deviceid);
					
					//echo $gcmRegIds."-".$pushStatus."<br>";
					// $insert = "insert into $tablename values(NULL, '".$deviceids."','".$gcmRegIDs."', '".$pushStatus."')";
					// mysqli_query($link,$insert); 
					// $_SESSION['table'] = $tablename;
					}
	}
		
   function sendMessageThroughGCMUser($registrationIds, $fcmMsg) {
		       
   
					

					// define( 'API_ACCESS_KEY', 'AIzaSyDfICxMNFxX6w1eX6B5hzGNeNPPzcynRnA');   
					define( 'API_ACCESS_KEY', 'AIzaSyA0VndTr9B3Zhc9kWwDFgQSY7zC4BlSWZE');   

					$fcmFields = array(
						'to' => $registrationIds,
							'priority' => 'high',
						'notification' => $fcmMsg,
						'data' => $fcmMsg,
						'andriod'=>array(
						   'ttl'=>3600 * 1000,
							'priority'=> 'normal',
					   'notification'=>$fcmMsg
						)
					);
					// print_R($fcmFields);
					// die;    
					$fields = array("to" =>$registrationIds,
										"data" => array("data"=>$fcmMsg,
														 // "body"=>$fcmMsg['body'],
														 "body"=>"welcome msg",
														 "title"=>"welcome msg",
														 "type"=>"updateProfile",
														 "img"=>$fcmMsg['img'],
														 'link'=>$fcmMsg['link']
														)
											
									
										);
					// print_R($fields); 
					// die;
					$headers = array(
						'Authorization: key=' . API_ACCESS_KEY,
						'Content-Type: application/json'
					);
					 
					$ch = curl_init();
					curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
					curl_setopt( $ch,CURLOPT_POST, true );
					curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
					curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
					curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
					curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
					$resultpush = curl_exec($ch );
					// print_R($resultpush); 
					// die;
					if ($result === FALSE) {
					// die('Curl failed: ' . curl_error($ch));
					$value = 'Curl failed: ' . curl_error($ch);
					}
					else
					{
					$value = $resultpush;
					}
					curl_close( $ch );
					// echo $value;
					// die;
					return $value;

	}
	function mailtest()
	{
		 try {
									$Email = new Email('default');
									$Email->emailFormat('html')
										 ->subject('Congratulations ! Now you are Verified Supplier on  Reseller Mantra.')
										->template('supplieractive')
										->to('click4mayank@gmail.com')
										->from('resellermantra@gmail.com')
										// ->viewVars($user)
										->send();  
									 }catch (Exception $e) {
											echo 'Exception : ',  $e->getMessage(), "\n";
									}
		die;
	}
	function generateRandomString($length = 6) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
	public function updateprofile()
	{
		if($this->request->is('post')){  
			$request = $this->request->getData();
			extract($request);
			// pr($request);
			// die;      
			if($customer_id)   
			{
				$table 	=	TableRegistry::get('Users');
				$Userextratable 	=	TableRegistry::get('Userextra');
				$userdata =$table
				->find()
				->select(['mobile','id','is_suplier','fullname','email','mobile','city','manual_ship','device_id','display_name','status'])
				->where(['id ='=>$customer_id])->first();
				
				if($userdata)  
				{
					if($fullname)
					$userdata->fullname=$fullname;
					if($display_name)
					$userdata->display_name=$display_name;
					if($mobile)
					$userdata->mobile=$mobile;
					if($user_rating)
					$userdata->user_rating=$user_rating;
					if($manual_ship)
					{
						if($manual_ship=="on")
						$userdata->manual_ship="y";
						else
						$userdata->manual_ship="n";	
					}
					
					
					if($email)
					$userdata->email=$email;
					if($city)
					$userdata->city=$city;
					// extra field for supllier 
				    if($delay_penalty)
					$userdata->delay_penalty=$delay_penalty;
					if($per_value)
					$userdata->per_value=$per_value;
					if($supplier_status=="y")
					{
						$manual_ship=$userdata->manual_ship;
						$AddresTable 	=	TableRegistry::get('Address');
						$addresscount = $AddresTable->find()->where(['customer_id'=>$customer_id,'address_for'=>'supplier','is_default'=>'y'])->count();
						if($addresscount || $manual_ship=="y")
						{
							$userdata->is_suplier="y";
							$pass=$this->generateRandomString();
							
							$encry="Jy5d1F4JC0p11YA8W1adqZ0KjC3Q85AB".$pass;
							 $newpass=sha1($encry);
							$userdata->pass=$pass;
							$userdata->password=$newpass;
							$userdata->username=$userdata->mobile;
						}
						else
						{
							
							$this->Flash->set('First Add Supplier Address', ['element' => 'error','class'=>'error']);
						}
						// send mail to supplier 
						
					}
				    if($supplier_status=="rejected")
					$userdata->is_suplier="rejected";
					if($user_status)
					$userdata->status=$user_status;
				
				     // pr($userdata);
					 // die;   
				    if($table->save($userdata))
					{
						if($supplier_status=="y")
						{
						   if($addresscount || $manual_ship=="y")
						   {						   
						   // send email to supllier 
						     $user_email=$userdata->email;
						  
						   $display_name=$userdata->display_name;
						
						   if($user_email)
							{
								 $status=$userdata->status;
								 $username=$userdata->mobile;
								$s_id="S".$userdata->id;
								// $s_id="S".$userdata->id;
								if($status=="active")
								{
									$userDataArr = array(
										'userFullName' =>$display_name,
										's_id' =>$s_id,
										'pass' =>$pass,
										'username' =>$username
									);
									// send mail to user 
									 try {
										 
									$Email = new Email('default');
									$Email->emailFormat('html')
										 ->subject('Congratulations ! Now you are Verified Supplier on  Reseller Mantra.')
										->template('supplieractive')
										->to($user_email,$display_name)
										->from('resellermantra@gmail.com')
										->setViewVars($userDataArr)
										->send();
										echo "mail send";
									 }catch (Exception $e) {
											echo 'Exception : ',  $e->getMessage(), "\n";
									}
								}
							}
						}
						}
					}
				    $userextra =$Userextratable
					->find()
					// ->select(['id','path','level','children_count','position','name','is_active'])
					->where(['user_id ='=>$customer_id])->first();
					// print_R($userextra);
					// die;
					
					if($userextra)
					{
						// all banking detail 
						if($alternative_mobile)
						$userextra->alternative_mobile=$alternative_mobile;
					     
						// $userextra->full_address=$full_address;
						if($bank_name)
						$userextra->bank_name=$bank_name;
						if($account_holder_name)
						$userextra->account_holder_name=$account_holder_name;
						if($account_number)
						$userextra->account_number=$account_number;
						if($ifsc_code)
						$userextra->ifsc_code=$ifsc_code;
						if($bank_city)
						$userextra->bank_city=$bank_city;
						if($bank_address)
						$userextra->bank_address=$bank_address;
						// gest detail 
						if($gst_number)
						$userextra->gst_number=$gst_number;
						if($pancard)
						$userextra->pancard=$pancard;
						if($address)
						$userextra->address=$address;
						if($address2)
						$userextra->address2=$address2;
						if($_FILES['gst_doc']['name'])
						{
						  $gst_doc = $this->uploadImage($_FILES['gst_doc']);
						  $userextra->gst_doc='http://resellermantra.com/profile/'.$gst_doc;
						}
						if($_FILES['supplier_pic']['name'])
						{
						  $supplier_pic = $this->uploadImage($_FILES['supplier_pic']);
						  $userextra->supplier_pic='http://resellermantra.com/profile/'.$supplier_pic;
						}
						if($_FILES['pan_card']['name'])
						{
							$pan_card = $this->uploadImage($_FILES['pan_card']);
							$userextra->pan_card='http://resellermantra.com/profile/'.$pan_card;
						}
						if($_FILES['address_prof']['name'])
						{
							$address_prof = $this->uploadImage($_FILES['address_prof']);
							$userextra->address_prof='http://resellermantra.com/profile/'.$address_prof;
						}
						if($type=="basic")
						$userextra->basic_profile="y";
						if($type=="bank")
						$userextra->bank_profile="y";
						if($type=="gst")
						$userextra->gst_profile="y";
						if($reject_type)
						{
							if($reject_type=="basic")
							$userextra->basic_profile="n";
							if($reject_type=="bank")
							$userextra->bank_profile="n";
							if($reject_type=="gst")
							$userextra->gst_profile="n";
							if($reject_type=="address")
							$userextra->address_profile="n";
							$userextra->rejection_comment=$rejection_comment;
						}
						
						if($type=="address")
						$userextra->address_profile="y";
					// pr($userextra);
					// die;
						$resultsave=$Userextratable->save($userextra);
						if($resultsave){
							// saved data
							// echo "profile updated";
							//return $this->redirect(['action' => 'userdetail',$customer_id]);
						}   
						else
						{
							//failed 
							
						}
					}
					else
					{
						// create new user exrta data field 
						$ue['user_id']=$customer_id;
						if($alternative_mobile)
						$ue['alternative_mobile']=$alternative_mobile;
						// if($full_address)
						// $ue['full_address']=$full_address;
						if($bank_name)
						$ue['bank_name']=$bank_name;
						if($account_holder_name)
						$ue['account_holder_name']=$account_holder_name;
						if($account_number)
						$ue['account_number']=$account_number;
						if($ifsc_code)
						$ue['ifsc_code']=$ifsc_code;
						if($bank_city)
						$ue['bank_city']=$bank_city;
						if($bank_address)
						$ue['bank_address']=$bank_address;
						if($gst_number)
						$ue['gst_number']=$gst_number;
						if($address)
						$ue['address']=$address;
						if($pancard)
						$ue['pancard']=$pancard;
						if($address2)
						$ue['address2']=$address2;
						if($_FILES['gst_doc']['name'])
						{
						  $gst_doc = $this->uploadImage($_FILES['gst_doc']);
						  $ue['gst_doc']='http://resellermantra.com/profile/'.$gst_doc;
						}
						if($_FILES['supplier_pic']['name'])
						{
						  $supplier_pic = $this->uploadImage($_FILES['supplier_pic']);
						  $ue['supplier_pic']='http://resellermantra.com/profile/'.$supplier_pic;
						}
						if($_FILES['pan_card']['name'])
						{
							$pan_card = $this->uploadImage($_FILES['pan_card']);
							$ue['pan_card']='http://resellermantra.com/profile/'.$pan_card;
						}
						if($_FILES['address_prof']['name'])
						{
							$address_prof = $this->uploadImage($_FILES['address_prof']);
							$ue['address_prof']='http://resellermantra.com/profile/'.$address_prof;
						}
						$userextra = $Userextratable->newEntity($ue);
						$Userextratable->save($userextra);
						
					}
					// pr($userdata);
					// die;
					// send push for profile update 
						         
						$reg_ids=$userdata->device_id;
						if($reg_ids)
						{
							$reponse['data']	=	$userdata;
							$reponse['id']	=	$userdata->id;
							$reponse['otp']	='';
							$reponse['newuser']	=false;
							$userextra['id']=$userdata->id;
							$userextra['name']=$userdata->fullname;
							$userextra['fullname']=$userdata->fullname;
							$userextra['email']=$userdata->email;
							$userextra['mobile']=$userdata->mobile;
							$userextra['city']=$userdata->city;
							if($userextra)
							$reponse['data']['profile'] 	=$userextra;
							else
							$reponse['data']['profile'] 	='';
						$push_title="Profile Updated";
							$message=    array(
												"body"=>$pushMessage,
												"title"=>$push_title,
												"type"=>"updateProfile",
												"itemid"=>"10017",
												"user_type"=>"1",
												"img"=>'',
												"is_background"=>false,
												 'link'=>'',
												// "payload"=>array("my-data-item"=>"my-data-value"),
												"timestamp"=>date('Y-m-d G:i:s'),
												"profile"=>$reponse
														);
							 $pushStatus =$this->sendMessageThroughGCMUser($reg_ids,$reponse);
						}
						
				}
			}  
		}
		
		return $this->redirect(['action' => 'userdetail',$customer_id]);
	}
	 function uploadImage($file=''){ 
    	if(!empty($file) && $file['error']==0){
    		$source = $file['tmp_name'];
    		$sub_dir = date('Y')."/".date('m')."/";
    		$dir = WWW_ROOT."profile/";
    		if(!file_exists($dir)){
    			mkdir($dir,0777,true);
    		}
    		// $name = time().str_replace(" ", "-", $file['name']);
    		$uniquesavename=time().uniqid(rand());
    		$name= $uniquesavename . '.png';
    		move_uploaded_file($source, $dir.$name);
    		return $name;
    	}

    }
	function sendpush()
	{
		$this->viewBuilder()->setLayout('admin');
		if($this->request->is('post')){
			$request = $this->request->getData();
			// pr($request);
			// die;
			 $user_data=array();
			
			$query =$this->Users
			->find()
			->select(['id','device_id'])
			->where(['status'=>'active','device_id !='=>'','id'=>'109'])
			->order(['id'=>'DESC'])
			->all()
			;
			// print_R($query);
			// die;
			foreach ($query as $data) {
			   $user_data[]=$data;
			}
			if(count($user_data)>0)
			{
				foreach($user_data as $rec)
				{
					$gcmRegIds[] = $rec['device_id'];
					// $deviceid[] = $rec['device_id'];
					// break;
				}
				$pushMessage=$request["push_message"];
				$select_type=$request["select_type"];
				$push_title=$request["tittle"];
				// $img_link='';
				$url_link=$request['url_link'];
				$imagge_link=$request['link'];
				if(($select_type=="Image") || ($select_type=="Youtube"))
				{
					if($select_type=="Youtube")
					{
						// $url_link=$_POST['url_link'];
					}
					else
					{
						$imagge_link=$request['link'];
						if($imagge_link=="")
						{
							  if(isset($_FILES['image'])){
								  $image = $this->uploadImage($_FILES['image']);
								$imagge_link = "http://resellermantra.com/image/". $image;
							
						   }
						}
					}
					// eiter upload push 
					
					
				}
				$url_link="http://resellermantra.com/image/2019/08/156701751120364920685d66ca2730bb0.png";
				$select_type="order";
					if (isset($gcmRegIds) && isset($pushMessage)) {	
						$regIdChunk=array_chunk($gcmRegIds,1000);
						// $message = array("title" => $push_title,"body"=>$pushMessage,"type"=>$select_type,"link"=>$img_link,"icon"=>'',"sound"=>'','timestamp'=>date('Y-m-d G:i:s'));	
					   $message=    array(
														"body"=>$pushMessage,
														"title"=>$push_title,
														"type"=>$select_type,
														"itemid"=>"8091",
														"user_type"=>"1",
														"img"=>$url_link,
														"is_background"=>false,
														 'link'=>$url_link,
														// "payload"=>array("my-data-item"=>"my-data-value"),
														"timestamp"=>date('Y-m-d G:i:s'),
														"id"=>"15",
														"catelog_id"=>"15",
														"name_en"=>"Non Cod Product edited",
														"name_hn"=>" ",
														"description"=>"Non cod product<br>",
														"img_height"=>0.67,
														"img_width"=>"700",
														"img_type"=>"portrait",
														"selling_price"=>"510",
														"amount"=>"510",
														"off"=>"0",
														"shipping_charges"=>"100",
														"cod"=>"100",
														"rating"=>"4.2",
														"share_text"=>"*Non Cod Product*\r\n\r\nNon cod product\r\n\r\n*Type* : my data\r\n\r\n*Fit* : full\r\n\r\n*Shipping* : *Free Shipping*\r\n\r\n*COD Available*: No\r\n\n *Price:*550/-"
														
														);
						
						foreach($regIdChunk[0] as $RegId){
							// print_R($RegId);
							// die;   
							// $fcm="f1znZrWQm4g:APA91bHl_aqfi7GKCKuU2FY1ETt9U1a3cDu0vY-eHaJ2i6gQ_nWBi138RBj3kReEgg4_1Yl8IXNf37oFhoiD_0w6DFBss5lvpQ-wgF0G5t-yuZc4NbEN_8u7CmuhU-WNwi6iaSdUKkMx";
							 $pushStatus =$this->sendMessageThroughGCM($RegId,$message);
							// break;
						}
						$gcmRegIDs = implode(",",$gcmRegIds);
					$deviceids = implode(",",$deviceid);
					
					//echo $gcmRegIds."-".$pushStatus."<br>";
					// $insert = "insert into $tablename values(NULL, '".$deviceids."','".$gcmRegIDs."', '".$pushStatus."')";
					// mysqli_query($link,$insert); 
					// $_SESSION['table'] = $tablename;
					}
			}
			
		
		}
	}
		//Generic php function to send GCM push notification
	function sendMessageThroughGCM($registrationIds, $fcmMsg) {
		       
   
					// pr($fcmMsg);
					// die;

					// define( 'API_ACCESS_KEY', 'AIzaSyDfICxMNFxX6w1eX6B5hzGNeNPPzcynRnA');   
					define( 'API_ACCESS_KEY', 'AIzaSyA0VndTr9B3Zhc9kWwDFgQSY7zC4BlSWZE');   

					$fcmFields = array(
						'to' => $registrationIds,
							'priority' => 'high',
						'notification' => $fcmMsg,
						'data' => $fcmMsg,
						'andriod'=>array(
						   'ttl'=>3600 * 1000,
							'priority'=> 'normal',
					   'notification'=>$fcmMsg
						)
					);
					// print_R($fcmFields);
					// die;    
					$fields = array("to" =>$registrationIds,
										"data" => array("data"=>$fcmMsg,
														 // "body"=>$fcmMsg['body'],
														 "body"=>"welcome msg",
														 "title"=>"welcome msg",
														 "type"=>$fcmMsg['type'],
														 "img"=>$fcmMsg['link'],
														 'link'=>$fcmMsg['link']
														)
											
									
										);
				echo 	json_encode($fields); 
					// die;
					$headers = array(
						'Authorization: key=' . API_ACCESS_KEY,
						'Content-Type: application/json'
					);
					 
					$ch = curl_init();
					curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
					curl_setopt( $ch,CURLOPT_POST, true );
					curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
					curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
					curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
					curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
					$resultpush = curl_exec($ch );
					print_R($resultpush); 
					// die;
					if ($result === FALSE) {
					// die('Curl failed: ' . curl_error($ch));
					$value = 'Curl failed: ' . curl_error($ch);
					}
					else
					{
					$value = $resultpush;
					}
					curl_close( $ch );
					// echo $value;
					die;
					return $value;

	}

}
