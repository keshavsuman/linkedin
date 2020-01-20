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

class OrderController extends AppController
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
}
?>