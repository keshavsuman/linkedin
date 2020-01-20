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

class ProductController extends AppController
{
	function beforeFilter(Event $event) {
	    parent::beforeFilter($event);
	    // $this->getEventManager()->off($this->Csrf);
	    $this->viewBuilder()->setLayout('admin');
	}
	function getRootCategory(){
    	$category = TableRegistry::get('Category');
		$query = $category
	    ->find()
	    ->select(['id','path','level','children_count','position','name','is_active'])
	    ->where(['level ='=>'0']);
	    $simple=[];
	    foreach ($query as $data) {
		   $simple[]=$data;
		}
		return $simple;
    }
    function add(){

		$root_category = $this->getRootCategory();
    	$attribute_column = $this->getAttributes();
    	if ($this->request->is('post')) {
    		$ProductTable = TableRegistry::get('Product');
    		// pr($this->request->getData());die;	
			$request = $this->request->getData();
			$request = array_filter($request);
			// pr($request);die;
			$image = $this->uploadImage($_FILES['pic']);
			$request['pic'] = !empty($image)?$image:'';
			$Product = $ProductTable->newEntity($request);
			$result = $ProductTable->save($Product);
			if($result){
				if(!empty($request['category_node']))
				{
					foreach($request['category_node'] as $cid)
					{
						$sub_category[]=['category_id'=>$cid,'product_id'=>$Product->id];
					}
					unset($request['category_node']);
					$request['ProductCategory']=$sub_category;
					$ProductCategoryTable = TableRegistry::get('ProductCategory');
					$entity = $ProductCategoryTable->newEntities($sub_category);
					$ProductCategoryTable->saveMany($entity);
				}
				if(!empty($request['attributes']))
				{
					foreach($request['attributes'] as $attr_data)
					{
						// pr($attr_data);
						$attr_code = key($attr_data); 
						$attr_value = $attr_data[$attr_code];
						$attribute=$this->getAttributeType($attr_code); 
						if($attr_value != ''){
							$attr_insert_data=['attribute_id'=>$attribute->attribute_id,'entity_id'=>$Product->id,'value'=>$attr_value];
							if($attribute->backend_type == 'int'){
								$attrTable = TableRegistry::get('ProductInt');
							}
							elseif($attribute->backend_type == 'varchar'){
								$attrTable = TableRegistry::get('ProductVarchar');
							}
							$attr_entity = $attrTable->newEntity($attr_insert_data);	
							$attrTable->save($attr_entity);
						}
						// pr($attr_insert_data);
					}
				}

			}
	    	$this->Flash->success('Product created successfully');
		}
		$this->set(compact('root_category','attribute_column'));
    }
    function edit(){

    	$product_id = (int)$this->request->getQueryParams('id');

    	if($product_id>0){
    		$ProductTable = TableRegistry::get('Product');
    		$product_entity  = $ProductTable->find()->where(['id ='=>$product_id])->first();
    		if(empty($product_entity)){
    			$this->redirect(['action'=>'index']);
    		}
     	}
     	else{
     		$this->Flash->error('Product not found');
     		$this->redirect(['action'=>'index']);
     	}
		$selected_categories = $this->getProductCategory($product_id);
		$root_category = $this->getRootCategory();
    	$attribute_column = $this->getAttributes($product_id);
    	if ($this->request->is('post')) {
    		$ProductTable = TableRegistry::get('Product');
    		// pr($this->request->getData());die;	
			$request = $this->request->getData();
			$request = array_filter($request);
			// pr($request);
			$image = $this->uploadImage($_FILES['pic']);
			$request['pic'] = !empty($image)?$image:$product_entity->pic;
			$Product = $ProductTable->patchEntity($product_entity,$request);
			$result = $ProductTable->save($Product);
			if(isset($request['category_node'])){
				$this->setProductCategory($request['category_node'],$product_id);
			}
			
			if($result){
				if(!empty($request['attributes']))
				{
					foreach($request['attributes'] as $attr_data)
					{
						// pr($attr_data);
						$attr_code = key($attr_data); 
						$attr_value = $attr_data[$attr_code];
						$attribute=$this->getAttributeType($attr_code); 
						if($attr_value != ''){
							$attr_insert_data=['attribute_id'=>$attribute->attribute_id,'entity_id'=>$Product->id,'value'=>$attr_value];
							if($attribute->backend_type == 'int'){
								$attrTable = TableRegistry::get('ProductInt');
								$attr_entity=$attrTable->find()->where(['attribute_id ='=>$attribute->attribute_id,'entity_id ='=>$product_id])->limit(1)->first();
							}
							elseif($attribute->backend_type == 'varchar'){
								$attrTable = TableRegistry::get('ProductVarchar');

								$attr_entity=$attrTable->find()->where(['attribute_id ='=>$attribute->attribute_id,'entity_id ='=>$product_id])->limit(1)->first();
							}
							if(!empty($attr_entity)){
								$attr_entity = $attrTable->patchEntity($attr_entity,$attr_insert_data);
							}
							else{
								$attr_entity = $attrTable->newEntity($attr_insert_data);
							}
								
							// pr($attr_entity);
							$attrTable->save($attr_entity);
						}
					}
				}

			}
	    	$this->Flash->success('Product created successfully');
		}
		$this->set(compact('root_category','product_entity','selected_categories','attribute_column'));
    }
    function getAttributeType($attribute_code)
    {
    	$attribute_code = strtolower($attribute_code);
    	$attribute = TableRegistry::get('Attribute');
    	$query	=	$attribute
    				->find()
    				->limit(1)
    				->where(['attribute_code ='=>$attribute_code])
 					;
 					foreach ($query as $data) {
					  return $data;
					}	
    }
    
