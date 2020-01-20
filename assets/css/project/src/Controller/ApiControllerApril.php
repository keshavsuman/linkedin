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
	    // $this->request->withData('data',array_map('trim',$this->request->getData()));
	}
	function index(){
		$category_entity	=	$this->getCategorList();
		pr($category_entity);
		die('exit');
	}
	function cateloglist($customer_id){
		
		$Offer = TableRegistry::get('Catelog');
		$query = $Offer
	    ->find()
	    // ->select(['id','children_count','thumbnail','name'])
	    ->order(['id'=>'DESC'])
	    ->where(['status ='=>'1']);
	    $sample=[];
	    foreach ($query as $value) {
		   	$catelog_id=$data['id']=$value['id'];
    		$data['title']=$value['name_en'];
    		
			// on amount offer value is applied 
    		// $data['amount']=3;
			 $offer_id=$value['offer_id'];
			
			// $offer_id=1;
			if($offer_id>0)
			{
			  $offer=$this->offerdetail($offer_id);
			  // print_R($offer);
			  // die;
			  $offer_type=$offer['offer_type'];
			  
			  if($offer_type=="fix")
			  {
				  $data['off']="Rs ".$offer['offer_value']." off";
				  $s_price=$value['selling_price']-$offer['offer_value'];
				  
			  }
			  else
			  {
				  // $offer['offer_value']=5;
				$data['off']=$offer['offer_value']." % off";  
				
				$s_price=($value['selling_price']*$offer['offer_value'])/100;
				 $s_price=round($value['selling_price']-$s_price);
			  }
			 
			  $data['selling_price']=$s_price;
			  $data['amount']=$value['selling_price'];
			  $data['off']=$offer['offer_value'];
			}
			else
			{
				
				$data['off']=0;
				$data['selling_price']=$value['selling_price'];
				$data['amount']=$value['selling_price'];   
			} 
			// $data['off']=1;
    		if($value['shipping_charges']==0)
			{
				$data['extra_text']="FREE SHIPPING";
			}
			else
			{
				$data['extra_text']='';
			}
			if($value['cod'])
			{
				$data['cod_text']="COD AVAILABLE";
			}
			else
			{ 
				$data['cod_text']='';
			}
    		
    		$data['share_text']=$value['share_text'];
			// 1 means product shared , 0 menas not shared 
			$sharedata=$this->priceupdated($catelog_id,$customer_id);
			
			if($sharedata)
			{
				$data['is_shared']=1;
				$data['market_price']=$sharedata['final_amount'];
				$data['my_earning']=$sharedata['increase_amount'];
				$data['market_string']=$value['selling_price']." + ".$sharedata['increase_amount']."(My Earning)";
			}
			else
			{
				$data['is_shared']=0;
				$data['market_price']=0;
				$data['my_earning']=100;
			}
			
			$data['min_range']=$value['selling_price'];
			if($value['reseller_earning'])
			$data['max_range']=$value['reseller_earning'];
		    else
			$data['max_range']=$value['selling_price']+500;	
    		// $data['image']=$value['offer_image'];
    		// $data['type']='category';
    		$data['image']=Router::url('image/',true).$value['pic'];
    		$slider=$data['slider']=$this->catelogproductimages($catelog_id);
			$data['product_count']=count($slider);
    		// $data['children_count']=$value['children_count'];
    		$sample[]=$data;   
		}
		return $sample;
	}
	function offerdetail($offer_id)
	{
		$offerTable = TableRegistry::get('Offer');
		$offerdata =$offerTable
	    ->find()
	    // ->select(['id','path','level','children_count','position','name','is_active'])
	    ->where(['id ='=>$offer_id])->first();
		return $offerdata;
	}
	function priceupdated($catelog_id,$customer_id)
	{
		
		$ShareTable = TableRegistry::get('Sharelist');
		$sharedata	=	$ShareTable
						->find()
					
						 ->where(['status = '=>'y','user_id'=>$customer_id,'catelog_id'=>$catelog_id])
						// ->select(['attribute_name'=>'frontend_label','attribute_id','backend_type','frontend_input'])
						->first(); 
		
				
		if($sharedata)
		{
			$sharedata=$sharedata;
		}
		else
		{
			$sharedata=[];
		}
		return $sharedata;
	}
	function catelogproductimages($catelog_id)
	{
		// $si=[];
		$table = TableRegistry::get('Product');
    	$slider = $table->find()->select(['id','pic'])->where(['catelog_id'=>$catelog_id])->toArray();
		if($slider)
		{
			$i=0;
			foreach($slider as $s)
			{
				$si[$i]=Router::url('image/',true).$s['pic'];
				$i++;
			}
		}
		else
		{
			$si=[];
		}
		return $si;
		
	}
	function offerlist(){
		$Offer = TableRegistry::get('Offer');
		$query = $Offer
	    ->find()
	    // ->select(['id','children_count','thumbnail','name'])
	    // ->order(['name'=>'asc'])
	    ->where(['status ='=>'1']);
	    $sample=[];
	    foreach ($query as $value) {
		   	$data['id']=$value['id'];
    		$data['title']=$value['title'];
    		$data['subtitle']=$value['subtitle'];
    		// $data['image']=$value['offer_image'];
    		// $data['type']='category';
    		$data['image']=Router::url('image/',true).$value['offer_image'];
    		// $data['children_count']=$value['children_count'];
    		$sample[]=$data;
		}
		return $sample;
	}
	function getCategorList($customer_id){
		$category = TableRegistry::get('Category');
		$query = $category
	    ->find()
	    ->select(['id','children_count','thumbnail','name'])
	    ->order(['id'=>'asc'])
	    ->where(['level ='=>'0']);
	    $sample=[];
		if($customer_id)
		{
			$ShareTable = TableRegistry::get('Sharelist');
			$sharecount	=	$ShareTable
						->find()
						 ->where(['status = '=>'y','user_id'=>$customer_id])
						->count();
			if($sharecount>0)
			{
				$data['id']=0;
				$data['name']="Shared List";
				$data['type']="share";
				$data['image']="http://13.233.186.157/category-thumbnail/share.png";
				$sample[]=$data;
			}
		}
	    foreach ($query as $value) {
		   	$data['id']=$value['id'];
    		$data['name']=$value['name'];
    		$data['type']='category';
    		$data['image']=Router::url('/category-thumbnail/', true) . $value['thumbnail'];
    		// $data['children_count']=$value['children_count'];
    		$sample[]=$data;
		}
		
		return $sample;
	}
	 function homeapi()
	{
		$i=0;
		$request=$this->request->getData();
		extract($request);
		$o[0]['title']='Best Selling';
		$o[0]['subtitle']='Order Now';
		$o[0]['image']='http://13.233.186.157/img/app/group_1625.png';
		$co[0]['name']="Collections";
		$co[0]['type']="collection";
		$ct[0]['id']=1;
		$ct[0]['title']="Catelog";
		$ct[0]['sellamount']="$700";
		$ct[0]['amount']="1000";
		$ct[0]['off']="30%";
		$ct[0]['sharecount']="300";
		$ct[0]['offer']="30%";
		$ct[0]['extra_text']="Free Shipping";
		$co[0]['data']=$this->cateloglist($customer_id);
		
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
		$data['category']=$this->getCategorList($customer_id);
		$data['offer']=$this->offerlist();
		$data['top']=$this->cateloglist($customer_id);
		$ShareTable = TableRegistry::get('Sharelist');
		
		
		$response['status'] =true;
		$response['data'] =$data;
		$response['code'] =200;
		echo json_encode($response);
		die;	
	}
	function checkavilablity()
	{ 
		$request=$this->request->getData();
		extract($request);	
		if($product_id && $pin_code)
		{
			$response['status'] =true;
			$response['data'] ="Product Avilable";
			$response['code'] =200;
		}
		else
		{
			$response['status'] =false;
			$response['data'] ="";
			$response['code'] =404;
			
		}
		
		echo json_encode($response);
		die;
	}
    function homeapi2()
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
		// product detail 
		$cdata[1]['id']=1;
		$cdata[1]['title']="Jacket in Blue";
		$cdata[1]['type']="product"; 
		$cdata[1]['image']='http://13.233.186.157/img/app/group_1469.png';
		
		$co[1]['data']=$cdata;
	
		$category_entity	=	$this->getCategorList();
		$top_item	=	$this->topItem();
		$data['record']=$top_item;
		$data['category']=$category_entity;
		$data['offer']=$o;
		$data['top']=$ct;
		$response['status'] =true;
		$response['data'] =$data;
		$response['code'] =200;
		echo json_encode($response);
		die;	
	}
	function getCatelogDetail(){
    	$connection = ConnectionManager::get('default');
    	$catelog_id = $this->request->getData('id');
    	$customer_id = $this->request->getData('customer_id');
		if($catelog_id)
		{
			   $sql = "select users.fullname as seller_name,p.shipping_charges,p.cod,p.share_text,p.offer_id,p.pic,p.offer_image,p.id as catelog_id,p.name_en,p.name_hn,p.description,p.primary_price,p.selling_price,p.shipping_charges
			 ,p.cod_rule,p.return_rule,p.youtube_link from catalog_catelog_entity as p inner join  users on users.id=p.seller_id where p.id=$catelog_id limit 1";	
    	 
			$value = $connection->execute($sql)->fetch('assoc');
			// print_R($value);
			// die;
			if(!empty($value)){
				$catelog_id=$data['catelog_id'] = $value['catelog_id'];
				$data['name_en'] = $value['name_en'];
				$data['name_hn'] = $value['name_hn'];
				$data['description'] = $value['description'];
				$offer_id=$value['offer_id'];
				if($offer_id>0)
				{
				  $offer=$this->offerdetail($offer_id);
				  // print_R($offer);
				  // die;
				  $offer_type=$offer['offer_type'];
				  
				  if($offer_type=="fix")
				  {
					  $data['off']="Rs ".$offer['offer_value']." off";
					  $s_price=$value['selling_price']-$offer['offer_value'];
					  
				  }
				  else
				  {
					  // $offer['offer_value']=5;
					$data['off']=$offer['offer_value']." % off";  
					
					$s_price=($value['selling_price']*$offer['offer_value'])/100;
					 $s_price=round($value['selling_price']-$s_price);
				  }
				 
				  $data['selling_price']=$s_price;
				  $data['amount']=$value['selling_price'];
				  $data['off']=$offer['offer_value'];
				}
				else
				{
					
					$data['off']=0;
					$data['selling_price']=$value['selling_price'];
					$data['amount']=$value['selling_price'];   
				} 
				// $data['primary_price'] = $value['primary_price'];
				// $data['selling_price'] = $value['selling_price'];
				if($value['shipping_charges']==0)
				{
					$data['shipping_charges']="FREE SHIPPING";
				}
				else
				{
					$data['shipping_charges']=$value['shipping_charges'];
				}
				if($value['cod'])
				{
					$data['cod']="COD AVAILABLE";
				}
				else
				{ 
					$data['cod']='COD CHARGES';
				}
    		
				
				$data['rating'] =4.2;
				$data['share_text'] =$value['share_text'];
				$attribute_column = $this->getAttributes($catelog_id,"catelog");
				
				$data['product_option'] = $attribute_column;
				$data['cod_rule'] = $value['cod_rule'];
				$data['return_rule'] = $value['return_rule'];
				$link=$data['youtube_link'] = $value['youtube_link'];
				if($link)
				{
					$video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
					if (empty($video_id[1]))
						$video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..

					$video_id = explode("&", $video_id[1]); // Deleting any other params
					$data['video_id']=$video_id = $video_id[0];
				}
				else
				{
					$data['video_id']='';
				}
				
				$data['suplier_name'] =$value['seller_name'];
				$data['suplier_rating'] =4;
			    $s[0]['image']= Router::url('image/',true).$value['pic'];
				if($offer_id>0)
				{
					$s[1]['image']= Router::url('image/',true).$offer['offer_image'];
				}
				$data['slider'] =$s;
				$data['product'] =$this->productlist($catelog_id,$customer_id);
				// $data['thumbnail'] = Router::url('image/',true).$value['pic'];
				// $data['primary_price'] = $value['primary_price'];
				// $data['description'] = $value['description'];
				// $data['selling_price'] = $value['selling_price'];
				// $attribute_column = $this->getAttributes($product_id);
				
				// $category = $this->getProductCategoryies($product_id);
				// $data['product_option'] = $attribute_column;
				// $data['category'] = $category;
				$reponse['status'] =true;
				$reponse['data'] =$data;
				$reponse['msg'] ="Product list";
			}
			else{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Sorry, we could not found any product here";
			}
		}
		else
		{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Sorry,Required Values missed";
		}
    	 
		echo json_encode($reponse);
		die;
    }
	 
	 function productlist($catelog_id,$customer_id=0)
	 {
		 $Offer = TableRegistry::get('Product');
		$query = $Offer
	    ->find()
	    // ->select(['id','children_count','thumbnail','name'])
	    ->order(['id'=>'DESC'])
	    ->where(['catelog_id'=>$catelog_id]);
		$sample=[];
		$p=0;
	    foreach ($query as $value) {
			if($p==0)
			{
				$sharedata=$this->priceupdated($catelog_id,$customer_id);
			}
			$product_id=$data[$p]['product_id'] = $value['id'];
			$offer_id=$value['offer_id'];
			if($offer_id>0)
			{
			  $offer=$this->offerdetail($offer_id);
			  // print_R($offer);
			  // die;
			  $offer_type=$offer['offer_type'];
			  
			  if($offer_type=="fix")
			  {
				  $data[$p]['off']="Rs ".$offer['offer_value']." off";
				  $s_price=$value['selling_price']-$offer['offer_value'];
				  
			  }
			  else
			  {
				  // $offer['offer_value']=5;
				$data[$p]['off']=$offer['offer_value']." % off";  
				
				$s_price=($value['selling_price']*$offer['offer_value'])/100;
				 $s_price=round($value['selling_price']-$s_price);
			  }
			 
			  $data[$p]['selling_price']=$s_price;
			  $data[$p]['amount']=$value['selling_price'];
			  $data[$p]['off']=$offer['offer_value'];
			}
			else
			{
				
				$data[$p]['off']=0;
				$data[$p]['selling_price']=$value['selling_price'];
				$data[$p]['amount']=$value['selling_price'];   
			} 
			$data[$p]['name_en'] = $value['name_en'];
			$data[$p]['name_hn'] = $value['name_hn'];
			$data[$p]['thumbnail'] = Router::url('image/',true).$value['pic'];
			// $data[$p]['primary_price'] = $value['primary_price'];
			// $data[$p]['selling_price'] = $value['selling_price'];
			// $data[$p]['percantage_value'] = $value['percantage_value'];
			$data[$p]['size'] = $this->productvarient($product_id);
			$data[$p]['sub_title'] = '';
			if($value['shipping_charges']==0)
			{
				$data[$p]['extra_text']="FREE SHIPPING";
			}
			else
			{
				$data[$p]['extra_text']='';
			}
			if($value['cod'])
			{
				$data[$p]['cod_text']="COD AVAILABLE";
			}
			else
			{ 
				$data[$p]['cod_text']='PRE PAYMENT';
			}
    		
    		$data[$p]['share_text']=$value['share_text'];
			if($sharedata)
			{
				$data[$p]['is_shared']=1;
				$data[$p]['market_price']=$sharedata['final_amount'];
				$data[$p]['my_earning']=$sharedata['increase_amount'];
				$data[$p]['market_string']=$value['selling_price']." + ".$sharedata['increase_amount']."(My Earning)";
			}
			else
			{ 
				$data[$p]['is_shared']=0;
				$data[$p]['market_price']=0;
				$data[$p]['my_earning']=100;
			}
			$data[$p]['min_range']=$value['selling_price'];
			if($value['reseller_earning'])
			$data[$p]['max_range']=$value['reseller_earning'];
		    else
			$data[$p]['max_range']=$value['selling_price']+500;	
			
			$p++;
		}
		return $data;
	 }
	 function productvarient($product_id)
	 {
		 $StockTable = TableRegistry::get('Stock');
		 $stockdata=$StockTable->find()
		  ->contain(['AttributeOptionValue'])
		 ->where(['product_id'=>$product_id])->toArray();
		if(count($stockdata)>0)
		{
			$i=0;
			foreach($stockdata as $s)
			{
				$stock[$i]['id']=$s['id'];
				$stock[$i]['name']=$s['attribute_option_value']['value'];
				$stock_value=$s['stock_qty'];
				$used=$s['sale_product'];
				$stock[$i]['stock']=$stock_value-$used;
				$i++;
			}
		}
		else
		{
			$stock=[];
		}
		// print_R($stock);
		// die;
		return $stock;
	 }
	 function getProductDetail(){
    	$connection = ConnectionManager::get('default');
    	$product_id = $this->request->getData('id');
    	$customer_id = $this->request->getData('customer_id');
		if($product_id)
		{
			 $sql = "select users.fullname as seller_name,p.catelog_id,p.cod_image,p.shipping_charges,p.cod,p.share_text,p.offer_id,p.pic,p.offer_image,p.id as product_id,p.name_en,p.name_hn,p.description,p.primary_price,p.selling_price,p.shipping_charges
			 ,p.cod_rule,p.return_rule,p.youtube_link from catalog_product_entity as p inner join  users on users.id=p.seller_id where p.id=$product_id limit 1";	
    	
			$value = $connection->execute($sql)->fetch('assoc');
			
			if(!empty($value)){
				$product_id=$data['product_id'] = $value['product_id'];
				$catelog_id=$value['catelog_id'];
				$data['name_en'] = $value['name_en'];
				$data['name_hn'] = $value['name_hn'];
				$data['description'] = $value['description'];
				$offer_id=$value['offer_id'];
				if($offer_id>0)
				{
				  $offer=$this->offerdetail($offer_id);
				  // print_R($offer);
				  // die;
				  $offer_type=$offer['offer_type'];
				  
				  if($offer_type=="fix")
				  {
					  $data['off']="Rs ".$offer['offer_value']." off";
					  $s_price=$value['selling_price']-$offer['offer_value'];
					  
				  }
				  else
				  {
					  // $offer['offer_value']=5;
					$data['off']=$offer['offer_value']." % off";  
					
					$s_price=($value['selling_price']*$offer['offer_value'])/100;
					 $s_price=round($value['selling_price']-$s_price);
				  }
				 
				  $data['selling_price']=$s_price;
				  $data['amount']=$value['selling_price'];
				  $data['off']=$offer['offer_value'];
				}
				else
				{
					
					$data['off']=0;
					$data['selling_price']=$value['selling_price'];
					$data['amount']=$value['selling_price'];   
				} 
				// $data['primary_price'] = $value['primary_price'];
				// $data['selling_price'] = $value['selling_price'];
				if($value['shipping_charges']==0)
				{
					$data['shipping_charges']="FREE SHIPPING";
				}
				else
				{
					$data['shipping_charges']=$value['shipping_charges'];
				}
				if($value['cod'])
				{
					$data['cod']="COD AVAILABLE";
				}
				else
				{ 
					$data['cod']='COD CHARGES';
				}
				
				$data['rating'] =4.2;  
				$data['size'] = $this->productvarient($product_id);
				$data['share_text'] =$value['share_text'];
				$attribute_column = $this->getAttributes($catelog_id,"catelog");
				
				$data['product_option'] = $attribute_column;
				$data['cod_rule'] = $value['cod_rule'];
				$data['return_rule'] = $value['return_rule'];
				$link=$data['youtube_link'] = $value['youtube_link'];
				if($link)
				{
					$video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
					if (empty($video_id[1]))
						$video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..

					$video_id = explode("&", $video_id[1]); // Deleting any other params
					$data['video_id']=$video_id = $video_id[0];
				}
				else
				{
					$data['video_id']='';
				}
				
				$data['suplier_name'] =$value['seller_name'];
				$data['suplier_rating'] =4;
				$sharedata=$this->priceupdated($catelog_id,$customer_id);
			
			if($sharedata)
			{
				$data['is_shared']=1;
				$data['market_price']=$sharedata['final_amount'];
				$data['my_earning']=$sharedata['increase_amount'];
				$data['market_string']=$value['selling_price']." + ".$sharedata['increase_amount']."(My Earning)";
			}
			else
			{
				$data['is_shared']=0;
				$data['market_price']=0;
				$data['my_earning']=100;
			}
			
			$data['min_range']=$value['selling_price'];
			if($value['reseller_earning'])
			$data['max_range']=$value['reseller_earning'];
		    else
			$data['max_range']=$value['selling_price']+500;	
			    $s[0]['image']= Router::url('image/',true).$value['pic'];
				if($offer_id>0)
				{
					$s[1]['image']= Router::url('image/',true).$offer['offer_image'];
				}
				$data['slider'] =$s;
				$data['cod_image'] =Router::url('image/',true).$value['cod_image'];
			
				// $data['thumbnail'] = Router::url('image/',true).$value['pic'];
				// $data['primary_price'] = $value['primary_price'];
				// $data['description'] = $value['description'];
				// $data['selling_price'] = $value['selling_price'];
				// $attribute_column = $this->getAttributes($product_id);
				
				// $category = $this->getProductCategoryies($product_id);
				// $data['product_option'] = $attribute_column;
				// $data['category'] = $category;
				$reponse['status'] =true;
				$reponse['data'] =$data;
				$reponse['msg'] ="Product list";
			}
			else{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Sorry, we could not found any product here";
			}
		}
		else
		{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Sorry,Required Values missed";
		}
    	 
		echo json_encode($reponse);
		die;
    }
	  function getAttributes($product_id=0,$type){
		 if($product_id){
			    $attribute = TableRegistry::get('Attribute');
				$conn = ConnectionManager::get('default');
				$select_value = $conn->execute("SELECT * FROM `catalog_product_entity_varchar` WHERE entity_id='$product_id'")->fetchAll('assoc');
				// pr($select_value);
				// die;
				$i=0;
				foreach($select_value as $select)
				{
					$atr_id=$select['attribute_id'];
					 $query	=	$attribute
    				->find()
					 ->where(['attribute_id = '=>$atr_id])
    				->select(['attribute_name'=>'frontend_label','attribute_id','backend_type','frontend_input'])
    				->first();  
					$data[$i]['attribute_value']=$select['value'];
					$data[$i]['attribute_name']=$query->attribute_name;
				}
		 }
		return $data;			
    }
	function topBrands(){
    	$attribute = TableRegistry::get('AttributeOption');
    	$result	=	$attribute
    	->find()
    	->contain(['AttributeOptionValue']);
    	$config =	['maxLimit'=>5,'order'=>['AttributeOption.value'=>'asc']];
    	$entity = $this->paginate($result,$config);
    	foreach ($entity as $key => $value) {
    		$item['brand_name'] = $value['attribute_option_value']['value'];
    		$item['brand_id'] = $value['option_id'];
    		$data[]=$item;
    	}
    	return $data;
    }
    function topSliderItem(){
    	$connection = ConnectionManager::get('default');
    	$category_id = $this->request->getData('category_id');
    	$sql = "select p.name_en,p.id as product_id,p.name_hn,p.pic,p.primary_price,p.selling_price from catalog_product_entity as p  order by p.id desc limit 6";	
    	$result = $connection->execute($sql)->fetchAll('assoc');
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$data['product_id'] = $value['product_id'];
				$data['name_en'] = $value['name_en'];
				$data['name_hn'] = $value['name_hn'];
				$data['thumbnail'] = Router::url('image/',true).$value['pic'];
				$data['primary_price'] = $value['primary_price'];
				$data['selling_price'] = $value['selling_price'];
				$simple[]=$data;
			}
		}
		return $simple;
    }
    function topItem(){
    	$connection = ConnectionManager::get('default');
    	$category_id = $this->request->getData('category_id');
    	$sql = "select p.name_en,p.id as product_id,p.name_hn,p.pic,p.primary_price,p.selling_price from catalog_product_entity as p  order by p.id desc limit 10";	
    	$result = $connection->execute($sql)->fetchAll('assoc');
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$data['id'] = $value['product_id'];
				$data['title'] = $value['name_en'];
				$data['type'] = 'product';
				$data['image'] = Router::url('image/',true).$value['pic'];
				$data['primary_price'] = $value['primary_price'];
				$data['selling_price'] = $value['selling_price'];
				$simple[]=$data;
			}
		}
		return $simple;
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
	function login()
	{
		if($this->request->is('post'))
    	{
			$table 	=	TableRegistry::get('Users');
			$request=$this->request->getData();
			extract($request);
			// role id 1 for reseller 
			$result	=	$table->find()->select(['mobile','id'])->where(['mobile'=>$mobile,'role'=>'3'])->first();
			if($result)
			{
				$result->otp=$rand_otp=rand(10000,99999);
				if($table->save($result))
				{
					$reponse['status']	=true;
					$reponse['data']	=	$result;
					$reponse['id']	=	$result->id;
					$reponse['otp']	=	$rand_otp;
					$reponse['newuser']	=false;
					$reponse['msg'] 	=	"Login successful";
				}
				else
				{
					$reponse['status']	=false;
					$reponse['msg'] 	=	"Login Failed";
					
				}
				
			}
			else
			{
				$request['role']=3;
				$request['otp']=$rand_otp=rand(10000,99999);
				$entity =	$table->newEntity($request);
				$result	=	$table->save($entity);
				if($result){
	    			$reponse['status']	=true;
					$reponse['data']	=	$result;
					$reponse['id']	=	$result->id;
					$reponse['otp']	=	$rand_otp;
					$reponse['msg'] 	=	"Resgister successful";
					$reponse['newuser']	=true;
				}
				else
				{
					$reponse['status']	=false;
					$reponse['msg'] 	=	"Register Failed";
					
				}
					
			}
			
		}
		echo json_encode($reponse);die;
	}
	function addtosharelist()
	{
		if($this->request->is('post'))
    	{
			
			$request=$this->request->getData();
			extract($request);
			if($customer_id && $catelog_id && $increase_amount && $final_amount)
			{
				$ShareTable = TableRegistry::get('Sharelist');
				$query	=	$ShareTable
						->find()
						 ->where(['status = '=>'y','user_id'=>$customer_id,'catelog_id'=>$catelog_id])
						// ->select(['attribute_name'=>'frontend_label','attribute_id','backend_type','frontend_input'])
						->first();   
				if($query)
				{
					$query->increase_amount=$increase_amount;
					$query->final_amount=$final_amount;
					if($ShareTable->save($query))
					{
						$reponse['status']	=true;
						$reponse['msg'] 	=	"Share List updated";
					}
					else
					{
						$reponse['status']	=false;
						$reponse['msg'] 	=	"Failed to update shared list";
					}
				}
				else
				{
					// new entry 
					$request['user_id']=$customer_id;
					$entity =	$ShareTable->newEntity($request);
					$result	=	$ShareTable->save($entity);
					if($result)
					{
						$reponse['status']	=true;
						$reponse['msg'] 	=	"Share List Created";
					}
					else
					{
						$reponse['status']	=false;
						$reponse['msg'] 	=	"Failed to Create Shared List";
					}
				}
			}
			else
			{
				$reponse['status']	=false;
				$reponse['msg'] 	=	"Required Parametr missing";
			}
			
		}
		echo json_encode($reponse);die;
	}
    function signup(){
    	if($this->request->is('post'))
    	{
    		$table 	=	TableRegistry::get('Users');
			$request=$this->request->getData();
			$request['role']=2;
    		$entity =	$table->newEntity($request);
    		$result	=	$table->save($entity);
    		if($result){
    			$result['customer_id'] = $result['id'];
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
	    			$result['customer_id'] = $result['id'];
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
			$result	=	$table->find()->select(['customer_id'=>'id','username','email','fullname','dob','mobile'])->where(['username'=>$username,'password'=>$password])->first();
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
	function sizestock()
	{
		$StockTable = TableRegistry::get('Stock');
		$size_id = $this->request->getData('size_id');
		$stockdata=$StockTable->find()
		  // ->contain(['AttributeOptionValue'])
		 ->where(['id'=>$size_id])->first();
		if($stockdata)
		{
			$reponse['status'] =true;
			$stock_value=$stockdata['stock_qty'];
			$used=$stockdata['sale_product'];
			$stock=$stock_value-$used;
			$reponse['stock'] =$stock;
			$reponse['msg'] ="Stock Detail";
		}
		else
		{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invalid Size Type";
		}
		echo json_encode($reponse);die;
	}
	function addToCart(){
    	if($this->request->is('post'))
    	{   
    		$request = $this->request->getData();
    		$quote_item_table=TableRegistry::get('QuoteItem');
    		$quote_table=TableRegistry::get('Quote');
    		$entity = $quote_item_table->newEntity($request,['validate'=>"item"]);
    		if(!$entity->getErrors())
    		{
    			$product = $this->getProduct($request['product_id']);
				// print_R($product);
				// die;
				$catelog_id=$product['catelog_id'];
				$customer_id = $request['customer_id'];
				$seller_id=$product['seller_id'];
				$sharedata=$this->priceupdated($catelog_id,$customer_id);
			   if($sharedata)
			   {
				  if($sharedata['final_amount']){
			    	$price = $sharedata['final_amount'];
					}else{
						$price = $product->selling_price;
					}
					$market_price=$sharedata['final_amount'];
					$my_earning=$sharedata['increase_amount'];
					$market_string=$product['selling_price']." + ".$sharedata['increase_amount']."(My Earning)";
			   }
			   else
			   {
				  $price = $product->selling_price;
				  $market_price=0;
				$my_earning=100;
				 $market_string='';
			   }
	    		
	    		$product_name = $product->name_en;
	    		$product_id = $product->id;
	    		$qty = $request['quantity'];
	    		
    			$grand_total  = $qty*$price;
    			$quote = $this->getQuoteId($customer_id);
    			// pr($quote);die;
				// filed for quote item 
				$offer_id=$product['offer_id'];
				if($offer_id>0)
				{
					$offer=$this->offerdetail($offer_id);
					$offer_type=$offer['offer_type'];
					if($offer_type=="fix")
					  {
						  $off="Rs ".$offer['offer_value']." off";
						  $s_price=$product['selling_price']-$offer['offer_value'];
						  
					  }
					  else
					  {
						  // $offer['offer_value']=5;
						$off=$offer['offer_value']." % off";  
						
						$s_price=($product['selling_price']*$offer['offer_value'])/100;
						 $s_price=round($product['selling_price']-$s_price);
					  }
					  $selling_price=$s_price;
					  $amount=$product['selling_price'];
					  $off=$offer['offer_value'];
			  
				}
				else
				{
					$off=0;
					$s_price=$product['selling_price'];
					$amount=$product['selling_price'];   
				}
				if($product['shipping_charges']==0)
				{
					$extra_text="FREE SHIPPING";
				}
				else
				{
					$extra_text='';
				}
				if($product['cod'])
				{
					$cod_text="COD AVAILABLE";
				}
				else
				{ 
					$cod_text='';
				}
				
				$share_text=$product['share_text'];
    			if(!empty($quote)){
    				$quote->grand_total = $quote->grand_total+$grand_total;	
    				$quote->items_count = $quote->items_count+$qty;	
    				$quote->items_qty = $quote->items_qty+$qty;

		    		$get_quote_item = $quote_item_table->find()->where(['product_id'=>$product_id,'quote_id'=>$quote->entity_id])->first();
		    		if(isset($_GET['debug'])){
		    			// pr($get_quote_item);
		    		}
		    		if(empty($get_quote_item)){
		    			$quote_item=[
			    			'created_at'=>date('Y-m-d H:i:s'),
			    			'quote_id'=>$quote->entity_id,    		
			    			'qty'=>$qty,    		
			    			'price'=>$s_price,    		
			    			'base_price'=>$grand_total,    		
			    			'product_id'=>$product_id,
			    			'name'=>$product_name,
			    			'off'=>$off,
			    			'extra_text'=>$extra_text,
			    			'cod_text'=>$cod_text,
			    			'market_price'=>$market_price,
			    			'my_earning'=>$my_earning,
			    			'market_string'=>$market_string,
							'created_at'=>date('Y-m-d H:i:s'),
			    			'updated_at'=>date('Y-m-d H:i:s'),
			    		];
		    			$quote_item_entity = $quote_item_table->newEntity($quote_item);
		    			$quote_item_table->save($quote_item_entity);
		    		}else{
		    			if($get_quote_item->qty ==1 && $qty ==-1){
		    				$quote_item_table->delete($get_quote_item);
		    			}
		    			else{
		    				$qty = $get_quote_item->qty + $request['quantity'];
		    				$grand_total  = $qty*$price;
			    			$get_quote_item->price=$price;	
			    			$get_quote_item->qty=$qty;	
			    			$get_quote_item->base_price=$grand_total;	
			    			$get_quote_item->name=$product_name;
			    			$get_quote_item->off=$off;
			    			$get_quote_item->extra_text=$extra_text;
			    			$get_quote_item->cod_text=$cod_text;
			    			$get_quote_item->market_price=$market_price;
			    			$get_quote_item->my_earning=$my_earning;
			    			$get_quote_item->market_string=$market_string;
							// print_R($get_quote_item);
							// die;
			    			$quote_item_table->save($get_quote_item);
		    			}
		    				
		    		}
		    		$quote_table->save($quote);
		    		$this->updateQuote($quote->entity_id);	
    			}
    			else{
    				$quote_data=[
		    			'created_at'=>date('Y-m-d H:i:s'),
		    			'store_id'=>0,    		
		    			'items_count'=>$qty,    		
		    			'items_qty'=>$qty,    		
		    			'customer_id'=>$customer_id,
		    			'grand_total'=>$grand_total,
		    			'remote_ip'=>$_SERVER['REMOTE_ADDR'],
		    		];
		    		$quote = $this->newQuoteId($quote_data);
		    		
		    		$quote_item=[
		    			'created_at'=>date('Y-m-d H:i:s'),
		    			'quote_id'=>$quote->entity_id,    		
		    			'qty'=>$qty,    		
		    			'price'=>$price,    		
		    			'base_price'=>$grand_total,    		
		    			'product_id'=>$product_id,
		    			'name'=>$product_name,
						'off'=>$off,
			    			'extra_text'=>$extra_text,
			    			'cod_text'=>$cod_text,
			    			'market_price'=>$market_price,
			    			'my_earning'=>$my_earning,
			    			'market_string'=>$market_string,
		    			'created_at'=>date('Y-m-d H:i:s'),
		    			'updated_at'=>date('Y-m-d H:i:s'),
		    		];  

		    		$quote_item_entity = $quote_item_table->newEntity($quote_item);
		    		$quote_item_table->save($quote_item_entity);
		    		$this->updateQuote($quote->entity_id);
    			}
    			$quote = $this->getQuote($quote->entity_id);
    			$grand_total = $quote->grand_total;
    			$data['quote_id']=$quote->entity_id;
    			$data['customer_id']=$quote->customer_id;
    			$data['items_count']=$quote->items_count;
    			$data['grand_total']=$grand_total;
				if($seller_id)
				{
					$table = TableRegistry::get('Users');
					$result	=	$table->find()->select(['fullname','dob','mobile'])->where(['id'=>$seller_id])->first();
					$data['reseller_name']=$result['fullname'];
					$data['reseller_phone']=$result['mobile'];
				}
				
				
    			$response['status'] = true;
    			$response['data'] = $data;
    			$response['msg'] = "$product_name add to cart successfully";
    		}
    		else{
    			 $response['status'] = false;
    			 $response['data'] = $entity->getErrors();
    			 $response['msg'] = "Some required fields Are Missing";

    		}
    	}
    	else{
			$response['status'] =false;
			$response['data'] = '';
			$response['msg'] = "Invalid request type";    		
    	}
    	echo json_encode($response);die;
    }
	 function getCart(){
    	$customer_id = $this->request->getData('customer_id');
    	$quote_id = $this->request->getData('quote_id');
    	if((int)$customer_id>0){
    		$table = TableRegistry::get('Quote');
    		$cart = $table->find()->where(['customer_id'=>$customer_id,'entity_id'=>$quote_id])->contain(['QuoteItem'=>function($q){
    				return $q->select(['name','item_id','product_id','price','base_price','quote_id','qty','off','extra_text','cod_text','market_price','my_earning','market_string']);
    		}
    	])
    	->all();
    		$msg="Get cart";
    		foreach ($cart as $key => $items) {
    			$data['quote_id']=$items->quote_id;
	    		$data['items_count']=$items->items_count;
	    		$data['grand_total']=$items->grand_total;
	    		$data['customer_id']=$items->customer_id;
				
	    		if(!empty($items->quote_item)){
		    		foreach ($items->quote_item as $key => $value) {
		    			$product_id = $value['product_id'];
		    			$product = $this->getProduct($product_id);
	    				$item['item_id'] = $value['item_id'];
	    				$item['product_id'] = $value['product_id'];   
	    				$item['name'] = $product->name_en;
	    				$item['thumbnail'] = Router::url('image/',true).$product->pic;
	    				$item['primary_price'] =$value['price'];
	    				$item['selling_price'] = $value['price'];
	    				$item['amount'] = $value['price'];
	    				$item['off'] = $value['off'];
	    				$item['extra_text'] = $value['extra_text'];
	    				$item['cod_text'] = $value['cod_text'];
	    				$item['share_text'] = $value['share_text'];
	    				$item['market_price'] = $value['market_price'];
	    				$item['my_earning'] = $value['my_earning'];
	    				$item['market_string'] = $value['market_string'];
	    				$item['min_range'] = 0;
	    				$item['max_range'] = 0;
	    					$item['qty'] = $value['qty'];
	    				$data['cart_item'][] = $item;
    				}
    			}
    			else{
    				$data='';
    				$msg="cart empty";
    			}
    		}
    		$response['status'] = "ok";
			$response['data'] = $data;
			$response['msg'] = $msg;

    	}
    	else{
    		$response['status'] = "error";
			$response['data'] = '';
			$response['msg'] = "Customer id Missing";
    	}
    	echo json_encode($response);die;	
    }
	 function deleteCartItem()
    {
    	$table = TableRegistry::get('QuoteItem');
    	$item_id = $this->request->getData('item_id');
    	$message ="Item removed from cart";
    	if($item_id){
    		
    		$entity 	=	$table->find()->where(['item_id'=>$item_id])->first();
    		if(!empty($entity))
    		{
    			$quote_id = $entity->quote_id;
    			$table->delete($entity);
    			$this->updateQuote($quote_id);
    			$quote = $this->getQuote($quote_id);
    			$data['grand_total']=$quote->grand_total;
    			$data['items_count']=$quote->items_count;
    		}
    		else{
    			$message = "Item not found in cart";
    		}
    		$response['status']="ok";
    		$response['data']=$data;
    		$response['msg']=$message;
    	}else{
    		$response['status']="error";
    		$response['data']="";
    		$response['msg']="item id required";
    	}
    	 echo json_encode($response);die;	
    }
	function getQuote($quote_id){
    	$table = TableRegistry::get('Quote');
    	$result = $table->find()->where(['entity_id'=>$quote_id,'is_active'=>1])->first();
    	return $result;
    }
    function updateQuote($quote_id){
    	$connection = ConnectionManager::get('default');
    	$quote_table = TableRegistry::get('Quote');
    	$data = $connection->execute("select sum(qty) as total_quantity,sum(base_price) as grand_total from sales_flat_quote_item where quote_id=$quote_id")->fetch('assoc');
    	$quote_entity = $quote_table->get($quote_id);
    	$quote_entity->items_count = isset($data['total_quantity'])?$data['total_quantity']:0;
    	$quote_entity->grand_total = isset($data['grand_total'])?$data['grand_total']:0;
    	$quote_table->save($quote_entity);
    	return true;
    }
	function newQuoteId($data){
    	$table = TableRegistry::get('Quote');
    	$entity = $table->newEntity($data);
    	return $quote = $table->save($entity);	
    }
	  function getQuoteId($customer_id)
    {
    	$table = TableRegistry::get('Quote');
    	$result = $table->find()->where(['customer_id'=>$customer_id,'is_active'=>1])->first();
    	return $result;
    }
	function getProduct($product_id){
    	$table = TableRegistry::get('Product');
    	$result = $table->find()->where(['id'=>$product_id])->first();
    	return $result;
    }
	 function addCustomerAddress(){
    	if($this->request->is('post'))
    	{
			
    		$table 	=	TableRegistry::get('Address');
    		$request = $this->request->getData();
			extract($request);
			if($customer_id && $name && $contact && $city)
			{
				$request['created_at'] = date('Y-m-d H:i:s');
				$entity =	$table->newEntity($request);
				$result	=	$table->save($entity);
				if($result)
				{
					$reponse['status'] =true;
					$reponse['data'] =$result;
					$reponse['msg'] ="Address added successfully";
				}
				else
				{
					$reponse['status'] =false;
					$reponse['data'] ='';
					$reponse['msg'] ="Something Went Wrong";
				}
			}
			else
			{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Customer id is missing";
			}
    		
    	}
    	else{
    		$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invalid request type";
    	}
    	echo json_encode($reponse);die;
    }
	    function updateCustomerAddress(){
    	if($this->request->is('post'))
    	{
    		$table 	=	TableRegistry::get('Address');
    		$request = $this->request->getData();
    		$request['update_at'] = date('Y-m-d H:i:s');
    		$entity_id = $request['entity_id'];
    		$entity = $table->get($entity_id); 
    		$entity =	$table->patchEntity($entity,$request,['validate'=>'address']);

    		if ($entity->getErrors()) {
			    $result	=	$entity->getErrors();
			    $reponse['status']	=	false;
				$reponse['data']	=	$result;
				$reponse['msg'] 	=	"Validation error";
			}
			else{
				// pr($entity);
				$result	=	$table->save($entity);
	    	 	$reponse['status']	=	true;
				$reponse['data']	=	$result;
				$reponse['msg'] 	=	"Address added successful";	
			}
    	}
    	else{
    		$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invalid request type";
    	}
    	echo json_encode($reponse);die;
    }
	 function getCustomerAddress(){
    	$customer_id = $this->request->getData('customer_id');
    	$table 	=	TableRegistry::get('Address');
    	$result = $table->find()->limit(10)->where(['customer_id'=>$customer_id])->all();
    	$simple=array();
    	if(!empty($result)){
			foreach ($result as $key => $value) {
				$data['entity_id'] = $value['entity_id'];
				$data['name'] = $value['name'];
				$data['contact'] = $value['contact'];  
				$data['address'] = $value['address'];
				$data['address2'] = $value['address2'];
				$data['state'] = $value['state'];
				$data['city'] = $value['city'];
				$data['zipcode'] = $value['zipcode'];
				// $data['is_active'] = $value['is_active']; 
				$data['is_active'] = $value['is_active'];
				$data['customer_id'] = $value['customer_id'];
				$simple[]=$data;
			}
			$reponse['status']	=	true;
			$reponse['data']	=	$simple;
			$reponse['msg'] 	=	"Address list";	
		}
		else{
			$reponse['status']	=	false;
			$reponse['data']	=	"";
			$reponse['msg'] 	=	"Address list empty";	
		}
		echo json_encode($reponse);die;
    }
	function cartcheckout()
	{
		if($this->request->is('post'))
    	{
			$request = $this->request->getData();
			extract($request);
			if($customer_id && $quote_id && $address_id && $delivery_from_name)
			{
				$table = TableRegistry::get('Quote');
				$result=$table->find()->where(['customer_id'=>$customer_id,'entity_id'=>$quote_id,'is_active'=>'1'])->first();
				// print_R($result);
				// die;
				if($result)
				{
					$result->address_id=$address_id;
					$result->delivery_from_name=$delivery_from_name;
					$result->delivery_from_mobile=$delivery_from_mobile;
					if($table->save($result))
					{
						$cart = $table->find()->select(['address_id','quote_id'=>'entity_id','entity_id','items_count','grand_total','customer_id','delivery_from_name','delivery_from_mobile','booking_date'=>'created_at'])->where(['customer_id'=>$customer_id,'entity_id'=>$quote_id,'is_active'=>'1'])->contain(['QuoteItem'=>function($q){
						return $q->select(['name','item_id','product_id','price','base_price','quote_id','qty']);
						}
						])
						->all();
						// print_R($cart);
						// die;
						$Addresstable 	=	TableRegistry::get('Address');
						
						$msg="Get cart";
						foreach ($cart as $key => $items) {
							$address_id=$items->entity_id;
							$addressresult = $Addresstable->find()->where(['entity_id'=>$address_id,'is_active'=>'1'])->first();
							// print_r($addressresult);
							// die;
							$data['quote_id']=$items->quote_id;
							$data['items_count']=$items->items_count;
							$data['grand_total']=$items->grand_total;
							$data['customer_id']=$items->customer_id;
							$data['address']=$addressresult;
							$date=$items->booking_date;
							$data['booking_date']=date_format($date,"d M Y");
							$data['delivery_from_name']=$items->delivery_from_name;
							$data['delivery_from_mobile']=$items->delivery_from_mobile;
							if(!empty($items->quote_item)){
								foreach ($items->quote_item as $key => $value) {
									$product_id = $value['product_id'];
									$product = $this->getProduct($product_id);
									$item['item_id'] = $value['item_id'];
									$item['name'] = $product->name_en;
									$item['thumbnail'] = Router::url('image/',true).$product->pic;
									$item['primary_price'] =$value['price'];
									$item['selling_price'] = $value['price'];
									// $item['selling_price'] = $product->selling_price;
									$item['product_id'] = $value['product_id'];
									$item['base_price'] = $value['base_price'];
									$item['qty'] = $value['qty'];
									$data['cart_item'][] = $item;
								}
							}
							else{
								$data='';
								$msg="cart empty";
							}
						}
						// print_R($data);
						// die;
						$reponse['status'] = true;
						$reponse['data'] = $data;
						$reponse['msg'] = $msg;
					}
					else
					{
						$reponse['status']	=	false;
						$reponse['data']	=	"";
						$reponse['msg'] 	=	"Something went wrong";
					}
				}
				else
				{
					$reponse['status']	=	false;
					$reponse['data']	=	"";
					$reponse['msg'] 	=	"Invalid Selection";	
				}
			}
			else
			{
				$reponse['status']	=	false;
				$reponse['data']	=	"";
				$reponse['msg'] 	=	"Required Parametr Missing";	
			}
    		
		}
		else{
			$reponse['status']	=	false;
			$reponse['data']	=	"";
			$reponse['msg'] 	=	"Invalid Data Type";	
		}
		echo json_encode($reponse);die;
	}
	  function getPaymentMethod(){
    	$table=TableRegistry::get("PaymentMethod");
    	$entity = $table->find()->where(['is_active'=>'1'])->all();
    	foreach ($entity as $key => $value) {
    	 	$data[] = $value;
    	 } 
    	 $response['status']=true;
    	 $response['data']=$data;
    	 $response['msg']="Payment method list";
    	 echo json_encode($response);die;
    }
	function placeorder(){ 
    	$customer_id = $this->request->getData('customer_id');
    	$coupon_code = $this->request->getData('coupon_code','');
    	if($customer_id){
    		$quote_table  = TableRegistry::get('Quote');
    		$order_table = TableRegistry::get('Order');
    		$quote = $this->getQuoteId($customer_id);
    		if(!empty($quote)){
	    		$remote_ip = $_SERVER['REMOTE_ADDR'];
	    		 $address_id = $this->request->getData('address_id');
	    		$addressTable=TableRegistry::get('address');
	    		$address=$addressTable->find()->where(['entity_id'=>$address_id])->first();
				// print_R($this->request->getData());
				// die;
	    		$quote_id = $quote->entity_id;
	    		$connection = ConnectionManager::get("default");
	    		$total_paid	=	$quote->grand_total;
	    		if($coupon_code!='')
	    		{
	    			$coupon_data = $this->applyCouponCode($total_paid,$coupon_code,$customer_id);
	    			$total_paid = $coupon_data['total_paid'];
	    			$order_data['discount_description'] = $coupon_data['discount_description'];
	    			$order_data['discount_amount'] = $coupon_data['discount_amount'];
	    			$order_data['coupon_code'] = $coupon_code;
	    		}
	    		
	    		$increment_id = $this->generateIncrementId();
	    		$order_data['quote_id'] = $quote->entity_id;
	    		$order_data['state'] = "new";
	    		$order_data['status'] = "pending";
	  	  		$order_data['store_id'] = "1";
	    		$order_data['customer_id'] = $quote->customer_id;
	    		$order_data['grand_total'] = $quote->grand_total;
	   			$order_data['total_paid'] = $total_paid;
	   			$order_data['increment_id'] = $increment_id;
	    		if(!empty($address->email)){
	    			$order_data['email'] = $address->email;
	    		}
	    		$order_data['name'] = $address->name;	    		
	    		$order_data['contact'] = $address->contact;
	    		$order_data['address'] = $address->address;
	    		$order_data['city'] = $address->city;
	    		$order_data['zipcode'] = $address->zipcode;
	    		$order_data['billing_address_id'] = $address_id;;
	    		$order_data['shipping_adddress_id'] = $address_id;;
	    		$order_data['remote_ip'] = $remote_ip;
	    		$order_data['total_item_count'] = $quote->items_count;
	    		$order_data['total_qty_ordered'] = $quote->items_qty;
	    		$order_data['created_at'] = date('Y-m-d H:i:s');
	    		$order_data['updated_at'] = date('Y-m-d H:i:s');
	    		$order_entity = $order_table->newEntity($order_data);
	    		$result = $order_table->save($order_entity);
	    		if($result)
	    		{
	    			$connection->execute("update sales_flat_quote set is_active=0 where entity_id=$quote_id limit 1");
	    		}
	    		$data['order_id'] = $result->increment_id;
	    		$response['status']=true;
	    		$response['data']=$data;
	    		$response['msg']='order placed successfully';
	    	}
	    	else{
	    		$response['status']=false;
	    		$response['data']='';
	    		$response['msg']='quote empty';	
	    	}
    	}
    	else{
    		$response['status']=false;
    		$response['status']='';
    		$response['msg']='Unable to place order failed';	
    	}
    	echo json_encode($response);die;
    }
	 function generateIncrementId(){
    	$connection = ConnectionManager::get('default');
    	$data = $connection->execute("select increment_id from sales_flat_order order by entity_id desc limit 1")->fetch('assoc');
    	if(!empty($data['increment_id']))
    	{
    		return $data['increment_id']+1;
    	}
    	else{
    		return 100000001;
    	}

    }
	 function applyCouponCode($total_paid,$coupon_code,$customer_id){
    	$table = TableRegistry::get('Orders');
    	$result=$table->find()->where(['coupon_code'=>$coupon_code,'customer_id'=>$customer_id])->first();
    	
    	if(empty($result))
    	{
    		$table = TableRegistry::get('Offer');
    		$offer=$table->find()->select(['id','coupon_code','discount','content','coupon_type','title'])->where(['coupon_code'=>$coupon_code,'status'=>'y'])->first();
    		if($offer->coupon_type=='fix'){
    			$discount_amount =	$offer['discount'];	
    		}
    		elseif($offer->coupon_type=="percent"){
    			$discount_amount = ($total_paid * $offer['discount'])/100;	
    		}
    		else{
    			$discount_amount = 0;	
    		}
    		$total_paid = $total_paid - $discount_amount; 
    		$coupon_data['total_paid'] = $total_paid;
    		$coupon_data['discount_description'] = $offer['content'];
    		$coupon_data['discount_amount'] = round($discount_amount,2);	
    	}
    	else{
    		$coupon_data['total_paid'] = $total_paid;
    		$coupon_data['discount_description'] = '';
    		$coupon_data['discount_amount'] = '';
    	}
    	return $coupon_data;
	}
	function sharedlist()
	{
		if($this->request->is('post'))
    	{ 
	      $request = $this->request->getData();
		  extract($request);
		  if($customer_id)
		  {
			 $ShareTable = TableRegistry::get('Sharelist');
			 $sharelist = $ShareTable->find()->where(['Sharelist.user_id'=>$customer_id,'Sharelist.status'=>"y"])->contain(['Catelog'])  
						->all()->toArray();   
			
			 if(count($sharelist))
			 {
				
				 foreach ($sharelist as $key => $item) {
					 $date_format=$item['created']->format('Y-m-d');
					  $arr[$date_format][$key]=$item;
					
				 }
				 $i=0;
				 
				 foreach($arr as $key=>$v)
				 {
					 $d[$i]['date']=$key;
					 $j=0;
					foreach($v as $s)
					{
						$value=$s['catelog'];
						$catelog_id=$data[$j]['id']=$value['id'];
						$data[$j]['title']=$value['name_en'];
						$offer_id=$value['offer_id'];
						if($offer_id>0)
							{
								$offer=$this->offerdetail($offer_id);
								$offer_type=$offer['offer_type'];
								if($offer_type=="fix")
								{
									$data[$j]['off']="Rs ".$offer['offer_value']." off";
									$s_price=$value['selling_price']-$offer['offer_value'];
								}
								  else
								  {
									  // $offer['offer_value']=5;
									$data[$j]['off']=$offer['offer_value']." % off";  
									
									$s_price=($value['selling_price']*$offer['offer_value'])/100;
									 $s_price=round($value['selling_price']-$s_price);
								  }
								 
								  $data[$j]['selling_price']=$s_price;
								  $data[$j]['amount']=$value['selling_price'];
								  $data[$j]['off']=$offer['offer_value'];
								}
								else
								{
									
									$data[$j]['off']=0;
									$data[$j]['selling_price']=$value['selling_price'];
									$data[$j]['amount']=$value['selling_price'];   
								} 
								// $data['off']=1;
								if($value['shipping_charges']==0)
								{
									$data[$j]['extra_text']="FREE SHIPPING";
								}
								else
								{
									$data[$j]['extra_text']='';
								}
								if($value['cod'])
								{
									$data[$j]['cod_text']="COD AVAILABLE";
								}
								else
								{ 
									$data[$j]['cod_text']='';
								}
								
								$data[$j]['share_text']=$value['share_text'];
								// 1 means product shared , 0 menas not shared 
								$sharedata=$this->priceupdated($catelog_id,$customer_id);
								
								if($sharedata)
								{
									$data[$j]['is_shared']=1;
									$data[$j]['market_price']=$sharedata['final_amount'];
									$data[$j]['my_earning']=$sharedata['increase_amount'];
									$data[$j]['market_string']=$value['selling_price']." + ".$sharedata['increase_amount']."(My Earning)";
								}
								else
								{
									$data[$j]['is_shared']=0;
									$data[$j]['market_price']=0;
									$data[$j]['my_earning']=100;
								}
								
								$data[$j]['min_range']=$value['selling_price'];
								if($value['reseller_earning'])
								$data[$j]['max_range']=$value['reseller_earning'];
								else
								$data[$j]['max_range']=$value['selling_price']+500;	
							    $data[$j]['image']=Router::url('image/',true).$value['pic'];
						$j++;
					}  
					 $d[$i]['data']=$data;
					 $i++;
				 }
				// print_R($d);
				// die;
				$response['status'] =true;
			$response['data']['record'] =$d;
			$response['msg'] = "data found";    	
			 }
			 else
			 {
				 $response['status'] =false;
				$response['data'] = '';
				$response['msg'] = "Share Catelog First";    	
			 }
		  }
		  else
		  {
			$response['status'] =false;
			$response['data'] = '';
			$response['msg'] = "Required Parametr Missing";    		  
			  
		  }
		} 
		else{
			$response['status'] =false;
			$response['data'] = '';
			$response['msg'] = "Invalid request type";    		
    	}
    	echo json_encode($response);die;
	}
	
	function addtocartwithshare()
	{
		if($this->request->is('post'))
    	{   
    		$request = $this->request->getData();
			// print_R($request);
			// die;
			extract($request);
    		$quote_item_table=TableRegistry::get('QuoteItem');
    		$quote_table=TableRegistry::get('Quote');
    		$entity = $quote_item_table->newEntity($request,['validate'=>"item"]);
			if($customer_id && $product_id && $increase_amount && $final_amount)
			{
				$ShareTable = TableRegistry::get('Sharelist');
				$query	=	$ShareTable
						->find()
						 ->where(['status = '=>'y','user_id'=>$customer_id,'product_id'=>$product_id])
						// ->select(['attribute_name'=>'frontend_label','attribute_id','backend_type','frontend_input'])
						->first();
				// print_R($query);
				// die;
				if($query)
				{
					$old_amount=$query->increase_amount;
					$edit_amount=$old_amount-$increase_amount;
					$query->increase_amount=$increase_amount;
					$query->edit_amount=$edit_amount;
					$query->final_amount=$final_amount;
					if($ShareTable->save($query))
					{
						// $reponse['status']	=true;
						// $reponse['msg'] 	=	"Share List updated";
					}
					else
					{
						// $reponse['status']	=false;
						// $reponse['msg'] 	=	"Failed to update shared list";
					}
				}
				else
				{
					// new entry 
					$request['user_id']=$customer_id;
					$entity =	$ShareTable->newEntity($request);
					$result	=	$ShareTable->save($entity);
					if($result)
					{
						// $reponse['status']	=true;
						// $reponse['msg'] 	=	"Share List Created";
					}
					else
					{
						// $reponse['status']	=false;
						// $reponse['msg'] 	=	"Failed to Create Shared List";
					}
				}
			}
    		if(!$entity->getErrors())
    		{
    			$product = $this->getProduct($request['product_id']);
				// print_R($product);
				// die;
				$catelog_id=$product['catelog_id'];
				$customer_id = $request['customer_id'];
				$seller_id=$product['seller_id'];
				$sharedata=$this->priceupdated($catelog_id,$customer_id);
			   if($sharedata)
			   {
				  if($sharedata['final_amount']){
			    	$price = $sharedata['final_amount'];
					}else{
						$price = $product->selling_price;
					} 
			   }
			   else
			   {
				  $price = $product->selling_price;
			   }
	    		
	    		$product_name = $product->name_en;
	    		$product_id = $product->id;
	    		$qty = $request['quantity'];
	    		
    			$grand_total  = $qty*$price;
    			$quote = $this->getQuoteId($customer_id);
    			// pr($quote);die;
    			if(!empty($quote)){
    				$quote->grand_total = $quote->grand_total+$grand_total;	
    				$quote->items_count = $quote->items_count+$qty;	
    				$quote->items_qty = $quote->items_qty+$qty;

		    		$get_quote_item = $quote_item_table->find()->where(['product_id'=>$product_id,'quote_id'=>$quote->entity_id])->first();
		    		if(isset($_GET['debug'])){
		    			// pr($get_quote_item);
		    		}
		    		if(empty($get_quote_item)){
		    			$quote_item=[
			    			'created_at'=>date('Y-m-d H:i:s'),
			    			'quote_id'=>$quote->entity_id,    		
			    			'qty'=>$qty,    		
			    			'price'=>$price,    		
			    			'base_price'=>$grand_total,    		
			    			'product_id'=>$product_id,
			    			'name'=>$product_name,
			    			'created_at'=>date('Y-m-d H:i:s'),
			    			'updated_at'=>date('Y-m-d H:i:s'),
			    		];
		    			$quote_item_entity = $quote_item_table->newEntity($quote_item);
		    			$quote_item_table->save($quote_item_entity);
		    		}else{
		    			if($get_quote_item->qty ==1 && $qty ==-1){
		    				$quote_item_table->delete($get_quote_item);
		    			}
		    			else{
		    				$qty = $get_quote_item->qty + $request['quantity'];
		    				$grand_total  = $qty*$price;
			    			$get_quote_item->price=$price;	
			    			$get_quote_item->qty=$qty;	
			    			$get_quote_item->base_price=$grand_total;	
			    			$get_quote_item->name=$product_name;
			    			$quote_item_table->save($get_quote_item);
		    			}
		    				
		    		}
		    		$quote_table->save($quote);
		    		$this->updateQuote($quote->entity_id);	
    			}
    			else{
    				$quote_data=[
		    			'created_at'=>date('Y-m-d H:i:s'),
		    			'store_id'=>0,    		
		    			'items_count'=>$qty,    		
		    			'items_qty'=>$qty,    		
		    			'customer_id'=>$customer_id,
		    			'grand_total'=>$grand_total,
		    			'remote_ip'=>$_SERVER['REMOTE_ADDR'],
		    		];
		    		$quote = $this->newQuoteId($quote_data);
		    		
		    		$quote_item=[
		    			'created_at'=>date('Y-m-d H:i:s'),
		    			'quote_id'=>$quote->entity_id,    		
		    			'qty'=>$qty,    		
		    			'price'=>$price,    		
		    			'base_price'=>$grand_total,    		
		    			'product_id'=>$product_id,
		    			'name'=>$product_name,
		    			'created_at'=>date('Y-m-d H:i:s'),
		    			'updated_at'=>date('Y-m-d H:i:s'),
		    		];

		    		$quote_item_entity = $quote_item_table->newEntity($quote_item);
		    		$quote_item_table->save($quote_item_entity);
		    		$this->updateQuote($quote->entity_id);
    			}
    			$quote = $this->getQuote($quote->entity_id);
    			$grand_total = $quote->grand_total;
    			$data['quote_id']=$quote->entity_id;
    			$data['customer_id']=$quote->customer_id;
    			$data['items_count']=$quote->items_count;
    			$data['grand_total']=$grand_total;
				if($seller_id)
				{
					$table = TableRegistry::get('Users');
					$result	=	$table->find()->select(['fullname','dob','mobile'])->where(['id'=>$seller_id])->first();
					$data['reseller_name']=$result['fullname'];
					$data['reseller_phone']=$result['mobile'];
				}
				
				
    			$response['status'] = true;
    			$response['data'] = $data;
    			$response['msg'] = "$product_name add to cart successfully";
    		}
    		else{
    			 $response['status'] = false;
    			 $response['data'] = $entity->getErrors();
    			 $response['msg'] = "Some required fields Are Missing";

    		}
    	}
    	else{
			$response['status'] =false;
			$response['data'] = '';
			$response['msg'] = "Invalid request type";    		
    	}
    	echo json_encode($response);die;
	}
	function categorydetail()
	{
		if($this->request->is('post'))
    	{ 
	      $request = $this->request->getData();
		  extract($request);
		  if($customer_id && $category_id)
		  {
			$category = TableRegistry::get('Category');
				$query = $category
				->find()
				->where(['id'=>$category_id])
				->first()->toArray();
				if(count($category)>0)
				{
					
					$o[0]['title']='Best Selling';
					$o[0]['subtitle']='Order Now';
					$o[0]['image']='http://13.233.186.157/img/app/group_1625.png';
					$co[0]['name']="Collections";
					$co[0]['type']="collection";
					$ct[0]['id']=1;
					$ct[0]['title']="Catelog";
					$ct[0]['sellamount']="$700";
					$ct[0]['amount']="1000";
					$ct[0]['off']="30%";
					$ct[0]['sharecount']="300";
					$ct[0]['offer']="30%";
					$ct[0]['extra_text']="Free Shipping";
					$co[0]['data']=$this->cateloglist($customer_id);
					
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
					$data['offer']=$this->offerlist();
					$data['category']=$this->subcategorylist($category_id);
					$data['topsubcategory']=$this->topsubcategory($category_id);
					$data['top']=$this->cateloglist($customer_id);
					$response['status'] =true;
					$response['data'] =$data;
					$response['msg'] = "Category detail";    
				}
				else
				{
					$response['status'] =false;
					$response['data'] = '';
					$response['msg'] = "Invalid Category id listing";    
				}
				
		  }
		  else
		  {
			$response['status'] =false;
			$response['data'] = '';
			$response['msg'] = "Required Parametr Missing";    		  
			  
		  }
		}
		else{
			$response['status'] =false;
			$response['data'] = '';
			$response['msg'] = "Invalid request type";    		
    	}
    	echo json_encode($response);die;
		
	}
	function topsubcategory($cat_id)
	{
		$category = TableRegistry::get('Category');
		$query = $category
	    ->find()
	    ->select(['id','children_count','thumbnail','name'])
	    ->order(['id'=>'asc'])
	    ->where(['level ='=>'2','parent_id'=>$cat_id]);
	    $sample=[];
		
	    foreach ($query as $value) {
		   	$data['id']=$value['id'];
    		$data['name']=$value['name'];
    		$data['type']='category';
    		$data['image']=Router::url('/category-thumbnail/', true) . $value['thumbnail'];
    		// $data['children_count']=$value['children_count'];
    		$sample[]=$data;
		}
		
		return $sample;
	}
	function subcategorylist($cat_id)
	{
		$category = TableRegistry::get('Category');
		$query = $category
	    ->find()
	    ->select(['id','children_count','thumbnail','name'])
	    ->order(['id'=>'asc'])
	    ->where(['level ='=>'1','parent_id'=>$cat_id]);
	    $sample=[];
		
	    foreach ($query as $value) {
		   	$sub_id=$data['id']=$value['id'];
    		$data['name']=$value['name'];
    		$data['type']='category';
    		
    		$data['image']=Router::url('/category-thumbnail/', true) . $value['thumbnail'];
			$data['subcategory']=$this->childcategory($sub_id);
    		// $data['children_count']=$value['children_count'];
    		$sample[]=$data;
		}
		
		return $sample;
	}
	function childcategory($cat_id)
	{
		$category = TableRegistry::get('Category');
		$query = $category
	    ->find()
	    ->select(['id','children_count','thumbnail','name'])
	    ->order(['id'=>'asc'])
	    ->where(['parent_id'=>$cat_id]);
	    $sample=[];
		
	    foreach ($query as $value) {
		   	$data['id']=$value['id'];
    		$data['name']=$value['name'];
    		$data['type']='category';
    		$data['image']=Router::url('/category-thumbnail/', true) . $value['thumbnail'];
    		// $data['children_count']=$value['children_count'];
    		$sample[]=$data;
		}
		
		return $sample;
	}
	function sucategorydetail()
	{
	}  
	
	

}
