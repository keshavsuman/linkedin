<?php
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\ORM\TableRegistry;

class AppController extends Controller
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Flash');
        $this->loadComponent('Paginator');
        $this->loadComponent('Auth', [
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'dashboard'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
            ],
            // 'authError' => 'Did you really think you are allowed to see that?',
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'username','password'=>'password']
                ]
            ],
            'storage' => 'Session'
        ]);
    }

    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['index', 'login']);
    }
	public function beforeRender(Event $event) {
     $this->set('Auth', $this->Auth);
	}
	public function totalcatelog($user_id)
	{
		
		$CatelogTable = TableRegistry::get('Catelog');
		$catelogcount = $CatelogTable
				->find()
				// ->select(['id','fullname'])
				->where(['seller_id'=>$user_id])->count();
		return $catelogcount;
	}
	function sendpush($message)
	{
		$UserTable = TableRegistry::get('Users');
		
		if($message['u_id'])
		{
			$u_id=$message['u_id'];
			// pr($u_id);
			// die;
			// $query=$UserTable->find()->where(['id IN'=>$u_id])->all();
				$query =$UserTable
			->find()
			->select(['id','device_id'])
			->where(['status'=>'active','device_id !='=>'','id IN'=>$u_id])  
			->order(['id'=>'DESC'])
			->all()
			;
			
		}
		else
		{
				$query =$UserTable
			->find()
			->select(['id','device_id'])
			->where(['status'=>'active','device_id !='=>''])  
			->order(['id'=>'DESC'])
			->all()
			;
		}
		// pr($query);
		// die;
		 $user_data=array();
			$UserTable = TableRegistry::get('Users');
		
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
				// print_R($gcmRegIds);
				// die;
				$select_type="catelog";
					if (isset($gcmRegIds) && isset($select_type)) {	
						$regIdChunk=array_chunk($gcmRegIds,1000);
						// $message = array("title" => $push_title,"body"=>$pushMessage,"type"=>$select_type,"link"=>$img_link,"icon"=>'',"sound"=>'','timestamp'=>date('Y-m-d G:i:s'));	
					   // print_R($regIdChunk[0]);
						
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
	function showordermsg2($order_status,$cancel_type)
	{
		// echo $cancel_type;
		// die;
		if($order_status=='1')
		{
			$order_msg="APPROVAL PENDING";
			$s_color="yellow";
		}
		if($order_status=='2')
		{
			$order_msg="Waiting for pickup";
			$s_color="orange";
		}
		if($order_status=='3')
		{
			$order_msg="Delivery Pending";
			$s_color="blue";
		}
		if($order_status=='4')
		{
			if($cancel_type=="rejectbyadmin")
				$order_msg="Rejected By Admin";
			else
			$order_msg="Cancel";
			$s_color="pink";
		}
		
		if($order_status=='5')
		{
			$order_msg="Cancel AFTER Approval";
			$s_color="red";
		}
		if($order_status=='6')
		{
			$order_msg="Delivered";
			$s_color="green";
		}
		if($order_status=='7')
		{
			$order_msg="Rto";
			$s_color="gray";
		}
		if($order_status=='8')
		{
			$order_msg="Return By customer";
			$s_color="black";
		}
		if($order_status=='9')
		{
			$order_msg="Approval For payment";
			$s_color="#DDA0DD";
		}if($order_status=='10')
		{
			$order_msg="Close/Payment Done";
			$s_color="purple";
		}
		if($order_status=='11')
		{
			$order_msg="Rejected";
		}
		if($order_status=='12')
		{
			$order_msg="REFUNDED/Dispute";
			$s_color="blue";
		}
		 $d['show_status']=strtoupper($order_msg);
		 $d['s_color']=$s_color;
		 return $d;
	}
	public function sendsms($message,$destination,$registrationIds)
	{
		
		$my_apikey = "UOWALZAO8KLT6Y574YKF";
		// $destination =$destination;
		$destination="+91".$destination;
		// $message = "Hello Welcome Api";
		$api_url = "http://panel.capiwha.com/send_message.php";
		$api_url .= "?apikey=". urlencode ($my_apikey);
		$api_url .= "&number=". urlencode ($destination);
		$api_url .= "&text=". urlencode ($message);
		$my_result_object = json_decode(file_get_contents($api_url, false));
		// pr($my_result_object);
		// die;
		// if($registrationIds)
		// $this->sendMessageThroughGCM($registrationIds,$message);
	}
	function sendMessageThroughGCM($registrationIds, $fcmMsg) {
		// pr($fcmMsg);
		// die;
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
														 "body"=>$fcmMsg['body'],
														 "title"=>$fcmMsg['title'],
														 "type"=>$fcmMsg['type'],
														 "img"=>$fcmMsg['link'],
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
	function sendOnesignalMessage($content,$heading) {
     // pr($);
    $hashes_array = array();
    array_push($hashes_array, array(
        "id" => "like-button",
        "text" => "Like",
        "icon" => "http://i.imgur.com/N8SN8ZS.png",
        "url" => "https://yoursite.com"
    ));
    array_push($hashes_array, array(
        "id" => "like-button-2",
        "text" => "Like2",
        "icon" => "http://i.imgur.com/N8SN8ZS.png",
        "url" => "https://yoursite.com"
    ));
    $fields = array(
        'app_id' => "742f79da-c99c-42b5-ad49-24ad301dbd5f",
        'included_segments' => array(
            'All'
        ),
        'data' => array(
            "foo" => "bar"
        ),
        'contents' => $content,
        'headings' => $heading,
        'web_buttons' => $hashes_array
    );
    
    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic NGZmYTAwOTEtZWRkZi00ZDU4LWJmMDItY2VlOThkZTIzNWFj'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
}
	function showordermsg($order_status,$cancel_type)
	{
		// echo $cancel_type;
		// die;
		if($order_status=='1')
		{
			$order_msg="APPROVAL PENDING";
		}
		if($order_status=='2')
		{
			$order_msg="Waiting for pickup";
		}
		if($order_status=='3')
		{
			$order_msg="Delivery Pending";
		}
		if($order_status=='4')
		{
			if($cancel_type=="rejectbyadmin")
				$order_msg="Rejected By Admin";
			else
			$order_msg="Cancel";
		}
		
		if($order_status=='5')
		{
			$order_msg="Cancel AFTER Approval";
		}
		if($order_status=='6')
		{
			$order_msg="Delivered";
		}
		if($order_status=='7')
		{
			$order_msg="Rto";
		}
		if($order_status=='8')
		{
			$order_msg="Return By customer";
		}
		if($order_status=='9')
		{
			$order_msg="Approval For payment";
		}if($order_status=='10')
		{
			$order_msg="Close/Payment Done";
		}
		if($order_status=='11')
		{
			$order_msg="Rejected";
		}
		if($order_status=='12')
		{
			$order_msg="REFUNDED/Dispute";
		}
		return strtoupper($order_msg);
	}
    //...
}