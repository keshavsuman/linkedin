<?php
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Event\EventManager;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Error\Debugger;
use Cake\Http\Exception;
// require(ROOT.DS.'vendor' .DS.'php-excel-reader/excel_reader2.php');
// require(ROOT.DS.'vendor' .DS.'php-excel-reader/SpreadsheetReader.php');
// require(ROOT.DS.'vendor' .DS.'php-excel-reader/Demo.php');
// use excel_reader2;
// use SpreadsheetReader;
// use Demo;
class AttributeController extends AppController
{
	function beforeFilter(Event $event) {
	    parent::beforeFilter($event);
	    // $this->getEventManager()->off($this->Csrf);
	    $this->viewBuilder()->setLayout('admin');  
	}
	
    
    function edit(){

    	$option_id = $this->request->getQuery('option_id');
    	$AttributeOptionValue = TableRegistry::get('AttributeOptionValue');
    	$entity  = $AttributeOptionValue->find()->first()->where(['option_id ='=>$option_id]);
		if ($this->request->is('post')) {
    		
    		// pr($this->request->getData());die;	
			$request = $this->request->getData();
			$entity->value=$request['value'];
	    	$this->Flash->success('Option save successfully');
		}
		$this->set(compact('entity'));
    }
	public function attributestyle()
    {
		$product_data=array();
		$Attributestyle = TableRegistry::get('Attributestyle');
		// $query = $Attributestyle
		
	    // ->find()
		// ->where(['style_type'=>'other']);
	    // $config=['maxLimit'=>100,'order'=>['Attributestyle.style_name'=>'asc']];
	    // $attributes = $this->Paginator->paginate($query, $config);
	    // foreach ($attributes as $data) {
		   // $product_data[]=$data;
		// }	
		
		$product_data  = $Attributestyle->find()->where(['style_type ='=>'other'])->toArray();
		// pr($product_data);die;
		$this->set(compact('product_data'));

    }
	public function sizestyle()
    {
		$product_data=array();
		$Attributestyle = TableRegistry::get('Attributestyle');
		$query = $Attributestyle
	    ->find()
		->where(['style_type'=>'size']);
	    $config=['maxLimit'=>50,'order'=>['Attributestyle.style_name'=>'asc']];
	    $attributes = $this->Paginator->paginate($query, $config);
	    foreach ($attributes as $data) {
		   $product_data[]=$data;
		}	
		// pr($product_data);die;
		$this->set(compact('product_data'));

    }
	public function addattributestyle()
    {
		$Attributestyle = TableRegistry::get('Attributestyle');
		$request = $this->request->getData();
		// $attribute_check  = $Attributestyle->find()->where(['style_name'=>$request['style_name']])->first();
		$attribute_check=0;
		if($attribute_check)
		{
			$this->Flash->error('Style with that name already Exit');
			$this->redirect(['action'=>'attributestyle']);
		}
		else
		{
			// print_R($request);
			// die;
			// $request['stype_type']="size";
			$entity = $Attributestyle->newEntity($request);
			$result=$Attributestyle->save($entity);
			if($result)
			{  
				$this->Flash->success('Style save successfully');
				if($request['style_type']=="size")
				$this->redirect(['action'=>'sizestyle']);
				else
				$this->redirect(['action'=>'attributestyle']);	
			}
		}
	}
    function editOption(){
    	$value_id = $this->request->getQuery('value_id');
    	$attribute_id = $this->request->getQuery('attribute_id');
    	$AttributeOptionValue = TableRegistry::get('AttributeOptionValue');
    	$entity  = $AttributeOptionValue->get($value_id);
		if ($this->request->is('post')) {
    		
    		// pr($this->request->getData());die;	
			$request = $this->request->getData();
			$entity->value=$request['value'];
			$AttributeOptionValue->save($entity);
	    	$this->Flash->success('Option save successfully');
	    	$this->redirect(['action'=>'attributeOptions','?'=>['attribute_id'=>$attribute_id]]);
		}
		$this->set(compact('entity'));
    }
    function addOption(){
    	$Attribute = TableRegistry::get('Attribute');
    	$AttributeOption = TableRegistry::get('AttributeOption');
    	$AttributeOptionValue = TableRegistry::get('AttributeOptionValue');
    	$attribute_column  = $Attribute->find()->where(['frontend_input ='=>'select'])->order(['frontend_label'=>'asc'])->all();
		if ($this->request->is('post')) {
    		
    		// pr($this->request->getData());die;

			$request = $this->request->getData();
			$attribute_id = $this->request->getData('attribute_id');
			
				$request['attribute_option_value']['value']=trim($request['option']);
				// pr($request);die;
				extract($request);
				$precheck	=	$AttributeOptionValue->find()->where(['value'=>$option,'style_id'=>$style_id]) ->first();
				// pr($precheck);
				// die;
				if($precheck)
				{
					$this->Flash->error('Size value  already exit for that Style');
					$this->redirect(['action'=>'attributeOptions','?'=>['attribute_id'=>$attribute_id]]);
				}
				else
				{
					$entity = $AttributeOption->newEntity($request);
					$result=$AttributeOption->save($entity);
					// pr($entity);
					// die;
					if($result)
					{
					$this->Flash->success('Option save successfully');
					$this->redirect(['action'=>'attributeOptions','?'=>['attribute_id'=>$attribute_id]]);	
					}
				}
			
			$this->redirect(['action' => 'addOption']);  
		}
		$Attributestyle = TableRegistry::get('Attributestyle');
		$attributestyle  = $Attributestyle->find()->where(['status ='=>'1','style_type'=>'size'])->all();
		$this->set(compact('attribute_column','attributestyle'));
    }
    function addOptionByCSV(){
    	$Attribute = TableRegistry::get('Attribute');
    	$AttributeOption = TableRegistry::get('AttributeOption');
    	$attribute_column  = $Attribute->find()->where(['frontend_input ='=>'select'])->order(['frontend_label'=>'asc'])->all();
    	echo $excel_file		=	$this->request->getAttribute('webroot')."sample.xlsx";
		$Reader = new SpreadsheetReader($excel_file);
		$data = new Demo();
		
		// foreach ($Reader as $row)
		// {
		// 	pr($row);
		// }
		die;
		// if ($this->request->is('post')) {
    		
    		// pr($this->request->getData());die;

			// $request = $this->request->getData();
			// $attribute_id = $this->request->getData('attribute_id');
			// if($this->isNewOption($request['option'],$attribute_id)){
			// 	$request['attribute_option_value']['value']=trim($request['option']);
			// 	// pr($request);die;

			// 	$entity = $AttributeOption->newEntity($request);
			// 	$AttributeOption->save($entity);
			// 	$this->Flash->success('Option save successfully');
			// 	$this->redirect(['action'=>'attributeOptions','?'=>['attribute_id'=>$attribute_id]]);	
			// }
			// else{
			// 	$this->Flash->success('Option already exist');
			// }
		// }
		// $this->set(compact('attribute_column'));
    }