    function setProductCategory($new_categories,$product_id){
    	if((int)$product_id >0){
			$product_categories_table = TableRegistry::get('ProductCategory');
			$product_categories = $product_categories_table->find()->select(['category_id'])->where(['product_id ='=>$product_id])->toList();
			// pr($product_categories);die;
			foreach ($product_categories as $key => $value) {
				$old_categories[] = $value['category_id']; 
			}
			if(count($new_categories) != count($old_categories))
			{
				$product_categories_table->deleteAll(['product_id' => $product_id]);
				if(!empty($new_categories)){

					foreach($new_categories as $cid)
					{
						$sub_category[]=['category_id'=>$cid,'product_id'=>$product_id];
					}
					$ProductCategoryTable = TableRegistry::get('ProductCategory');
					$entity = $ProductCategoryTable->newEntities($sub_category);
					$ProductCategoryTable->saveMany($entity);	
				}
			}
			// pr($old_categories);die;
		}
    }
    function getProductCategory($product_id){
    	$old_categories=[];
    	$product_categories_table = TableRegistry::get('ProductCategory');
		$product_categories = $product_categories_table->find()->select(['category_id'])->where(['product_id ='=>$product_id])->toList();
		// pr($product_categories);die;
		foreach ($product_categories as $key => $value) {
			$old_categories[] = $value['category_id']; 
		}
		return $old_categories;
    }

    function SubCategoryTree(){
    	
    	$this->viewBuilder()->setLayout(false);
    	$category_data=array();
		if ($this->request->is('post')) {
			$request = $this->request->getData(); 
    		$cat_id = $request['cat_id']; 
    		$selected_categories = isset($request['selected_categories'])?explode(',',$request['selected_categories']):array(); 
			$category = TableRegistry::get('Category');
			$query = $category
		    ->find()
		    ->select(['id','path','level','children_count','position','name','is_active'])
		    ->where(['parent_id = '=>$cat_id])
		    ->all()
		    ;
		    foreach ($query as $data) {
			   $category_data[]=$data;
			}	
		}
		$this->set(compact('category_data','selected_categories'));
    }
    function uploadImage($file=''){
    	if(!empty($file) && $file['error']==0){
    		$source = $file['tmp_name'];
    		$sub_dir = date('Y')."/".date('m')."/";
    		$dir = WWW_ROOT."image/".$sub_dir;
    		if(!file_exists($dir)){
    			mkdir($dir,0777,true);
    		}
    		$name = time().str_replace(" ", "-", $file['name']);
    		
    		move_uploaded_file($source, $dir.$name);
    		return $sub_dir.$name;
    	}

    }
    function index(){
    	
    	$product_data=array();
		$Product = TableRegistry::get('Product');
		$query = $Product
	    ->find()
	    ->all()
	    ;
	    foreach ($query as $data) {
		   $product_data[]=$data;
		}	
		// pr($product_data);die;
		$this->set(compact('product_data'));
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
    function csvUpload(){
    	if($this->request->is('post')){
    		if($_FILES['csv']['error']==0){
    			$tmp_name = $_FILES['csv']['tmp_name'];
    			$dir = WWW_ROOT."product_sheet/";
	    		$name = "sheet-".date('Y-m-d-H-i-s').str_replace(" ", "-", $_FILES['csv']['name']);
	    		if(!file_exists($dir)){
	    			mkdir($dir,0777,true);
	    		}
	    		move_uploaded_file($tmp_name, $dir.$name);
    		}
    	}
    }
    function import(){
  //   	require 'vendor/autoload.php';
		// use PhpOffice\PhpSpreadsheet\Spreadsheet;
		// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

		// $spreadsheet = new Spreadsheet();
		// $sheet = $spreadsheet->getActiveSheet();
		// $sheet->setCellValue('A1', 'Hello World !');

		// $writer = new Xlsx($spreadsheet);
		// $writer->save('hello world.xlsx');
    }
}
