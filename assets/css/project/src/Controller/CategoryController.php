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
use Cake\Routing\Router;

class CategoryController extends AppController
{
	function beforeFilter(Event $event) {
	    parent::beforeFilter($event);
	    // $this->getEventManager()->off($this->Csrf);
	    $this->viewBuilder()->setLayout('admin');
	}
    function index(){
    	
    }
    function add(){
    	$root_category = $this->getRootCategory();
    	if ($this->request->is('post')) {
    		$categoryTable = TableRegistry::get('Category');
    		// pr($this->request->getData());
			// die;
    		$cat_id = $this->request->getData('category_id');

    		if((int)$cat_id >0){
    			if($this->request->getData('delete','') =="delete"){
    				$this->deleteCategory($cat_id);
    			}
    			else{
    				$this->updateCategory($cat_id,$_FILES);
    			}

			}
			else{
				
				$request = $this->request->getData();

				// $old_category = $categoryTable->find()->select(['id'])->where(['name ='=>$request['name']])->first();
				// if(!empty($old_category)){
					// $this->Flash->error('Category already exist');	
				// }else{
					$request['parent_id'] =(int)$this->request->getData('parent_id');
					$path=1;
					$level=0;
					$children_count=0;
					// pr($request);die;
					
					$request['path'] = $path;
					$request['level'] = $level;
					if(isset($_FILES['thumbnail']['name']) && $_FILES['thumbnail']['error']==0){
						$image = $this->uploadImage($_FILES['thumbnail']);	
						$request['thumbnail'] = $image;
					}
					$request['children_count'] = $children_count;
					$category = $categoryTable->newEntity($request);
					$result = $categoryTable->save($category);
					if($result){
						if($request['parent_id']>0){
							$parent_id = $request['parent_id'];
							$category_id = $category->id;
							$parent_category = $categoryTable->get($parent_id); // Return category with id
							$path =$parent_category->path."/".$category_id;
							$children_count =$parent_category->children_count + 1;
							$level =$parent_category->level + 1;
							$parent_category->children_count=$children_count;
							$categoryTable->save($parent_category);
							$category = $categoryTable->get($category_id); // Return category with id
							$category->path=$path;
							$category->level=$level;
							$categoryTable->save($category);


						}	
					}
			    	$this->Flash->success('Category created successfully');	
				
			}
			$this->redirect(['action'=>'add']);
		}
		$this->set(compact('root_category'));
		
    }
    function deleteCategory($cat_id){
    	if((int)$cat_id >0){
			$categoryTable = TableRegistry::get('Category');
			$category = $categoryTable->get($cat_id); // Return category with id 
			$categoryTable->delete($category);
		}
    }
    function updateCategory($cat_id,$FILE_DATA=''){
    	if((int)$cat_id >0){
			$categoryTable = TableRegistry::get('Category');
			$category = $categoryTable->get($cat_id); // Return category with id 
			$category->name = $this->request->getData('name');
			if(isset($FILE_DATA['thumbnail']['name']) && $FILE_DATA['thumbnail']['error']==0){
				$image = $this->uploadImage($_FILES['thumbnail']);	
				$category->thumbnail = $image;
			}
			$category->is_active = $this->request->getData('is_active');
			$categoryTable->save($category);
		}
    }

    function getCategoryData(){
    	$this->autoRender = false;
    	$this->viewBuilder()->setLayout(false);
    	if ($this->request->is('post')) {

    		$cat_id = $this->request->getData('cat_id'); 
    		$category = TableRegistry::get('Category');
			$query = $category
		    ->find()
		    ->select(['id','name','thumbnail','is_active','category_type'])
		    ->limit(1)
		    ->where(['id =' => $cat_id]);
		    foreach ($query as $data) {
		    	if($data['thumbnail']){
		    		$data['thumbnail']=Router::url('/category-thumbnail/', true) . $data['thumbnail'];	
		    	}else{
		    		$data['thumbnail']='';
		    	}
		    	
			   echo json_encode($data);
			}
		    
		}
		exit;
    }
    function getRootCategory(){
    	$category = TableRegistry::get('Category');
		$query = $category
	    ->find()
	    ->select(['id','path','level','children_count','position','name','is_active'])
	    ->order(['name'=>'asc'])
	    ->where(['level ='=>'0']);
	    $simple=[];
	    foreach ($query as $data) {
		   $simple[]=$data;
		}
		return $simple;
    }
    function uploadImage($file=''){
    	if(!empty($file) && $file['error']==0){
    		$source = $file['tmp_name'];

    		$dir = WWW_ROOT."category-thumbnail/";
    		$name = time() ."-". $this->clean($file['name']);
    		if(!file_exists($dir)){
    			mkdir($dir,0777,true);
    		}
    		move_uploaded_file($source, $dir.$name);
    		return $name;
    	}

    }
    function clean($string) {
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

	   return preg_replace('/[^A-Za-z0-9\-\.]/', '', $string); // Removes special chars.
	}
    function subCategoryTree(){
    	
    	$this->viewBuilder()->setLayout(false);
    	$category_data=array();
		if ($this->request->is('post')) {
			$request = $this->request->getData(); 
    		$cat_id = $request['cat_id']; 
    		$category = TableRegistry::get('Category');
			$query = $category
		    ->find()
		    ->select(['id','path','level','children_count','position','name','is_active'])
		    ->where(['parent_id = '=>$cat_id])
		    ->order(['name'=>'asc'])
		    ->all()
		    ;
		    foreach ($query as $data) {
			   $category_data[]=$data;
			}	
		}
		$this->set(compact('category_data'));
    }
}
