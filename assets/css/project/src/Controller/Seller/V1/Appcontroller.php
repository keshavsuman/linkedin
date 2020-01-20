<?php
namespace App\Controller\Seller\V1;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

class AppController extends Controller
{

    // use \Crud\Controller\ControllerTrait;

    public function initialize()
    {
         parent::initialize();
		$this->viewBuilder()->layout(false);
        $this->loadComponent('RequestHandler'); 
		$this->viewBuilder()->layout(false);
		$this->loadComponent('Security');
		$this->autoRender = false;
		
		 
    }
	public function beforeFilter(Event $event)
	{
		
		// echo $_SERVER['PHP_AUTH_USER'];
		// if (!isset($_SERVER['PHP_AUTH_USER']))
		// {
			// header('WWW-Authenticate: Basic Admin Log For ="foxity"');
			// header('HTTP/1.0 401 Unauthorized');
			// $array=array('status'=>'0','msg'=>'Not Authorized To Access','data'=>array());
			// echo json_encode($array);
			// exit;
		// } 
		// else 
		// {
		   // if($_SERVER['PHP_AUTH_USER']=="foxity" && $_SERVER['PHP_AUTH_PW']=="ABnVT5h6HHGPjR8J")
			// {
				
			 // }
			 // else
			 // {
			  // $array=array('status'=>'0','msg'=>'Not Authorized To Access','data'=>array());
			 // echo json_encode($array);
			  // exit;
			 // }
		// }
	}
		
	public function isAuthorized($user = null)
    {	
		
		// Only admins can access admin functions
        if ($this->request->params['prefix'] === 'seller') {
			 
			return true;	
			
        }
		
        // Default deny
        return false;
    }
	
	public function apiAuth($token = null)
    {	
		return true;
    }
	
}
