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

class ShypliteController extends RestController
{
	function beforeFilter(Event $event) {
	    // parent::beforeFilter($event);
         // $this->getEventManager()->off($this->Csrf);
	    $this->viewBuilder()->setLayout(false);
	    // $this->request->withData('data',array_map('trim',$this->request->getData()));
	}

	public function shypliteplaceorder($o)
	{
		
		pr($o);
		echo "price sum";
		die;   
	}   
	
}
?>