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
use Cake\Controller\ShypliteController;

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
	function sendOnesignalMessage() {
    $content      = array(
        "en" => 'Share New Catalogue \n Catalogue Name'
    );
    $hashes_array = array();
    array_push($hashes_array, array(
        "id" => "like-button",
        "text" => "Like",
        "icon" => "http://i.imgur.com/N8SN8ZS.png",
        "url" => "https://yoursite.com"
    ));
    array_push($hashes_array, array(
        "id" => "like-button-2",
        "text" => "Like2",
        "icon" => "http://i.imgur.com/N8SN8ZS.png",
        "url" => "https://yoursite.com"
    ));
   $fields = array(
        'app_id' => "742f79da-c99c-42b5-ad49-24ad301dbd5f",
        'included_segments' => array(
            'All'
        ),
        'data' => array(
            "foo" => "bar"
        ),
        'contents' => $content,
		 'headings' => array("en"=>"test heading"),
		  'chrome_web_image' => 'http://resellermantra.com/image/2019/08/1566838724FWP0014.jpeg',
        'web_buttons' => $hashes_array
    );
    $fields = json_encode($fields);
    print("\nJSON sent:\n");
    print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic NGZmYTAwOTEtZWRkZi00ZDU4LWJmMDItY2VlOThkZTIzNWFj'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

	function pushtest()
	{
		$push=$this->sendOnesignalMessage();
	    pr($push);
		die;
	}
	function topsellingcatelog($customer_id)
	{
		$connection = ConnectionManager::get('default');
		$c=0;
		// get all top selling catelog
		$q="SELECT catelog_id, SUM(qty) AS TotalQuantity
				FROM sales_flat_quote_item where process_status='orderplace'
				GROUP BY catelog_id
				ORDER BY catelog_id DESC
				LIMIT 10";
		$childlist=$connection->execute($q)->fetchAll('assoc');
		if(count($childlist)>0)
		{
			foreach($childlist as $ch)
			{
				$child[$c]=$ch['catelog_id'];
				$c++;
			}
		}

		$Offer = TableRegistry::get('Catelog');
		// top sales

		$topsale = $Offer
	    ->find()
	    ->select(['id'])
	    ->order(['id'=>'DESC'])
	    ->where(['status ='=>'1','top_catelog'=>'1'])
		->toArray();
		// pr($topsale);
		// die;
		if(count($topsale)>0)
		{

			foreach($topsale as $t)
			{
				$child[$c]=$t['id'];
				$c++;
			}
		}
		// pr($child);
		// die;
		$c_ids=implode(",",$child);
		  $query="select * from catalog_catelog_entity where status='1' and id in($c_ids)";

			$query = $connection->execute($query)->fetchAll('assoc');
		// pr($query);
		// die;
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

			  $data['selling_price']=$value['selling_price'];
			  $data['amount']=$value['base_price'];
			  $data['off']=$offer['offer_value'];
			}
			else
			{

				$data['off']=0;
				$data['selling_price']=$value['selling_price'];
				$data['amount']=$value['base_price'];
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
				$data['my_earning']=50;
			}

			$data['min_range']=$value['selling_price'];
			$data['img_height']=floatval($value['img_height']);
			$data['img_width']=$value['img_width'];
			$data['img_type']=$value['img_type'];
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
	function cateloglist($customer_id,$category_id){
		$Catelog = TableRegistry::get('Catelog');
		$sample=[];
		// echo $category_id;
		// die;
		if($category_id)
		{
			// find all child of that category
			$connection = ConnectionManager::get('default');
			   $catchild="SELECT id FROM `catalog_category` WHERE `parent_id` ='$category_id' group by id";
			 $childlist = $connection->execute($catchild)->fetchAll('assoc');
			$child[0]=$category_id;
			$c=1;
				foreach($childlist as $ch)
				{
					$child[$c]=$ch['id'];
					$c++;
				}

				$child_ids=implode(',',$child);

				if($child_ids)
				{
			      $catquery="SELECT catelog_id FROM `catalog_category_catelog` WHERE `category_id` in($child_ids)   group by catelog_id";

				$catlist = $connection->execute($catquery)->fetchAll('assoc');
				}
				else
				{
					$catlist=[];
				}
			// pr($catlist);
			// die;
			$count=count($catlist);
			if($count>0)
			{
				$j=0;
				foreach($catlist as $cat)
				{
					$cids[$j]=$cat['catelog_id'];
					$j++;
				}
				// pr($cids);

				$c_ids=implode(",",$cids);
				  $query="select c.* from catalog_catelog_entity as c left join page_order on c.id=page_order.catelog_id
					where c.status='1' and c.pending_stock>=1 and c.id in($c_ids) and c.status='1' and c.on_stock='y' group by c.id order by page_order.shift_pos DESC,c.id desc";

				$resultdata = $connection->execute($query)->fetchAll('assoc');
				// pr($resultdata);
				// die;
				foreach ($resultdata as $value) {
						$catelog_id=$data['id']=$value['id'];
						$data['title']=$value['name_en'];

						// on amount offer value is applied
						// $data['amount']=3;
						 $offer_id=$value['offer_id'];

						// $offer_id=1;
						$data['off']=$value['offer_amount'];
						$data['selling_price']=$value['selling_price'];
						$data['amount']=$value['base_price'];
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
						$attribute_column = $this->getAttributes($catelog_id,"catelog");
						// pr($attribute_column);
						// die;
						foreach($attribute_column as $val)
						{
							// pr($val);
							// die;
							$a .="*".$val['attribute_name']."*: ".$val['attribute_value'];
							$a .="\n";
						}
						// echo $a;
						// die;
						$data['share_text']=$value['share_text'];
						// $data['share_text']=$value['share_text']."\n *Price:* ".$value['base_price']." /- \n".$a;
						// 1 means product shared , 0 menas not shared
						// echo "dd";
						// die;
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
							$data['my_earning']=50;
						}

						$data['min_range']=$value['selling_price'];
						$data['img_height']=floatval($value['img_height']);
						$data['img_width']=$value['img_width'];
						$data['img_type']=$value['img_type'];
						if($value['reseller_earning'])
						$data['max_range']=$value['reseller_earning'];
						else
						$data['max_range']=$value['max_earning'];
						// $data['image']=$value['offer_image'];
						// $data['type']='category';
						$data['image']=Router::url('image/',true).$value['pic'];
						$slider=$data['slider']=$this->catelogproductimages($catelog_id);
						$data['product_count']=count($slider);
						// $data['children_count']=$value['children_count'];
						$sample[]=$data;
					}

			}



		}
		// pr($sample);
		// die;
		return $sample;
		// pr($catlist);
		// die;



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
						 ->order(['id'=>'desc'])
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
		// pr($sharedata);
		// die;
		return $sharedata;
	}
	function catelogproductimages($catelog_id)
	{
		// $si=[];
		$table = TableRegistry::get('Product');
    	$slider = $table->find()->select(['id','pic'])->where(['catelog_id'=>$catelog_id,'on_stock'=>'y'])->toArray();
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
	function offerlist($category_id){
		$connection = ConnectionManager::get('default');
		$Offer = TableRegistry::get('Offer');
		if($category_id>0)
		{
			 $q="SELECT offer_id FROM `catalog_catelog_entity` WHERE status='1' and id in(SELECT catelog_id FROM `catalog_category_catelog` WHERE category_id
			in(SELECT id as category_id FROM `catalog_category` WHERE id='$category_id' or parent_id='$category_id')) and pending_stock>=1 group by offer_id";

			 $childlist = $connection->execute($q)->fetchAll('assoc');
			 $count=0;
			 $off_ids=[];
				foreach($childlist as $ch)
				{
					$off_ids[$c]=$ch['offer_id'];
					$count++;
				}

				// $off_ids=implode(',',$child);
			// pr($off_ids);
			// die;
			if(count($off_ids)>0)
			{
			$query = $Offer
			->find()
			// ->select(['id','children_count','thumbnail','name'])
			// ->order(['name'=>'asc'])
			->where(['status ='=>'1','id IN'=>$off_ids]);
			}
			else
			{
				$query=[];
			}
		}
		else if($category_id==0)
		{
			$query = $Offer
				->find()
				// ->select(['id','children_count','thumbnail','name'])
				// ->order(['name'=>'asc'])
				->where(['status ='=>'1']);
		}
	   else
	   {
		   $query=[];
	   }


	    $sample=[];
	    foreach ($query as $value) {
		   	$data['id']=$value['id'];
    		$data['title']=$value['title'];
    		$data['subtitle']=$value['subtitle'];
    		$data['search_keyword_1']=$value['search_keyword_1'];
    		$data['search_keyword_2']=$value['search_keyword_2'];
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
		// $query = $category
	    // ->find()

	    // ->order(['Category.shift_category'=>'asc'])
	   // ;
		$query = $category->find()->select(['id','children_count','thumbnail','name']) ->where(['level ='=>'0','is_active'=>'1'])->limit(15);

			$zeroLastCase = $query->newExpr()->addCase(
				[$query->newExpr()->add(['Category.shift_category' => 0])],
				[1, 0],
				['integer', 'integer']
			);

			$query
				->orderAsc($zeroLastCase)
				->orderAsc('Category.shift_category');
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
				$data['image']="http://resellermantra.com/category-thumbnail/listshare.png";
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
		$Pageorder = TableRegistry::get('Pageorder');
		$pagelist = $Pageorder
	    ->find()
		->contain(['Category'])
		->contain(['Category'=>function($q){
    				return $q->select(['id','name','thumbnail']);
    		}
    	])
	    // ->select(['id','path','level','children_count','position','name','is_active'])
	    ->order(['shift_pos'=>'asc'])
	    ->where(['page_type'=>'home','status'=>'active'])
		->toArray();
		// $adslist = $Pageorder
	    // ->find()
	    // ->order(['shift_pos'=>'asc'])
	    // ->where(['page_type'=>'ads','status'=>'active'])
		// ->toArray();
		$adslist=[];
		 $co=[];
		 $live_ver=2;

		foreach($pagelist as $list)
		{

		   if(count($adslist)>0)
		   {

			   if($i%2==0)
			   {
				   // show ads
				   if($adslist[0])
					$co[$i]['name']=$adslist[$i];
					$co[$i]['type']="collection";
					$co[$i]['image']="collection";
					$category_id= $co[$i]['id']=$list['category_id'];
					$co[$i]['data']=$this->cateloglist($customer_id,$category_id);
			   }
			   else
			   {
			   }
		   }
		   else
		   {
			   $category_id=$list['category_id'];
			   $catelogdata=$this->cateloglist($customer_id,$category_id);

			   if(count($catelogdata)>0)
			   {
					$cd['name']=$list['category']['name'];
					$cd['type']="collection";
					$category_id= $cd['id']=$list['category_id'];
					$cd['data']=$catelogdata;
					$co[]=$cd;

			   }


			  // $category_id=1;
			  // $subcat='';
				$subcat=$this->subcategory($category_id,50);
			   // pr($subcat);
			  // die;

			  if(count($subcat)>0)
			  {

				$cd['name']="YOU MAY LIKE TO SHARE";
				$cd['type']="category";
				$j=0;
				$cdata=array();
				foreach($subcat as $cat)
				{
					$cdata[$j]['id']=$cat['id'];
					$cdata[$j]['title']= substr($cat['name'], 0, 12);
					$cdata[$j]['type']="category";
					$cdata[$j]['image']="http://resellermantra.com/category-thumbnail/".$cat['thumbnail'];
					$j++;
				}

				$cd['data']=$cdata;
				$co[]=$cd;
			  }
			  // pr($co);
			  // die;
		   }
		  // $i++;
		}
		// $co[0]['name']="Collections";
		// $co[0]['type']="collection";



		$data['record']=$co;
		$data['category']=$this->getCategorList($customer_id);
		$data['offer']=$this->offerlist(0);
		$data['top']=$this->topsellingcatelog($customer_id);
		// $data['top']=[];
		$ShareTable = TableRegistry::get('Sharelist');


		$response['status'] =true;
		$response['data'] =$data;
		$response['contact_no'] ="+918819801234";
		$response['contact_email'] ="support@resellermantra.in";
		$response['contact_msg '] ="Call Support Timing From 10am-7pm";
		$is_force="y";
		if($is_force=='y' && $live_ver>$app_ver)
		{
			$status=201;
			$msg="Dear User,To Continue using App you have to upgrade it to latest version";
		} else if($live_ver>$app_ver)
		{
			$status=202;
			$msg="Dear User,We have added few cool features . To experience them, we request you to kindly update your app";
		} else
		{
			$status=200;
			$msg="data found";
		}
		$response['code'] =$status;
		$response['msg'] =$msg;
		echo json_encode($response);
		die;
	}

	function subcategory($category_id,$limit)
	{
		$sub_data=array();
		$category = TableRegistry::get('Category');
			$query = $category
		    ->find()
		    ->select(['id','path','level','children_count','position','name','is_active','thumbnail'])
		    ->where(['parent_id'=>$category_id])
		    ->order(['id'=>'asc'])
			->limit($limit)
		    ->all()
		    ;
		    foreach ($query as $data) {
			   $sub_data[]=$data;
			}
		// pr($category_data);
		// die;
		return $sub_data;
	}
	function checkavilablity()
	{
		$request=$this->request->getData();
		extract($request);
		if($product_id && $pin_code)
		{
			$modelist=array('1'=>'Air','3'=>'Lite-2kg','8'=>'Lite-1kg','9'=>'Lite-0.5kg');
			$connection = ConnectionManager::get('default');
			$q="select p.id,a.zipcode from catalog_product_entity as p inner join customer_address_entity as a on a.entity_id=p.seller_address_id where p.id='$product_id'";
			$predata = $connection->execute($q)->fetch('assoc');
			// var_dump($predata);
			// exit;
			if($predata)
			{
				$source_pin=$predata['zipcode'];
				$res=$this->serviceability($pin_code,$source_pin);
				extract($res);
				if($airCod==1 || $lite2kgCod==1 || $lite1kgCod==1 || $liteHalfKgCod==1)
				{
					$response['status'] =true;
					$response['msg'] ="Product Avilable";
					$response['code'] =200;
				}
				else
				{
					$response['status'] =false;
					$response['msg'] ="Service is Not avilable in your area";
					$response['code'] =404;
				}
			}
			else
			{
				$response['status'] =false;
				$response['data'] ="Something Went wrong at supplier side,contact support";
				$response['code'] =404;
			}
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

	function getCatelogDetail(){
    	$connection = ConnectionManager::get('default');
    	$catelog_id = $this->request->getData('id');
    	$customer_id = $this->request->getData('customer_id');
		if($catelog_id)
		{
			   $sql = "select users.user_rating,users.display_name as seller_name,p.base_price,p.offer_amount,p.img_height,p.img_width,p.img_type,p.shipping_charges,p.cod,p.share_text,p.offer_id,p.pic,p.offer_image,p.id as catelog_id,p.name_en,p.name_hn,p.description,p.primary_price,p.selling_price,p.shipping_charges
			 ,p.cod_rule,p.return_rule,p.youtube_link from catalog_catelog_entity as p inner join  users on users.id=p.seller_id where p.id=$catelog_id limit 1";

			$value = $connection->execute($sql)->fetch('assoc');
			// pr($value);
			// die;
			if(!empty($value)){
				$catelog_id=$data['catelog_id'] = $value['catelog_id'];
				$data['name_en'] = $value['name_en'];
				$data['name_hn'] = $value['name_hn'];
				$data['description'] = $value['description'];
				$data['img_height'] = floatval($value['img_height']);
				$data['img_width'] = $value['img_width'];
				$data['img_type'] = $value['img_type'];
				$offer_id=$value['offer_id'];
				$data['selling_price']=$value['selling_price'];
				$data['amount']=$value['base_price'];
				 $data['off']=$value['offer_amount'];
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
				$data['share_text'] =$value['share_text']."\n *Price:* ".$value['selling_price']."/-";
				$attribute_column = $this->getAttributes($catelog_id,"catelog");
				if(!$attribute_column)
					$attribute_column=[];
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
				$data['suplier_rating'] =$value['user_rating'];
			    $s[0]['image']= Router::url('image/',true).$value['pic'];
				if($offer_id>0)
				{
					$offer=$this->offerdetail($offer_id);
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
	    ->where(['catelog_id'=>$catelog_id,'on_stock'=>'y'])->toArray();
		// pr($query);
		// die;
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

				$s_price=($value['selling_price']*100)/(100-$offer['offer_value']);
				 $s_price=round($s_price);
			  }

			  $data[$p]['amount']=$value['base_price'];
			  $data[$p]['selling_price']=$value['selling_price'];
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
			if(isset($s_price))
			$data[$p]['primary_price'] = $s_price;
			else
				$data[$p]['primary_price']=$value['selling_price'];
			// $data[$p]['primary_price']=$value['base_price'];
			$data[$p]['primary_price']=$value['base_price'];
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
				$data[$p]['cod_text']='';
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
				$data[$p]['my_earning']=50;
			}
			$data[$p]['min_range']=$value['selling_price'];
			if($value['reseller_earning']>0)
			$data[$p]['max_range']=$value['reseller_earning'];
		    else
			$data[$p]['max_range']=$value['max_earning'];
			// pr($data);
			// die;
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
		 $stock=[];
		if(count($stockdata)>0)
		{

			$i=0;
			foreach($stockdata as $s)
			{
				$stock_qty=$s['pending_stock'];
				if($stock_qty>2)
				{
				$stock[$i]['id']=$s['id'];
				$stock[$i]['name']=$s['attribute_option_value']['value'];
				$stock_value=$s['pending_stock'];
				$used=$s['sale_product'];
				$stock[$i]['stock']=$stock_value-$used;

				$i++;
				}


			}
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
			  $sql = "select users.fullname as seller_name,p.base_price,p.offer_amount,p.img_guarantee,p.reseller_earning,p.catelog_id,p.cod_image,p.shipping_charges,p.cod,p.share_text,p.offer_id,p.pic,p.offer_image,p.id as product_id,p.name_en,p.name_hn,p.description,p.primary_price,p.selling_price,p.shipping_charges
			 ,p.cod_rule,p.return_rule,p.youtube_link from catalog_product_entity as p inner join  users on users.id=p.seller_id where p.id=$product_id limit 1";
			// die;
			$value = $connection->execute($sql)->fetch('assoc');

			if(!empty($value)){
				$product_id=$data['product_id'] = $value['product_id'];
				$catelog_id=$value['catelog_id'];
				$CatelogTable = TableRegistry::get('Catelog');
				$catelogdata =$CatelogTable
				->find()
				->select(['id','img_height','img_width','img_type'])
				->where(['id ='=>$catelog_id])->first();
				$data['img_height'] = floatval($catelogdata['img_height']);
				$data['img_width'] = $catelogdata['img_width'];
				$data['img_type'] = $catelogdata['img_type'];
				$data['name_en'] = $value['name_en'];
				$data['name_hn'] = $value['name_hn'];
				$data['description'] = $value['description'];
				$offer_id=$value['offer_id'];
				$data['selling_price']=$value['selling_price'];
				$data['amount']=$value['base_price'];
				$data['primary_price']=$value['base_price'];
				$data['off']=$value['offer_amount'];
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
				$data['img_guarantee'] =Router::url('image/',true).$value['img_guarantee'];
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
				$data['my_earning']=50;
			}

			$data['min_range']=$value['selling_price'];
			if($value['reseller_earning'])
			$data['max_range']=$value['reseller_earning'];
		    else
			$data['max_range']=$value['max_earning'];
			    $s[0]['image']= Router::url('image/',true).$value['pic'];
				if($offer_id>0)
				{
					$offer=$this->offerdetail($offer_id);
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
					$i++;
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
			$request=$this->request->getData();
			extract($request);

			if($customer_id)
			{

				$sample=$this->offercateloglist($search_keyword);

				$reponse['status'] =true;
				$reponse['data'] =$sample;
				$reponse['msg'] ="Search  Result";
			}
			else
			{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Required Parameter Missing";
			}

    	}else{
    		$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invalid request type";
    	}

		echo json_encode($reponse);die;
    }

	function offercateloglist($search_keyword){
		$s=explode(',',$search_keyword);
		$s1=$s[0];
		$s2=$s[1];
		$sample=[];
		$c=1;
		$connection = ConnectionManager::get('default');
		if($s1 && $s2)
		{
		  // have to search category name as 1 and offer value as 2nd variable
		  $childlist=$connection->execute("select id from catalog_category where name='$s1'")->fetchAll('assoc');
		  if($childlist)
			{
				foreach($childlist as $ch)
				{
					$child[$c]=$ch['id'];
					$c++;
				}
				$child_ids=implode(',',$child);
				if($child_ids)
				{
					$catquery="SELECT catelog_id FROM `catalog_category_catelog` WHERE `category_id` in($child_ids)   group by catelog_id";
					$catlist = $connection->execute($catquery)->fetchAll('assoc');
				}
				else
				{
					$catlist=[];
				}
				// pr($catlist);
				// die;
				$count=count($catlist);
				if($count>0)
				{
					$j=0;
					foreach($catlist as $cat)
					{
						$cids[$j]=$cat['catelog_id'];
						$j++;
					}
				}
			}
			// if($s2)
			// {
				// $child2=$connection->execute("select id from catalog_catelog_entity where offer_amount='$s2' and status='1'")->fetchAll('assoc');

				// foreach($child2 as $cat)
				// {
					// $cids[$j]=$cat['id'];
					// $j++;
				// }
			// }
		}
		else
		{
			// has to search supplier name , catelog name
			$j=0;
			$child=$connection->execute("select id from catalog_catelog_entity where name_en like '%$s1%'")->fetchAll('assoc');
				// pr($child);
				// die;
			if(count($child)>0)
			{
				foreach($child as $cat)
				{
					$cids[$j]=$cat['id'];
					$j++;
				}
			}
			$child2=$connection->execute("select id from catalog_catelog_entity where seller_id in(select id from users where display_name like '%$s1%' and status='active')")->fetchAll('assoc');
				// pr($child2);
				// die;
			if(count($child2)>0)
			{
				foreach($child2 as $cat)
				{
					$cids[$j]=$cat['id'];
					$j++;
				}
			}
		}
		if(count($cids)>0)
		{
			$c_list=implode(",",$cids);
			if($s2)
			{
				$query="select c.* from catalog_catelog_entity as c left join page_order on c.id=page_order.catelog_id
					where c.status='1' and c.pending_stock>=1 and offer_amount='$s2' and c.id in($c_list) and c.status='1' and c.on_stock='y' group by c.id order by page_order.shift_pos DESC,c.id desc";

			}
			else
			{
				$query="select c.* from catalog_catelog_entity as c left join page_order on c.id=page_order.catelog_id
					where c.status='1' and c.pending_stock>=1 and c.id in($c_list) and c.status='1' and c.on_stock='y' group by c.id order by page_order.shift_pos DESC,c.id desc";

			}
			$resultdata = $connection->execute($query)->fetchAll('assoc');
			foreach ($resultdata as $value) {
					$catelog_id=$data['id']=$value['id'];
					$data['title']=$value['name_en'];
					// on amount offer value is applied
						// $data['amount']=3;
						 $offer_id=$value['offer_id'];

						// $offer_id=1;
						$data['off']=$value['offer_amount'];
						$data['selling_price']=$value['selling_price'];
						$data['amount']=$value['base_price'];
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
						$attribute_column = $this->getAttributes($catelog_id,"catelog");
						// pr($attribute_column);
						// die;
						foreach($attribute_column as $val)
						{
							// pr($val);
							// die;
							$a .="*".$val['attribute_name']."*: ".$val['attribute_value'];
							$a .="\n";
						}
						// echo $a;
						// die;
						$data['share_text']=$value['share_text'];
						// $data['share_text']=$value['share_text']."\n *Price:* ".$value['base_price']." /- \n".$a;
						// 1 means product shared , 0 menas not shared
						// echo "dd";
						// die;
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
							$data['my_earning']=50;
						}

						$data['min_range']=$value['selling_price'];
						$data['img_height']=floatval($value['img_height']);
						$data['img_width']=$value['img_width'];
						$data['img_type']=$value['img_type'];
						if($value['reseller_earning'])
						$data['max_range']=$value['reseller_earning'];
						else
						$data['max_range']=$value['max_earning'];
						// $data['image']=$value['offer_image'];
						// $data['type']='category';
						$data['image']=Router::url('image/',true).$value['pic'];
						$slider=$data['slider']=$this->catelogproductimages($catelog_id);
						$data['product_count']=count($slider);
						// $data['children_count']=$value['children_count'];
						$sample[]=$data;
					}
		}

		return $sample;

	}

	function login()
	{
		if($this->request->is('post'))
    	{
			$table 	=	TableRegistry::get('Users');
			$request=$this->request->getData();
			extract($request);
			// role id 1 for reseller
			 $mobile=str_replace("+91","",$mobile);
			$result	=	$table->find()->select(['status','mobile','id','is_suplier','fullname','email','mobile','city'])->where(['mobile'=>$mobile])->first();
			// pr($result);
			// die;
			if($result)
			{
					$user_status=$result->status;
					if($user_status=="active")
					{
						$customer_id=$result->id;
					$Userextratable 	=	TableRegistry::get('Userextra');
					$userextra =$Userextratable
						->find()
						// ->select(['id','path','level','children_count','position','name','is_active'])
						->where(['user_id ='=>$customer_id])->first();
					$result->otp=$rand_otp=rand(10000,99999);
					if($device_id)
						$result->device_id=$device_id;
						if($other['player_id'])
						$result->player_id=$other['player_id'];
					if($table->save($result))
					{
						$result->name=$result->fullname;
						$reponse['status']	=true;
						$reponse['data']	=	$result;
						$reponse['id']	=	$result->id;
						$reponse['is_suplier']	=	$result->is_suplier;
						$reponse['name']	=	$result->fullname;
						$reponse['otp']	=	$rand_otp;
						$reponse['newuser']	=false;
						$userextra->id=$result->id;
						$userextra->name=$result->fullname;
						$userextra->email=$result->email;
						$userextra->mobile=$result->mobile;
						$userextra->city=$result->city;
						// $userextra['id']
						if($userextra)
						$reponse['data']['profile'] 	=$userextra;
						else
						$reponse['data']['profile'] 	='';

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
					$reponse['status']	=false;
					$reponse['msg'] 	=	"Your Account is Block Plz Contact to support";
				}


			}
			else
			{
				$request['role']=2;
				$request['mobile']=$mobile;
				$request['player_id']=$other['player_id'];
				$request['created_utc']=$current_utc=strtotime(date('Y-m-d h:i'));

				$request['otp']=$rand_otp=rand(10000,99999);
				$entity =	$table->newEntity($request);
				$result	=	$table->save($entity);
				if($result){
					// sendsms
					$v_link="https://www.youtube.com/watch?v=Raa0Gca15lQ";
					$sms="Dear Reseller Check Out This Video Now and Learn How to Earn From *Reseller Mantra* App Without Capital Investment.\n".$v_link;
					$reg_ids='';
					$current_date=date('d-m-y h:i A');
					if($mobile)
					$this->sendsms($sms,$mobile,$reg_ids);
					$n['title']="Welcome to Reseller Mantra";
					$n['subtitle']="The Miracles of Sharing";
					$n['user_id']=$result->id;
					$n['order_id']=0;
					$n['created']=$current_date;
					$this->addnotification($n);
	    			$reponse['status']	=true;
					$reponse['data']	=	$result;
					$reponse['id']	=	$result->id;
					$reponse['otp']	=	$rand_otp;
					$reponse['msg'] 	=	"Resgister successful";
					$userextra->id=$result->id;
						$userextra->name='';
						$userextra->email='';
						$userextra->mobile=$result->mobile;
						$userextra->city='';
					$reponse['profile'] 	=$userextra;
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

			if($customer_id && $catelog_id  && $final_amount)
			{
				// if($increase_amount==0)
					// $increase_amount=0;
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
			// $used=$stockdata['sale_product'];
			$stock=$stockdata['pending_stock'];
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
			extract($request);
			if($customer_id && $product_id  && $quantity && $size_id)
			{
				$quote_item_table=TableRegistry::get('QuoteItem');
				$quote_table=TableRegistry::get('Quote');
				$entity = $quote_item_table->newEntity($request,['validate'=>"item"]);
				// pr($entity);
				// die;
				$p_status=true;
				if(!$entity->getErrors())
				{
					$product = $this->getProduct($request['product_id']);
					// pr($product);
					// die;
					if($product)
					{
						$shipping_charges=$product['shipping_charges'];
						$product_name = $product->name_en;
						$orignal_amount = $product->primary_price;  // amount a
						$price_added = $product->price_added;  // amount b
						// $catelog_id = $product->catelog_id;  // amount b

						if($size_id)
						{
							 $StockTable = TableRegistry::get('Stock');
							 $stockdata=$StockTable->find()
							  ->contain(['AttributeOptionValue'])
							 ->where(['id'=>$size_id])->first();
							 // pr($stockdata);
							 // die;
							 $size_name=$stockdata['attribute_option_value']['value'];
						}
						else
						{
							$size_name='';
						}
						$pending_stock=$stockdata['pending_stock'];
						if($pending_stock>0)
						{
							$catelog_id=$product['catelog_id'];
							$primary_price=$product['base_price'];
							$customer_id = $request['customer_id'];
							$seller_id=$product['seller_id'];
							$seller_address_id=$product['seller_address_id'];
							// $size_id=$product['size_id'];
							$sharedata=$this->priceupdated($catelog_id,$customer_id);
						   if($sharedata)
						   {
							  if($sharedata['final_amount']){
								$price = $sharedata['final_amount']+$shipping_charges;
								}else{
									$price = $product->selling_price;
								}
								$market_price=$sharedata['final_amount']+$shipping_charges;
								$my_earning=$sharedata['increase_amount'];
								$market_string=$product['selling_price']+$shipping_charges." + ".$sharedata['increase_amount']."(My Earning)";
						   }
						   else
						   {
								$price = $product->selling_price+$shipping_charges;
								$market_price=0;
								$my_earning=0;
								$market_string='';
						   }

							$product_name = $product->name_en;
							$product_id = $product->id;
							$qty = $request['quantity'];
							// $price=$price+$shipping_charges;
							$grand_total  = $qty*$price;
							$quote = $this->getQuoteId($customer_id);
							// pr($quote);die;
							// filed for quote item
							$offer_id=$product['offer_id'];
							$off=$product['offer_amount'];
							$s_price=$product['selling_price']+$shipping_charges;
							$amount=$product['base_price']+$shipping_charges;
							if($product['shipping_charges']==0)
							{
								$extra_text="FREE SHIPPING";
							}
							else
							{
								$extra_text='';
							}
							$cod=$product['cod'];
							if($product['cod'])
							{
								$cod_text="COD AVAILABLE";
							}
							else
							{
								$cod_text='';
							}
							$share_text=$product['share_text'];
							// die;
						if(!empty($quote)){
							$final_total=$quote->grand_total+$grand_total;
							if($final_total<0)
								$final_total=0;
							$quote->grand_total = $final_total;
							$quote->items_count = $quote->items_count+$qty;
							$quote->items_qty = $quote->items_qty+$qty;

							$get_quote_item = $quote_item_table->find()->where(['size_id'=>$size_id,'product_id'=>$product_id,'quote_id'=>$quote->entity_id,'process_status'=>'oncart','qty >'=>0])->first();
							if(isset($_GET['debug'])){
								// pr($get_quote_item);
							}
							// pr($get_quote_item);
							// die;

							if(empty($get_quote_item)){
								if($qty>0)
								{
									$quote_item=[
									'quote_id'=>$quote->entity_id,
									'qty'=>$qty,
									'price'=>$s_price,
									'primary_price'=>$primary_price,
									'base_price'=>$grand_total,
									'product_id'=>$product_id,
									'catelog_id'=>$catelog_id,
									'name'=>$product_name,
									'off'=>$off,
									'extra_text'=>$extra_text,
									'size_name'=>$size_name,
									'size_id'=>$size_id,
									'customer_id'=>$customer_id,
									'seller_id'=>$seller_id,
									'seller_address_id'=>$seller_address_id,
									'cod_text'=>$cod_text,
									'share_text'=>$share_text,
									'shipping_charges'=>$shipping_charges,
									'cod'=>$cod,
									'market_price'=>$market_price,
									'my_earning'=>$my_earning,
									'market_string'=>$market_string,
									'orignal_amount'=>$orignal_amount,
									'price_added'=>$price_added,
									'created_at'=>date('Y-m-d H:i:s'),
									'updated_at'=>date('Y-m-d H:i:s'),
								];
								// pr($quote_item);
								// die;
								$quote_item_entity = $quote_item_table->newEntity($quote_item);
								$quote_item_table->save($quote_item_entity);
								}
								else
								{
									$p_status=false;
								}
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
									$get_quote_item->size_name=$size_name;
									$get_quote_item->size_id=$size_id;
									$get_quote_item->extra_text=$extra_text;
									$get_quote_item->cod_text=$cod_text;
									$get_quote_item->market_price=$market_price;
									$get_quote_item->my_earning=$my_earning;
									$get_quote_item->market_string=$market_string;
									// pr($get_quote_item);
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
									'quote_id'=>$quote->entity_id,
									'qty'=>$qty,
									'price'=>$s_price,
									'base_price'=>$grand_total,
									'product_id'=>$product_id,
									'catelog_id'=>$catelog_id,
									'primary_price'=>$primary_price,
									'name'=>$product_name,
									'off'=>$off,
									'size_name'=>$size_name,
									'size_id'=>$size_id,
									'extra_text'=>$extra_text,
									'customer_id'=>$customer_id,
									'seller_address_id'=>$seller_address_id,
									'seller_id'=>$seller_id,
									'cod_text'=>$cod_text,
									'share_text'=>$share_text,
									'shipping_charges'=>$shipping_charges,
									'cod'=>$cod,
									'market_price'=>$market_price,
									'my_earning'=>$my_earning,
									'market_string'=>$market_string,
									'orignal_amount'=>$orignal_amount,
									'price_added'=>$price_added,
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
							$result	=	$table->find()->select(['display_name','dob','mobile'])->where(['id'=>$customer_id])->first();
							$data['reseller_name']=$result['display_name'];
							$data['reseller_phone']="+91".$result['mobile'];
						}

						if($p_status)
						{
							$response['status'] = true;
							$response['data'] = $data;
							$response['msg'] = "$product_name add to cart successfully";
						}
						else
						{
							$response['status'] = false;
							$response['data'] = $data;
							$response['msg'] = "Failed to Add to cart";
						}
					}
						else
						{

							$response['status'] =false;
							$response['data'] ='';
							$response['msg'] ="$product_name is Out of Stock,Try Later";
						}


					}
					else
					{
						$response['status'] =false;
						$response['data'] ='';
						$response['msg'] ="Without Product  cant go ahead";
					}
				}
				else
				{
					 $response['status'] = false;
					 $response['data'] = $entity->getErrors();
					 $response['msg'] = "Some required fields Are Missing";
				}
			}
			else{
				$response['status'] =false;
				$response['data'] = '';
				$response['msg'] = "Required Parameter Missing";
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
    		$cart = $table->find()->where(['customer_id'=>$customer_id,'entity_id'=>$quote_id,'Quote.grand_total >'=>0])->contain(['QuoteItem'=>function($q){
    				return $q->select(['size_name','primary_price','share_text','name','item_id','product_id','price','base_price','quote_id','qty','off','extra_text','cod_text','market_price','my_earning','market_string','shipping_charges','cod'])
					->where(['process_status'=>'oncart']);
    		}
    	])
    	->all();
    		$msg="Get cart";
    		foreach ($cart as $key => $items) {
				// pr($items);

    			$data['quote_id']=$items->entity_id;
	    		$data['items_count']=$items->items_count;
	    		$data['grand_total']=$items->grand_total;
	    		$data['customer_id']=$items->customer_id;

	    		if(!empty($items->quote_item)){
		    		foreach ($items->quote_item as $key => $value) {
						 $qty=$value['qty'];
						if($qty>0)
						{
		    			$product_id = $value['product_id'];
		    			$product = $this->getProduct($product_id);
	    				$item['item_id'] = $value['item_id'];
	    				$item['product_id'] = $value['product_id'];
	    				$item['name'] = $product->name_en;
	    				$item['thumbnail'] = Router::url('image/',true).$product->pic;
	    				$item['primary_price'] =$value['primary_price'];
	    				$item['base_price'] =$value['base_price'];
	    				$item['selling_price'] = $value['price'];
	    				$item['amount'] = $value['price'];
	    				$item['size'] = $value['size_name'];
	    				$item['off'] = $value['off'];
	    				$item['extra_text'] = $value['extra_text'];
	    				$item['cod_text'] = $value['cod_text'];
	    				$item['share_text'] = $value['share_text'];
	    				$item['market_price'] = $value['market_price'];
	    				$item['my_earning'] = $value['my_earning'];
	    				$item['market_string'] = $value['market_string'];
	    				$item['min_range'] = 0;
	    				$item['max_range'] = 0;
						if($value['shipping_charges']==0)
						{
							$item['extra_text']="FREE SHIPPING";
						}
						else
						{
							$item['extra_text']='';
						}
						if($value['cod'])
						{
							$item['cod_text']="COD AVAILABLE";
						}
						else
						{
							$item['cod_text']='';
						}

	    					$item['qty'] = $value['qty'];
	    				$data['cart_item'][] = $item;
						}
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
    	$data = $connection->execute("select sum(qty) as total_quantity,sum(base_price) as grand_total from sales_flat_quote_item where process_status='oncart' and quote_id=$quote_id")->fetch('assoc');
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
				$Pincode = TableRegistry::get('Pincode');
				$pindata = $Pincode
				->find()
				// ->select(['id','path','level','children_count','position','name','is_active','thumbnail'])
				->where(['pincode'=>$zipcode,'cod'=>'y','lite'=>"y"])
				// ->order(['name'=>'asc'])
				->first();
				// pr($pindata);
				// die;
				 if($pindata)
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
					$reponse['msg'] ="Your Pin code is not in service area";
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
			$Pincode = TableRegistry::get('Pincode');
				$pindata = $Pincode
				->find()
				// ->select(['id','path','level','children_count','position','name','is_active','thumbnail'])
				->where(['pincode'=>$zipcode,'cod'=>'y','surface'=>"y"])
				// ->order(['name'=>'asc'])
				->first();
			if($pindata)
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
			else
			{
				$reponse['status'] =false;
					$reponse['data'] ='';
					$reponse['msg'] ="Your Pin code is not in service area";
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
    	$result = $table->find()->limit(10)->where(['customer_id'=>$customer_id,'address_for'=>'customer'])
		->order(['entity_id'=>'DESC'])
		->all();
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
							$cart = $table->find()->where(['customer_id'=>$customer_id,'entity_id'=>$quote_id])->contain(['QuoteItem'=>function($q){
    				return $q->select(['primary_price','name','size_name','item_id','product_id','price','base_price','quote_id','qty','off','extra_text','cod_text','market_price','my_earning','market_string','shipping_charges','cod'])
					->where(['process_status'=>'oncart','ship_available'=>'1']);
							}
						])
						// ->all();
						->all();
						// pr($cart);
						// die;
						$Addresstable 	=	TableRegistry::get('Address');

						$msg="Get cart";
						$StockTable = TableRegistry::get('Stock');
						foreach ($cart as $key => $items) {
							 // $address_id=$items->address_id;
								$addressresult = $Addresstable->find()->where(['entity_id'=>$address_id,'is_active'=>'1'])->first();
								// print_r($addressresult);
								// die;
								$data['quote_id']=$quote_id;
								$data['items_count']=$items->items_count;
								$data['grand_total']=$items->grand_total;
								$data['customer_id']=$items->customer_id;
								$data['address']=$addressresult;
								$date=$items->created_at;
								// $start=tdate('Y-m-d', strtotime($date. ' + 2 days'));
								$end=date('d M Y', strtotime($date. ' + 4 days'));
								// $data['booking_date']=date_format($end,"d M Y");
								$data['booking_date']=$end;
								$data['delivery_from_name']=$items->delivery_from_name;
								// $data['delivery_from_name']='';
								$data['delivery_from_mobile']=$items->delivery_from_mobile;
								if(!empty($items->quote_item)){
								foreach ($items->quote_item as $key => $value) {
									$product_id = $value['product_id'];
									$product = $this->getProduct($product_id);
									$item['item_id'] = $value['item_id'];
									$item['name'] = $product->name_en;
									$item['thumbnail'] = Router::url('image/',true).$product->pic;
									$item['primary_price'] =$value['primary_price'];
									$item['selling_price'] = $value['price'];
									// $item['selling_price'] = $product->selling_price;
									$item['product_id'] = $value['product_id'];
									$item['base_price'] = $value['base_price'];
									$item['amount'] = $value['price'];
									$item['off'] = $value['off'];
									$item['extra_text'] = $value['extra_text'];
									$item['size'] = $value['size_name'];
									$item['cod_text'] = $value['cod_text'];
									$item['share_text'] = $value['share_text'];
									$item['market_price'] = $value['market_price'];
									$item['my_earning'] = $value['my_earning'];
									$item['market_string'] = $value['market_string'];
									$item['min_range'] = 0;
									$item['max_range'] = 0;
									if($value['shipping_charges']==0)
									{
										$item['extra_text']="FREE SHIPPING";
									}
									else
									{
										$item['extra_text']='';
									}
									if($value['cod'])
									{
										$item['cod_text']="COD AVAILABLE";
									}
									else
									{
										$item['cod_text']='';
									}
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
	function scheck()
	{
		$pick_pin=$this->request->getQuery('p');
		$dest_pin=$this->request->getQuery('d');
		if($pick_pin && $dest_pin)
		{
		$timestamp = time();
		$auth=$this->authenticatShyplite($timestamp);
				// pr($auth);
				// die;
				if($auth['status'])
				{
					$appID=$auth['appID'];
					$sellerid=$auth['sellerid'];
					$userToken=$auth['userToken'];
					$key=$auth['key'];
					$sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
					$authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $userToken, true)));
					$header = array(
						"x-appid: $appID",
						"x-sellerid:$sellerid",
						"x-timestamp: $timestamp",
						"Authorization: $authtoken",
						// "Content-Type: application/json",
						// "Content-Length: ".strlen($data_json)
					);
					 $url="https://api.shyplite.com/getserviceability/".$pick_pin."/".$dest_pin;
					 $ch = curl_init();

					$header = array(
						"x-appid: $appID",
						"x-timestamp: $timestamp",
						"x-sellerid:$sellerid",
						"Authorization: $authtoken"
					);

					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$server_output = curl_exec($ch);
					$res=json_decode($server_output,true);
					pr($res);
					curl_close($ch);
				}
		}
		else
		{
			echo "re";
			die;
		}
		die;
	}
	function placeorder(){
    	 $customer_id = $this->request->getData('customer_id');

    	$coupon_code = $this->request->getData('coupon_code');
    	$product_ids = $this->request->getData('product_ids');
    	$payment_method = $this->request->getData('payment_method');
    	if($customer_id){
			$quote_table  = TableRegistry::get('Quote');
    		$order_table = TableRegistry::get('Order');
    		$quote = $this->getQuoteId($customer_id);
			$date = date('Y-m-d H:i:s');
			$dateutc=strtotime($date);
			if(!empty($quote)){
				$remote_ip = $_SERVER['REMOTE_ADDR'];
	    		$address_id = $this->request->getData('address_id');

	    		$addressTable=TableRegistry::get('address');
	    		$address=$addressTable->find()->where(['entity_id'=>$address_id])->first();
				// pr($address);
				// die;
				// print_R($this->request->getData());
				// die;
	    		$quote_id = $quote->entity_id;
	    		$connection = ConnectionManager::get("default");
				if($product_ids)
				$quote_items="select p.pic,qt.catelog_id,qt.product_id,qt.payment_method,qt.my_earning,qt.item_order_id,qt.seller_id,qt.orignal_amount,qt.price_added,qt.item_id,qt.size_name,qt.size_id,qt.qty,p.name_en,s.display_name as seller_name,s.mobile as seller_mobile,u.fullname as user_name,u.mobile as user_mobile
      			,u.accept_time from sales_flat_quote_item as qt inner join catalog_product_entity as p on p.id=product_id inner join users as s on s.id=qt.seller_id inner join users as u on u.id=qt.customer_id
				where qt.quote_id='$quote_id' and qt.process_status='oncart' and qt.ship_available='1' and qt.product_id in($product_ids)";
				else
				$quote_items="select p.pic,qt.catelog_id,qt.product_id,qt.payment_method,qt.my_earning,qt.orignal_amount,qt.seller_id,qt.price_added,qt.item_id,qt.size_name,qt.qty,p.name_en,qt.size_id,s.display_name as seller_name,s.mobile as seller_mobile,u.fullname as user_name,u.mobile as user_mobile,u.accept_time
      			from sales_flat_quote_item as qt inner join catalog_product_entity as p on p.id=product_id inner join users as s on s.id=qt.seller_id inner join users as u on u.id=qt.customer_id
				where quote_id='$quote_id'  and qt.process_status='oncart' and qt.ship_available='1'";

				$quotelist = $connection->execute($quote_items)->fetchAll('assoc');
				// pr($quotelist);
				// die;

				// pr($quotelist);
				// die;
				$grand_total=$quote->grand_total;
				$total_count=(int)$quote->items_qty;
				$total_paid=0;
				if($product_ids)
				{
					$product_array=explode(" ",$product_ids);

					$total_amount = $connection->execute("select sum(base_price) as grand_total from sales_flat_quote_item where quote_id='$quote_id' and ship_available='1' and product_id in($product_ids)")->fetch('assoc');
					$total_paid	=	$total_amount['grand_total'];
					$pending_paid=$grand_total-$total_amount['grand_total'];
					// $total_count=count($allitem);
					$product_count=count($product_array);
					 $pending_item=$total_count-$product_count;

					if($pending_item<0)
						$pending_item=0;

				}
				else
				{
					// have to proceed all items
					$total_paid	=	$quote->grand_total;
					$pending_paid=0;
					$pending_item=0;
				}

				if($coupon_code!='')
	    		{
	    			$coupon_data = $this->applyCouponCode($total_paid,$coupon_code,$customer_id);
	    			$total_paid = $coupon_data['total_paid'];
	    			$order_data['discount_description'] = $coupon_data['discount_description'];
	    			// $order_data['discount_amount'] = $coupon_data['discount_amount'];
	    			$order_data['discount_amount'] =0;
	    			$order_data['coupon_code'] = $coupon_code;
					// add trascation

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
				if($address->name)
	    		$order_data['name'] = $address->name;
				else
				$order_data['name']='';
	    		$order_data['contact'] = $address->contact;
	    		$order_data['address'] = $address->address;
	    		$order_data['city'] = $address->city;
	    		$order_data['zipcode'] = $address->zipcode;
	    		$order_data['billing_address_id'] = $address_id;;
	    		$order_data['shipping_adddress_id'] = $address_id;;
	    		$order_data['remote_ip'] = $remote_ip;
	    		$order_data['total_item_count'] = $quote->items_count;
	    		$items_qty=$order_data['total_qty_ordered'] = $quote->items_qty;
	    		$order_data['created_at'] = date('Y-m-d H:i:s');
	    		$order_data['updated_at'] = date('Y-m-d H:i:s');
	    		$order_entity = $order_table->newEntity($order_data);
				// pr($order_entity);
				// die;
	    		$result = $order_table->save($order_entity);
	    		if($result)
	    		{
					 $order_date=date('Y-m-d H:i:s');
					 $order_utc=strtotime($order_date);
					$order_id=$result->increment_id;
					if($pending_item==0)
					{
	    			$connection->execute("update sales_flat_quote set is_active=0 where entity_id=$quote_id limit 1");
					}
					else
					{
						if($total_paid=='')
							$total_paid=0;
						// echo "update sales_flat_quote set grand_total=$pending_paid,paid_amount=$total_paid,items_count=$pending_item,paid_item=$product_count  where entity_id=$quote_id limit 1";
						// die;
					$connection->execute("update sales_flat_quote set grand_total=$pending_paid,paid_amount=$total_paid,items_count=$pending_item,paid_item=$product_count  where entity_id=$quote_id limit 1");
					}
				   // echo "update sales_flat_quote_item set process_status='orderplace',order_id=$order_id where item_id in($item_str)";
				   // die;
				   // $connection->execute("update sales_flat_quote_item set process_status='orderplace',order_id=$order_id,order_date='$order_date',order_utc='$order_utc' where item_id in($item_str)");

					// $product_detail=$this->productdetail($o);
					// send sms
					 $StockTable = TableRegistry::get('Stock');
					if(count($quotelist)>0)
					{
						foreach($quotelist as $q)
							{
							    $increment_id = $this->generateItemIncrementId();
								$item_id=$q['item_id'];
								$accept_time=$q['accept_time'];
								$expire_utc=$dateutc+ 60*60*$accept_time;
								$connection->execute("update sales_flat_quote_item set add_utc='$dateutc',expire_utc='$expire_utc',payment_method='$payment_method',process_status='orderplace',order_id=$order_id,order_date='$order_date',order_utc='$order_utc',item_order_id='$increment_id',billing_address_id='$address_id' where item_id='$item_id'");
								$p_name=$q['name_en'];
								$size_name=$q['size_name'];
								$size_id=$q['size_id'];
								$item_order_id=$q['item_order_id'];
								 $qty=$items_qty=(int)$q['qty'];
								 $my_earning=(int)$q['my_earning'];
								// add reseller side  trascation report
								$ct['user_id']=$customer_id;
								// $ct['amount']=(int)($q['orignal_amount']+$q['price_added'])*$q['qty'];
								$ct['amount']=$my_earning*$items_qty;
								$ct['bill_amount']=(int)$quote['grand_total'];
								$ct['user_type']=1;
								$item_order_id=$ct['item_order_id']=$increment_id;
								$ct['process_date']=$order_date;
								$ct['created_date']=$order_date;
								$ct['created_utc']=$order_utc;
								$ct['payment_type']="add";
								$ct['order_status']="onprocess";
								$ct['order_type']=1;
								$ct['comment']="New order Placed";
								// pr($ct);
								// die;
								$this->addtransaction($ct);

							  // update stock count


							    if($items_qty>0)
								{
									$size_id=$q['size_id'];
									$seller_id=$q['seller_id'];
									$product_id=$q['product_id'];
									$catelog_id=$q['catelog_id'];

									if($items_qty>0)
									{
										$s_type="orderplace";
										$this->stockupdate($size_id,$items_qty,$s_type,$seller_id,$product_id,$catelog_id);
									}

								}

							  $seller_name=$q['seller_name'];
							  $user_name=$q['user_name'];
							  $seller_mobile=$q['seller_mobile'];
							  // $item_amount=$q['seller_mobile'];
							  $reseller_mobile=$q['user_mobile'];
							  $product_image=Router::url('image/',true).$q['pic'];
							  if($q['payment_method']=='1')
							  $paid_type="COD";
							  else  if($q['payment_method']=="2")
								$paid_type="Prepaid";
								$reg_ids='';
							  $reseller_sms="*New Order Placed*: \n*".$p_name."*\nSize : *".$size_name."*\nQuantity : *".$qty."* \nOrder Number *".$item_order_id."* For Rs. *".$total_paid."* ".$paid_type." is successfully placed.";
							  $supplier_sms="*New Order Placed*: \n*".$p_name."*\nSize : *".$size_name."*\nQuantity : *".$qty."* \nOrder Number *".$item_order_id."* For ".$paid_type." is placed kindly approve.";
							  // $supplier_sms="*New Order Placed* : Your *".$p_name."*,Size :*".$size_name."*, Quantity :*".$qty."* Order Number *".$item_order_id."*For Rs.".$total_paid." ".$paid_type." is placed kindly approve.";
							 // $supplier_sms="Order Placed : Your *".$p_name."*,Size :".$size_name.", Quantity :".$qty. " Order Number ".$item_order_id. "For Rs.".$total_paid." ".$paid_type." is Confirmed.Please Approve Fast To Avoid Penalty.";
							 // $customer_id=$q['customer_id'];

							 if($reseller_mobile)
							  {
								$this->sendsms($reseller_sms,$reseller_mobile,$reg_ids);
								  if($product_image)
									 $this->sendsms($product_image,$reseller_mobile,$reg_ids);
							  }
							  if($seller_mobile)
							  {
								$this->sendsms($supplier_sms,$seller_mobile,$reg_ids);
								if($product_image)
									 $this->sendsms($product_image,$seller_mobile,$reg_ids);
							  }
							  	$push_msg=array('u_id'=>array($customer_id),'user_type'=>1,'type'=>'order','itemid'=>$item_order_id,"title"=>'New Order Placed','body'=>"(".$item_order_id.") ".$p_name);
							  	$push_msg_2=array('u_id'=>array($seller_id),'user_type'=>2,'type'=>'order','itemid'=>$item_order_id,"title"=>'New Order Placed','body'=>"(".$item_order_id.") ".$p_name);
								$this->sendpush($push_msg);
								$this->sendpush($push_msg_2);
							  // save notification
							  $save_Date=date('d-m-y h:i A',strtotime($order_date));
							  $n['title']="New Order Placed";
							  $n['subtitle']="(".$item_order_id.") ".$p_name."\n".$save_Date;
							   $n['user_id']=$customer_id;
							   $n['order_id']=$item_order_id;
							   $n['created']=$order_date;
							   $this->addnotification($n);
							    $n['title']="New Order Placed";
								$n['subtitle']="(".$item_order_id.") ".$p_name."\n".$save_Date;
							   $n['user_id']=$seller_id;
							   $n['order_id']=$item_order_id;
							     $n['created']=$order_date;
							    $this->addnotification($n);


							}
					}

				}
	    		$data['order_id'] = $result->increment_id;
				$data['total_price']=$pending_paid;
				$data['total_count']=$pending_item;
	    		$response['total_price']=$pending_paid;
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
	function testpush()
	{
		$item_order_id=8097;
		$p_name="Manual Product";
		 $push_msg=array('u_id'=>array(109,66),$type=>'order','order_id'=>$item_order_id,"body"=>'New Order Placed','title'=>$p_name);
		$this->sendpush($push_msg);
	}
	function sendpush($message)
	{
		$UserTable = TableRegistry::get('Users');

		if($message['u_id'])
		{
			$u_id=$message['u_id'];
			// pr($u_id);
			// die;
			// $query=$UserTable->find()->where(['id IN'=>$u_id])->all();
				$query =$UserTable
			->find()
			->select(['id','device_id'])
			->where(['status'=>'active','device_id !='=>'','id IN'=>$u_id])
			->order(['id'=>'DESC'])
			->all()
			;

		}
		else
		{
				$query =$UserTable
			->find()
			->select(['id','device_id'])
			->where(['status'=>'active','device_id !='=>''])
			->order(['id'=>'DESC'])
			->all()
			;
		}
		// pr($query);
		// die;
		 $user_data=array();
			$UserTable = TableRegistry::get('Users');

			// print_R($query);
			// die;
			foreach ($query as $data) {
			   $user_data[]=$data;
			}
			if(count($user_data)>0)
			{
				foreach($user_data as $rec)
				{
					$gcmRegIds[] = $rec['device_id'];
					// $deviceid[] = $rec['device_id'];
					// break;
				}
				// print_R($gcmRegIds);
				// die;
				$select_type="catelog";
					if (isset($gcmRegIds) && isset($select_type)) {
						$regIdChunk=array_chunk($gcmRegIds,1000);
						// $message = array("title" => $push_title,"body"=>$pushMessage,"type"=>$select_type,"link"=>$img_link,"icon"=>'',"sound"=>'','timestamp'=>date('Y-m-d G:i:s'));
					   // print_R($regIdChunk[0]);

						foreach($regIdChunk[0] as $RegId){
							// print_R($RegId);
							// die;
							// $fcm="f1znZrWQm4g:APA91bHl_aqfi7GKCKuU2FY1ETt9U1a3cDu0vY-eHaJ2i6gQ_nWBi138RBj3kReEgg4_1Yl8IXNf37oFhoiD_0w6DFBss5lvpQ-wgF0G5t-yuZc4NbEN_8u7CmuhU-WNwi6iaSdUKkMx";
							 $pushStatus =$this->sendMessageThroughGCM($RegId,$message);
							// break;
						}
						$gcmRegIDs = implode(",",$gcmRegIds);
					$deviceids = implode(",",$deviceid);

					//echo $gcmRegIds."-".$pushStatus."<br>";
					// $insert = "insert into $tablename values(NULL, '".$deviceids."','".$gcmRegIDs."', '".$pushStatus."')";
					// mysqli_query($link,$insert);
					// $_SESSION['table'] = $tablename;
					}
			}
	}
	function paytmplaceorder()
	{
		$request=$this->request->getData();
		extract($request);
		if($customer_id && $order_id)
		{
			 $customer_id = $this->request->getData('customer_id');
			$MID="GOLDOP76116288550603";
			$coupon_code = $this->request->getData('coupon_code');
			$product_ids = $this->request->getData('product_ids');
			$payment_method = $this->request->getData('payment_method');
			$request=$this->request->getData();
			extract($request);
			$paytm_order_id=$order_id;
			if($customer_id && $CHECKSUMHASH && $order_id){
				$TXNTYPE="CAPTURE";
				 $url="https://securegw-stage.paytm.in/order/status";
				 $post = [
				'MID' => $MID,
				'ORDERID' =>$order_id,
				'CHECKSUMHASH'   =>$CHECKSUMHASH,
			];
				$data_json = json_encode($post);
					$header = array(

						"Content-Type: application/json",
						// "Content-Length: ".strlen($data_json)
					);


					 $ch = curl_init();
					 curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$res=json_decode($server_output,true);
					// pr($res);
					// die;
				$quote_table  = TableRegistry::get('Quote');
				$order_table = TableRegistry::get('Order');
				$quote = $this->getQuoteId($customer_id);
				$date = date('Y-m-d H:i:s');
				$dateutc=strtotime($date);
				if(!empty($quote)){
					$remote_ip = $_SERVER['REMOTE_ADDR'];
					$address_id = $this->request->getData('address_id');

					$addressTable=TableRegistry::get('address');
					$address=$addressTable->find()->where(['entity_id'=>$address_id])->first();
					// pr($address);
					// die;
					// print_R($this->request->getData());
					// die;
					$quote_id = $quote->entity_id;
					$connection = ConnectionManager::get("default");
					if($product_ids)
					$quote_items="select p.pic,qt.catelog_id,qt.product_id,qt.payment_method,qt.my_earning,qt.item_order_id,qt.seller_id,qt.orignal_amount,qt.price_added,qt.item_id,qt.size_name,qt.size_id,qt.qty,p.name_en,s.display_name as seller_name,s.mobile as seller_mobile,u.fullname as user_name,u.mobile as user_mobile
					,u.accept_time from sales_flat_quote_item as qt inner join catalog_product_entity as p on p.id=product_id inner join users as s on s.id=qt.seller_id inner join users as u on u.id=qt.customer_id
					where qt.quote_id='$quote_id' and qt.process_status='oncart' and qt.ship_available='1' and qt.product_id in($product_ids)";
					else
					$quote_items="select p.pic,qt.catelog_id,qt.product_id,qt.payment_method,qt.my_earning,qt.orignal_amount,qt.seller_id,qt.price_added,qt.item_id,qt.size_name,qt.qty,p.name_en,qt.size_id,s.display_name as seller_name,s.mobile as seller_mobile,u.fullname as user_name,u.mobile as user_mobile,u.accept_time
					from sales_flat_quote_item as qt inner join catalog_product_entity as p on p.id=product_id inner join users as s on s.id=qt.seller_id inner join users as u on u.id=qt.customer_id
					where quote_id='$quote_id'  and qt.process_status='oncart' and qt.ship_available='1'";

					$quotelist = $connection->execute($quote_items)->fetchAll('assoc');
					// pr($quotelist);
					// die;

					// pr($quotelist);
					// die;
					$grand_total=$quote->grand_total;
					if($product_ids)
					{
						$product_array=explode(" ",$product_ids);

						$total_amount = $connection->execute("select sum(base_price) as grand_total from sales_flat_quote_item where ship_available='1' and product_id in($product_ids)")->fetch('assoc');
						$total_paid	=	$total_amount['grand_total'];
						$pending_paid=$grand_total-$total_amount['grand_total'];
						$total_count=count($allitem);
						$product_count=count($product_array);
						$pending_item=$total_count-$product_count;
						if($pending_item<0)
							$pending_item=0;

					}
					else
					{
						// have to proceed all items
						$total_paid	=	$quote->grand_total;
						$pending_paid=0;
						$pending_item=0;
					}

					if($coupon_code!='')
					{
						$coupon_data = $this->applyCouponCode($total_paid,$coupon_code,$customer_id);
						$total_paid = $coupon_data['total_paid'];
						$order_data['discount_description'] = $coupon_data['discount_description'];
						// $order_data['discount_amount'] = $coupon_data['discount_amount'];
						$order_data['discount_amount'] =0;
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
					if($address->name)
					$order_data['name'] = $address->name;
					else
					$order_data['name']='';
					$order_data['contact'] = $address->contact;
					$order_data['address'] = $address->address;
					$order_data['city'] = $address->city;
					$order_data['zipcode'] = $address->zipcode;
					$order_data['billing_address_id'] = $address_id;;
					$order_data['shipping_adddress_id'] = $address_id;;
					$order_data['remote_ip'] = $remote_ip;
					$order_data['total_item_count'] = $quote->items_count;
					$items_qty=$order_data['total_qty_ordered'] = $quote->items_qty;
					$order_data['created_at'] = date('Y-m-d H:i:s');
					$order_data['updated_at'] = date('Y-m-d H:i:s');
					$order_entity = $order_table->newEntity($order_data);
					// pr($order_entity);
					// die;
					$result = $order_table->save($order_entity);
					if($result)
					{
						 $order_date=date('Y-m-d H:i:s');
						 $order_utc=strtotime($order_date);
						$order_id=$result->increment_id;
						if($pending_item==0)
						{
						$connection->execute("update sales_flat_quote set is_active=0 where entity_id=$quote_id limit 1");
						}
						else
						{
						$connection->execute("update sales_flat_quote set grand_total=$pending_paid,paid_amount=$total_paid,items_count=$pending_item,paid_item=$product_count  where entity_id=$quote_id limit 1");
						}
					   // echo "update sales_flat_quote_item set process_status='orderplace',order_id=$order_id where item_id in($item_str)";
					   // die;
					   // $connection->execute("update sales_flat_quote_item set process_status='orderplace',order_id=$order_id,order_date='$order_date',order_utc='$order_utc' where item_id in($item_str)");

						// $product_detail=$this->productdetail($o);
						// send sms
						 $StockTable = TableRegistry::get('Stock');
						if(count($quotelist)>0)
						{

							foreach($quotelist as $q)
								{
									$increment_id = $this->generateItemIncrementId();
									$item_id=$q['item_id'];
									$accept_time=$q['accept_time'];
									$expire_utc=$dateutc+ 60*60*$accept_time;
									$connection->execute("update sales_flat_quote_item set CHECKSUMHASH='$CHECKSUMHASH',ORDERID='$paytm_order_id',add_utc='$dateutc',expire_utc='$expire_utc',payment_method='$payment_method',process_status='orderplace',order_id=$order_id,order_date='$order_date',order_utc='$order_utc',item_order_id='$increment_id',billing_address_id='$address_id' where item_id='$item_id'");
									$p_name=$q['name_en'];
									$size_name=$q['size_name'];
									$size_id=$q['size_id'];
									$item_order_id=$q['item_order_id'];
									 $items_qty=(int)$q['qty'];
									 $my_earning=(int)$q['my_earning'];
									// add reseller side  trascation report
									$ct['user_id']=$customer_id;
									// $ct['amount']=(int)($q['orignal_amount']+$q['price_added'])*$q['qty'];
									$ct['amount']=$my_earning*$items_qty;
									$ct['bill_amount']=(int)$quote['grand_total'];
									$ct['user_type']=1;
									$ct['item_order_id']=$increment_id;
									$ct['created_date']=$order_date;
									$ct['created_utc']=$order_utc;
									$ct['payment_type']="add";
									$ct['order_status']="onprocess";
									$ct['comment']="New order Placed";
									// pr($ct);
									// die;
									$this->addtransaction($ct);

								  // update stock count


									if($items_qty>0)
									{
										$size_id=$q['size_id'];
										$seller_id=$q['seller_id'];
										$product_id=$q['product_id'];
										$catelog_id=$q['catelog_id'];

										if($items_qty>0)
										{
											$s_type="orderplace";
											$this->stockupdate($size_id,$items_qty,$s_type,$seller_id,$product_id,$catelog_id);
										}

									}

								  $seller_name=$q['seller_name'];
								  $user_name=$q['user_name'];
								  $seller_mobile=$q['seller_mobile'];
								  // $item_amount=$q['seller_mobile'];
								  $reseller_mobile=$q['user_mobile'];
								  $product_image=Router::url('image/',true).$q['pic'];
								  if($q['payment_method']=='1')
								  $paid_type="COD";
								  else  if($q['payment_method']=="2")
									$paid_type="Prepaid";
									$reg_ids='';
								  $reseller_sms="Order Placed : Your *".$p_name."*,Size :*".$size_name."*, Quantity :*".$qty."* Order Number *".$item_order_id."*For Rs.".$total_paid." ".$paid_type." is Confirmed. Wait For Approval.";
								  $supplier_sms="Order Placed : Your *".$p_name."*,Size :*".$size_name."*, Quantity :*".$qty."* Order Number *".$item_order_id."*For Rs.".$total_paid." ".$paid_type." is Confirmed.Please Approve Fast To Avoid Penalty.";
								 // $supplier_sms="Order Placed : Your *".$p_name."*,Size :".$size_name.", Quantity :".$qty. " Order Number ".$item_order_id. "For Rs.".$total_paid." ".$paid_type." is Confirmed.Please Approve Fast To Avoid Penalty.";
								  if($reseller_mobile)
								  {
									$this->sendsms($reseller_sms,$reseller_mobile,$reg_ids);
									  if($product_image)
										 $this->sendsms($product_image,$reseller_mobile,$reg_ids);
								  }
								  if($seller_mobile)
								  {
									$this->sendsms($supplier_sms,$seller_mobile,$reg_ids);
								  }

								}
						}

					}
					$data['order_id'] = $result->increment_id;
					$data['total_price']=$pending_paid;
					$data['total_count']=$pending_item;
					$response['total_price']=$pending_paid;
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

		}
		else
		{
			$response['status']=false;
    		$response['status']='';
    		$response['msg']='Unable to place order failed';
		}
		echo json_encode($response);die;
	}
	 function generateItemIncrementId(){
    	$connection = ConnectionManager::get('default');
    	$data = $connection->execute("SELECT max(item_order_id) as item_order_id FROM sales_flat_quote_item")->fetch('assoc');
		// pr($data);
		// die;
    	if(!empty($data['item_order_id']))
    	{
    		return $data['item_order_id']+1;
    		return $data['item_order_id']+1;
    	}
    	else{
    		return 1001;
    	}

    }
	 function generateIncrementId(){
    	$connection = ConnectionManager::get('default');
    	$data = $connection->execute("select increment_id from sales_flat_order order by entity_id desc limit 1")->fetch('assoc');
    	if(!empty($data['increment_id']))
    	{
    		return $data['increment_id']+1;
    	}
    	else{
    		return 1001;
    	}

    }
	 function applyCouponCode($total_paid,$coupon_code,$customer_id){
    	$table = TableRegistry::get('Orders');
    	$result=$table->find()->where(['coupon_code'=>$coupon_code,'customer_id'=>$customer_id])->first();

    	if(empty($result))
    	{
    		$table = TableRegistry::get('Promo');
    		$offer=$table->find()->select(['id','coupon_code','discount','content','coupon_type','title'])->where(['coupon_code'=>$coupon_code,'status'=>'y'])->first();
    		// pr($offer);
			// die;
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
						->order(['Sharelist.id'=>'DESC'])
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
						$data[$j]['off']=$value['offer_amount'];
						$data[$j]['selling_price']=$value['selling_price'];
						$data[$j]['amount']=$value['base_price'];
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
									$data[$j]['my_earning']=0;
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
    		$qutentity = $quote_item_table->newEntity($request,['validate'=>"item"]);
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
					$product=$this->getProduct($request['product_id']);
					$catelog_id=$product['catelog_id'];
					$primary_price=$product['base_price'];
					// new entry
					$request['catelog_id']=$catelog_id;
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
			$p_status=true;
    		if(!$qutentity->getErrors())
				{
					$product = $this->getProduct($request['product_id']);
					// pr($product);
					// die;
					if($product)
					{
						$product_name = $product->name_en;
						$orignal_amount = $product->primary_price;  // amount a
						$price_added = $product->price_added;  // amount b
						$StockTable = TableRegistry::get('Stock');
						if($size_id)
						{
							 $StockTable = TableRegistry::get('Stock');
							 $stockdata=$StockTable->find()
							  ->contain(['AttributeOptionValue'])
							 ->where(['id'=>$size_id])->first();
							 // pr($stockdata);
							 // die;
							 $size_name=$stockdata['attribute_option_value']['value'];
						}
						else
						{
							$size_name='';
						}
						$pending_stock=$stockdata['pending_stock'];
						if($pending_stock>0)
						{

						$catelog_id=$product['catelog_id'];
						$primary_price=$product['base_price'];

						$customer_id = $request['customer_id'];
						$customer_id = $request['customer_id'];

						$seller_id=$product['seller_id'];
						$seller_address_id=$product['seller_address_id'];
						// $size_id=$product['size_id'];
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
						$my_earning=0;
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
						$off=$product['offer_amount'];
						$s_price=$product['selling_price'];
						$amount=$product['base_price'];
						$shipping_charges=$product['shipping_charges'];
						if($product['shipping_charges']==0)
						{
							$extra_text="FREE SHIPPING";
						}
						else
						{
							$extra_text='';
						}
						$cod=$product['cod'];
						if($product['cod'])
						{
							$cod_text="COD AVAILABLE";
						}
						else
						{
							$cod_text='';
						}

						$share_text=$product['share_text'];
						if($size_id)
							{
							 $StockTable = TableRegistry::get('Stock');
							 $stockdata=$StockTable->find()
							  ->contain(['AttributeOptionValue'])
							 ->where(['id'=>$size_id])->first();
							 // pr($stockdata);
							 // die;
							 $size_name=$stockdata['attribute_option_value']['value'];
							}
							else
							{
								$size_name='';
							}
						// die;
						if(!empty($quote)){
							$final_total=$quote->grand_total+$grand_total;
							if($final_total<0)
							$final_total=0;
							$quote->grand_total = $final_total;
							$quote->items_count = $quote->items_count+$qty;
							$quote->items_qty = $quote->items_qty+$qty;

							$get_quote_item = $quote_item_table->find()->where(['size_id'=>$size_id,'product_id'=>$product_id,'quote_id'=>$quote->entity_id,'process_status'=>'oncart'])->first();
							if(isset($_GET['debug'])){
								// pr($get_quote_item);
							}
							// pr($get_quote_item);
							// die;

							if(empty($get_quote_item)){
								if($qty>0)
								{
								$quote_item=[
									'quote_id'=>$quote->entity_id,
									'qty'=>$qty,
									'price'=>$s_price,
									'primary_price'=>$primary_price,
									'base_price'=>$grand_total,
									'product_id'=>$product_id,
									'catelog_id'=>$catelog_id,
									'name'=>$product_name,
									'off'=>$off,
									'extra_text'=>$extra_text,
									'size_name'=>$size_name,
									'size_id'=>$size_id,
									'customer_id'=>$customer_id,
									'seller_address_id'=>$seller_address_id,
									'seller_id'=>$seller_id,
									'cod_text'=>$cod_text,
									'share_text'=>$share_text,
									'shipping_charges'=>$shipping_charges,
									'cod'=>$cod,
									'market_price'=>$market_price,
									'my_earning'=>$my_earning,
									'market_string'=>$market_string,
									'orignal_amount'=>$orignal_amount,
									'price_added'=>$price_added,
									'created_at'=>date('Y-m-d H:i:s'),
									'updated_at'=>date('Y-m-d H:i:s'),
								];
								// pr($quote_item);
								// die;
								$quote_item_entity = $quote_item_table->newEntity($quote_item);
								$quote_item_table->save($quote_item_entity);
								}
								else
								{
									$p_status=false;
								}
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
									$get_quote_item->size_name=$size_name;
									$get_quote_item->size_id=$size_id;
									$get_quote_item->extra_text=$extra_text;
									$get_quote_item->cod_text=$cod_text;
									$get_quote_item->market_price=$market_price;
									$get_quote_item->my_earning=$my_earning;
									$get_quote_item->market_string=$market_string;
									// pr($get_quote_item);
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
									'quote_id'=>$quote->entity_id,
									'qty'=>$qty,
									'price'=>$s_price,
									'base_price'=>$grand_total,
									'product_id'=>$product_id,
									'catelog_id'=>$catelog_id,
									'primary_price'=>$primary_price,
									'name'=>$product_name,
									'off'=>$off,
									'size_name'=>$size_name,
									'size_id'=>$size_id,
									'extra_text'=>$extra_text,
									'customer_id'=>$customer_id,
									'seller_address_id'=>$seller_address_id,
									'seller_id'=>$seller_id,
									'cod_text'=>$cod_text,
									'share_text'=>$share_text,
									'shipping_charges'=>$shipping_charges,
									'cod'=>$cod,
									'market_price'=>$market_price,
									'my_earning'=>$my_earning,
									'market_string'=>$market_string,
									'orignal_amount'=>$orignal_amount,
									'price_added'=>$price_added,
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
							$result	=	$table->find()->select(['display_name','dob','mobile'])->where(['id'=>$customer_id])->first();
							$data['reseller_name']=$result['display_name'];
							$data['reseller_phone']="+91".$result['mobile'];
						}
						if($p_status)
						{
							$response['status'] = true;
							$response['data'] = $data;
							$response['msg'] = "$product_name add to cart successfully";
						}
						else
						{
							$response['status'] = false;
							$response['data'] = $data;
							$response['msg'] = "Failed to Add to cart";
						}
					}
						else
						{

							$response['status'] =false;
							$response['data'] ='';
							$response['msg'] ="$product_name is Out of Stock,Try Later";
						}


					}
					else
					{
						$response['status'] =false;
						$response['data'] ='';
						$response['msg'] ="Without Product  cant go ahead";
					}
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
	function subcategorydetail()
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
				if($category)
				{
					$cate=$this->cateloglist($customer_id,$category_id);
					$i=0;
					if(count($cate)>0)
					{
						$o[0]['title']='Best Selling';
						$o[0]['subtitle']='Order Now';
						$o[0]['image']='http://resellermantra.com/img/app/group_1625.png';
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
						$co[0]['data']=$cate;
						$i++;
					}
					// categoty format id
					$co[$i]['name']="You may Like";
					$co[$i]['type']="category";
					$cdata[0]['id']=1;
					$cdata[0]['title']="Jacket in Blue";
					$cdata[0]['type']="category";
					$cdata[0]['image']='http://resellermantra.com/img/app/group_1469.png';

					// product detail
					$cdata[1]['id']=1;
					$cdata[1]['title']="Jacket in Blue";
					$cdata[1]['type']="product";
					$cdata[1]['image']='http://resellermantra.com/img/app/group_1469.png';

					$co[$i]['data']=$cdata;


					$data['data']=$cate;
					$data['offer']=$this->offerlist($category_id);
					$data['category']=$this->subcategorylist($category_id);
					$data['topsubcategory']=$this->topsubcategory($category_id);
					$top=$this->cateloglist($customer_id,$category_id);
					if(count($top)>0)
					{
						$data['top']=$top;
					}
					$response['status'] =true;
					$response['data'] =$cate;
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
	function categorydetail()
	{
		// echo "d";
		// die;
		if($this->request->is('post'))
    	{
	      $request = $this->request->getData();
		  extract($request);
		  if($customer_id && $category_id)
		  {
			  $i=0;
				$category = TableRegistry::get('Category');
				$query = $category
				->find()
				->where(['id'=>$category_id])
				->first()->toArray();
				if($category)
				{


				  $subcat=$this->subcategory($category_id,50);

				   if(count($subcat)>0)
					  {

						$co[$i]['name']="NEW ARRIVAL";
						$co[$i]['type']="category";
						$j=0;
						foreach($subcat as $cat)
						{
							$cdata[$j]['id']=$cat['id'];
							$cdata[$j]['title']= substr($cat['name'], 0,12);
							$cdata[$j]['type']="category";
							$cdata[$j]['image']="http://resellermantra.com/category-thumbnail/".$cat['thumbnail'];
							$j++;
						}

						$co[$i]['data']=$cdata;
						$i++;
					  }
					  $catdata=$this->cateloglist($customer_id,$category_id);
					  if(count($catdata)>0)
					  {
						$co[$i]['name']="Collection";
						$co[$i]['type']="collection";
						$co[$i]['data']=$this->cateloglist($customer_id,$category_id);
					  }
						$data['record']=$co;
						$data['offer']=$this->offerlist($category_id);
						// $data['category']=$this->subcategorylist($category_id,100);
						// $top=$this->topsubcategory($category_id);
						// pr($top);
						// die;
						// $data['topsubcategory']= $top;
						$data['top']=$this->cateloglist($customer_id,0);
					$response['status'] =true;
					$response['data'] =$data;
					$response['code'] =200;
					echo json_encode($response);
					die;
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
	    ->where(['level'=>'2','parent_id'=>$cat_id])
		->toArray();
	    $topsample=[];
		// pr($query);
		// die;
	    foreach ($query as $value) {
		   	$data['id']=$value['id'];
    		$data['name']=$value['name'];
    		$data['type']='category';
    		$data['image']=Router::url('/category-thumbnail/', true) . $value['thumbnail'];
    		// $data['children_count']=$value['children_count'];
    		$topsample[]=$data;
		}
		// pr($sample);
		// die;
		return $topsample;
	}
	function subcategorylist($cat_id)
	{
		$category = TableRegistry::get('Category');
		$query = $category
	    ->find()
	    ->select(['id','children_count','thumbnail','name'])
	    ->order(['id'=>'asc'])
	    ->where(['level ='=>'1','parent_id'=>$cat_id,'total_catelog >='=>1]);
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
	    ->where(['parent_id'=>$cat_id,'total_catelog >='=>1]);
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
	function promolist()
	{
		if($this->request->is('post')){
			$request = $this->request->getData();
			extract($request);
			if($customer_id)
			{
				$PromoTable = TableRegistry::get('Promo');
				$result	=	$PromoTable->find()->where(['status'=>'active'])->toArray();
				if($result)
				{
					foreach($result as $p)
					{
						$coupon_method=$p['coupon_method'];
						if($coupon_method=="bulk")
						{

						}
					}
				}
			   	$reponse['status'] =true;
				$reponse['data'] =$result;
				$reponse['msg'] ="Promo List";

			}
			else
			{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Paramter missing";
			}

		}
		else{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invaid Type";
		}

		echo json_encode($reponse);
		die;
	}
	function applypromo()
	{
		if($this->request->is('post')){
			$request = $this->request->getData();
			extract($request);
			if($customer_id && $coupon_code)
			{
				$apply_status=false;
				$PromoTable = TableRegistry::get('Promo');
				$quote_table=TableRegistry::get('Quote');
				$result	=	$PromoTable->find()->where(['status'=>'active','coupon_code'=>$coupon_code])->first();


				if($result)
				{
					// extract($result);
					// print_R($result);
					// die;
					$coupon_id=$result['id'];

					$coupon_method=$result['coupon_method'];
					$pending_count=$result['pending_count'];
					$stock_count=$result['coupon_stock'];
					$valid_from=$result['valid_from'];
					$valid_to=$result['valid_to'];
					$current_utc=strtotime(date('Y-m-d h:i'));

					$min_amount=$result['min_amount'];
					$max_amount=$result['max_amount'];
					if($pending_count==0)
					{
						$apply_status=false;
						$err_msg="Coupon is Out of Stock,Try other";

					}
					else if($coupon_stock)
					{
						// check coupon validity
						if(($current_utc>=$valid_from) || ($current_utc<=$valid_to))
						{
							// check coupon apply amount
							if($min_amount>0 || $max_amount>0)
							{
								//  boundaed with amount
							    if(($cart_amount>=$min_amount) && ($cart_amount<=$max_amount))
								{
									// apply promo code
									$promo_status=$this->couponapply($result,$coupon_id);

								}
								else
								{
									$apply_status=false;
									$err_msg="To Apply That Promo Catr Value in Between ".$min_amount." And ".$max_amount;
								}
							}
							else
							{
								// apply promo code
							}


						}
						else
						{
							$apply_status=false;
							$err_msg="Coupon is Expired, Try Another";

						}

					}
					$reponse['status'] =true;
					$reponse['data'] ='Promo Apply Successfully';
					$reponse['msg'] ="Promo Apply Successfully";
					$reponse['discount'] =10;
				}
				else
				{
					$reponse['status'] =false;
					$reponse['msg'] ="Please enter a valid Promotional or Voucher Code";
				}


			}
			else
			{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Paramter missing";
			}

		}
		else{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invaid Type";
		}

		echo json_encode($reponse);
		die;
	}
	function couponapply($coupondata,$coupon_id)
	{
		$coupon_method=$coupondata['coupon_method'];
		$quote_table=TableRegistry::get('Quote');
		if($coupon_method=="single")
		{

		}
		else if($coupon_method=="bulk")
		{
			$quotecount=$quote_table->find()->where(['user_id'=>'active','coupon_code'=>$coupon_id])->count();
		}
		else
		{
			$res['apply_status']=false;
			$res['err_msg']="Invalid Method Selection";
		}
		return $res;
	}

	function orderlist()
	{
		if($this->request->is('post')){
			$request = $this->request->getData();
			// pr($request);
			// die;
			extract($request);
			// $user_type=1;
			// user_type 1 for reseller & 2 for wholeseller
			if($user_type=='')
				$user_type=1;
			if($customer_id && $user_type)
			{
				$bonus=$this->bonusprogram($customer_id);
				$connection = ConnectionManager::get('default');
				// user type 1 for reselle 2 for supplier
				$current_date=date('Y-m-d H:i:s');
				$current_utc=strtotime($current_date);
				if($user_type==1)
				{
					$query="select i.*,p.primary_price as orignal_value,p.price_added,p.name_en,p.pic as product_pic from sales_flat_quote_item as i inner join catalog_product_entity as p on p.id=i.product_id
						where i.process_status='orderplace' and i.customer_id='$customer_id' and i.order_expire='n' order by i.item_id desc limit 0,100";

				}
				else
				{
					  $query="select i.*,p.primary_price as orignal_value,p.price_added,p.name_en,p.pic as product_pic,p.share_text from sales_flat_quote_item as i inner join catalog_product_entity as p on p.id=i.product_id
						where i.process_status='orderplace' and i.seller_id='$customer_id' and i.order_expire='n'  order by i.item_id desc limit 0,100";
					// die;
				}
				$orderlist = $connection->execute($query)->fetchAll('assoc');
				if(count($orderlist)>0)
				{
					$s=0;
					foreach($orderlist as $sitem)
					{
						// pr($sitem);
						// die;
						$seller_address_id=$sitem['seller_address_id'];
						$order_status=$sitem['order_status'];
						$item_id=$d[$s]['item_id']=$sitem['item_order_id'];
						$order_status=$sitem['order_status'];
						$d[$s]['market_price']=(int)$sitem['base_price'];
						if($order_status==11 || $order_status==5 || $order_status==4)
						$d[$s]['my_earning']=0;
						else
						$d[$s]['my_earning']=(int)$sitem['my_earning']*(int)$sitem['qty'];

						$d[$s]['primary_price']=(int)$sitem['primary_price'];
						$d[$s]['selling_price']=(int)$sitem['base_price'];
						$d[$s]['product_price']=(int)$sitem['price'];
						$d[$s]['product_id']=$sitem['product_id'];
						$d[$s]['base_price']=(int)$sitem['base_price'];
						$d[$s]['product_amount']=(int)$sitem['orignal_value'];
						$d[$s]['amount']=(int)$sitem['price'];
						$d[$s]['qty']=$sitem['qty'];
						if($order_status!='6')
						{
							if($order_status==8)
								$d[$s]['awbNo']=$sitem['return_awbNo'];
							else
								$d[$s]['awbNo']=$sitem['awbNo'];
						}
						else
						$d[$s]['awbNo']='';
						if($sitem['payment_method']==1)
						$d[$s]['order_type']="COD";
						else
						$d[$s]['order_type']="PREPAID";
						$d[$s]['off']=$sitem['off'];
						$d[$s]['size']=$sitem['size_name'];
						$d[$s]['extra_text']=$sitem['extra_text'];
						$d[$s]['cod_text']=$sitem['cod_text'];
						$d[$s]['share_text']=$sitem['share_text'];
						// $d[$s]['market_price']=$sitem['product']['market_price'];
						// $d[$s]['my_earning']=$sitem['product']['my_earning'];
						$d[$s]['min_range']=0;
						$d[$s]['max_range']=0;
						$order_status=$d[$s]['order_status']=$sitem['order_status'];
						$d[$s]['order_id']=1;
						if($order_status==8)
						{
							$d[$s]['track_url']=$sitem['return_track_url'];
							$d[$s]['track_code']=$sitem['track_code'];
						}
						else
						{
							$d[$s]['track_url']=$sitem['track_url'];
							$d[$s]['track_code']=$sitem['track_code'];
						}
						$cancel_type=$sitem['cancel_type'];
						$d[$s]['show_msg']=$this->showordermsg($order_status,$cancel_type);
						$d[$s]['time_left']="23";
						$d[$s]['product_name']=$sitem['name_en'];

						$order_date=$d[$s]['order_date']=$sitem['order_date'];
						$extra_time = strtotime("+2880 minutes", strtotime($order_date));
						// $extra_time = strtotime("+4320 minutes", strtotime($order_date));
						// $d[$s]['order_utc']=$sitem['order_utc'];
						$d[$s]['order_utc']=$extra_time;
					    if($sitem['shipment_pdf'])
						$d[$s]['invoice_pdf']="http://resellermantra.com/webroot/pdf/shipment.php?order_id=".$item_id;
						else
						$d[$s]['invoice_pdf']='';
						if($sitem['shipment_pdf'])
						$d[$s]['shipment_pdf']=$sitem['shipment_pdf'];
						else
						$d[$s]['shipment_pdf']='';
						$d[$s]['image']=Router::url('image/',true).$sitem['product_pic'];
						$s++;
					}
					$reponse['status'] =true;
					$reponse['bonus'] =$bonus;

					$reponse['data'] =$d;
					$reponse['bonus_exit'] ='y';
					$reponse['msg'] ="Order list found";
					$address =$this->addresslist($seller_address_id);
					if($user_type==2)
					{
						$reponse['address_count']=$address['address_count'];
						$reponse['address']=$address['address'];
					}

				}
				else
				{
					$reponse['status'] =true;
					$reponse['bonus'] =$bonus;
					$reponse['data'] =[];
					$reponse['bonus_exit'] ='y';
					$reponse['msg'] ="Order list found";

				}
			}
			else
			{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Paramter missing";
			}
		}
		else{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invaid Type";
		}

		echo json_encode($reponse);
		die;
	}
	function showordermsg($order_status,$cancel_type)
	{

		if($order_status=='1')
		{
			$order_msg="APPROVAL PENDING";
		}
		if($order_status=='2')
		{
			$order_msg="Waiting for pickup";
		}
		if($order_status=='3')
		{
			$order_msg="Delivery Pending";
		}
		if($order_status=='4')
		{
			$order_msg="Cancel";
		}
		if($order_status=='4')
		{
			if($cancel_type=="rejectbyadmin")
				$order_msg="Rejected By Admin";
			else
			$order_msg="Cancel";
		}
		if($order_status=='5')
		{
			$order_msg="Cancel AFTER APPROVAL";
		}
		if($order_status=='6')
		{
			$order_msg="Delivered";
		}
		if($order_status=='7')
		{
			$order_msg="Rto";
		}
		if($order_status=='8')
		{
			$order_msg="Return By customer";
		}
		if($order_status=='9')
		{
			$order_msg="Approval For payment";
		}if($order_status=='10')
		{
			$order_msg="Close/Payment Done";
		}
		if($order_status=='11')
		{
			$order_msg="Rejected";
		}
		if($order_status=='12')
		{
			$order_msg="REFUNDED/Dispute";
		}
		return strtoupper($order_msg);
	}
	function addresslist($seller_address_id)
	{
		$table 	=	TableRegistry::get('Address');
		$result=$table->find()->where(['is_active'=>'1','address_for'=>'supplier','entity_id'=>$seller_address_id])->toArray();
			$simple=array();
		if(count($result)>0)
		{
			$d['address_count']=count($result);

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
				$data['sellerAddressId'] = $value['sellerAddressId'];
				$simple[]=$data;
			}
			$d['address']=$simple;
		}
		else
		{
			$d['address_count']=0;
			$d['address']=$simple;
		}
		return $d;
	}

	function bonusprogram($customer_id)
	{
		$d['bonus_exit']="y";
		$d['bonus_title']="Bonus Point 1 Week ";
		$d['bonus_sale']=500;
		$d['bonus_target']=1000;
		return $d;

	}
	function changeorderstatus()
	{

		// 1 for order place , 2 for order accept , 3 for order reject
		if($this->request->is('post')){
			$request = $this->request->getData();
			// pr($request);
			// die;
			extract($request);
			if($customer_id && $item_id && $status_id)
			{
				$item_order_id=$item_id;
				$order_date=date('Y-m-d H:i:s');
				$order_utc=strtotime($order_date);
				$err=false;
				$quote_item_table=TableRegistry::get('QuoteItem');
				$itemorder	=	$quote_item_table->find()->where(['item_order_id'=>$item_id])->contain(['Product']) ->first();
				$seller_id=$itemorder['seller_id'];
				$user_id=$itemorder['customer_id'];
				$UserTable = TableRegistry::get('Users');
				$user	=	$UserTable->find()->where(['id'=>$customer_id])->contain(['Address']) ->first();
				$userdetail	=	$UserTable->find()->where(['id'=>$user_id])->contain(['Address']) ->first();
				$supplierdata	=	$UserTable->find()->select(['id','manual_ship','delay_penalty','per_value'])->where(['id'=>$seller_id])->first();
				// pr($supplierdata);
				// die;
					$reseller_mobile=$userdetail['mobile'];
					$supplier_mobile=$supplierdata['mobile'];
				    $manual_ship=$supplierdata->manual_ship;
				    $delay_penalty=$supplierdata->delay_penalty;
				       $comission_set=$supplierdata->per_value;

					 $orignal_value=(int)$itemorder['orignal_amount'];
					 $orignal_value_total=$orignal_value*$itemorder['qty'];
						$tcs=(1/ 100) * $orignal_value_total;
						// $comission_set=$o['percantage_value'];
						$comission=($comission_set/ 100) * $orignal_value_total;
						$gst=round((18/ 100) * $comission);
						$settlement_amount=$orignal_value_total-($tcs+$gst+$comission);
						// echo $settlement_amount;
						// die;
					 $current_date=date('Y-m-d H:i:s');
					$current_utc=strtotime($current_date);
					$seller_id=$itemorder['seller_id'];
					$user_id=$itemorder['customer_id'];
					$size_name=$itemorder['size_name'];
					$qty=(int)$itemorder['qty'];
					$p_name=$itemorder['product']['name_en'];
					 $save_Date=date('d-m-y h:i A',strtotime($order_date));
					 if($status_id==2)
					 {
						 //ACCEPT
						 if($sellerAddressId)
						 {
							 $table 	=	TableRegistry::get('Address');
							  $user_address_id=$itemorder['billing_address_id'];
							 $useraddress = $table->find()->where(['entity_id'=>$user_address_id])->first();
							 $supplieraddress = $table->find()->where(['sellerAddressId'=>$sellerAddressId])->first();
							 $o['sourcePin']=$supplieraddress['zipcode'];
							 $destinationPin=$o['destinationPin']=$useraddress['zipcode'];
							 // pr($user);
							 // die;
							// echo $itemorder->order_status;
							// die;
							if($itemorder->order_status==1)
							{

								$o['orderId']=$itemorder['item_order_id'];
								$o['customerName']=$useraddress['name'];
								$o['customerAddress']=$useraddress['address'].",".$useraddress['address2'];
								$o['customerCity']=$useraddress['city'];
								$o['customerPinCode']=$destinationPin;
								$o['customerContact']=$useraddress['contact'];
								$o['quantity']=$itemorder['qty'];
								$o['categoryName']="Cameras Audio and Video";
								$o['packageLength']=$itemorder['product']['packageLength'];
								$o['packageWidth']=$itemorder['product']['packageWidth'];
								$o['packageHeight']=$itemorder['product']['packageHeight'];
								$o['packageWeight']=$itemorder['product']['packageWeight'];
								$o['packageName']=$itemorder['product']['name_en'];
								$o['totalValue']=$itemorder['base_price'];
								$o['sellerAddressId']=$sellerAddressId;
								$o['ship_status']=$itemorder['ship_status'];
								$o['payment_method']=$itemorder['payment_method'];
								if($itemorder['payment_method']==1)
									$orderType="cod";
								else if($itemorder['payment_method']==2)
									$orderType="prepaid";
								$o['orderType']=$orderType;
								$o['orderDate']=date('Y-m-d');
								// pr($o);
								// die;
								if($manual_ship=="y")
								{
									$orderplace['status']=true;
								}
								else
								{
									$orderplace=$this->shypliteplaceorder($o);
									// pr($orderplace);
									// die;
									// $orderplace['order_track_id']['status']=true;
								}
								// pr($orderplace);
								// die;
								// $orderplace['status']=true;
								if($orderplace['status']=true)
								{
									$itemorder->order_status='2';
									$itemorder->sellerAddressId=$sellerAddressId;
									$itemorder->shyplite_order_id=$orderplace['data']['order_track_id'];
									$itemorder->shyplite_status="pass";
									$itemorder->shyplite_selected_mode=$orderplace['data']['mode_type'];
									$itemorder->shyplite_amount=$orderplace['data']['courier_charge'];
									if($orderplace['data']['carrierName'])
									$itemorder->carrierName=$orderplace['data']['carrierName'];
								    if($orderplace['data']['carrierName'])
									$itemorder->carrierName=$orderplace['data']['carrierName'];
									if($orderplace['data']['awbNo'])
									$itemorder->awbNo=$orderplace['data']['awbNo'];
									if($orderplace['data']['manifestID'])
									$itemorder->manifestID=$orderplace['data']['manifestID'];
									if($orderplace['data']['shipment_pdf'][0])
									$itemorder->shipment_pdf=$orderplace['data']['shipment_pdf'][0];
									if($orderplace['data']['mainfest_pdf'])
									$itemorder->mainfest_pdf=$orderplace['data']['mainfest_pdf'];
									$itemorder->shyplite_msg=$orderplace['msg'];
									// add balance to seller side
									// $seller_id=$itemorder->seller_id;
									$ct['user_id']=$itemorder->seller_id;
									$ct['amount']=(int)$settlement_amount;
									$ct['bill_amount']=(int)($itemorder->orignal_amount)*$itemorder->qty;
									$ct['user_type']=2;
									$ct['item_order_id']=$item_id;
									$ct['created_date']=$order_date;
									$ct['process_date']=$order_date;
									$ct['created_utc']=$order_utc;
									$ct['payment_type']="add";
									$ct['order_status']="onprocess";
									$ct['comment']="Order Accepted By seller";
									$this->addtransaction($ct);
									//add notification
									$awbNo=$orderplace['data']['awbNo'];
									$carrierName=$orderplace['data']['carrierName'];
									if($orderplace['data']['awbNo'])
									$reseller_sms="*Order Approved* :\n*".$p_name."*\nSize : *".$size_name."*\nQuantity : *".$qty."* \nOrder Number *".$item_order_id."* is Approved.Your Order Tracking No. *".$awbNo."* (".$carrierName.")";
									else
										$reseller_sms="*Order Approved* :\n*".$p_name."*\nSize :*".$size_name."*\nQuantity : *".$qty."* \nOrder Number *".$item_order_id."* is Approved.";
									  $n['title']="Order Approved";
									  $n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
									   $n['user_id']=$user_id;
									   $n['order_id']=$item_id;
									   $n['created']=$order_date;
									   $this->addnotification($n);
										$n['title']="Order Approved";
										$n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
									   $n['user_id']=$seller_id;
									   $n['order_id']=$item_id;
										 $n['created']=$order_date;
										$this->addnotification($n);
									 if($reseller_mobile)
									  {
										  $reg_ids='';
										$this->sendsms($reseller_sms,$reseller_mobile,$reg_ids);
										  // if($product_image)
											 // $this->sendsms($product_image,$reseller_mobile,$reg_ids);
									  }
									$push_msg=array('u_id'=>array($user_id,$seller_id),'user_type'=>1,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Approved','body'=>"(".$item_order_id.") ".$p_name);
									$push_msg_2=array('u_id'=>array($seller_id),'user_type'=>2,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Approved','body'=>"(".$item_order_id.") ".$p_name);
									$this->sendpush($push_msg);
									$this->sendpush($push_msg_2);
								}
								else
								{
									$itemorder->shyplite_status="fail";
									$msg=$itemorder->shyplite_msg=$orderplace['msg'];
									$err_msg=$msg;
									$err=true;
								}

								// api to take order from shylite

							}
							else
							{

								$err_msg="Without place order cant able to Accpet";
								$err=true;
							}
						 }
						 else
						 {
							$err_msg="Without Address id cant able to accept order";
							$err=true;
						 }

					 }
					 if($status_id==11)
					 {
						//REJECT_SUPPLIER
						$delay_penalty=$user['delay_penalty'];
						$itemorder->order_status='11';
						$itemorder->cancel_type='supplierreject';
						$itemorder->delay_penalty=$delay_penalty;
						$itemorder->cancel_utc=$current_utc;
						// cancel benfit from user
						$Tras = TableRegistry::get('Transaction');
						$usertras=$Tras->find()->where(['item_order_id'=>$item_id,'user_type'=>'1','order_status'=>'onprocess'])->first();
						if($usertras)
						{
						if($delay_penalty>0)
						{
							$ct['user_id']=$itemorder->seller_id;
							$ct['amount']=$delay_penalty;
							$ct['user_type']=2;
							$ct['item_order_id']=$item_id;
							// $ct['created_utc']=$order_utc;
							$ct['payment_type']="deduct";
							$ct['process_date']=date('Y-m-d H:i:s');
							$ct['created_date']=date('Y-m-d H:i:s');
							$ct['process_utc']=$order_utc;
							$ct['payment_status']="credited";
							$ct['payment_process']="n";
							$ct['order_status']="completed";
							$ct['comment']="Order Rejected By seller";

							$this->addtransaction($ct);
						}
						$usertras->payment_status="declinesupplier";
						$usertras->payment_process="n";
						$Tras->save($usertras);
						}
							$reseller_sms="*Order Rejected* :\n*".$p_name."*\nSize : *".$size_name."*\nQuantity : *".$qty."*\nOrder Number *".$item_order_id."* is rejected.Sorry For Inconvenience.";
							$n['title']="Order Rejected";
							$n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
							$n['user_id']=$user_id;
							$n['order_id']=$item_id;
							$n['created']=$order_date;
							$this->addnotification($n);
							$n['title']="Order Rejected";
							$n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
							$n['user_id']=$seller_id;
							$n['order_id']=$item_id;
							$n['created']=$order_date;
							$this->addnotification($n);
							if($reseller_mobile)
							{
								$reg_ids='';
								$this->sendsms($reseller_sms,$reseller_mobile,$reg_ids);
								// if($product_image)
								// $this->sendsms($product_image,$reseller_mobile,$reg_ids);
							}
							$push_msg=array('u_id'=>array($user_id),'user_type'=>1,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Rejected','body'=>"(".$item_order_id.") ".$p_name);
							$push_msg_2=array('u_id'=>array($seller_id),'user_type'=>2,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Rejected','body'=>"(".$item_order_id.") ".$p_name);
							$this->sendpush($push_msg);
							$this->sendpush($push_msg_2);
					 }
					  if($status_id==4)
					 {
						//CANCEL_CUSTOMER
						$current_status=$itemorder->order_status;
						if($current_status!='4')
						{

							$Tras = TableRegistry::get('Transaction');
							$usertras=$Tras->find()->where(['item_order_id'=>$item_id,'user_type'=>'1'])->first();
							// pr($usertras);
							// die;
							$suppliertras=$Tras->find()->where(['item_order_id'=>$item_id,'user_type'=>'2','order_status'=>'onprocess'])->first();
							$cancelorder=$this->cancelshyliteorderorder($item_id);
							if($usertras)
							{
								if($current_status==2)
								{
									$comment="Order Cancel After Dispatch";
									$usertras->comment=$comment;
									// $usertras->process_payment="n";
									$usertras->payment_status="declineuser";
									$usertras->order_status="cancelled";
								}
								else
								{
									$usertras->comment="Order Cancelled By user";

									$usertras->payment_status="declineuser";
									$usertras->order_status="cancelled";
								}

								$usertras->payment_process="n";
								// pr($usertras);
								// die;
								$Tras->save($usertras);
							}
							if($suppliertras)
							{
								if($current_status==2)
								{
									$suppliertras->comment="Order Cancelled After Dispatch";
								}
								else
								{
									$suppliertras->comment="Order Cancelled By user";
								}
								$suppliertras->payment_process="n";
								$suppliertras->payment_status="declineuser";
								// $suppliertras->order_status="cancelled";
								$Tras->save($suppliertras);
							}

							// pr($cancelorder);
							// die;
							// order cancel from user side

							   if($current_status==2)
								{
									$itemorder->order_status='5';
									$itemorder->cancel_type='afterdispatch';
								}
								else
								{
								  $itemorder->order_status='4';
								  $itemorder->cancel_type='usercancel';
								}

								$itemorder->cancel_utc=$current_utc;
								if($reason)
								$itemorder->reason=$reason;
								if($comment)
								$itemorder->comment=$comment;
							$reseller_sms="*Order Canceled* : \n*".$p_name."* \nSize : *".$size_name." *\nQuantity :*".$qty."* \nOrder Number *".$item_order_id."* is Canceled Successfully.";
							$supplier_sms="*Order Canceled* : \n*".$p_name."* \nSize : *".$size_name." *\nQuantity :*".$qty."* \nOrder Number *".$item_order_id."* is Canceled.";
							$n['title']="Order Canceled";
							$n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
							$n['user_id']=$user_id;
							$n['order_id']=$item_id;
							$n['created']=$order_date;
							$this->addnotification($n);
							$n['title']="Order Canceled";
							$n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
							$n['user_id']=$seller_id;
							$n['order_id']=$item_id;
							$n['created']=$order_date;
							$this->addnotification($n);
							if($reseller_mobile)
							{
								$reg_ids='';
								$this->sendsms($reseller_sms,$reseller_mobile,$reg_ids);
								if($product_image)
								$this->sendsms($product_image,$reseller_mobile,$reg_ids);
							}
							if($supplier_mobile)
							{
								$reg_ids='';
								$this->sendsms($supplier_sms,$supplier_mobile,$reg_ids);
								if($product_image)
								$this->sendsms($product_image,$reseller_mobile,$reg_ids);
							}
							$push_msg=array('u_id'=>array($user_id,$seller_id),'user_type'=>1,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Canceled','body'=>"(".$item_order_id.") ".$p_name);
							$push_msg_2=array('u_id'=>array($seller_id),'user_type'=>2,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Canceled','body'=>"(".$item_order_id.") ".$p_name);
							$this->sendpush($push_msg);
							$this->sendpush($push_msg_2);

						}
						else
						{
							$err_msg="Order is Already Cancelled Try another";
							$err=true;
						}

					 }
					  if($status_id==5)
					 {
						 // CANCEL_SUPPLIER
						$delay_penalty=$user['delay_penalty'];

						$itemorder->order_status='4';
						$itemorder->cancel_type='suppliercancel';
						$itemorder->delay_penalty=$delay_penalty;
						$itemorder->cancel_utc=$current_utc;
						if($reason)
						$itemorder->reason=$reason;
						if($comment)
						$itemorder->comment=$comment;
						$itemorder->order_status='4';
						$Tras = TableRegistry::get('Transaction');
						$usertras=$Tras->find()->where(['item_order_id'=>$item_order_id,'user_type'=>'1'])->first();
						$suppliertras=$Tras->find()->where(['item_order_id'=>$item_order_id,'user_type'=>'2','order_process'=>'onprocess'])->first();
						if($usertras)
							{
								$usertras->comment="Order Cancelled By Supplier";
								$usertras->payment_status="declinesupplier";
								// $usertras->order_status="cancelled";
								$Tras->save($usertras);
							}
							if($suppliertras)
							{
								$suppliertras->comment="Order Cancelled By user";
								$suppliertras->payment_status="declineresupplier";
								$suppliertras->order_status="cancelledreview";
								$Tras->save($suppliertras);
							}

							$reseller_sms="*Order Canceled* :*".$p_name."* \nSize :*".$size_name."* \nQuantity :*".$qty."* \nOrder Number *".$item_order_id."* is Canceled Successfully.";
							$supplier_sms="*Order Canceled* :*".$p_name."* \nSize :*".$size_name."* \nQuantity :*".$qty."* \nOrder Number *".$item_order_id."* is Canceled.";
							$n['title']="Order Canceled";
							$n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
							$n['user_id']=$user_id;
							$n['order_id']=$item_id;
							$n['created']=$order_date;
							$this->addnotification($n);
							$n['title']="Order Canceled";
							$n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
							$n['user_id']=$seller_id;
							$n['order_id']=$item_id;
							$n['created']=$order_date;
							$this->addnotification($n);
							if($reseller_mobile)
							{
								$reg_ids='';
								$this->sendsms($reseller_sms,$reseller_mobile,$reg_ids);

							}
							if($supplier_mobile)
							{
								$reg_ids='';
								$this->sendsms($supplier_sms,$supplier_mobile,$reg_ids);

							}
							$push_msg=array('u_id'=>array($user_id),'user_type'=>1,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Canceled','body'=>"(".$item_order_id.") ".$p_name);
							$push_msg_2=array('u_id'=>array($seller_id),'user_type'=>2,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Canceled','body'=>"(".$item_order_id.") ".$p_name);
							$this->sendpush($push_msg);
							$this->sendpush($push_msg_2);

					 }
					  if($status_id==8)
					 {
						 // return order
						if(($itemorder->order_status)>=6)
						{
							if($reason)
								$itemorder->reason=$reason;
								if($comment)
								$itemorder->comment=$comment;
							$itemorder->order_status='8';
							$itemorder->is_return_applicable='applied';
							$itemorder->awbNo='';
							$itemorder->retrun_text='Your Return will be done with in 4-5 days';

							$supplier_sms="*Order Return* :*".$p_name."* \nSize : *".$size_name."* \nQuantity :*".$qty."* \nOrder Number *".$item_order_id."*  is Returned By Customer, To Know Reason Please Log In To Admin Panel.";

							$n['title']="Order Return";
							$n['subtitle']="(".$item_id.") ".$p_name."\n".$save_Date;
							$n['user_id']=$seller_id;
							$n['order_id']=$item_id;
							$n['created']=$order_date;
							$this->addnotification($n);

							if($supplier_mobile)
							{
								$reg_ids='';
								$this->sendsms($supplier_sms,$supplier_mobile,$reg_ids);

							}
							$push_msg=array('u_id'=>array($seller_id),'user_type'=>2,'type'=>'order','itemid'=>$item_order_id,"title"=>'Order Return','body'=>"(".$item_order_id.") ".$p_name);
							$this->sendpush($push_msg);
						}
						else
						{
							$err_msg="Without Delivery of Product Return is not accepted";
							$err=true;
						}
					 }


				if($err==true)
				{

					$reponse['status']	=	false;
					$reponse['data']	=	"";
					$reponse['msg'] 	=	$err_msg;
				}
				else
				{

					if($quote_item_table->save($itemorder))
					{
						// in case of orject reject or customer cancel refill order
					if($status_id==11 || $status_id==4)
						{
							$size_id=$itemorder->size_id;
							$seller_id=$itemorder->seller_id;
							$product_id=$itemorder->product_id;
							$catelog_id=$itemorder->catelog_id;
							$items_qty=(int)$itemorder->qty;
							if($items_qty>0)
							{
								if($status_id==11)
								$s_type="reject";
								if($status_id==4)
								$s_type="canceluser";
								$this->stockupdate($size_id,$items_qty,$s_type,$seller_id,$product_id,$catelog_id);
							}
						}
						$reponse['status']	=	true;
						$reponse['data']	=	"";
						$reponse['msg'] 	=	"order Proceed to next stage";
					}
					else
					{
						$reponse['status']	=	false;
						$reponse['data']	=	"";
						$reponse['msg'] 	=	"Something Went Wrong";
					}

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
	function stockupdate($size_id,$items_qty,$s_type,$seller_id,$product_id,$catelog_id)
	{
		// echo $catelog_id;
		// die;
		$connection = ConnectionManager::get("default");
		$StockTable = TableRegistry::get('Stock');
		$stockdata = $StockTable
					->find()
					->where(['id'=>$size_id])
					->first();
		$old_count=$stockdata->pending_stock;
		if($s_type=="reject" || $s_type=="canceluser" || $s_type=="cancel")
		$new_count=$old_count+$items_qty;
		else
		$new_count=$old_count-$items_qty;
		$stockdata->pending_stock=$new_count;
		$all_blank="y";
		if($StockTable->save($stockdata))
		{
			$connection->execute("INSERT INTO stock_data(user_id,product_id,stock_id,stock_value,s_type) VALUES ('$seller_id','$product_id','$size_id','$items_qty','$s_type')");
			$stockdata=$StockTable->find()
					 ->where(['product_id'=>$product_id])->toArray();
			foreach($stockdata as $si)
			{
				// pr($si);
				$pending_stock=$si['pending_stock'];
				if($pending_stock>2)
				{
					$all_blank="n";
					break;
				}
			}
			if($all_blank=="y")
			{
				$product=$connection->execute("update catalog_product_entity set on_stock='n' where id='$product_id'");
				// if all product are out of stock then make catelog out of stock too
				$totalproductstock=$connection->execute("select count(id) as total_product_stock from catalog_product_entity where catelog_id='$catelog_id' and status='1' and on_stock='n'")->fetch('assoc')['total_product_stock'];

				$CatelogTable = TableRegistry::get('Catelog');
				$catelog_detail = $CatelogTable->find()->where(['id'=>$catelog_id])->first();
				// pr($catelog_detail);
				// die;
				$product_count=$catelog_detail->product_count;
				if($totalproductstock==$product_count)
				$connection->execute("update catalog_catelog_entity set on_stock='n' where id='$catelog_id'");
			}
			else
			{
				$product=$connection->execute("update catalog_product_entity set on_stock='y' where id='$product_id'");
				$connection->execute("update catalog_catelog_entity set on_stock='y' where id='$catelog_id'");
			}
		}


	}
	function cancelshyliteorderorder($order_id)
	{
		$timestamp = time();
		$auth=$this->authenticatShyplite($timestamp);
		// pr($auth);
		// die;
		if($auth['status'])
		{
			$appID=$auth['appID'];
			$sellerid=$auth['sellerid'];
			$userToken=$auth['userToken'];
			$key=$auth['key'];
			$sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
			$authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $userToken, true)));
			 $data = array(
				"orders"=> [$order_id]
			);
			$data_json = json_encode($data);
			$header = array(
						"x-appid: $appID",
						"x-sellerid:$sellerid",
						"x-timestamp: $timestamp",
						"Authorization: $authtoken",
						"Content-Type: application/json",
						"Content-Length: ".strlen($data_json)
					);
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/ordercancel');
				curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
				curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$response  = curl_exec($ch);
				curl_close($ch);
				$res=json_decode($response,true);
				// pr($res);
				// die;
				if($res['result'][0]['status'])
				{
					$status=true;
				}
				else
				{
					$status=false;
				}
		}

     return $status;
	}
   function notificationlist()
   {
	   	$request = $this->request->getData();
		extract($request);
		$i=0;
		$n=[];
	   if($customer_id)
	   {
		   $Noti = TableRegistry::get('Notification');
		   $notlist = $Noti->find()->where(['status'=>"y",'user_id'=>$customer_id])->order(['id'=>'DESC'])->limit(50)->toArray();

		   foreach($notlist as $s)
		   {
			   $n[$i]['title']=$s['title'];
			   $n[$i]['desc']=$s['subtitle'];
			   $n[$i]['img']='';
			$i++;
		   }

	   }
	   $r['status']=true;
	   $r['data']=$n;
	   $r['msg'] 	=	" Data Type";

	   echo json_encode($r);die;
   }
   function updateInitialProfile()
	{
		if($this->request->is('post')){
			$request = $this->request->getData();
			// print_R($request);
			// die;
			extract($request);

			if($mobile)
			{
				$table 	=	TableRegistry::get('Users');
				$userdata =$table
				->find()
				->where(['mobile ='=>$mobile])->first();
				// print_R($userdata);
				// die;
				if($userdata)
				{
					$userdata->fullname=$fullname;
					$userdata->email=$email;
					$userdata->gender=$gender;
					$userdata->business=$business;
					$userdata->occupation=$occupation;
					$userdata->pincode=$pincode;
					if ($referrral_code) {
						$userdata->referrral_code=$referrral_code;
					}
					if($_FILES['profileImage']['name'])
					{
						$profile = $this->uploadImage($_FILES['profileImage']);
						$userextra->profile='http://resellermantra.com/profile/'.$profile;
					}
					if($table->save($userdata)){
						$reponse['status'] =true;
						$reponse['data'] ='';
						$reponse['msg'] ="Data has been updated";
					}else{
					   	$reponse['status'] =false;
						$reponse['data'] ='';
						$reponse['msg'] ="Couldn't save data";
					}
				}else{
					$reponse['status'] =false;
					$reponse['data'] ='';
					$reponse['msg'] ="Invalid Account access";
				}
			}else{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Paramter missing";
			}
		}else{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Data is not Post";
		}

		echo json_encode($reponse);
		die;
	}

	function updateBankProfile()
	{
		if($this->request->is('post')){
			$request = $this->request->getData();
			// print_R($request);
			// die;
			extract($request);
			$user_type=1;

			if($mobile)
			{
				$table 	=	TableRegistry::get('Users');

				$Userextratable 	=	TableRegistry::get('Userextra');
				$userdata =$table
				->find()
				->where(['mobile ='=>$mobile])->first();
				// print_R($userdata->id);
				// die;
				if($userdata)
				{
					$userextra =$Userextratable
					->find()
					// ->select(['id','path','level','children_count','position','name','is_active'])
					->where(['user_id ='=>$userdata->id])->first();
					// print_R($userextra);
					// die;
					if($userextra)
					{
						// all banking detail

						if($acname)
						$userextra->account_holder_name=$acname;
						if($acnumber)
						$userextra->account_number=$acnumber;
						if($ifsccode)
						$userextra->ifsc_code=$ifsccode;
						if($_FILES['profileImage']['name']){
							$bank_prof = $this->uploadImage($_FILES['profileImage']);
							$userextra->bank_prof='http://resellermantra.com/profile/'.$bank_prof;
						}

						$resultsave=$Userextratable->save($userextra);
						if($resultsave){
							$reponse['status']	=true;
							$reponse['data']	='';
							$reponse['msg'] 	=	"Update successful";
						}else{
							$reponse['status']	=false;
							$reponse['msg'] 	=	"Update Failed";
						}
					}else{
						$userextra['user_id']=$userdata->id;
						// do first entry
						if($account_holder_name)
							$userextra['account_holder_name']=$account_holder_name;
						if($account_number)
							$userextra['account_number']=$account_number;
						if($ifsc_code)
							$userextra['ifsc_code']=$ifsc_code;
						if($bank_prof){
							$bank_prof = $this->uploadImage($_FILES['bank_prof']);
							$userextra['bank_prof']='http://resellermantra.com/profile/'.$bank_prof;
						}
						// print_R($userextra);
						// die;
						$entity =	$Userextratable->newEntity($userextra);
						$resultsave	=	$Userextratable->save($entity);
						if($resultsave){
							$reponse['status']	=true;
							$reponse['data']	='';
							$reponse['msg'] 	=	"Register successful";
						}else{
							$reponse['status']	=false;
							$reponse['msg'] 	=	"Register Failed";

						}
					}
				}else{
					$reponse['status'] =false;
					$reponse['data'] ='';
					$reponse['msg'] ="Invalid Account access";
				}
			}else{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Paramter missing";
			}
		}else{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invaid Type";
		}

		echo json_encode($reponse);
		die;

	}
	function updateprofile()
	{
		if($this->request->is('post')){
			$request = $this->request->getData();
			// print_R($request);
			// die;
			extract($request);
			$user_type=1;

			if($customer_id)
			{
				$table 	=	TableRegistry::get('Users');

				$Userextratable 	=	TableRegistry::get('Userextra');
				$userdata =$table
				->find()
				->select(['mobile','id','is_suplier','fullname','email','mobile','city'])
				->where(['id ='=>$customer_id])->first();
				// print_R($userdata);
				// die;
				if($userdata)
				{
					$display_name=$userdata->display_name;
					if($name)
					$userdata->fullname=$name;
					if($display_name=='')
					$userdata->display_name=$name;
					if($device_id)
					$userdata->device_id=$device_id;
					if($latitude)
					$userdata->latitude=$latitude;
					if($longitute)
					$userdata->longitute=$longitute;
				    // if($fullname)
					// $userdata->fullname=$fullname;
					if($email)
					$userdata->email=$email;
					if($city)
					$userdata->city=$city;
				   $table->save($userdata);
					$userextra =$Userextratable
					->find()
					// ->select(['id','path','level','children_count','position','name','is_active'])
					->where(['user_id ='=>$customer_id])->first();
					// print_R($userextra);
					// die;
					if($userextra)
					{
						// all banking detail
						if($bank_name)
						$userextra->bank_name=$bank_name;

						if($account_holder_name)
						$userextra->account_holder_name=$account_holder_name;
						if($account_number)
						$userextra->account_number=$account_number;
						if($ifsc_code)
						$userextra->ifsc_code=$ifsc_code;
						if($bank_city)
						$userextra->bank_city=$bank_city;
						// gest detail
						if($gst_number)
						$userextra->gst_number=$gst_number;
					   if($pancard)
						$userextra->pancard=$pancard;
					   if($_FILES['bank_prof']['name'])
						{
						  $bank_prof = $this->uploadImage($_FILES['bank_prof']);
						  $userextra->bank_prof='http://resellermantra.com/profile/'.$bank_prof;
						}
						if($_FILES['gst_doc']['name'])
						{
						  $gst_doc = $this->uploadImage($_FILES['gst_doc']);
						  $userextra->gst_doc='http://resellermantra.com/profile/'.$gst_doc;
						}
							if($_FILES['pan_card']['name'])
						{
							$pan_card = $this->uploadImage($_FILES['pan_card']);
							$userextra->pan_card='http://resellermantra.com/profile/'.$pan_card;
						}
						if($_FILES['address_prof']['name'])
						{
							$address_prof = $this->uploadImage($_FILES['address_prof']);
							$userextra->address_prof='http://resellermantra.com/profile/'.$address_prof;
						}
						if($basic_profile)
						$userextra->basic_profile=$basic_profile;
						if($bank_profile)
						$userextra->bank_profile=$bank_profile;
						if($gst_profile)
						$userextra->gst_profile=$gst_profile;
						if($address_profile)
						$userextra->address_profile=$address_profile;
						$resultsave=$Userextratable->save($userextra);
						if($resultsave){
							$userdata->fullname=$userdata->fullname;
							$reponse['status']	=true;
							$reponse['data']	=	$userdata;
							$reponse['id']	=	$userdata->id;
							$reponse['is_suplier']	=	$userdata->is_suplier;
							$reponse['otp']	='';
							$reponse['newuser']	=false;
							$userextra->name=$userdata->fullname;
							$userextra->fullname=$userdata->fullname;
							$userextra->email=$userdata->email;
							$userextra->mobile=$userdata->mobile;
							$userextra->city=$userdata->city;
							if($userextra)
							$reponse['data']['profile'] 	=$userextra;
							else
							$reponse['data']['profile'] 	='';

							$reponse['msg'] 	=	"Update successful";
						}
						else
						{
							$reponse['status']	=false;
							$reponse['msg'] 	=	"Register Failed";

						}
					}
					else
					{
						$userextra['user_id']=$customer_id;
						// do first entry
						if($bank_name)
						$userextra['bank_name']=$bank_name;
						if($account_holder_name)
						$userextra['account_holder_name']=$account_holder_name;
						if($account_number)
						$userextra['account_number']=$account_number;
						if($ifsc_code)
						$userextra['ifsc_code']=$ifsc_code;
						if($bank_city)
						$userextra['bank_city']=$bank_city;
						// gest detail
						if($gst_number)
						$userextra['gst_number']=$gst_number;
					    if($pancard)
						$userextra['pancard']=$pancard;
						if($gst_doc)
						{
							$gst_doc = $this->uploadImage($_FILES['gst_doc']);
							$userextra['gst_doc']='http://resellermantra.com/profile/'.$gst_doc;
						}
						if($bank_prof)
						{
							$bank_prof = $this->uploadImage($_FILES['bank_prof']);
							$userextra['bank_prof']='http://resellermantra.com/profile/'.$bank_prof;
						}
						if($pan_card)
						{
							$pan_card = $this->uploadImage($_FILES['pan_card']);
							$userextra['pan_card']='http://resellermantra.com/profile/'.$pan_card;
						}
						if($address_prof)
						{
							$address_prof = $this->uploadImage($_FILES['address_prof']);
							$userextra['address_prof']='http://resellermantra.com/profile/'.$address_prof;
						}
						if($basic_profile)
						$userextra['basic_profile']=$basic_profile;
						if($bank_profile)
						$userextra['bank_profile']=$bank_profile;
						if($gst_profile)
						$userextra['gst_profile']=$gst_profile;
						if($address_profile)
						$userextra['address_profile']=$address_profile;
						// print_R($userextra);
						// die;
						$entity =	$Userextratable->newEntity($userextra);
						$resultsave	=	$Userextratable->save($entity);
						if($resultsave){
							$reponse['status']	=true;
							$reponse['data']	=	$userdata;
							$reponse['id']	=	$userdata->id;
							$reponse['otp']	='';
							$reponse['newuser']	=false;
							$userextra['id']=$userdata->id;
							$userextra['name']=$userdata->fullname;
							$userextra['fullname']=$userdata->fullname;
							$userextra['email']=$userdata->email;
							$userextra['mobile']=$userdata->mobile;
							$userextra['city']=$userdata->city;
							if($userextra)
							$reponse['data']['profile'] 	=$userextra;
							else
							$reponse['data']['profile'] 	='';

							$reponse['msg'] 	=	"Update successful";
						}
						else
						{
							$reponse['status']	=false;
							$reponse['msg'] 	=	"Register Failed";

						}
					}
				}
				else
				{
					$reponse['status'] =false;
					$reponse['data'] ='';
					$reponse['msg'] ="Invalid Account access";
				}
			}
			else
			{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Paramter missing";
			}
		}
		else{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invaid Type";
		}

		echo json_encode($reponse);
		die;

	}

	function seller()
	{
		if($this->request->is('post')){
			$request = $this->request->getData();
			// print_R($request);
			// die;
			extract($request);
			$user_type=1;

			if($user_id)
			{
				$userextra 	=	TableRegistry::get('Sellers');

				$userextra['user_id']=$user_id;
				if($ac_name)
				$userextra['ac_name']=$ac_name;
				$userextra['product']=1;
				if($contact_name)
				$userextra['contact_name']=$contact_name;
				if($contact_number)
				$userextra['contact_number']=$contact_number;
				$userextra['created']=date('Y-m-d H:i:s');
				$userextra['modified']=date('Y-m-d H:i:s');
				// print_R($userextra);
				// die;
				$entity =	$Sellers->newEntity($userextra);
				$resultsave	=	$Sellers->save($entity);
				if($resultsave){
					$reponse['status']	=true;

					$reponse['msg'] 	=	"Apply Successfully";
				}else{
					$reponse['status']	=false;
					$reponse['msg'] 	=	"Register Failed";

				}
			}else{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Invalid Account access";
			}
		}else{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invaid Type";
		}

		echo json_encode($reponse);
		die;

	}

	function becomesupplier()
	{
		if($this->request->is('post')){
			$request = $this->request->getData();
			// print_R($request);
			// die;
			extract($request);
			$table 	=	TableRegistry::get('Users');
			$result	=	$table->find()->select(['mobile','id','is_suplier'])->where(['id'=>$customer_id,'role'=>'2'])->first();
			if($result)
			{
				$result->is_suplier="requested";
				$result->request_utc=$current_utc=strtotime(date('Y-m-d h:i:s'));
				if($table->save($result))
				{
					$reponse['status'] =true;
					$reponse['data'] =$result;
					$reponse['msg'] ="Supplier requested";
				}
				else
				{
				  $reponse['status'] =false;
					$reponse['data'] ='';
					$reponse['msg'] ="Something Went wrong";
				}
			}
			else{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Invaid User id Selected";
			}

		}
		else{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invaid Type";
		}

		echo json_encode($reponse);
		die;

	}
	 function uploadImage($file=''){
    	if(!empty($file) && $file['error']==0){
    		$source = $file['tmp_name'];
    		$sub_dir = date('Y')."/".date('m')."/";
    		$dir = WWW_ROOT."profile/";
    		if(!file_exists($dir)){
    			mkdir($dir,0777,true);
    		}
    		$name = time().str_replace(" ", "-", $file['name']);

    		move_uploaded_file($source, $dir.$name);
    		return $name;
    	}

    }
	function collectionlist()
	{
		$CollectionTable = TableRegistry::get('Collection');
		$data = $CollectionTable
			->find()
			->where(['status'=>"y",'is_slider'=>'n'])
			->order(['id'=>"desc"])
			->toArray();

			$slider = $CollectionTable
			->find()
			->where(['status'=>"y","is_slider"=>'y'])
			->order(['id'=>"desc"])
			->toArray();
			$i=0;
			$j=0;
		if(count($data)>0)
		{
		 foreach ($data as $u) {
			 $d[$i]['id']=$u['id'];
			 $d[$i]['title']=$u['title'];
			 $d[$i]['offer_image']=Router::url('image/',true).$u['offer_image'];
			 $d[$i]['search_keyword_1']=$u['search_keyword_1'];
			 $d[$i]['search_keyword_2']=$u['search_keyword_2'];
			 $i++;
		 }
		 foreach ($slider as $sl) {
			 $s[$j]['id']=$sl['id'];
			 $s[$j]['title']=$sl['title'];
			 $s[$j]['subtitle']='';
			 $s[$j]['offer_image']=Router::url('image/',true).$sl['offer_image'];
			 $s[$j]['search_keyword_1']=$sl['search_keyword_1'];
			 $s[$j]['search_keyword_2']=$sl['search_keyword_2'];
			 $j++;
		 }
		 $response['status'] =true;
			$response['offer'] =$s;
			$response['data'] =$d;
			$response['code'] =404;
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
	function trackdetail()
	{
			$request = $this->request->getData();
			// print_R($request);
			// die;
			extract($request);
		if($customer_id && $item_id)
		{
			$quote_item_table=TableRegistry::get('QuoteItem');
			$itemorder	=	$quote_item_table->find()->where(['item_order_id'=>$item_id])->first();
			if($itemorder)
			{
				// pr($itemorder);
				// die;
				$order_status=$itemorder->order_status;
				if($order_status=="8")
				{
					$response['status'] =true;
					$d['awb']=$itemorder->return_awbNo;
					$d['carrier']=$itemorder->return_carrierName;

					$response['data'] =$d;
					$response['code'] =200;
				}
				else
				{
					$track_status=$itemorder->track_status;
					$awbNo=$itemorder->awbNo;
					$shyplite_order_id=$itemorder->item_order_id;
					if($shyplite_order_id)
					{
						$timestamp = time();
						$auth=$this->authenticatShyplite($timestamp);
						// pr($auth);
						// die;
						if($auth['status'])
						{
							$appID=$auth['appID'];
							$sellerid=$auth['sellerid'];
							$userToken=$auth['userToken'];
							$key=$auth['key'];
							$sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
							$authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $userToken, true)));
							$header = array(
								"x-appid: $appID",
								"x-sellerid:$sellerid",
								"x-timestamp: $timestamp",
								"Authorization: $authtoken",
								"Content-Type: application/json",
								"Content-Length: ".strlen($data_json)
							);
						}
						// echo $awbNo;

						// die;
						// $shyplite_order_id=10097;

						if($awbNo=='' || $itemorder->shipment_pdf=='')
						{
							// echo $shyplite_order_id;
							// die;
							// $shyplite_order_id="1013";
							// generate awb no first
							$timestamp = time();
							$auth=$this->authenticatShyplite($timestamp);
							$secret=$auth['userToken'];
							$sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
							$authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
							$ch = curl_init();
							$header = array(
								"x-appid: $appID",
								"x-timestamp: $timestamp",
								"x-sellerid:9600",
								"Authorization: $authtoken"
							);
						   // $order="10104";
							curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/getSlip?orderID='.urlencode($shyplite_order_id));
							curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$cresponse = curl_exec($ch);
							$slip_json=json_decode($cresponse,true);
							   // pr($slip_json);
							   // die;
							if($slip_json['carrierName'] && ($slip_json['status']=="success" || $slip_json['status']=="pending"))
							{
								if($slip_json['carrierName'] && $itemorder->carrierName=='')
								{
										$itemorder->carrierName=$slip_json['carrierName'];
								}
								if($slip_json['awbNo'] && $itemorder->awbNo=='')
								{
									$awbNo=$itemorder->awbNo=$slip_json['awbNo'];
								}
								if($slip_json['manifestID'] && $itemorder->manifestID=='')
								{
									$itemorder->manifestID=$slip_json['manifestID'];
								}
								if($slip_json['s3Path'] && $itemorder->shipment_pdf=='')
								{
									$url=$slip_json['s3Path'][0];
									$uni_id=$shyplite_order_id."_shipment";
									// echo $url;
									// die;
									if($url)
									$itemorder->shipment_pdf=$this->downloadfile("shipment",$url,$uni_id);

								}
							}
						}

						// echo $awbNo;
						// die;
						if($awbNo)
						{

							$current_date=date('Y-m-d H:i:s');
							 $current_utc=strtotime($current_date);

							$last_track_utc_time=$itemorder->last_track_utc_time;
							if($last_track_utc_time)
							{
								$utc_diff=abs($current_utc-$last_track_utc_time);
								$utc_min=round($utc_diff / 60);
							}

							if(($utc_min>60) || $track_status=='' || $last_track_utc_time=='')
							{


								$ch = curl_init();
								curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/track/'.$awbNo);
								curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
								curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								$track_output = curl_exec($ch);
								$res=json_decode($track_output,true);
								// pr($res);
								// die;
								if($res['data']['awbNo'])
								{
									if($res['data']['events'])
									{
										$itemorder->track_status=$track_output;
										$itemorder->last_track_utc_time=$current_utc;

									}
								}
								curl_close($ch);

							}
							else
							{
								$track_output=$itemorder->track_status;
							}

							$response['status'] =true;
							$awbNo=$itemorder->awbNo;
							$carrierName=$itemorder->carrierName;
							$response['data']=$this->formattrackorder($track_output,$awbNo,$carrierName);
							$response['code'] =200;


						}
						else
						{
							$response['status'] =false;
							$response['msg'] ="Failed to generate Awb no,Contact to support";
							$response['code'] =404;
						}
						// pr($itemorder);
						// die;
						$quote_item_table->save($itemorder);
					}
					else
					{
						$response['status'] =false;
						$response['msg'] ="Failed to generate Tracking id,Contact to support";
						$response['code'] =404;
					}
				}

			}
			else
			{
				$response['status'] =false;
				$response['msg'] ="Invalid Order id to track";
				$response['code'] =404;

			}

		}
		else
		{
			$response['status'] =false;
			$response['data'] ="";
			$response['code'] =404;

		}
		// pr($response);
		// die;
		echo json_encode($response);
		die;

	}
	public function downloadfile($dest,$url,$uni_id)
	{
		$destination_folder = WWW_ROOT.$dest."/";
		// $url ="http://www.africau.edu/images/default/sample.pdf";
		// $newfname = $destination_folder . basename($url);
		$newfname = $destination_folder .$uni_id.".pdf";

		$file = fopen ($url, "rb");
		if ($file) {
		  $newf = fopen ($newfname, "wb");

		  if ($newf)
		  while(!feof($file)) {
			fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
		  }
		}

		if ($file) {
		  fclose($file);
		}

		if ($newf) {
		  fclose($newf);
		}
		$f_url="http://resellermantra.com/".$dest."/".$uni_id.".pdf";
		return  $f_url;
	}
	public function formattrackorder($track_output,$awbNo,$carrierName)
	{
		$tr=json_decode($track_output, true);
		extract($tr['data']);
		if($tr)
		{
			$t['carrier']=$carrierName;
			$t['awb']=$awbNo;
			$ti=[];
			foreach($events as $e)
			{
				$d['lable_name']=$e['Remarks'];
				$d['label_address']=$e['Location'];
				$date=$e['Time'];
				$labeldata=date("d-m-Y h:i A", strtotime($date));
				$d['label_date']=$labeldata;
				$ti[]=$d;
			}
			$t['track']=$ti;
		}
	   return $t;
	}
	public function orderdetail()
	{
		if($this->request->is('post')){
			$request = $this->request->getData();
			// print_R($request);
			// die;
			extract($request);
			if($customer_id && $user_type && $item_id)
			{
				$quote_item_table=TableRegistry::get('QuoteItem');
				$itemorder	=	$quote_item_table->find()->where(['item_order_id'=>$item_id])->first();
				if($itemorder->customer_id==$customer_id)
					$user_type=1;
				if($itemorder->seller_id==$customer_id)
					$user_type=2;

				$connection = ConnectionManager::get('default');
				  $query="select i.*,i.base_price as sale_base,p.percantage_value,p.primary_price as orignal_value,p.*,o.discount_amount,o.billing_address_id,o.shipping_amount,o.cod_amount,s.display_name as supllier_name,s.user_rating as supplier_rating,s.mobile as supplier_mobile,
				 u.fullname as user_name,u.mobile as user_mobile from sales_flat_quote_item as i inner join catalog_product_entity as
				 p on p.id=i.product_id inner join sales_flat_order as o on o.increment_id=i.order_id inner join users as s on s.id=p.seller_id inner join users as u on u.id=i.customer_id where i.item_order_id='$item_id'  order by i.order_utc desc limit 0,1";

			// die;
				$o = $connection->execute($query)->fetch('assoc');
				if($o)
				{
					// pr($o);
					// die;
					$order_status=$o['order_status'];
					$seller_address_id=$o['seller_address_id'];
					// $seller_address_id=$o['seller_address_id'];
					if($user_type==1)
					{
						// show buyer and supplier both detail

						$s['supplier_name']=$o['supllier_name'];
						$customer_id=$o['customer_id'];

						$s['supplier_mobile']="+91".$o['supplier_mobile'];
						$s['supplier_rating']=(float)$o['supplier_rating'];
						$de['supplier']=$s;
						$pay_label="Buyer Pay";
						// $support_msg="I "."*R".$customer_id."* Need Help Regarding Order Item Id: *".$item_id."*";
						$support_msg="Need Support :  I Need Support For My Order ".$item_id.". My Reseller ID : R".$customer_id;
					}
					else
					{
						$seller_id=$o['seller_id'];
						$pay_label="Supplier Get";
						// $support_msg="I "."*S".$seller_id."* Need Help Regarding Order Item Id: *".$item_id."*";
						$support_msg="Need Support :  I Need Support For My Order ".$item_id.". My Supplier  ID : S".$seller_id;
						// $support_msg="Hi,I Need Help Regarding  3 Order Item Id:".$item_id;
					}

					$order_status=$o['order_status'];
					$de['track_code']=$this->trackstatus($order_status,$o);
					// $de['track_code']=$track['code'];
					$de['track_msg']='';
					$de['rating']=$o['rating_by_user'];
					$de['comment']=$o['feedback_user'];
					if($order_status=='8')
					{
						$de['track_url']=$o['return_track_url'];
						$de['carrierName']=$o['return_carrierName'];
					}
					else
					{
						$de['track_url']=$o['track_url'];
						$de['carrierName']=$o['carrierName'];
					}
					$de['is_return_applicable']=$o['is_return_applicable'];

					$de['retrun_text']=$o['retrun_text'];
					$de['return_track_url']=$o['return_track_url'];
					$p['pay_label']=$pay_label;
					$shipping_charges=(int)$o['shipping_charges'];

					$qty=(int)$o['qty'];
					$total_shipping=(int)$shipping_charges*$qty;
					$p['shipping']=$total_shipping;
					$my_earning=(int)$o['my_earning']*(int)$o['qty'];
					if($user_type==2)
					$orignal_value=$p['product_price']=(int)$o['orignal_value']*$qty;
					else
					$p['product_price']=((int)$o['sale_base']-$total_shipping)-$my_earning;
					$p['cod']=(int)$o['cod_amount'];
					$p['discount_amount']=(int)$o['discount_amount'];
					if($user_type==2)
					$p['base_price']=(int)$o['orignal_value']*$qty;
					else
					$p['base_price']=(int)$o['sale_base'];

					// $p['base_price']=(int)$o['sale_base'];
					$p['my_earning']=(int)$o['my_earning']*(int)$o['qty'];
					if($user_type==2)
					{
						 $orignal_value=(int)$o['orignal_value'];
						 $orignal_value_total=$orignal_value*$o['qty'];
						$tcs=(1/ 100) * $orignal_value_total;
						$comission_set=$o['percantage_value'];
						$comission=($comission_set/ 100) * $orignal_value_total;
						$gst=round((18/ 100) * $comission);
						$settlement_amount=$orignal_value_total-($tcs+$gst+$comission);
						$p['tcs']=round($tcs);
						$p['comission']=round($comission);
						$p['settlement_amount']=$settlement_amount;
						$p['gst']=$gst;
						$p['pently']=0;
						$p['refund']=0;
						$p['supplier_get']=100;
					}
					if($order_status==11 || $order_status==4 || $order_status==5 || $order_status==7 || $order_status==12)
					{
						$delay_penalty=(int)$o['delay_penalty'];
						if($delay_penalty>0)
							$show_pen="-".$delay_penalty;
						else
							$show_pen=0;
						$p['product_price']=0;
						$p['base_price']=0;
						$p['tcs']=0;
						$p['comission']=0;
						$p['shipping']=0;
						$p['my_earning']=0;
						if($user_type==2)
						{
							if($order_status==11 || $order_status==4)
							{
								$p['settlement_amount']=$show_pen;
								$p['pently']=$show_pen;
							}
							else
							{
								$p['settlement_amount']=0;
								$p['pently']=0;
							}

						}
						$p['gst']=0;
						// $p['pently']=-100;
						$p['refund']=0;
						$p['supplier_get']=0;
					}
					$de['pay']=$p;
					$de['product']=$this->productdetail($o);

					// user detail
					 $billing_address_id=$o['billing_address_id'];
					$table 	=	TableRegistry::get('Address');
						$addressr = $table->find()->where(['entity_id'=>$billing_address_id])->first();
					if($user_type==1)
					{


						// pr($addressr);
						// die;
						if($addressr)
						{
							$user_name=$addressr['name'];
							$user_mobile=$addressr['contact'];
							$user_address=$addressr['address'].",".$addressr['address2']."\n".$addressr['city'].",".$addressr['zipcode'];
						}
					}
					else
					{
						$user_name=$addressr['name'];
						$user_mobile=$o['user_mobile'];
						$user_address=$addressr['address'].",".$addressr['address2']."\n".$addressr['city'].",".$addressr['zipcode'];
					}
					if(strpos($user_mobile, "+91") === 0)
					{
					}
					else
					{
						$user_mobile=$user_mobile;
					}

					$b['name']=$user_name;
					$b['address']=$user_address;
					$b['mobile']="+91".$user_mobile;
					$b['buyer_msg']=$support_msg;
					$de['buyer']=$b;
					// $de['support_no']="+91".$o['user_mobile'];
					$de['support_no']="+91"."8819811234";
					$de['support_msg']=$support_msg;
					// $de['comment']=$support_msg;
					$address =$this->addresslist($seller_address_id);
					if($user_type==2)
					{
						$de['address_count']=$address['address_count'];
						$de['address']=$address['address'];
					}
					$reponse['status'] =true;

					$reponse['data'] =$de;
					$reponse['msg'] ="Order detail";
				}
				else
				{
				  $reponse['status'] =false;
					$reponse['data'] ='';
					$reponse['msg'] ="Invalid Order id";
				}
			}
			else
			{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Required Parameter missing";
			}
		}
		else{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invaid Type";
		}

		echo json_encode($reponse);
		die;
	}
	public function trackstatus($s_code,$o)
	{
	   switch ($s_code) {
			case 1:
				$s="";
				break;
			case 2:
			    $s="A";
				break;
			case 3:
			    $s="C";
				break;
			case 6:
			{
				$feedback_applicable=$o['is_feedback_applicable'];
				if($feedback_applicable=="y")
				{
				    $s="F";
				} else if($feedback_applicable=="completed")
				{
					 $s="G";
				} else
				{
					$s="D";
				}

				break;
			}
			case 9:
			case 10:
			{
				$payment_status=$o['payment_status'];
				if($payment_status=="made")
				{
					$s="E";
				} else
				{
					$s="D";
				}
				break;
			}
			case 4:
			case 5:
			case 11:
			    $s="H";
				break;
			case 8:
			    $s="I";
				break;
			case 12:
			    $s="J";
				break;
			default:
				$s="";
		}
		// echo $s;
		// $s='H';
		// echo $s;
		// die;
		// $s="";
	  return $s;
	}
	public function productfeedback()
	{
		if($this->request->is('post')){
			$request = $this->request->getData();
			extract($request);
			if($customer_id && $item_id)
			{
				$quote_item_table=TableRegistry::get('QuoteItem');
				$itemorder	=	$quote_item_table->find()->where(['item_order_id'=>$item_id]) ->first();
				if($itemorder)
				{
					if($itemorder->rating_by_user)
					{
						$reponse['status'] =false;
						$reponse['data'] ='';
						$reponse['msg'] ="Already Rated For that product";
					}
					else
					{
						if($rating)
						$itemorder->rating_by_user=$rating;
						if($comment)
						$itemorder->feedback_user=$comment;
						$itemorder->is_feedback_applicable="completed";
						if($quote_item_table->save($itemorder))
						{
							$reponse['status'] =true;
							$reponse['data'] ='';
							$reponse['msg'] ="Feedback Done";
						}
						else
						{
							$reponse['status'] =false;
							$reponse['data'] ='';
							$reponse['msg'] ="Something Went Wrong";
						}
					}
				}
			}
		}
		else{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invaid Type";
		}

		echo json_encode($reponse);
		die;
	}
	public function productdetail($sitem)
	{
		if($sitem)
		{
			// pr($sitem);
			// die;
			$s=0;
			$order_status=$sitem['order_status'];
			$p_item_id=$d['item_id']=$sitem['item_order_id'];
			$d['market_price']=(int)$sitem['base_price'];
			$d['my_earning']=(int)$sitem['my_earning'];
			$d['primary_price']=(int)$sitem['primary_price'];
						$d['selling_price']=(int)$sitem['base_price'];
						$d['product_id']=$sitem['product_id'];
						$d['base_price']=(int)$sitem['base_price'];
						$d['amount']=(int)$sitem['price'];
						$d['qty']=$sitem['qty'];
						if($order_status!='6')
						{
							if($order_status=='8')
							$d['awbNo']=$sitem['return_awbNo'];
							else
								$d['awbNo']=$sitem['awbNo'];
						}
						else
						$d['awbNo']='';
						if($sitem['payment_method']==1)
						$d['order_type']="COD";
						else
						$d['order_type']="PREPAID";

						$d['off']=$sitem['off'];
						$d['size']=$sitem['size_name'];
						$d['extra_text']=$sitem['extra_text'];
						$d['cod_text']=$sitem['cod_text'];
						$d['share_text']=$sitem['share_text'];
						// $d[$s]['market_price']=$sitem['product']['market_price'];
						// $d[$s]['my_earning']=$sitem['product']['my_earning'];
						$d['min_range']=0;
						$d['max_range']=0;
						$order_status=$d['order_status']=$sitem['order_status'];
						$d['order_id']=1;
						$d['track_code']=$sitem['track_code'];
						$cancel_type=$d['cancel_type']=$sitem['cancel_type'];
						$d['show_msg']=$this->showordermsg($order_status,$cancel_type);
						$d['time_left']="23";
						$d['product_name']=$sitem['name_en'];
						$order_utc=$sitem['order_utc'];
						// $order_date=date('Y-m-d H:i',$order_utc);
						$order_date=$d['order_date']=$sitem['order_date'];
						$extra_time = strtotime("+2880 minutes", strtotime($order_date));
						// $extra_time = strtotime("+4320 minutes", strtotime($order_date));
						// $d[$s]['order_utc']=$sitem['order_utc'];
						$d['order_utc']=$extra_time;
						if($sitem['shipment_pdf'])
						$d['invoice_pdf']="http://resellermantra.com/webroot/pdf/shipment.php?order_id=".$p_item_id;
						else
						$d['invoice_pdf']='';
						if($sitem['shipment_pdf'])
						$d['shipment_pdf']=$sitem['shipment_pdf'];
						else
						$d['shipment_pdf']='';
						$d['image']=Router::url('image/',true).$sitem['pic'];
		}
		return $d;
	}
	public function videolist()
	{
		if($this->request->is('post')){
			$request = $this->request->getData();
			// print_R($request);
			// die;
			extract($request);
			if($customer_id)
			{
				$Video = TableRegistry::get('Video');
				$videolist = $Video
				->find()
				// ->select(['id','children_count','thumbnail','name'])
				->order(['id'=>'DESC'])
				->where(['status ='=>'y'])->toArray();
				if(count($videolist)>0)
				{
					$i=0;
					foreach($videolist as $vi)
					{
						$v[$i]['id']=$vi['id'];
						$v[$i]['video_title']=$vi['video_title'];
						$v[$i]['video_title']=$vi['video_title'];
						$v[$i]['video_img']=Router::url('image/',true).$vi['video_img'];
						// $v[$i]['video_img']="http://resellermantra.com/image/2019/04/1555141356amazon4642.jpg";
						$link=$vi['video_url'];
						if($link)
						{
							$video_id = explode("?v=", $link); // For videos like http://www.youtube.com/watch?v=...
							if (empty($video_id[1]))
								$video_id = explode("/v/", $link); // For videos like http://www.youtube.com/watch/v/..

							$video_id = explode("&", $video_id[1]); // Deleting any other params
							$v[$i]['video_url']=$video_id = $video_id[0];
						}
						else
						{
							$v[$i]['video_url']='';
						}
						$i++;
					}

					 $reponse['status'] =true;
					$reponse['data'] =$v;
					$reponse['top_image'] ="http://resellermantra.com/img/Rewarded_video.png";
					$reponse['msg'] ="Video list id";
				}
				else
				{
				  $reponse['status'] =false;
				  $reponse['top_image'] ="http://resellermantra.com/img/Rewarded_video.png";
					$reponse['data'] ='';
					$reponse['msg'] ="Invalid Product id";
				}
			}
			else
			{
				$reponse['status'] =false;
				$reponse['data'] ='';
				$reponse['msg'] ="Required Parameter missing";
			}
		}
		else{
			$reponse['status'] =false;
			$reponse['data'] ='';
			$reponse['msg'] ="Invaid Type";
		}

		echo json_encode($reponse);
		die;
	}
	public function earning()
	{
	   if($this->request->is('post')){
			$request = $this->request->getData();
			extract($request);
			// $report_type summery-s,monthly-m, daily-d,weekly-w
			// statement_type account-a,sales-s
			if($customer_id && $user_type && $statement_type && $report_type)
			{
				$connection = ConnectionManager::get('default');
				$cashback_amount=$final_amount=$approval_amount=$process_amount=$total_payment=0;
			   // $total_amount=10000;
				if($statement_type=="a")
				{
					if($report_type=="m")
						{
							$filter=" YEAR(payment_date) = YEAR(NOW()) AND MONTH(payment_date)=MONTH(NOW()) and";
						}
						if($report_type=="w")
						{
							$filter=" WEEKOFYEAR(payment_date) = WEEKOFYEAR(NOW()) and";
						}
						if($report_type=="d")
						{
							$filter="date(payment_date)=curdate() and";
						}

						if($filter || $report_type=='s')
						{
							  $q="SELECT sum(total_amount) as sum_amount
									FROM payoff
									WHERE   $filter   user_id='$customer_id' and user_type='$user_type'  and payment_status in('paid')";

							 $total_amount = (int)$connection->execute($q)->fetch('assoc')['sum_amount'];



							 $process_amount=$total_amount;

						}
						if($report_type=="s")
						{
							   $q="SELECT *
									FROM payoff
									WHERE   $filter   user_id='$customer_id' and user_type='$user_type'  and payment_status in('paid')";
									// die;
							$recentorder = $connection->execute($q)->fetchAll('assoc');
						}
						else
						{
							if($report_type=="m")
							{
								 $squery="SELECT Sum(total_amount) AS Amount_Owed, DATE_FORMAT(payment_date, '%M %Y') AS m
										FROM payoff where  user_id='$customer_id' and user_type='$user_type' and payment_status in('paid')
										GROUP BY DATE_FORMAT(payment_date, '%Y-%m')  order by payment_date desc";

							}

							if($report_type=="d" || $report_type=='w')
							{
								  $squery="SELECT  Sum(total_amount) AS Amount_Owed, date(payment_date) AS m, WEEKOFYEAR(payment_date) AS week_number
									FROM payoff where user_id='$customer_id' and user_type='$user_type' and payment_status in('paid')
									GROUP BY m, week_number
									ORDER BY `m`  DESC";
								// die;
							}

							if($squery)
							$recorddata = $connection->execute($squery)->fetchAll('assoc');

							if($report_type=="w")
							{
								$temp = [];
									foreach($recorddata as $value) {
										//check if color exists in the temp array
										if(!array_key_exists($value['week_number'], $temp)) {
											//if it does not exist, create it with a value of 0
											$temp[$value['week_number']] = 0;
										}
										//Add up the values from each color

										$temp[$value['week_number']] += $value['Amount_Owed'];
									}
									$ci=0;
									foreach($temp as $key=>$v)
									{
										$week_array = $this->getStartAndEndDate($key,2019);

										 $w_s=$week_array['week_start'];
										$w_e=$week_array['week_end'];
										if($ci==0)
											$ri[$ci]['m']="Current Week";
										else
										$ri[$ci]['m']=date("d", strtotime($w_e))."-".date("d M Y", strtotime($w_s));
										$ri[$ci]['Amount_Owed']=$v;
										$ci++;
									}
								$recorddata=$ri;
							}
						}
						// pr($recorddata);
						// die;
					// echo $total_amount;
					// die;
					if($report_type=="s")
					{
						$s=0;
						// pr($recentorder);
						// die;
						foreach($recentorder as $order)
						{
							$order_type=$order['order_status'];
							$payment_type=$order['payment_type'];
							 $w_add=$order['payment_date'];

							if($order_type=="cashback")
							$e[$s]['key_name']="Cashback ".date("d M Y h:i A", strtotime($w_add));
							else
							$e[$s]['key_name']=date("d M Y h:i A", strtotime($w_add));
							if($payment_type=="deduct")
							$e[$s]['amount']="-".$order['total_amount'];
							else
							$e[$s]['amount']=$order['total_amount'];
							$s++;
						}

					}
					else
					{

						if(count($recorddata)>0)
						{
							$i=0;
							foreach($recorddata as $r)
							{
								$e[$i]['key_name']=$r['m'];

								$e[$i]['amount']=$r['Amount_Owed'];
								$i++;
							}
						}
						else
						{
							$e=[];
						}


					}

				}
				else if($statement_type=="s")
				{
						if($report_type=="m")
						{
							$filter=" YEAR(process_date) = YEAR(NOW()) AND MONTH(process_date)=MONTH(NOW()) and";
						}
						if($report_type=="w")
						{
							$filter=" WEEKOFYEAR(process_date) = WEEKOFYEAR(NOW()) and";
						}
						if($report_type=="d")
						{
							$filter="date(process_date)=curdate() and";
						}

						if($filter || $report_type=='s')
						{
							 $q="SELECT sum(amount) as sum_amount
									FROM user_transaction
									WHERE   $filter  payment_type='add' and user_id='$customer_id' and user_type='$user_type' and  hold_status='n' and  tras_status ='1' and payment_status in('requested','credited','approved','requestedpayment')";
							 $cash="SELECT sum(amount) as sum_amount
									FROM user_transaction
									WHERE   $filter  payment_type='add' and user_id='$customer_id' and user_type='$user_type'  and   hold_status='n' and  tras_status ='1' and  order_status='cashback' and payment_status in('credited')";

							$total_amount = (int)$connection->execute($q)->fetch('assoc')['sum_amount'];
							$cashback_amount = (int)$connection->execute($cash)->fetch('assoc')['sum_amount'];

							 $total_deduction = (int)$connection->execute("SELECT sum(amount) as sum_amount
									FROM user_transaction
									WHERE  $filter  payment_type='deduct' and user_id='$customer_id' and user_type='$user_type' and hold_status='n' and  tras_status ='1'  and payment_status='credited' and order_status='completed'")->fetch('assoc')['sum_amount'];

							  $process_amount=($total_amount+$cashback_amount)-$total_deduction;
							   $rq="SELECT sum(amount) as sum_amount
									FROM user_transaction
									WHERE   $filter  payment_type='add' and user_id='$customer_id' and user_type='$user_type' and hold_status='n' and  tras_status ='1'  and payment_status in('requested')";
							$on_process= (int)$connection->execute($rq)->fetch('assoc')['sum_amount'];

							}
						if($report_type=="s")
						{
							$approval_amount = (int)$connection->execute("select sum(amount) as sum_amount from user_transaction where user_id='$customer_id' and user_type='$user_type' and order_status='completed' and payment_status in('approved','requestedpayment') and hold_status='n' and  tras_status ='1' and payment_type='add'")->fetch('assoc')['sum_amount'];
							$cashback_amount = (int)$connection->execute("select sum(amount) as sum_amount from user_transaction where user_id='$customer_id' and user_type='$user_type' and order_status='cashback' and payment_status in('approved','requestedpayment') and hold_status='n' and  tras_status ='1'")->fetch('assoc')['sum_amount'];
							// $final_amount = (int)$connection->execute("select sum(amount) as sum_amount from user_transaction where  payment_type='add' and user_id='$customer_id' and user_type='$user_type' and order_status='completed' and payment_status in('credited') and hold_status='n' and  tras_status ='1'")->fetch('assoc')['sum_amount'];
							$approval_amount=$approval_amount-$total_deduction;
							// $final_amount=($final_amount+$cashback_amount)-$total_deduction;
							$unpaid_amount = (int)$connection->execute("select sum(total_amount) as sum_amount from payoff where user_id='$customer_id' and user_type='$user_type'  and payment_status in('unpaid')")->fetch('assoc')['sum_amount'];
						}
						else
						{
							if($report_type=="m")
							{
								 $squery="SELECT Sum(CASE payment_type
										WHEN 'add' THEN amount
										WHEN 'deduct' THEN -amount
										END) AS Amount_Owed, DATE_FORMAT(process_date, '%M %Y') AS m
										FROM user_transaction where  user_id='$customer_id' and user_type='$user_type' and payment_status in('requested','credited','approved','requestedpayment') and payment_type in('add','deduct') and hold_status='n' and  tras_status ='1'
										GROUP BY DATE_FORMAT(process_date, '%Y-%m')  order by process_date desc";

							}

							if($report_type=="d" || $report_type=='w')
							{
								 $squery="SELECT  Sum(CASE payment_type
									 WHEN 'add' THEN amount
									 WHEN 'deduct' THEN -amount
									END) AS Amount_Owed, date(process_date) AS m, WEEKOFYEAR(process_date) AS week_number
									FROM user_transaction where user_id='$customer_id' and user_type='$user_type' and payment_status in('requested','credited','approved','requestedpayment') and payment_type in('add','deduct') and hold_status='n' and  tras_status ='1'
									GROUP BY m, week_number
									ORDER BY `m`  DESC";
								// die;
							}

							if($squery)
							$recorddata = $connection->execute($squery)->fetchAll('assoc');

							if($report_type=="w")
							{
								$temp = [];
									foreach($recorddata as $value) {
										//check if color exists in the temp array
										if(!array_key_exists($value['week_number'], $temp)) {
											//if it does not exist, create it with a value of 0
											$temp[$value['week_number']] = 0;
										}
										//Add up the values from each color

										$temp[$value['week_number']] += $value['Amount_Owed'];
									}
									$ci=0;
									foreach($temp as $key=>$v)
									{
										$week_array = $this->getStartAndEndDate($key,2019);

										 $w_s=$week_array['week_start'];
										$w_e=$week_array['week_end'];
										if($ci==0)
											$ri[$ci]['m']="Current Week";
										else
										$ri[$ci]['m']=date("d", strtotime($w_e))."-".date("d M Y", strtotime($w_s));
										$ri[$ci]['Amount_Owed']=$v;
										$ci++;
									}
								$recorddata=$ri;
							}
						}
						// pr($recorddata);
						// die;
					// echo $total_amount;
					// die;
					if($report_type=="s")
					{
						$e[0]['key_name']="Order Approval";
						$e[0]['amount']=$approval_amount;
						$e[1]['key_name']="Order Processed";
						$e[1]['amount']=$on_process;
						if($unpaid_amount>0)
						{
							$e[2]['key_name']="Unpaid Amount";
							$e[2]['amount']=$unpaid_amount;
						}
						if($cashback>0)
						{
							$e[2]['key_name']="CashBack Amount";
							$e[2]['amount']=$cashback_amount;
						}

					}
					else
					{
						if(count($recorddata)>0)
						{
							$i=0;
							foreach($recorddata as $r)
							{
								$e[$i]['key_name']=$r['m'];

								$e[$i]['amount']=$r['Amount_Owed'];
								$i++;
							}
						}
						else
						{
							$e=[];
						}


					}
				}

				$reponse['status']	=	true;
				$reponse['data']	=$e;
				if($process_amount<0)
					$process_amount=0;
				$reponse['total_amount']	=$process_amount;
				$reponse['msg'] 	=	"data";

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
	function getStartAndEndDate($week, $year) {
  $dto = new \DateTime();
  $dto->setISODate($year, $week);
  $ret['week_start'] = $dto->format('Y-m-d');
  $dto->modify('+6 days');
  $ret['week_end'] = $dto->format('Y-m-d');
  return $ret;
}
	// all shyplite code
	public function shypliteplaceorderdummy()
	{
		$d['shyplite_order_id']=188047;
		$d['shyplite_amount']=148;
		$d['shyplite_selected_mode']="Air";
		$d['status']=true;
        return $d;
	}
	function authenticatShyplite($timestamp) {
    // $email =  "sam.sourabh@gmail.com";
    // $password = "12345678";


    // $appID = 2383;
    // $sellerid = 9600;
    // $key = 'WWu9nhly2i0=';
    // $secret = 'G8zu5XIDJyqBNcZEOpnq7b6XbCXPYABWG3yR+JvOkXS67P3I6zruusw4Z7f2Qt5wbncrhuCIKNqPZzqnIk84rw==';
	 $email =  "resellermantra@gmail.com";
    $password = "goldopium*1";


    $appID = 2812;
    $sellerid = 15288;
    $key = 'IQl7NMvNFTw=';
    $secret = '6blpiawaAKCgo804JU95aOsh0bPu63ibBFVZRycr+/G+4/SEX8kM+TQA6liAExsHlNRO45wQzeh0raimrqVMjw==';

    $sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
    $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
    $ch = curl_init();

    $header = array(
        "x-appid: $appID",
        // "x-sellerid   : $sellerid",
        "x-timestamp: $timestamp",
        "Authorization: $authtoken"
    );

    curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/login');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "emailID=$email&password=$password");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
	$server_output=json_decode($server_output, true);
	// print_R($server_output);
	// die;
	   if($server_output['userToken'])
	   {
		   $s['userToken']=$server_output['userToken'];
		   $s['authtoken']=$authtoken;
		   $s['sellerid']=$sellerid;
		   $s['appID']=$appID;
		   $s['key']=$key;
		   $s['status']=true;

	   }
	   else
	   {
		     $s['status']=false;
	   }
	   return $s;
		curl_close($ch);
	}
	public function shypliteplaceorder($o)
	{
		// pr($o);
		// die;
	    $flag=false;
		$ship_status=$o['ship_status'];
		 $payment_method=$o['payment_method'];
		// 1 for cod, 2 for cash
		$modelist=[];
		if($ship_status)
		{
			if($payment_method==1)
				$orderType_id=1;
			else if($payment_method==2)
				$orderType_id=2;
			$s=json_decode($ship_status,true);

			if($s)
			{
				if($payment_method==1)
				{
					if($s['airCod'])
					{
						$k['key']=1;
						$k['value']="Air";
						$modelist[]=$k;
					}
					if($s['lite2kgCod'])
					{
						$k['key']=3;
						$k['value']="Lite-2kg";
						$modelist[]=$k;
					}
					if($s['lite1kgCod'])
					{
						$k['key']=8;
						$k['value']="Lite-1kg";
						$modelist[]=$k;
					}
					if($s['liteHalfKgCod'])
					{
						$k['key']=9;
						$k['value']="Lite-0.5kg";
						$modelist[]=$k;
					}

				} else if($payment_method==2)
				{
					if($s['airPrepaid'])
					{
						$k['key']=1;
						$k['value']="Air";
						$modelist[]=$k;
					}
					if($s['lite2kgPrepaid'])
					{
						$k['key']=3;
						$k['value']="Lite-2kg";
						$modelist[]=$k;
					}
					if($s['lite1kgPrepaid'])
					{
						$k['key']=8;
						$k['value']="Lite-1kg";
						$modelist[]=$k;
					}
					if($s['liteHalfKgPrepaid'])
					{
						$k['key']=9;
						$k['value']="Lite-0.5kg";
						$modelist[]=$k;
					}
				}

			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		//first calculate best price then go ahead for place order with courier
		// $modelist=array('1'=>'Air','3'=>'Lite-2kg','8'=>'Lite-1kg','9'=>'Lite-0.5kg');
		// $modelist=array('1'=>'Air');
		$p=[];

		// pr($modelist);
		// die;
		foreach($modelist as $s=>$sval)
		{

			$key=$sval['key'];
			extract($o);
			$data = array(
                "sourcePin"=> $sourcePin,
                "destinationPin"=>$destinationPin,
                "orderType"=>$orderType_id,
                "modeType"=> $key,
                "length"=> $packageLength,
                "width"=> $packageWidth,
                "height"=> $packageHeight,
                "weight"=>$packageWeight,
                "invoiceValue"=>$totalValue
            );
			      // pr($data);
				  // die;
			 $data_json = json_encode($data);
			if($data_json)
			{
				$timestamp = time();
				$auth=$this->authenticatShyplite($timestamp);
				// pr($auth);
				if($auth['status'])
				{
					$appID=$auth['appID'];
					$sellerid=$auth['sellerid'];
					$userToken=$auth['userToken'];
					$key=$auth['key'];
					$sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
					$authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $userToken, true)));
					$header = array(
						"x-appid: $appID",
						"x-sellerid:$sellerid",
						"x-timestamp: $timestamp",
						"Authorization: $authtoken",
						"Content-Type: application/json",
						"Content-Length: ".strlen($data_json)
					);

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/calculateprice');
					curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
					curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
					curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$response  = curl_exec($ch);
					$res=json_decode($response,true);
					// pr($res);
					// die;
					if($res['calculatedPrice'])
					{
						$r['calculatedPrice']=$res['calculatedPrice'];
						$r['mode_type']=$sval['value'];
						$sample[]=$r;
					}


				}

			}

		}
		// pr($sample);
		// die;
		$minamount = min($sample);
		if($minamount['calculatedPrice']>0)
		{
			$modeType=$minamount['mode_type'];
			// place order
			$order_data = array( 'orders'=> [
					array(
						"orderId"=>$orderId,
						"customerName"=>$customerName,
						"customerAddress"=>$customerAddress,
						"customerCity"=>$customerCity,
						"customerPinCode"=> $destinationPin,
						"customerContact"=>$customerContact,
						"orderDate"=>$orderDate,
						"modeType"=>$modeType,
						"orderType"=>$orderType,
						"totalValue"=>$totalValue,
						// "totalValue"=>1,
						"categoryName"=>$categoryName,
						"packageName"=>$packageName,
						"quantity"=>$quantity,
						"packageLength"=>$packageLength,
						"packageWidth"=>$packageWidth,
						"packageHeight"=> $packageHeight,
						"packageWeight"=> $packageWeight,
						"sellerAddressId"=>$sellerAddressId
					)
				]);
			 $order_json = json_encode($order_data);
			 // pr($order_data);
			 // die;
			$header = array(
						"x-appid: $appID",
						"x-sellerid:$sellerid",
						"x-timestamp: $timestamp",
						"Authorization: $authtoken",
						"Content-Type: application/json",
						"Content-Length: ".strlen($order_json)
					);

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/order');
			curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
			curl_setopt($ch, CURLOPT_POSTFIELDS,$order_json);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$order_res  = curl_exec($ch);
			$order_res=json_decode($order_res, true);
			// pr($order_res);
			// pr($order_res[0]['error']);
			// die;

			// $order_res[0]['success']="10002";
			if($order_res[0]['success'])
			{
				$flag=true;
				$msg="Order Place Successfully";
				$order_track_id=$data['order_track_id']=$order_res[0]['success'];
				// after placing order get shipment slip

					$secret=$auth['userToken'];
						$sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
						$authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
						$ch = curl_init();
						$header = array(
							"x-appid: $appID",
							"x-timestamp: $timestamp",
							"x-sellerid:9600",
							"Authorization: $authtoken"
						);
					   // $order="10104";
						curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/getSlip?orderID='.urlencode($orderId));
						curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						$cresponse = curl_exec($ch);
						$slip_json=json_decode($cresponse,true);
						if($slip_json['carrierName'] && ($slip_json['status']=="success" || $slip_json['status']=="pending"))
						{
						$data['carrierName']=$slip_json['carrierName'];
						$data['awbNo']=$slip_json['awbNo'];
						$manifestID=$data['manifestID']=$slip_json['manifestID'];

						$url=$slip_json['s3Path'][0];
						$uni_id=$orderId."_shipment";
						if($url)
						$data['shipment_pdf']=$this->downloadfile("shipment",$url,$uni_id);
						// $data['shipment_pdf']=$slip_json['s3Path'];
						if($manifestID)
						{
							curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/getManifestPDF/'.$manifestID);
							curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$server_output = curl_exec($ch);
							$mainfest_json=json_decode($server_output, true);
							if($mainfest_json['s3Path'])
							{

								$url=$mainfest_json['s3Path'];
								$uni_id=$orderId."_mainfest";
								if($url)
								$data['mainfest_pdf']=$this->downloadfile("mainfest",$url,$uni_id);
							}
						}
					}
					// get mainfest slip

				// $data['shyplite_order_id']=$order_res[0]['success'];
				$data['courier_charge']=$minamount['calculatedPrice'];
				$data['mode_type']=$minamount['mode_type'];
			}
			else
			{
				$flag=false;
				$msg=$order_res[0]['error'];
			}
			// die;
			curl_close($ch);
		}
		else
		{
			$flag=false;
			$msg="Can't able to find Shipping company";
		}
		// pr($data);
		// die;
		$r['status']=$flag;
		$r['msg']=$msg;
		$r['data']=$data;
		return $r;
	}
	public function addnotification($n)
	{
		$Noti = TableRegistry::get('Notification');
		$entity =	$Noti->newEntity($n);
		$trasresult	=	$Noti->save($entity);
	}
	public function addtransaction($t)
	{
		// pr($t);
		// die;
		$Tras = TableRegistry::get('Transaction');
		$entity =	$Tras->newEntity($t);
		$trasresult	=	$Tras->save($entity);
	}

	public function smstest()
	{
		$mobile="+919001025477";
		$sms="http://panel.apiwha.com/img/cat.jpg";
		$this->sendsms($sms,$mobile,"");
	}
	public function sendsms($message,$destination,$registrationIds)
	{

		$my_apikey = "UOWALZAO8KLT6Y574YKF";
		// $destination =$destination;
		$destination="+91".$destination;
		// $message = "Hello Welcome Api";
		$api_url = "http://panel.capiwha.com/send_message.php";
		$api_url .= "?apikey=". urlencode ($my_apikey);
		$api_url .= "&number=". urlencode ($destination);
		$api_url .= "&text=". urlencode ($message);
		$my_result_object = json_decode(file_get_contents($api_url, false));
		// pr($my_result_object);
		// die;
		// if($registrationIds)
		// $this->sendMessageThroughGCM($registrationIds,$message);
	}
		//Generic php function to send GCM push notification
	function sendMessageThroughGCM($registrationIds, $fcmMsg) {
		       define( 'API_ACCESS_KEY', 'AIzaSyA0VndTr9B3Zhc9kWwDFgQSY7zC4BlSWZE');
				$fcmFields = array(
						'to' => $registrationIds,
							'priority' => 'high',
						'notification' => $fcmMsg,
						'data' => $fcmMsg,
						'andriod'=>array(
						   'ttl'=>3600 * 1000,
							'priority'=> 'normal',
					   'notification'=>$fcmMsg
						)
					);
					// print_R($fcmFields);
					// die;
					$fields = array("to" =>$registrationIds,
										"data" => array("data"=>$fcmMsg,
														 "body"=>$fcmMsg['body'],
														 "title"=>$fcmMsg['title'],
														 "type"=>$fcmMsg['type'],
														 "img"=>$fcmMsg['img'],
														 'link'=>$fcmMsg['link']
														)


										);
					// print_R($fields);
					// die;
					$headers = array(
						'Authorization: key=' . API_ACCESS_KEY,
						'Content-Type: application/json'
					);

					$ch = curl_init();
					curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
					curl_setopt( $ch,CURLOPT_POST, true );
					curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
					curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
					curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
					curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
					$resultpush = curl_exec($ch );
					// print_R($resultpush);
					// die;
					if ($result === FALSE) {
					// die('Curl failed: ' . curl_error($ch));
					$value = 'Curl failed: ' . curl_error($ch);
					}
					else
					{
					$value = $resultpush;
					}
					curl_close( $ch );
					// echo $value;
					// die;
					return $value;

	}
	function cancelshyliteorder()
	{

	}
	function serviceability($pick_pin,$dest_pin)
	{

		// $pick_pin=$this->request->getQuery('p');
		// $dest_pin=$this->request->getQuery('d');
		if($pick_pin && $dest_pin)
		{
		$timestamp = time();
		$auth=$this->authenticatShyplite($timestamp);
				// pr($auth);
				// die;
				if($auth['status'])
				{
					$appID=$auth['appID'];
					$sellerid=$auth['sellerid'];
					$userToken=$auth['userToken'];
					$key=$auth['key'];
					$sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
					$authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $userToken, true)));
					$header = array(
						"x-appid: $appID",
						"x-sellerid:$sellerid",
						"x-timestamp: $timestamp",
						"Authorization: $authtoken",
						// "Content-Type: application/json",
						// "Content-Length: ".strlen($data_json)
					);
					 $url="https://api.shyplite.com/getserviceability/".$pick_pin."/".$dest_pin;
					 $ch = curl_init();

					$header = array(
						"x-appid: $appID",
						"x-timestamp: $timestamp",
						"x-sellerid:$sellerid",
						"Authorization: $authtoken"
					);

					curl_setopt($ch, CURLOPT_URL,$url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					$server_output = curl_exec($ch);
					$res=json_decode($server_output,true);
					// pr($res);
					// die;
					// $res=$res;
					$res=$res['serviceability'];
					// return $res;
					curl_close($ch);
				}
		}
		else
		{
		    $res=[];
		}
		// pr($res);
		// die;
		return $res;
		// die;
	}
	public function cartstatusbyaddress()
	{
		 if($this->request->is('post')){
			$request = $this->request->getData();
			// pr($request);
			extract($request);
			if($quote_id && $address_id && $customer_id)
			{
				$connection = ConnectionManager::get('default');

				 $q="select  qt.*,a.zipcode from sales_flat_quote_item as qt inner  join customer_address_entity as a  on a.entity_id=qt.seller_address_id where qt.quote_id='$quote_id'
				and qt.customer_id='$customer_id' and qt.process_status='oncart'";
				// die;
				$result = $connection->execute($q)->fetchAll('assoc');
				// pr($result);
				// die;
				if($result)
				{

					$AddresTable 	=	TableRegistry::get('Address');
					$customeradd = $AddresTable->find()->select(['zipcode'])->where(['entity_id'=>$address_id])->first();
					if($customeradd)
					{
						$customer_pin=$customeradd->zipcode;
						foreach($result as $r)
						{
							$item_id=$r['item_id'];
							$seller_pin=$r['zipcode'];
							$res=$this->serviceability($seller_pin,$customer_pin);
							// pr($res);
							// die;
							extract($res);

							if($airPrepaid==1 || $lite2kgPrepaid==1 || $lite1kgPrepaid==1 || $liteHalfKgPrepaid==1)
							{
								$res_json=json_encode($res);
								// pr($res_json);
								// die;
								 $query="UPDATE `sales_flat_quote_item` SET `ship_available` = '1',ship_status='$res_json' where item_id='$item_id'";
								// die;
								$q2 = $connection->execute($query);
							}
							else
							{
								 $query="UPDATE `sales_flat_quote_item` SET `ship_available` = '0' where item_id='$item_id'";
								 $q2 = $connection->execute($query);
							}




						}
						$data=$this->getShipCart($customer_id,$quote_id);
						$reponse['status']	=	true;
						$reponse['data']	=$data;
						$reponse['msg'] 	=	"Status  updated";
					}
					else
					{
						$reponse['status']	=	false;
						$reponse['data']	=	"";
						$reponse['msg'] 	=	"Without Customer Pin code  cant go ahead";
					}
				}
				else
				{
					$reponse['status']	=	false;
					$reponse['data']	=	"";
					$reponse['msg'] 	=	"Your Cart is empty";
				}

    		}

			else
			{
				$reponse['status']	=	false;
				$reponse['data']	=	"";
				$reponse['msg'] 	=	"Required Parameter Missing";
			}
		 }
		  else{
			$reponse['status']	=	false;
			$reponse['data']	=	"";
			$reponse['msg'] 	=	"Invalid Data Type";
		}
		echo json_encode($reponse);die;
	}

	function getShipCart($customer_id,$quote_id){
    	// $customer_id = $this->request->getData('customer_id');
    	// $quote_id = $this->request->getData('quote_id');
    	if((int)$customer_id>0){
    		$table = TableRegistry::get('Quote');
    		$cart = $table->find()->where(['customer_id'=>$customer_id,'entity_id'=>$quote_id])->contain(['QuoteItem'=>function($q){
    				return $q->select(['ship_status','size_name','ship_available','primary_price','share_text','name','item_id','product_id','price','base_price','quote_id','qty','off','extra_text','cod_text','market_price','my_earning','market_string','shipping_charges','cod'])
					->where(['process_status'=>'oncart','ship_available IN'=>['0','1']]);
    		}
    	])
    	->all();
		// pr($cart);
		// die;
		$StockTable = TableRegistry::get('Stock');
    		$msg="Get cart";
    		foreach ($cart as $key => $items) {
				// pr($items);
    			$data['quote_id']=$items->entity_id;
	    		$data['items_count']=$items->items_count;
	    		$data['grand_total']=$items->grand_total;
	    		$data['customer_id']=$items->customer_id;

	    		if(!empty($items->quote_item)){
		    		foreach ($items->quote_item as $key => $value) {
						$size_id=$value['size_id'];
						$item_id=$item['item_id'] = $value['item_id'];
						$stockdata = $StockTable
						->find()
						// ->select(['id','fullname'])
						->where(['id'=>$size_id])
						->first();
						// pr($stockdata);
						// die;
						$pending_stock=$stockdata->pending_stock;
						if($pending_stock==0)
						{
							$query="UPDATE sales_flat_quote_item SET `ship_available` = '3' where item_id='$item_id'";
						}
						$product_id = $value['product_id'];
							$product = $this->getProduct($product_id);
							$item['product_id'] = $value['product_id'];
							$item['name'] = $product->name_en;
							$item['thumbnail'] = Router::url('image/',true).$product->pic;
							$item['primary_price'] =$value['primary_price'];
							$item['base_price'] =$value['base_price'];
							$item['size'] =$value['size_name'];
							$item['selling_price'] = $value['price'];
							$item['amount'] = $value['price'];
							$item['off'] = $value['off'];
							$item['extra_text'] = $value['extra_text'];
							$item['cod_text'] = $value['cod_text'];
							$item['share_text'] = $value['share_text'];
							$item['market_price'] = $value['market_price'];
							$item['ship_available'] = $value['ship_available'];


							if($value['ship_available']=='0')
							{
								$ship_msg="Product is Not  avilable for selected address";
							}
							else if($value['ship_available']=='3')
							{
								$ship_msg='';
							}
							else
							{
								$ship_msg='';
							}
							$item['ship_msg'] = $ship_msg;
							$item['my_earning'] = $value['my_earning'];
							$item['market_string'] = $value['market_string'];
							$item['min_range'] = 0;
							$item['max_range'] = 0;
							if($value['shipping_charges']==0)
							{
								$item['extra_text']="FREE SHIPPING";
							}
							else
							{
								$item['extra_text']='';
							}
							if($value['cod'])
							{
								$item['cod_text']="COD AVAILABLE";
							}
							else
							{
								$item['cod_text']='';
							}

								$item['qty'] = $value['qty'];
							$data['cart_item'][] = $item;



    				}
    			}
    			else{
    				$response=[];
    			}
    		}
    		$response=$data;

    	}
    	else{
    		$response=[];
    	}
		return $response;
    	//echo json_encode($response);die;
    }

}