    function isNewOption($value,$attribute_id){
    	$connection =	ConnectionManager::get('default');
    	$result	=	$connection->execute("select at_option.option_id from eav_attribute_option as at_option inner join eav_attribute_option_value as at_value on at_value.option_id=at_option.option_id where at_value.value='{$value}' and at_option.attribute_id=$attribute_id")->fetch();
	    if(!empty($result))
	    {
	    	return false;
	    	
	    }
	    else{
	    	return true;
	    }
	}
	function isNewAttribute($value){
    	$connection =	ConnectionManager::get('default');
    	$result	=	$connection->execute("select attribute_code from eav_attribute where attribute_code='{$value}'")->fetch();
	    if(!empty($result))
	    {
	    	return false;
	    	
	    }
	    else{
	    	return true;
	    }
	}
    function addAttribute(){
		if(isset($this->request->query['id']))
		{
			$id=$this->request->query['id'];
			$this->set(compact('id'));
		}
    	$Attribute = TableRegistry::get('Attribute');
    	// $entity  = $AttributeOptionValue->get($value_id);
		if ($this->request->is('post')) {
    		$backend_type=['text'=>'varchar','select'=>'int','textarea'=>'text','decimal'=>'decimal','datetype'=>'datetype'];
    		$request = $this->request->getData();
    		$request['attribute_code'] = strtolower(str_replace(" ", "_", $request['attribute_name'])).rand(99,10000);
    		$request['frontend_label'] = $request['attribute_name'];
    		$request['att_type'] = "catelog";
    		// $request['att_type'] ="text";
    		$request['backend_type'] = isset($backend_type[$request['frontend_input']]) ? $backend_type[$request['frontend_input']] :'text';
			// print_R($request);
			// die;

    			$entity = $Attribute->newEntity($request);
				$Attribute->save($entity);
		    	$this->Flash->error('Attribute save successfully');
				if(isset($this->request->query['id']))
				{
					$this->redirect(['action'=>'index',$this->request->query['id']]);
				}
				else
				{
					$this->redirect(['action'=>'index']);	
				}
    		 
			 $this->redirect(['action' => 'addAttribute']); 
	    	
		}
		$Attributestyle = TableRegistry::get('Attributestyle');
		$attributestyle  = $Attributestyle->find()->where(['status ='=>'1','style_type'=>'other'])->all();
		// pr($attributestyle);
		// die;
		$this->set(compact('entity','attributestyle'));
    }
    function index($id){	
    	$product_data=array();
		$Product = TableRegistry::get('Attribute');
		$Attributestyle = TableRegistry::get('Attributestyle');
		$styledata  = $Attributestyle->find()->where(['id'=>$id])->first();
		$query = $Product
		->find()
		->where(['style_id'=>$id]);
	    
		
	    $config=['order'=>['Attribute.attribute_name'=>'asc']];
	    $attributes = $this->Paginator->paginate($query, $config);
	    foreach ($attributes as $data) {
		   $product_data[]=$data;
		}	
		// pr($product_data);die;
		$this->set(compact('product_data','styledata','id'));
    }
    function attributeOptions(){	
    	$product_data=array();
    	// pr($this->request->getQuery());die;
    	$attribute_id = $this->request->getQuery('attribute_id');
    	$style_id = $this->request->getQuery('style_id');
		$Product = TableRegistry::get('AttributeOption');
		$query = $Product
	    ->find()
	    ->where(['AttributeOption.style_id ='=>$style_id,'AttributeOption.attribute_id'=>28])
	    ->contain(['AttributeOptionValue'])
	    ->all()
	    ;
	    foreach ($query as $data) {
		   $product_data[]=$data;
		}	
		$style_id=$product_data[0]['style_id'];
		$Attributestyle = TableRegistry::get('Attributestyle');
		$styledata  = $Attributestyle->find()->where(['id'=>$style_id])->first();
		// pr($product_data);die;
		$this->set(compact('product_data','styledata'));
    }
    function getAttributes($product_id=0){
    	$conn = ConnectionManager::get('default');
    	$attribute = TableRegistry::get('Attribute');
    	$query	=	$attribute
    				->find()
    				->all();
    	foreach ($query as $data) {
    		$attribute_id = $data['attribute_id'];
    		$jointable = "catalog_product_entity_".$data['backend_type'];
    		if($data['frontend_input']=='select'){
    			$options = $conn->execute("select * from eav_attribute_option as o inner join eav_attribute_option_value as ov on o.option_id=ov.option_id where o.attribute_id=$attribute_id order by ov.value asc")->fetchAll('assoc');
    			$data['options']=$options;
    		}
    		if($product_id){
				$select_value = $conn->execute("select value from $jointable as at_value where at_value.attribute_id=$attribute_id and at_value.entity_id=$product_id and store_id=0 limit 1")->fetch('assoc');
				$data['selected_value']=isset($select_value['value']) ? $select_value['value']:'';
			}
		   $attribute_column[]=$data;
		}
		return $attribute_column;			
    }
}
