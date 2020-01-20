<?php
namespace App\Controller\Seller\V1;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use App\Controller\AppController;
use Cake\Network\Email\Email;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use \Exception;
use Cake\Network\Exception\InvalidCsrfTokenException;

class UsersController extends AppController
{
 public function initialize()
    {
        parent::initialize();
		$this->Auth->allow();
    }
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
		$this->autoRender = false;
		// change parsing way 
		// $parsedata=$this->request->data['data'];
		 // $this->getEventManager()->off($this->Csrf);
        // error_reporting(0);
    }
	function login()
	{
		if($this->request->is('post'))
    	{
			$table 	=	TableRegistry::get('Users');
			$request=$this->request->getData();
			extract($request);
			// role id 1 for reseller 
			
			$result	=	$table->find()->select(['mobile','id','is_suplier','fullname','email','mobile','city'])->where(['mobile'=>$mobile,'role'=>'2'])->first();
			// print_R($result);
			// die;
			if($result)
			{
				$customer_id=$result->id;
				$Userextratable 	=	TableRegistry::get('Userextra');
				$userextra =$Userextratable
					->find()
					// ->select(['id','path','level','children_count','position','name','is_active'])
					->where(['user_id ='=>$customer_id])->first();
				$result->otp=$rand_otp=rand(10000,99999);
				if($table->save($result))
				{
					$reponse['status']	=true;
					$reponse['data']	=	$result;
					$reponse['id']	=	$result->id;
					$reponse['is_suplier']	=	$result->is_suplier;
					$reponse['otp']	=	$rand_otp;
					$reponse['newuser']	=false;
					$userextra->name=$result->fullname;
					$userextra->email=$result->email;
					$userextra->mobile=$result->mobile;
					$userextra->city=$result->city;
					if($userextra)
					$reponse['data']['profile'] 	=$userextra;
					else
					$reponse['data']['profile'] 	='';
					
					$reponse['msg'] 	=	"Login successful";
				}
				else
				{
					$reponse['status']	=false;
					$reponse['msg'] 	=	"Login Failed";
					
				}
				
			}
			else
			{   
				$request['role']=2;
				$request['otp']=$rand_otp=rand(10000,99999);
				$entity =	$table->newEntity($request);
				$result	=	$table->save($entity);
				if($result){
	    			$reponse['status']	=true;
					$reponse['data']	=	$result;
					$reponse['id']	=	$result->id;
					$reponse['otp']	=	$rand_otp;
					$reponse['msg'] 	=	"Resgister successful";
					$reponse['profile'] 	='';
					$reponse['newuser']	=true;
				}
				else
				{
					$reponse['status']	=false;
					$reponse['msg'] 	=	"Register Failed";
					
				}
					
			}
			
		}
		echo json_encode($reponse);die;
	}
 

	
}
?>