<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Cache\Cache;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
	public function beforeFilter(Event $event)
    {
       // allow all action
        $this->Auth->allow();
		$this->viewBuilder()->setLayout(false);
    	
    }
    function index(){
    	$this->viewBuilder()->setLayout('admin');
    	
    }
	public function notification()
	{
		
	}
	public function offer()
	{
		
	}
	function about()
	{
	}
	function terms()
	{
	}
	function privacy()
	{
	}
	function help()
	{
	}

}
