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
class CouponController extends AppController
{
	function beforeFilter(Event $event) {
	    parent::beforeFilter($event);
	    // $this->getEventManager()->off($this->Csrf);
	    $this->viewBuilder()->setLayout('admin');
		 $this->Auth->allow(['home','terms','notification','offer']);
	}
	public function index()
	{
	    $PromoTable = TableRegistry::get('Promo');
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			extract($request);
			$promo_save=true;
			if($coupon_code)
			{

				$quote_table=TableRegistry::get('Quote');
				$result	=	$PromoTable->find()->where(['status'=>'active','coupon_code'=>$coupon_code])->first();
				// pr($result);
				// die;
				if($result)
				{
					$promo_save=false;
					$this->Flash->error(__('That Coupon Code Already Exit'));
				}
			}
			if($promo_save)
			{
				$i=0;
				if($coupon_method=="bulk")
				{
					for($i=0;$i<$coupon_stock;$i++)
					{
						if($coupon_code=='')
						{
							$c[$i]['coupon_code']=$this->generatecoupon();
						}
						else
						{
							$c[$i]['coupon_code']=$coupon_code;
						}
						$c[$i]['title']=$title;
						if($valid_from)
						$c[$i]['valid_from']=$valid_from;
						else
						$c[$i]['valid_from']='';
						$c[$i]['valid_to']=$valid_to;
						$c[$i]['coupon_method']=$coupon_method;
						$c[$i]['coupon_stock']=1;
						$c[$i]['min_amount']=$min_amount;
						$c[$i]['max_amount']=$max_amount;
						$c[$i]['discount']=$discount;
						$c[$i]['coupon_type']=$coupon_type;
						// pr($c);
						// die;
						// $coupon_code='';

					}
				}
				else
				{
					if($coupon_code=='')
						{
							$c[$i]['coupon_code']=$this->generatecoupon();
						}
						else
						{
							$c[$i]['coupon_code']=$coupon_code;
						}
						$c[$i]['title']=$title;
						if($valid_from)
						$c[$i]['valid_from']=$valid_from;
						else
						$c[$i]['valid_from']='';
						$c[$i]['valid_to']=$valid_to;
						$c[$i]['coupon_method']=$coupon_method;
						$c[$i]['coupon_stock']=$coupon_stock;
						$c[$i]['min_amount']=$min_amount;
						$c[$i]['max_amount']=$max_amount;
						$c[$i]['discount']=$discount;
						$c[$i]['coupon_type']=$coupon_type;
				}

				// pr($c);
				// die;
				if(count($c)>0)
				{
					$entity =	$PromoTable->newEntities($c);
					$trasresult	=	$PromoTable->saveMany($entity);
					// $PromoTable->save($trasresult);
					// die;
					if($trasresult)
					$this->Flash->success(__('Promo Code Created Successfully'));
					else
					$this->Flash->error(__('Something Went Wrong to Save Record'));
				}
				else
				{
					$this->Flash->error(__('Something Went Wrong to Save Record'));
				}
			}

		}
		$UserTable = TableRegistry::get('Users');
		$userlist=$UserTable->find()
						->where(['Users.status'=>'active','role !='=>'1'])
						->order(['id'=>'DESC'])
					  ->toArray();
		// pr($userlist);
		// die;
		$record	=	$PromoTable->find()->where(['status'=>'active'])->toArray();
		$this->set(compact('record','userlist'));

	}
	function couponuser()
	{
		$request = $this->request->getData();
		extract($request);
		$connection = ConnectionManager::get('default');
		$q="select pu.*,u.display_name,u.mobile,u.id as u_id from promo_user_list as pu inner join users as u on u.id=pu.user_id where promo_id='$promo_id'";
		$cuser = $connection->execute($q)->fetchAll('assoc');
		$this->set(compact('cuser'));
	}
	function assigncouponuser()
	{
		 $PromoUserTable = TableRegistry::get('Promouser');
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			$request['added_date']=date('d-m-y h:i');
			$req = $PromoUserTable->newEntity($request);
			// pr($req);die;
		    if ($PromoUserTable->save($req)) {
				$this->Flash->success(__('User Assigner To Promo'));
			}

		}
		return $this->redirect(['action' => 'index']);
	}
	function generatecoupon($length = 6) {
		$PromoTable = TableRegistry::get('Promo');
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString= strtoupper(substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz",6)), 0,6));
		$result	=	$PromoTable->find()->where(['status'=>'active','coupon_code'=>$randomString])->first();
		if($result)
		{
			$this->generatecoupon();
		}
		return $randomString;
	}
}
?>
