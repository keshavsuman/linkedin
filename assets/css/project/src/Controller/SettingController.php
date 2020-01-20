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

class SettingController extends AppController
{
	function beforeFilter(Event $event) {
	    parent::beforeFilter($event);
	    // $this->getEventManager()->off($this->Csrf);
	    $this->viewBuilder()->setLayout('admin');
	}
	function  offerlist()
	{
	  $offerTable = TableRegistry::get('Offer');
	  $offerlist = $offerTable->find()->toArray();
	 
	  $this->set(compact('offerlist'));
	}
	function changeofferstatus($status,$id)
	{
		// echo $status;
		// die;
		$offerTable = TableRegistry::get('Offer');
		$offerlist =$offerTable
						->find()
						// ->select(['id','total_catelog'])
						->where(['id ='=>$id])->first();
		if($status=="block")
			$u_status='2';
		if($status=="active")
			$u_status='1';
		$offerlist->status=$u_status;
		// pr($offerlist);
		// die;
		if($offerTable->save($offerlist))
		{
			$this->Flash->success('Offer Status Changes ');
		}
		else
		{
			$this->Flash->error('Failed to Changed Offer status');
		}
		$this->redirect(['action' =>'offerlist']);
	}
	function deletecollection($id)
	{
		$CollectionTable = TableRegistry::get('Collection');
		$entity = $CollectionTable->get($id);
		// pr($entity);
		// die;
		$result = $CollectionTable->delete($entity);
		$this->redirect(['action' =>'collectionlist']);
	}
	function editcollection()
	{
		$CollectionTable = TableRegistry::get('Collection');
		if ($this->request->is('post')) {
		   $request = $this->request->getData();
		   // pr($request);
		   // die;
		   extract($request);
		   if($collection_id)
		   {
			   $data = $CollectionTable
				->find()
				->where(['id'=>$collection_id])
				// ->order(['id'=>"desc"])
				->first();
				// pr($data);
				// die;
				if($data)
				{
					if($title)
					$data->title=$title;
					if($search_keyword_1)
					$data->search_keyword_1=$search_keyword_1;
					if($search_keyword_2)
					$data->search_keyword_2=$search_keyword_2;
					if($is_slider)
					$data->is_slider=$is_slider;
					if($_FILES['offer_image']['name'])
					{
						$image = $this->uploadImage($_FILES['offer_image']);
						$data->offer_image=$image;
					}  
					$CollectionTable->save($data);
				}
				
		   }
		   
		}
		$this->redirect(['action' =>'collectionlist']);
		
	}
	function collectionlist()
	{
		$CollectionTable = TableRegistry::get('Collection');
		$data = $CollectionTable
			->find()
			->where(['status'=>"y"])
			->order(['id'=>"desc"])
			->toArray();
		$this->set(compact('data'));
		if ($this->request->is('post')) {
		   $request = $this->request->getData();
			extract($request);
			$image = $this->uploadImage($_FILES['offer_image']);
			$request['offer_image']=$image;
			// pr($request);
			// die;
			if(isset($request['is_slider']))
			{
				// if($request['is_slider']=="y")
				$request['is_slider']=$request['is_slider'];
			}
			// pr($request);
			// die;
			$CatelogEntity = $CollectionTable->newEntity($request);
			$result = $CollectionTable->save($CatelogEntity);
			if($result){
				$this->redirect(['action' =>'collectionlist']);
			}
		}
		
	}
	function tutorial()
	{
		$Video = TableRegistry::get('Video');
		$data = $Video
			->find()
			->where(['status'=>"y"])
			->order(['id'=>"desc"])
			->toArray();
		$this->set(compact('data'));
		if ($this->request->is('post')) {
		   $request = $this->request->getData();
			extract($request);
			$image = $this->uploadImage($_FILES['video_img']);
			$request['video_img']=$image;
			// pr($request);
			// die;
			
			// pr($request);
			// die;
			$CatelogEntity = $Video->newEntity($request);
			$result = $Video->save($CatelogEntity);
			if($result){
				$this->redirect(['action' =>'tutorial']);
			}
		}
		
	}
	function edithomepage()
	{
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			
			extract($request);
			$Pageorder = TableRegistry::get('Pageorder');
			$samelist = $Pageorder
			->find()
			->where(['shift_pos'=>$shift_pos,'category_id'=>$category_id,'page_type'=>'home','status'=>'active'])
			->first();
			if($samelist)
			{
			  // make ignore 
			 
			}
			else
			{
				
				$Pageorder->deleteAll(['shift_pos'=>$shift_pos]);
				$Pageorder->deleteAll(['category_id'=>$category_id]);
				$request['page_type']='home';
					$entities = $Pageorder->newEntity($request);
					$result = $Pageorder->Save($entities);
					if($result)
					{
						return $this->redirect(['action' => 'homepage']);
					}
			}
		}
		return $this->redirect(['action' => 'homepage']);
	}
	function categoryorder()
	{
		$category = TableRegistry::get('Category');
		$root_category = $category
	    ->find()
	    ->select(['id','path','level','children_count','position','name','is_active'])
	    
	    ->where(['is_active'=>'1','level'=>'0'])
		->order(['name'=>'asc'])->toArray();  
		$pagelist = $category
	    ->find()
		 ->order(['Category.shift_category'=>'asc'])   
	    ->where(['level ='=>'0'])
		->toArray();
		// pr($pagelist);
		// die;
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			extract($request);
			if($category_id)
			{
				$catdata =$category
				->find()
				->where(['id ='=>$category_id])->first();
				if($catdata)
				{
					$old_position=$catdata->shift_category;
					$catdata->shift_category=$shift_pos;
					$olddata =$category
						->find()
						->where(['shift_category ='=>$shift_pos])->first();
					if($olddata)
					$olddata->shift_category=$old_position;
					if($category->save($catdata))
					{
						if($olddata)
						$category->save($olddata);
					}
				}
			}
			return $this->redirect(['action' => 'categoryorder']);
		}
		$this->set(compact('root_category','pagelist'));
	}
	function homepage()
	{
		$category = TableRegistry::get('Category');
		$Pageorder = TableRegistry::get('Pageorder');
		$root_category = $category
	    ->find()
	    ->select(['id','path','level','children_count','position','name','is_active'])
	    
	    ->where(['is_active'=>'1','level'=>'0'])
		->order(['name'=>'asc'])->toArray();  
		$pagelist = $Pageorder
	    ->find()
		->contain(['Category'])
	    // ->select(['id','path','level','children_count','position','name','is_active'])
	    ->order(['shift_pos'=>'asc'])
	    ->where(['Pageorder.page_type'=>'home','status'=>'active'])
		->toArray();
		// print_R($pagelist);
		// die;  
		$this->set(compact('root_category','pagelist'));
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			extract($request);
			$pagedata	=	$Pageorder->find()->select(['id'])->where(['category_id'=>$category_id,'page_type'=>'home'])->first();
			     
			if($pagedata)
			{
				// break old posting and update to latest one 
				
					$delete=$Pageorder->delete($pagedata);
				if($delete)
				{
					// echo "dd";
					// die;
					$request['page_type']='home';
					$entities = $Pageorder->newEntity($request);
					$result = $Pageorder->Save($entities);
					if($result)
					{
						return $this->redirect(['action' => 'homepage']);
					}
				}
				
			}
			else
			{
			   $request['page_type']='home';
					$entities = $Pageorder->newEntity($request);
					$result = $Pageorder->Save($entities);
					if($result)
					{
						return $this->redirect(['action' => 'homepage']);
					}	
			}
		}
	}
	function adssetup()
	{
		
		$Pageorder = TableRegistry::get('Pageorder');
		
		$pagelist = $Pageorder
	    ->find()
		// ->contain(['Category'])
	    // ->select(['id','path','level','children_count','position','name','is_active'])
	    ->order(['shift_pos'=>'asc'])
	    ->where(['Pageorder.page_type'=>'ads','status'=>'active'])
		->toArray();
		// print_R($pagelist);
		// die;  
		$this->set(compact('pagelist'));
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			extract($request);
			$pagedata	=	$Pageorder->find()->select(['id'])->where(['shift_pos'=>$shift_pos,'page_type'=>'ads'])->first();
			     
			if($pagedata)
			{
				if($title)
				$pagedata->title=$title;
				if($search_keyword_1)
				$pagedata->search_keyword_1=$search_keyword_1;
				if($search_keyword_2)
				$pagedata->search_keyword_2=$search_keyword_2;
				if($_FILES['ad_image'])
				{
					$ad_image = $this->uploadImage($_FILES['ad_image']);
					$pagedata->ad_image=$ad_image;
					
				}
				if($Pageorder->save($pagedata))
				{
					return $this->redirect(['action' => 'adssetup']);
				}
				
			}
			else
			{
				    if($_FILES['ad_image'])
					{
						$ad_image = $this->uploadImage($_FILES['ad_image']);
						$request['ad_image']=$ad_image;
						
					}
					$request['page_type']='ads';
					$entities = $Pageorder->newEntity($request);
					$result = $Pageorder->Save($entities);
					if($result)
					{
						return $this->redirect(['action' => 'adssetup']);
					}
			}
		}
	}
	public function catelogdetail()
	{
       // $this->ViewBuilder::setLayout(false);
		$this->viewBuilder()->layout(false); 
		if ($this->request->is('post')) {
			$connection = ConnectionManager::get('default');
			
			$request = $this->request->getData();
			extract($request);
			
			if($category_id)
			{
				$cat_str='';
				$data=$this->getCatelogByCategoryId($category_id,$cat_str,0);
				$j=0;
				foreach($data as $single)
				{
					$cat[]=$single['catelog_id'];
					$catelog_id=$single['catelog_id'];
					$d[$j]['catelog_id']=$single['catelog_id'];
					$d[$j]['catelog_name']=$single['catelog_name'];
					$d[$j]['selling_price']=$single['selling_price'];
					$d[$j]['seller_name']=$single['seller_name'];
					 $qu="select shift_pos from page_order where catelog_id='$catelog_id' and category_id='$category_id' and page_type='catelog' order by id desc limit 0,1";
				
					$shiftcheck = $connection->execute($qu)->fetch('assoc');
					if($shiftcheck)
					{
						$d[$j]['shift_pos']=$shiftcheck['shift_pos'];
					}
					else
					{
						$d[$j]['shift_pos']='';
					}
					
					$j++;
				}
			    $data=$d;
				// print_R($data);
				// die;
				if(count($data)>0)
				{
					
					 $cat_arr=implode(',',$cat);
					 $qu="select u.id as seller_id,u.fullname as seller_name from users as u where u.is_suplier='y' and id in(select seller_id from catalog_catelog_entity where id in($cat_arr))";
					$sellerlist = $connection->execute($qu)->fetchAll('assoc');
				}
				$this->set(compact('data','sellerlist'));
				
			}
			else
			{
				echo "Required Parameter is not passed.</br></br>";
				die;
			}
		}
	}
	function getCatelogByCategoryId($category_id,$pre_list,$seller_id){
    	$connection = ConnectionManager::get('default');
    	// $category_id = $this->request->getData('category_id');
		
	if($seller_id)
		{
    	    $sql = "SELECT c.id as catelog_id,c.name_en as catelog_name,c.selling_price,u.fullname as seller_name  FROM catalog_catelog_entity as c inner join 
			catalog_category_catelog as cat on cat.catelog_id=c.id inner join users as u  on c.seller_id=u.id  where cat.category_id='$category_id' and u.is_suplier='y' and u.id='$seller_id' and c.pending_stock>0 order by c.id desc  limit 0,50";	
    	
		}
		else
		{     
			 $sql = "SELECT c.id as catelog_id,c.name_en as catelog_name,c.selling_price,u.fullname as seller_name  FROM catalog_catelog_entity as c inner join 
			catalog_category_catelog as cat on cat.catelog_id=c.id inner join users as u  on c.seller_id=u.id  where cat.category_id='$category_id' and u.is_suplier='y'  and c.pending_stock>0  order by c.id desc  limit 0,50";	
    	
		}
		$result = $connection->execute($sql)->fetchAll('assoc');
		// print_R($result);
		// die;   
		return $result;
    }
	public function cateloglist($id)
    {
		$Pageorder = TableRegistry::get('Pageorder');
		$connection = ConnectionManager::get('default');
		if ($this->request->is('post')) {
		
			$request = $this->request->getData();
			// pr($request);
			// die;
			extract($request);
			$pagedata	=	$Pageorder->find()->select(['id'])->where(['category_id'=>$category_id,'page_type'=>'catelog'])->toArray();
		
			if($pagedata)
			{
				// remove all older one 
				$Pageorder->deleteAll(['catelog_id'=>$catelog_id,'page_type'=>'catelog']);
				// $predata = $connection->execute("delete from page_order where catelog_id='$catelog_id' and page_type='catelog'");
				$Pageorder->deleteAll(['shift_pos'=>$shift_pos,'category_id'=>$category_id,'page_type'=>'catelog']);
				
			}
			$request['page_type']='catelog';
			// $request['page_type']='category';
			
					$entities = $Pageorder->newEntity($request);
					$result = $Pageorder->Save($entities);
					if($result)
					{
						return $this->redirect(['action' => 'cateloglist',$id]);
					}
		}
		
			$pagedata = $Pageorder
			->find()
			->contain(['Category'])
			// ->select(['id','path','level','children_count','position','name','is_active'])
			
			->where(['Pageorder.category_id'=>$id])
			->first();
			// print_r($pagedata);
			// die;
			if($pagedata)
			{
				 $cat_id=$pagedata['category_id'];
				// $pagelist = $Pageorder
					// ->find()
					// ->contain(['Catelog'])
					// ->contain(['Catelog'])
					// ->where(['Pageorder.category_id ='=>$cat_id,'Pageorder.page_type'=>'catelog'])
					// ->toArray();
				// print_r($pagelist);
				// die;
				 $sql = "SELECT c.id as catelog_id,c.name_en as catelog_name,c.pic as pic,c.selling_price,u.fullname as seller_name,p.shift_pos,p.start_utc,p.end_utc FROM catalog_catelog_entity as c inner join 
			catalog_category_catelog as cat on cat.catelog_id=c.id inner join users as u  on c.seller_id=u.id inner join page_order as p 
			on p.catelog_id=c.id
			where p.page_type='catelog' and cat.category_id='$cat_id' and u.is_suplier='y'  and c.pending_stock>0  order by c.id desc  limit 0,50";	
					// die;
			$pagelist = $connection->execute($sql)->fetchAll('assoc');
			foreach($pagelist as $p)
			{
				$start_utc=$p['start_utc'];
				$end_utc=$p['end_utc'];
				$go_ahead=false;
				if($start_utc && $end_utc)
				{
					if(($start_utc>$current_utc) && ($end_utc>=$current_utc))
					$go_ahead=true;	
				}
				else
				{
					$go_ahead=true;
				}
				if($go_ahead)
				{
					$pd[$j]['catelog_id']=$p['catelog_id'];
					$pd[$j]['catelog_name']=$p['catelog_name'];
					$pd[$j]['pic']=$p['pic'];
					$pd[$j]['selling_price']=$p['selling_price'];
					$pd[$j]['seller_name']=$p['seller_name'];
					$pd[$j]['shift_pos']=$p['shift_pos'];
					$pd[$j]['start_utc']=$p['start_utc'];
					$pd[$j]['end_utc']=$p['end_utc'];
				}
				$j++;
			}
			$pagelist=$pd;
				// pr($pagelist);
				// die;
				$this->set(compact('pagelist','pagedata','id'));
			}
			else
			{
				return $this->redirect(['action' => 'homepage']);
			}
			
		
	
    }

	public function offerdetail()
	{   
		if ($this->request->is('post')) {
		
			$request = $this->request->getData();
			// $id=$request['id'];
			$offerTable = TableRegistry::get('Offer');
			$detail  = $offerTable->find()->where(['id'=>$request['id']])->first();
			if(count($detail)>0)
			{
				$res['status']=true;
				$res['id']=$detail->id;
				$res['content']=$detail->title;
				$res['offer_type']=$detail->offer_type;
				$res['offer_value']=$detail->offer_value;
				// $res['pic']=$detail->pic;
				if($detail->pic)
				{
					$res['pic']= $this->request->getAttribute("webroot") ."image/".$detail->pic;
				}
				else
				{
				  $res['pic']= '';  
				}
				
				
				$res['msg']="Data found";
			}
			else
			{
				$res['status']=false;
				$res['msg']="Somethign Went Wrong";
				
			}
			echo json_encode($res);
			die;
		}
	}
	public function editoffer($id)
	{
		// $offerTable = TableRegistry::get('Offer');
		$offerTable = TableRegistry::get('Offer');
		$detail  = $offerTable->find()->where(['id'=>$id])->first();
		$this->set(compact('detail'));
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			// pr($request);
			// die;
			extract($request);
			if($title)
			$detail->title=$title;
			if($subtitle)
			$detail->subtitle=$subtitle;
			if($offer_type)
			$detail->offer_type=$offer_type;
			if($offer_value)
			$detail->offer_value=$offer_value;
			if($search_keyword_1)
			$detail->search_keyword_1=$search_keyword_1;
			if($search_keyword_2)
			$detail->search_keyword_2=$search_keyword_2;
			if($status)
			$detail->status=$status;
			if($_FILES['offer_image'] && $request['offer_image']['name'])
			{
				$image = $this->uploadImage($_FILES['offer_image']);
				$detail->offer_image= !empty($image)?$image:'';
			}
			// pr($detail);
			// die;   
			if($offerTable->save($detail))
			{
			  $this->Flash->set('Offer Updated', ['element' => 'success','class'=>'success']);
							
			}
			else
			{
				 $this->Flash->set('Failed to updated offer', ['element' => 'error','class'=>'error']);
							
			}
			return $this->redirect(['action' => 'offerlist']);
		}
		
	}
    public function addoffer()
    {
		$offerTable = TableRegistry::get('Offer');
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			$request = array_filter($request);
			// pr($request);die;
			$image = $this->uploadImage($_FILES['offer_image']);
			$request['offer_image'] = !empty($image)?$image:'';
			$CatelogEntity = $offerTable->newEntity($request);
			$result = $offerTable->save($CatelogEntity);
			if($result){
				return $this->redirect(['action' => 'offerlist']);
			}
		}
    }
	public function policylist()
	{
		$product_data=array();
		$Templatestyle = TableRegistry::get('Templatestyle');
		$query = $Templatestyle
	    ->find();
	    $config=['maxLimit'=>50,'order'=>['Templatestyle.policy_name'=>'asc']];
	    $attributes = $this->Paginator->paginate($query, $config);
	    foreach ($attributes as $data) {
		   $product_data[]=$data;
		}	
		// pr($product_data);die;
		$this->set(compact('product_data'));
	}
	public function modelist()
	{
		$mode_data=array();
		$Mode = TableRegistry::get('Mode');
		$query = $Mode
	    ->find();
	    $config=['maxLimit'=>50,'where'=>['status'=>'y']];
	    $attributes = $this->Paginator->paginate($query, $config);
	    foreach ($attributes as $data) {
		   $mode_data[]=$data;
		}	
		// pr($product_data);die;
		$this->set(compact('mode_data'));
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			$entity = $Mode->newEntity($request);
			$result=$Mode->save($entity);
			if($result)
			{ 
				$this->Flash->success('Courier Mode save successfully');
				$this->redirect(['action'=>'modelist']);
			}
		}
	}
	public function modedetail()
	{
		if ($this->request->is('post')) {
		
			$request = $this->request->getData();
			// $id=$request['id'];
			$Mode = TableRegistry::get('Mode');
			$detail  = $Mode->find()->where(['id'=>$request['id']])->first();
			if(count($detail)>0)
			{
				$res['status']=true;
				$res['mode_name']=$detail->mode_name;
				$res['packageLength']=$detail->packageLength ;
				$res['packageWidth']=$detail->packageWidth ;
				$res['packageHeight']=$detail->packageHeight ;
				$res['packageWeight']=$detail->packageWeight ;
				// $res['pic']=$detail->pic;
				$res['msg']="Data found";
			}
			else
			{
				$res['status']=false;
				$res['msg']="Somethign Went Wrong";
				
			}
			echo json_encode($res);
			die;
		}
	}
	public function policydetail()
	{
		if ($this->request->is('post')) {
		
			$request = $this->request->getData();
			// $id=$request['id'];
			$Templatestyle = TableRegistry::get('Templatestyle');
			$detail  = $Templatestyle->find()->where(['id'=>$request['id']])->first();
			if(count($detail)>0)
			{
				$res['status']=true;
				$res['content']=$detail->content;
				$res['pic']=$detail->pic;
				$res['msg']="Data found";
			}
			else
			{
				$res['status']=false;
				$res['msg']="Somethign Went Wrong";
				
			}
			echo json_encode($res);
			die;
		}
	}
	public function addpolicystyle()
    {
		$Templatestyle = TableRegistry::get('Templatestyle');
		$request = $this->request->getData();
		$attribute_check  = $Templatestyle->find()->where(['policy_name'=>$request['policy_name']])->first();
		if($attribute_check)
		{
			$this->Flash->error('Style with that name already Exit');
			$this->redirect(['action'=>'policylist']);
		}
		else
		{
			// print_R($request);
			// die;
			if($_FILES['pic'])
			{
				$image = $this->uploadImage($_FILES['pic']);
				$request['pic'] = !empty($image)?$image:'';
			}
			$entity = $Templatestyle->newEntity($request);
			$result=$Templatestyle->save($entity);
			if($result)
			{ 
				$this->Flash->success('Style save successfully');
				$this->redirect(['action'=>'policylist']);
			}
		}
	}
	public function sellercatelog()
	{
		if($this->Auth->user())
		{
			$parent_user_id=$this->Auth->user('id');
		
		}
		// $route_id=1;
		$this->viewBuilder()->layout(false); 
		if($this->request->is('post'))
        {
			// print_R($this->request->data);
			extract($this->request->data);
			$connection = ConnectionManager::get('default');
			
			$request = $this->request->getData();
			extract($request);
			
			if($category_id)
			{
				$cat_str='';
				if($seller_id=='-1')
				$seller_id='';
				$data=$this->getCatelogByCategoryId($category_id,$cat_str,$seller_id);
				$j=0;
				foreach($data as $single)
				{
					$cat[]=$single['catelog_id'];
					$catelog_id=$single['catelog_id'];
					$d[$j]['catelog_id']=$single['catelog_id'];
					$d[$j]['catelog_name']=$single['catelog_name'];
					$d[$j]['selling_price']=$single['selling_price'];
					$d[$j]['seller_name']=$single['seller_name'];
					 $qu="select shift_pos from page_order where catelog_id='$catelog_id' and category_id='$category_id' and page_type='category' order by id desc limit 0,1";
				
					$shiftcheck = $connection->execute($qu)->fetch('assoc');
					if($shiftcheck)
					{
						$d[$j]['shift_pos']=$shiftcheck['shift_pos'];
					}
					else
					{
						$d[$j]['shift_pos']='';
					}
					
					$j++;
				}
			    $data=$d;
				// print_R($data);
				// die;
				if(count($data)>0)
				{
					
					 $cat_arr=implode(',',$cat);
					 $qu="select u.id as seller_id,u.fullname as seller_name from users as u where u.is_suplier='y' and id in(select seller_id from catalog_catelog_entity where id in($cat_arr))";
					$sellerlist = $connection->execute($qu)->fetchAll('assoc');
				}
				$this->set(compact('data','sellerlist'));
				
			}
			else
			{
				echo "Required Parameter is not passed.</br></br>";
				die;
			}
			
	    
		}
	}
	function createads()
	{
		$AdsTable = TableRegistry::get('Ads');
		$ads_data = $AdsTable
			->find()
			// ->where(['shift_pos'=>$shift_pos,'category_id'=>$category_id,'page_type'=>'home','status'=>'active'])
			->toArray();
		$this->set(compact('ads_data'));
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			// pr($_FILES);
			// die;
				extract($request);
				$ads_image = $this->uploadImage($_FILES['ads_image']);
				$i=0;
				foreach ($_FILES['extra_image'] as $image) {
					if(!empty($image['name'])) {
						echo $fileName = $image['name'];
						$extra_image = $this->uploadImage($fileName);
					} else {
						$this->Flash->error(__('Please choose an image to upload.'));
					}
				}
			
			
			$request['extra_image']=$extra_image;
			$request['ads_image']=$ads_image;
			pr($extra_image);
			// pr($request);
			die;
			$entities = $AdsTable->newEntity($request);
			$result = $AdsTable->Save($entities);
			if($result)
			{
				return $this->redirect(['action' => 'createads']);
			}
		}
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
}
