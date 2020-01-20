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

class ApiController extends RestController
{
	function beforeFilter(Event $event) {
	    // parent::beforeFilter($event);
         // $this->getEventManager()->off($this->Csrf);
	    $this->viewBuilder()->setLayout(false);
	    $this->request->withData('data',array_map('trim',$this->request->getData()));
	}
    function homeapi()
	{
		$i=0;
		$c[0]['id']=1;
		$c[0]['name']='Men';
		$c[0]['image']='http://13.233.186.157/img/app/group_1469.png';
		$o[0]['title']='Best Selling';
		$o[0]['subtitle']='Order Now';
		$o[0]['image']='http://13.233.186.157/img/app/group_1625.png';
		$co[0]['name']="Women's Collections";
		$co[0]['type']="collection";
		$ct[0]['id']=1;
		$ct[0]['title']="Catelog Title";
		$ct[0]['sellamount']="$700";
		$ct[0]['amount']="1000";
		$ct[0]['off']="30%";
		$ct[0]['sharecount']="300";
		$ct[0]['offer']="30%";
		$co[0]['data']=$ct;
		
		// categoty format id
		$co[1]['name']="You may Like";
		$co[1]['type']="category";
		$cdata[0]['id']=1;
		$cdata[0]['title']="Jacket in Blue";
		$cdata[0]['type']="category"; 
		$cdata[0]['image']='http://13.233.186.157/img/app/group_1469.png';
		
		// product detail 
		$cdata[1]['id']=1;
		$cdata[1]['title']="Jacket in Blue";
		$cdata[1]['type']="product"; 
		$cdata[1]['image']='http://13.233.186.157/img/app/group_1469.png';
		
		$co[1]['data']=$cdata;
	
		  
		$data['record']=$co;
		$data['category']=$c;
		$data['offer']=$o;
		$data['top']=$ct;
		$response['status'] =true;
		$response['data'] =$data;
		$response['code'] =200;
		echo json_encode($response);
		die;	
	}  
    function getSubcategoryies(){
    	if($this->request->is('post')){
    		$cat_id = $this->request->getData('category_id'); 
			$category = TableRegistry::get('Category');
			$query = $category
		    ->find()
		    ->select(['id','name','thumbnail','children_count'])
		    ->where(['parent_id =' => $cat_id]);
		    foreach ($query as $value) {
		    	$data['category_id']=$value['id'];
	    		$data['name']=$value['name'];
	    		if($value['thumbnail']!=''){
	    			$data['thumbnail']=Router::url('/category-thumbnail/', true) . $value['thumbnail'];
	    		}
	    		else{
	    			$data['thumbnail']='';
	    		}
	    		$data['children_count']=$value['children_count'];
	    		$sample[]=$data;
			}   
			$reponse['status'] ="ok";
			$reponse['data'] =$sample;
			$reponse['msg'] ="category list";
    	}else{
    		$reponse['status'] ="error";
			$reponse['data'] ='';
			$reponse['msg'] ="Invalid request type";
    	}
		
		echo json_encode($reponse);
		die;
    }
    function getRootCategory(){
    	$category = TableRegistry::get('Category');
		$query = $category
	    ->find()
	    ->select(['id','children_count','thumbnail','name'])
	    ->order(['name'=>'asc'])
	    ->where(['level ='=>'0']);
	    $sample=[];
	    foreach ($query as $value) {
		   	$data['category_id']=$value['id'];
    		$data['name']=$value['name'];
    		$data['thumbnail']=Router::url('/category-thumbnail/', true) . $value['thumbnail'];
    		$data['children_count']=$value['children_count'];
    		$sample[]=$data;
		}
		$reponse['status'] ="ok";
		$reponse['data'] =$sample;
		$reponse['msg'] ="category list";
		echo json_encode($reponse);
		die;
    }
    function getProductByCategoryId(){
    	$connection = ConnectionManager::get('default');
    	$category_id = $this->request->getData('category_id');
    	$sql = "select p.name_en,p.name_hn,p.pic,p.primary_price,p.selling_price from catalog_category_product as c left join catalog_product_entity as p on c.product_id=p.id where c.category_id=$category_id";	
    	$result = $connection->execute($sql)->fetchAll('assoc');
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$data['name_en'] = $value['name_en'];
				$data['name_hn'] = $value['name_hn'];
				$data['thumbnail'] = Router::url('image/',true).$value['pic'];
				$data['primary_price'] = $value['primary_price'];
				$data['selling_price'] = $value['selling_price'];
				$simple[]=$data;
			}
			$reponse['status'] ="ok";
			$reponse['data'] =$simple;
			$reponse['msg'] ="category list";
		}
		else{
			$reponse['status'] ="error";
			$reponse['data'] ='';
			$reponse['msg'] ="Sorry, we could not found any product here";
		}
		
		echo json_encode($reponse);
		die;
    }
    function search()
    {
    	if($this->request->is('post'))
    	{
    		$sample=[];
    		$keyword = $this->request->getData('q');
    		$sql = "SELECT name_hn,name_en,pic,id FROM catalog_product_entity WHERE name_en LIKE '%" . 
           	$keyword . "%' OR name_hn LIKE '%" . $keyword ."%'";
    		$connection = ConnectionManager::get('default');
    		$result = $connection->execute($sql)->fetchAll('assoc');
    		if(!empty($result)){
	    		foreach ($result as $key => $value) {
	    			$data['product_id'] = $value['id'];
	    			$data['name_en'] = $value['name_en'];
	    			$data['name_hn'] = $value['name_hn'];
	    			$data['thumbnail'] = Router::url('/image/', true).$value['pic'];
	    			$sample[] = $data;
	    		}
    		}
    		$reponse['status'] ="ok";
			$reponse['data'] =$sample;
			$reponse['msg'] ="product list";

    	}else{
    		$reponse['status'] ="error";
			$reponse['data'] ='';
			$reponse['msg'] ="Invalid request type";
    	}
    	
		echo json_encode($reponse);die;
    }
    function signup(){
    	if($this->request->is('post'))
    	{
    		$table 	=	TableRegistry::get('Users');
    		$entity =	$table->newEntity($this->request->getData());
    		$result	=	$table->save($entity);
    		if($result){
    			$result['user_id'] = $result['id'];
    			unset($result['password']);
    			unset($result['device_id']);
    			unset($result['id']);
			}
    	 	$reponse['status']	=	"ok";
			$reponse['data']	=	$result;
			$reponse['msg'] 	=	"Resistration successful";
    	}
    	else{
    		$reponse['status'] ="error";
			$reponse['data'] ='';
			$reponse['msg'] ="Invalid request type";
    	}
    	echo json_encode($reponse);die;
    }
     function loginSocial(){
    	if($this->request->is('post'))
    	{
    		$table 	=	TableRegistry::get('Users');
    		if($this->request->getData('social_id') && $this->request->getData('social_type')){
    			$social_id = $this->request->getData('social_id');
    			$social_type = $this->request->getData('social_type');
    			$result	=	$table->find()->select(['id','email','username','fullname','mobile','social_id','social_type'])->where(['social_id'=>$social_id])->first();
	    		if(empty($result)){
	    			$entity =	$table->newEntity($this->request->getData());
		    		$result	=	$table->save($entity);
	    		}
	    		if($result){
	    			$result['user_id'] = $result['id'];
	    			unset($result['device_id']);
	    			unset($result['id']);
				}
				$message = "Login successful";
    		}
    		else{
    			$message="social id or social type are required";
    		}
    		
    	 	$reponse['status']	=	"ok";
			$reponse['data']	=	$result;
			$reponse['msg'] 	=	$message;
    	}
    	else{
    		$reponse['status'] ="error";
			$reponse['data'] ='';
			$reponse['msg'] ="Invalid request type";
    	}
    	echo json_encode($reponse);die;
    }
    public function signin()
    {
    	if ($this->request->is('post')) {
    		$username = $this->request->getData('username');
    		$password = $this->request->getData('password');
    		$user = new User();
    		$password	=	$user->hashValue($password);
			$table = TableRegistry::get('Users');
			$result	=	$table->find()->select(['user_id'=>'id','username','email','fullname','dob','mobile'])->where(['username'=>$username,'password'=>$password])->first();
			if ($result) {
				$message = "Login successful";
			} else {
				$message = 'Username or password is incorrect';
			}
			$reponse['status']	=	"ok";
			$reponse['data']	=	$result;
			$reponse['msg'] 	=	$message;
		}
		else{
    		$reponse['status'] ="error";
			$reponse['data'] ='';
			$reponse['msg'] ="Invalid request type";
    	}
    	echo json_encode($reponse);die;
    }

}
