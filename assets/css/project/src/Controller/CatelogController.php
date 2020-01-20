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

class CatelogController extends AppController
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
	function stockdetail()
	{
		$this->viewBuilder()->layout(false);
		$conn = ConnectionManager::get('default');
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			extract($request);
			if($id)
			{
				 $StockTable = TableRegistry::get('Stock');
				 $stockdata=$StockTable->find()
				  ->contain(['AttributeOptionValue'])
				 ->where(['id'=>$id])->first();
				 // pr($stockdata);
			  $data = $conn->execute("select * from stock_data where stock_id='$id' and s_type='stockrefill' order by id ASC limit 0,10")->fetchAll('assoc');
			$this->set(compact('stockdata','data'));	 // die;
			}
			if($stock_id)
			{
				pr($request);
				die;
			}
		}
	}
	function addstock()
	{

	}

	function uploadedcatelog()
	{
		$conn = ConnectionManager::get('default');
		$doc_data = $conn->execute("select c.*,u.mobile,u.id as u_id,u.display_name from catelog_upload as c inner join users as u on u.id=c.user_id order by c.id desc")->fetchAll('assoc');;
		// pr($cat_list);
		// die;
		$this->set(compact('doc_data'));
	}
	function  upload()
	{
		$Uploadcatelog = TableRegistry::get('Uploadcatelog');
		 $user_id=$this->Auth->user('id');

		$doc_data	=	$Uploadcatelog->find()->where(['user_id'=>$user_id])->toArray();
		$this->set(compact('doc_data'));
		if ($this->request->is('post')) {
			$request = $this->request->getData();
			extract($request);
			if($request && $user_id)
			{
				$current_date=date('Y-m-d H:i:s');
				$current_utc=strtotime($current_date);
				if($_FILES['catelog_file'])
				{
					$catelog_file = $this->uploadcatelog($_FILES['catelog_file']);
					$image_folder = $this->uploadcatefolder($_FILES['image_folder']);
					if($catelog_file)
					{
						$request['catelog_file'] = !empty($catelog_file)?$catelog_file:'';
						$request['image_folder'] = !empty($image_folder)?$image_folder:'';
						$request['upload_utc']=$current_utc;
						// pr($request);
						// die;
						$CatelogEntity = $Uploadcatelog->newEntity($request);
						$result = $Uploadcatelog->save($CatelogEntity);
						if($result){
								$this->Flash->set('Catelog Uploaded Successfully, Our Team will update you asap', ['element' => 'success','class'=>'success']);
						}
						else
						{
							$this->Flash->set('Faile to update catelog File', ['element' => 'error','class'=>'error']);
						}
					}
					else
					{
						$this->Flash->set('Catelog File is missing', ['element' => 'error','class'=>'error']);
					}
				}
				else
				{
					$this->Flash->set('Catelog File is missing', ['element' => 'error','class'=>'error']);
				}
			}
			else
			{
				$this->Flash->set('Required Parameter missing', ['element' => 'error','class'=>'error']);
			}
			return $this->redirect([ 'action' => 'upload']);
		}

	}
	function uploadcatefolder($file=''){
    	if(!empty($file) && $file['error']==0){
    		$source = $file['tmp_name'];
    		$sub_dir = date('Y')."/".date('m')."/";
    		$dir = WWW_ROOT."catelog_folder/".$sub_dir;
    		if(!file_exists($dir)){
    			mkdir($dir,0777,true);
    		}
    		$name = time().str_replace(" ", "-", $file['name']);

    		move_uploaded_file($source, $dir.$name);
    		return $sub_dir.$name;
    	}

    }
	function uploadcatelog($file=''){
    	if(!empty($file) && $file['error']==0){
    		$source = $file['tmp_name'];
    		$sub_dir = date('Y')."/".date('m')."/";
    		$dir = WWW_ROOT."catelog_doc/".$sub_dir;
    		if(!file_exists($dir)){
    			mkdir($dir,0777,true);
    		}
    		$name = time().str_replace(" ", "-", $file['name']);

    		move_uploaded_file($source, $dir.$name);
    		return $sub_dir.$name;
    	}

    }
	function bellcatelog($id)
	{
		$conn = ConnectionManager::get('default');
		$CatelogTable = TableRegistry::get('Catelog');
		$request = $CatelogTable->find()->select(['id','name_en','description','share_text','pic'])->where(['id'=>$id])->first();
		$image=$request['pic'];
		$url_link="http://resellermantra.com/image/".$image;

		$message=    array(
							"title"=>"Share New Catalogue",
							"body"=>$request['name_en'],
							"type"=>"catelog",
							"itemid"=>"10017",
							"user_type"=>"1",
							"img"=>$url_link,
							"is_background"=>false,
							'link'=>$url_link,
							// "payload"=>array("my-data-item"=>"my-data-value"),
							"timestamp"=>date('Y-m-d G:i:s'),
							"id"=>$id,
							"catelog_id"=>$id,
							"name_en"=>$request['name_en'],
							"name_hn"=>" ",
							"description"=>$request['description'],
							"share_text"=>$request['share_text']
						);
		// pr($message);
		// die;
		$this->sendpush($message);
		return $this->redirect([ 'action' => 'index']);
	}
	function changecatelogstatus($status,$id)
	{
		$conn = ConnectionManager::get('default');
		$CatelogTable = TableRegistry::get('Catelog');
		$request = $CatelogTable->find()->select(['id','name_en','description','share_text','pic'])->where(['id'=>$id])->first();
		if($status=="live")
		{
			$image=$request['pic'];
		  $v_status=1;


		}
		if($status=="block")
		{
		  $v_status=2;
		}
		$cat_list = $conn->execute("UPDATE catalog_catelog_entity SET `status` = '$v_status' WHERE `catalog_catelog_entity`.`id`='$id'");
		$cat_list2 = $conn->execute("UPDATE catalog_product_entity SET `status` = '$v_status' WHERE `catalog_product_entity`.`catelog_id`='$id'");
		$this->redirect(['action' => 'index']);
	}
	function editcatelog($catelog_id)
	{
		$this->viewBuilder()->layout(false);
		$CatelogTable = TableRegistry::get('Catelog');
		$cdetail = $CatelogTable->find()->where(['id'=>$catelog_id])->first();
		// pr($cdetail);
		// die;
		$this->set(compact('cdetail'));
		if ($this->request->is('post')) {
			if($cdetail)
			{
				// pr($_FILES['pic']);
				// die;
				$request = $this->request->getData();
				// pr($request);
				// die;
				extract($request);
				if($cdetail->seller_id!=$seller_id)
				{
					$cdetail->seller_id=$seller_id;
					$cdetail->seller_address_id=$seller_address_id;

				}


					// if offer applied then have to change selling price_added
					$s_val=$request['primary_price']+$request['price_added'];
					if($offer_id>0)
					{
						$offerTable = TableRegistry::get('Offer');
						$offer =$offerTable
						->find()
						// ->select(['id','path','level','children_count','position','name','is_active'])
						->where(['id ='=>$offer_id])->first();
						$offer_type=$offer['offer_type'];

						$s_price=($s_val*100)/(100-$offer['offer_value']);
						  $s_price=round($s_price);

						$base_price=$request['base_price']=(int) $s_price;
						$selling_price=$cdetail->selling_price=$s_val;

						$request['offer_amount']=$offer['offer_value'];
						$offer_amount=$cdetail->offer_amount=$request['offer_amount'];
						$cdetail->offer_id=$offer_id;
						$cdetail->off=$offer['offer_value'];
					}
					else
					{
						$base_price=$request['base_price']=(int) $request['primary_price']+$request['price_added'];
					}
					$base_price=$cdetail->base_price=$base_price;
				$max_earning= (int)((($max_ratio / 100) * $base_price)+$base_price);

				$cdetail->max_earning=$max_earning;
				$cdetail->base_price=$base_price;
				// echo $base_price;
				// die;
				// pr($cdetail);
				// die;
				if($cdetail->percantage_value!=$percantage_value)
				$cdetail->percantage_value=$percantage_value;
				if($_FILES['pic']['name'])
				{

					 $image = $this->uploadImage($_FILES['pic']);
					$cdetail->pic = !empty($image)?$image:'';
				}
				else
				{
					$image=$cdetail->pic;
				}


				if(isset($_FILES['img_guarantee']))
				{
					$img_guarantee = $this->uploadImage($_FILES['img_guarantee']);
					$cdetail->img_guarantee = !empty($img_guarantee)?$img_guarantee:'';
				}
				else
				{
					$img_guarantee=$cdetail->img_guarantee;
				}
			    if($cdetail->img_height!=$img_height)
				$cdetail->img_height=$img_height;
				if($max_ratio)
				$cdetail->max_ratio=$max_ratio;
				if($cdetail->offer_id!=$offer_id)
				$cdetail->offer_id=$offer_id;
				if($cdetail->name_en!=$name_en)
				$cdetail->name_en=$name_en;
				if($cdetail->description!=$description)
				$cdetail->description=$description;
				if($cdetail->style_id!=$style_id)
				$cdetail->style_id=$style_id;
				//  update all field value
				if($cdetail->primary_price!=$primary_price)
				$cdetail->primary_price=$primary_price;
				if($cdetail->price_added!=$price_added)
				$cdetail->price_added=$price_added;
				// if($cdetail->selling_price!=$selling_price)
				$cdetail->selling_price=$selling_price;
				if($cdetail->shipping_charges!=$shipping_charges)
				$cdetail->shipping_charges=$shipping_charges;
				if($cdetail->youtube_link!=$youtube_link)
				$cdetail->youtube_link=$youtube_link;
				if($cod=="on")
				{
				$cdetail->cod=1;
				$cod=1;
				}
				else
				{
				$cdetail->cod=0;
				$cod=0;
				}
				if($return_applicable=="on")
				{
				$cdetail->return_applicable=1;
				$return_applicable=1;
				}
				else
				{
				$cdetail->return_applicable=0;
				$return_applicable=0;
				}
				if($top_catelog=="on")
				{
				$cdetail->top_catelog=1;
				$top_catelog=1;
				}
				else
				{
				$cdetail->top_catelog=0;
				$top_catelog=0;
				}

				//
				// $max_earning=$cdetail->max_earning= (int)((($max_ratio / 100) * $primary_price)+$primary_price);
				if($cdetail->max_ratio!=$max_ratio)
				$cdetail->max_ratio=$max_ratio;
				if($cdetail->policy_id!=$policy_id)
				$cdetail->policy_id=$policy_id;
				if($cdetail->return_rule!=$return_rule)
				$cdetail->return_rule=$return_rule;
				if($cdetail->mode_id!=$mode_id)
				$cdetail->mode_id=$mode_id;
				if($cdetail->packageLength!=$packageLength)
				$cdetail->packageLength=$packageLength;
				if($cdetail->packageWidth!=$packageWidth)
				$cdetail->packageWidth=$packageWidth;
				if($cdetail->packageHeight!=$packageHeight)
				$cdetail->packageHeight=$packageHeight;
				if($cdetail->packageWeight!=$packageWeight)
				$cdetail->packageWeight=$packageWeight;
			// pr($cdetail);
			// die;
				// pr($request['category_node']);
				// die;
			    if(isset($request['category_node'])){
					$this->setCatelogCategory($request['category_node'],$catelog_id);
				}

			   if(!empty($request['newselectstyle']))
				{
					$selectvalue=$request['newselectvalue'];
					$j=0;
					$attrTable = TableRegistry::get('ProductVarchar');
					foreach($request['newselectstyle'] as $attr_data)
					{
						// pr($attr_data);
						if($attr_data!="--Select--")
						{
						$attr_insert_data=['attribute_id'=>$attr_data,'entity_id'=>$catelog_id,'value'=>$selectvalue[$j]];
							$attr_entity = $attrTable->newEntity($attr_insert_data);
							$attrTable->save($attr_entity);
						$j++;
						}
						// pr($attr_insert_data);
					}
				}

				if($CatelogTable->save($cdetail))
				{
					// update product too
					// $name_en=mysql_real_escape_string($name_en);
					$connection = ConnectionManager::get("default");
					   $q="UPDATE catalog_product_entity SET offer_id='$offer_id',offer_amount='$offer_amount',cod='$cod',top_catelog='$top_catelog',return_applicable='$return_applicable',name_en='".$name_en."',primary_price='$primary_price',base_price='$base_price'
					,percantage_value='$percantage_value',price_added='$price_added',selling_price='$selling_price',shipping_charges='$shipping_charges'
					,seller_id='$seller_id',seller_address_id='$seller_address_id',cod='$cod',max_earning='$max_earning',max_ratio='$max_ratio' WHERE catelog_id ='$catelog_id'";

					$query = $connection->execute($q);
					$this->Flash->success('Catelog updated successfully');
				}
				else
				{
					$this->Flash->error('Failed to update Catelog');
				}

			}
			return $this->redirect([ 'action' => 'editcatelog',$catelog_id]);
		}
		else
		{

			if($cdetail)
			{

				 $this->viewBuilder()->setLayout(false);
				 $Attributestyle = TableRegistry::get('Attributestyle');
				 $selected_categories = $this->getCatelogCategory($catelog_id);
				 // pr($selected_categories);
				 // die;
				$root_category = $this->getRootCategory();

				$attribute_column = $this->getAttributes(0,"catelog");
				$UserTable = TableRegistry::get('Users');
				$AttributeTable = TableRegistry::get('Attribute');

				$userdata = $UserTable
				->find()
				->select(['id','fullname','display_name'])
				->where(['is_suplier'=>'y',"status"=>'active'])->toArray();
				// print_R($userdata);
				// die;
				$Templatestyle = TableRegistry::get('Templatestyle');
				$returnpolicylist = $Templatestyle->find()->where(['policy_for'=>"return"])->toArray();
				$codrule = $Templatestyle->find()->where(['policy_for'=>"cod"])->toArray();
				// print_R($returnpolicylist);
				// die;
				$offerTable = TableRegistry::get('Offer');
				$offerlist = $offerTable->find()->toArray();
				$widthstyle = $Attributestyle
				->find()
				->where(['style_type'=>'imgheight'])->toArray();
				// print_R($att_style);die;
				$Mode = TableRegistry::get('Mode');
				$mode_style = $Mode
				->find()
				->where(['status'=>'y'])->toArray();

			$attribute_column = $this->getAttributes2($catelog_id,"catelog");
			// pr($att_style);
			// die;
			$style_id=$cdetail['style_id'];
			if($style_id)
			$attrlist = $AttributeTable->find('all')->where(['att_type'=>'catelog','style_id'=>$style_id])->toArray();
			foreach($attrlist as $atr)
			{

			// die;
				$re[$i]['attribute_code']=$atr['attribute_id'];
				$re[$i]['frontend_label']=$atr['frontend_label'];
				$i++;
			}
			$att_style = $Attributestyle
				->find()
				->where(['style_type'=>'other'])->toArray();
			// pr($att_style);
			// die;
				$this->set(compact('attribute_column','re','att_style','userdata','returnpolicylist','codrule','offerlist','widthstyle','mode_style','root_category','selected_categories'));
				// manage size varient
			}
			else
			{
				$this->redirect(['action' => 'index']);
			}
		}



	}
  function add(){
    $this->viewBuilder()->setLayout(false);
		$root_category = $this->getRootCategory();
    	$attribute_column = $this->getAttributes(0,"catelog");
		$UserTable = TableRegistry::get('Users');
		$AttributeTable = TableRegistry::get('Attribute');

		$userdata = $UserTable
	    ->find()
	    ->select(['id','fullname','display_name'])
	    ->where(['is_suplier'=>'y',"status"=>'active'])->toArray();
		// print_R($userdata);
		// die;
		$Templatestyle = TableRegistry::get('Templatestyle');
		$returnpolicylist = $Templatestyle->find()->where(['policy_for'=>"return"])->toArray();
		$codrule = $Templatestyle->find()->where(['policy_for'=>"cod"])->toArray();
		// print_R($returnpolicylist);
		// die;
		$offerTable = TableRegistry::get('Offer');
		$offerlist = $offerTable->find()->toArray();
		// manage size varient

		$this->set(compact('userdata','returnpolicylist','codrule','offerlist'));
    	if ($this->request->is('post')) {
    		$CatelogTable = TableRegistry::get('Catelog');
			$category = TableRegistry::get('Category');
    		// print_R($this->request->getData());die;
			$request = $this->request->getData();
			// pr($request);
			// die;
			extract($request);
			$request = array_filter($request);

			$image = $this->uploadImage($_FILES['pic']);
			$request['pic'] = !empty($image)?$image:'';
			$offer_image = $this->uploadImage($_FILES['offer_image']);
			if($_FILES['img_guarantee'])
			{
			$img_guarantee = $this->uploadImage($_FILES['img_guarantee']);
			}
			else
			{
			$img_guarantee="http://resellermantra.com/image/100.jpg";
			}
			$selling_value=$request['selling_price'];
			 $max_ratio=$request['max_ratio'];
			 $Addresstable 	=	TableRegistry::get('Address');
			 $addressresult = $Addresstable->find()->where(['customer_id'=>$seller_id,'is_default'=>'y'])->first();
			 $request['seller_address_id']=$seller_address_id=$addressresult->entity_id;
			// if offer applied then have to change selling price_added
			if($offer_id>0)
			{
				$offerTable = TableRegistry::get('Offer');
				$offer =$offerTable
				->find()
				// ->select(['id','path','level','children_count','position','name','is_active'])
				->where(['id ='=>$offer_id])->first();
				$offer_type=$offer['offer_type'];

				$s_price=($request['selling_price']*100)/(100-$offer['offer_value']);
				$s_price=round($s_price);
				$base_price=$request['base_price']=(int) $s_price;
				$request['offer_amount']=$offer['offer_value'];
			}
			else
			{
				$base_price=$request['base_price']=(int) $request['primary_price']+$request['price_added'];
			}

			$request['selling_price']=$request['primary_price']+$request['price_added'];

			$request['max_earning']= (int)((($max_ratio / 100) * $base_price)+$base_price);
			$request['offer_image'] = !empty($offer_image)?$offer_image:'';
			$request['img_guarantee'] = !empty($img_guarantee)?$img_guarantee:'';
			// $request['share_text']=nl2br($share_text);
			// pr($request);die;
			$CatelogEntity = $CatelogTable->newEntity($request);
			$result = $CatelogTable->save($CatelogEntity);
			if($result){
				// upload push to all
				 $catelog_id=  $result->id;
				// die;

			   // $heading=array('en'=>'Share New Catalogue');
			   // $content=array('en'=>$name_en);
				// $this->sendOnesignalMessage($content,$heading);
				 // $catelog_id=$result->id;

				if(!empty($request['category_node']))
				{
					foreach($request['category_node'] as $cid)
					{
						$catdata =$category
						->find()
						->select(['id','total_catelog'])
						->where(['id ='=>$cid])->first();
						$old_stock=$catdata->total_catelog;

						$sub_category[]=['category_id'=>$cid,'catelog_id'=>$CatelogEntity->id];
						$total_stock=array_sum($request['stock_qty']);
						$new_stock=$old_stock+$total_stock;
						if($total_stock>0)
						{
							$catdata->total_catelog=$new_stock;
							$catdata->catelog_stock="y";
							$category->save($catdata);
							// $conn = ConnectionManager::get('default');
							// $q1 = $conn->execute("UPDATE catalog_category SET catelog_stock='y' WHERE id=$cid")->fetch('assoc');
							// $q2 = $conn->execute("UPDATE catalog_category SET catelog_stock= 'y' WHERE id=$cid")->fetch('assoc');

						}
					}
					unset($request['category_node']);
					$request['CatelogCategory']=$sub_category;
					$CatelogCategoryTable = TableRegistry::get('CatelogCategory');
					// pr($sub_category);
					// die;
					$entity = $CatelogCategoryTable->newEntities($sub_category);
					$CatelogCategoryTable->saveMany($entity);
				}
				if(!empty($request['selectstyle']))
				{
					$selectvalue=$request['selectvalue'];
					$j=0;
					$attrTable = TableRegistry::get('ProductVarchar');
					foreach($request['selectstyle'] as $attr_data)
					{
						// pr($attr_data);
						if($attr_data!="--Select--")
						{
						$attr_insert_data=['attribute_id'=>$attr_data,'entity_id'=>$CatelogEntity->id,'value'=>$selectvalue[$j]];
							$attr_entity = $attrTable->newEntity($attr_insert_data);
							$attrTable->save($attr_entity);
						$j++;
						}
						// pr($attr_insert_data);
					}
				}
				if(!empty($request['stock_type']))
				{
					$StockTable = TableRegistry::get('Stock');
					$j=0;
					$stockvalue=$request['stock_qty'];
					$totalcount=0;
					foreach($request['stock_type'] as $singlestock)
					{
						if($stockvalue[$j]>0)
						{
							$stock_insert_data=['value_id'=>$singlestock,'catelog_id'=>$CatelogEntity->id,'pending_stock'=>$stockvalue[$j],'stock_qty'=>$stockvalue[$j]];
							$attr_entity = $StockTable->newEntity($stock_insert_data);
							$StockTable->save($attr_entity);
						}

						$totalcount=$totalcount+$stockvalue[$j];
						$j++;
					}
					$catelogdata=$CatelogTable->find()->where(['id'=>$catelog_id])->first();
					$catelogdata->total_stock=$totalcount;
					$catelogdata->pending_stock=$totalcount;
					$CatelogTable->save($catelogdata);
				}

			}
	    	$this->Flash->success('Catelog created successfully');

			$this->redirect(['action' => 'addproduct',$CatelogEntity->id]);
		}
		$this->set(compact('root_category','attribute_column'));
		$att_style=array();
		$Attributestyle = TableRegistry::get('Attributestyle');

		$att_style=$Attributestyle->find()->where(['style_type ='=>'other'])->order(['style_name'=>'ASC'])->toArray();
		$size_style = $Attributestyle
		->find()
		->where(['style_type'=>'size'])->toArray();
		$widthstyle = $Attributestyle
		->find()
		->where(['style_type'=>'imgheight'])->toArray();
		// print_R($att_style);die;
		$Mode = TableRegistry::get('Mode');
		$mode_style = $Mode
		->find()
		->where(['status'=>'y'])->toArray();
		$this->set(compact('att_style','size_style','widthstyle','mode_style'));
    }
	function sendpush($fcmMsg)
	{
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
					$fields = array("to"=> "/topics/reseller",
										"data" => array("data"=>$fcmMsg,
														 "body"=>$fcmMsg['body'],
														 "title"=>$fcmMsg['title'],
														 "type"=>$fcmMsg['type'],
														 "img"=>$fcmMsg['link'],
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
	function sendpush2($message)
	{

		 $user_data=array();
			$UserTable = TableRegistry::get('Users');
			$query =$UserTable
			->find()
			->select(['id','device_id'])
			->where(['status'=>'active','device_id !='=>''])
			->order(['id'=>'DESC'])
			->all()
			;
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
	function attrlist()
	{
		 $this->viewBuilder()->setLayout(false);
		$style_id = $this->request->getQuery('style_id');
		$Attribute = TableRegistry::get('Attribute');
		$attrlist = $Attribute->find('all')->where(['att_type'=>'catelog','style_id'=>$style_id])->toArray();
		$i=0;
		// pr($attrlist);
		// die;
		foreach($attrlist as $atr)
		{

		// die;
			$re[$i]['attribute_code']=$atr['attribute_id'];
			$re[$i]['frontend_label']=$atr['frontend_label'];
			$i++;
		}
		echo json_encode($re);
		die;
	}
	function sizelist()
	{
		 $this->viewBuilder()->setLayout(false);
		$style_id = $this->request->getQuery('style_id');
		$AttributeTable = TableRegistry::get('AttributeOption');

		$attrlist = $AttributeTable->find('all')
		 ->where(['AttributeOption.attribute_id ='=>28,'AttributeOption.style_id'=>$style_id])
		  ->contain(['AttributeOptionValue'])
		->toArray();
		$i=0;
		// print_R($attrlist);
		// die;
		foreach($attrlist as $atr)
		{
			// print_R($atr);
		// die;
		// die;
		if($atr['attribute_option_value']['value'])
		{
			$re[$i]['attribute_code']=$atr['attribute_option_value']['value_id'];
			$re[$i]['frontend_label']=$atr['attribute_option_value']['value'];
		}
			$i++;
		}
		echo json_encode($re);
		die;
	}
	function addproduct($catelog_id)
	{
		$this->set(compact('catelog_id'));
		if ($this->request->is('post')) {
			 // pr($this->request->getData());die;
			 $ProductTable = TableRegistry::get('Product');
			 $image = $this->uploadImage($_FILES['file']);
			$request['pic'] = !empty($image)?$image:'';
			$request['catelog_id']=$catelog_id;
			$CatelogTable = TableRegistry::get('Catelog');
			$catelog_detail = $CatelogTable->find()->where(['id ='=>$catelog_id])->first();
			// print_R($catelog_detail);
			// die;
			$request['status']=2;
			// copy fields from catelog table to product fields
			$request['name_en']=$catelog_detail['name_en'];
			$request['mode_id']=$catelog_detail['mode_id'];
			$request['name_hn']=$catelog_detail['name_hn'];
			$request['primary_price']=$catelog_detail['primary_price'];
			$request['seller_address_id']=$catelog_detail['seller_address_id'];
			$request['base_price']=$catelog_detail['base_price'];
			$request['offer_amount']=$catelog_detail['offer_amount'];
			$request['percantage_value']=$catelog_detail['percantage_value'];
			$request['price_added']=$catelog_detail['price_added'];
			$request['selling_price']=$catelog_detail['selling_price'];
			$request['img_guarantee']=$catelog_detail['img_guarantee'];
			$request['shipping_charges']=$catelog_detail['shipping_charges'];
			$request['added_by']=$catelog_detail['added_by'];
			$request['seller_id']=$catelog_detail['seller_id'];
			$request['reseller_earning']=$catelog_detail['reseller_earning'];
			$request['max_earning']=$catelog_detail['max_earning'];
			if($catelog_detail['instock'])
			$request['instock']=$catelog_detail['instock'];
			if($catelog_detail['cod'])
			$request['cod']=$catelog_detail['cod'];
		    if($catelog_detail['cod_image'])
			$request['cod_image']=$catelog_detail['cod_image'];
		    if($catelog_detail['top_catelog'])
			$request['top_catelog']=$catelog_detail['top_catelog'];
		    if($catelog_detail['style_id'])
			$request['style_id']=$catelog_detail['style_id'];
		     if($catelog_detail['cod_rule'])
			$request['cod_rule']=$catelog_detail['cod_rule'];
			 if($catelog_detail['description'])
			$request['description']=$catelog_detail['description'];
			 if($catelog_detail['return_rule'])
			$request['return_rule']=$catelog_detail['return_rule'];
			 if($catelog_detail['youtube_link'])
			$request['youtube_link']=$catelog_detail['youtube_link'];
			$request['share_text']=$catelog_detail['share_text'];
			 if($catelog_detail['offer_id'])
			$request['offer_id']=$catelog_detail['offer_id'];

			$request['packageLength']=$catelog_detail['packageLength'];
			$request['packageWidth']=$catelog_detail['packageWidth'];
			$request['packageHeight']=$catelog_detail['packageHeight'];
			$request['packageWeight']=$catelog_detail['packageWeight'];
			// $request['instock']=$catelog_detail['instock'];
			// $request['cod']=$catelog_detail['cod'];
			// $request['top_catelog']=$catelog_detail['top_catelog'];
			// print_R($request);
			// die;
			$ProductEntity = $ProductTable->newEntity($request);
			$result = $ProductTable->save($ProductEntity);
			if($result)
			{
				// increase product count in stock
				$old_count=$catelog_detail->product_count;
				$catelog_detail->product_count=$old_count+1;
				$catelog_detail->on_stock="y";
				$CatelogTable->save($catelog_detail);
				// after uploading add stock of product
				$StockTable = TableRegistry::get('Stock');
				$stockdata = $StockTable
					->find()
					// ->select(['id','fullname'])
					->where(['catelog_id ='=>$catelog_id,'product_id'=>0])->toArray();
				$j=0;

				foreach($stockdata as $st)
				{
					$b[$j]['value_id']=$st['value_id'];
					$b[$j]['stock_qty']=$st['stock_qty'];
					$b[$j]['pending_stock']=$st['pending_stock'];
					$b[$j]['catelog_id']=$st['catelog_id'];
					$b[$j]['product_id']=$ProductEntity->id;
					$j++;
				}
					// print_R($b);
				// die;
				$benties = $StockTable->newEntities($b);
				if($StockTable->saveMany($benties))
				{

				}


				echo "Product Uploaded";
			}
			else
			{
				echo "Failed to upload";
			}
		}
	}
	 function productvarient($product_id)
	 {
		 // echo $product_id;
		 // die;
		 $StockTable = TableRegistry::get('Stock');
		 $stockdata=$StockTable->find()
		  ->contain(['AttributeOptionValue'])
		 ->where(['product_id'=>$product_id])->toArray();
		 // pr($stockdata);
		 // die;
		if(count($stockdata)>0)
		{
			$i=0;
			foreach($stockdata as $s)
			{
				$stock[$i]['id']=$s['id'];
				$stock[$i]['name']=$s['attribute_option_value']['value'];
				$stock_value=$s['stock_qty'];
				$used=$s['sale_product'];
				// $stock[$i]['stock']=$stock_value-$used;
				$stock[$i]['stock']=$s['pending_stock'];
				$i++;
			}
		}
		else
		{
			$stock=[];
		}
		// pr($stock);
		// die;
		return $stock;
	 }
	function catelogproduct($catelog_id)
	{
		$connection = ConnectionManager::get("default");
		if($this->request->is('post')){
			$conn = ConnectionManager::get('default');
			$user_id=$this->Auth->user('id');
			$request = $this->request->getData();
			// pr($request);
			// die;
			extract($request);
			$StockTable = TableRegistry::get('Stock');
			$stockdata=$StockTable->find()
			 ->where(['id'=>$stock_id])->first();
				$old_pending=$stockdata->pending_stock;
				$product_id=$stockdata->product_id;
				 $new_pending=$old_pending+$add_stock;
				// die;
				$new_qty=($stockdata->stock_qty)+$add_stock;
				if($new_pending<0)
					$new_pending=0;
				$stockdata->pending_stock=$new_pending;
				$stockdata->stock_qty=$new_qty;

				 $all_blank="y";

				if($StockTable->save($stockdata))
				{
					$data = $conn->execute("INSERT INTO `stock_data` (`user_id`, `product_id`, `stock_id`, `stock_value`,`s_type`) VALUES ('$user_id','$product_id', '$stock_id','$add_stock','stockrefill')");

					$stockdata=$StockTable->find()
					 ->where(['product_id'=>$product_id])->toArray();
					 foreach($stockdata as $si)
					 {
						 // pr($si);
						$pending_stock=$si['pending_stock'];
						if($pending_stock>=2)
						{
							// echo "no";
							$all_blank="n";
							break;
						}
					}

					if($all_blank=="y")
					{
						$product=$conn->execute("update catalog_product_entity set on_stock='n' where id='$product_id'");
						// if all product are out of stock then make catelog out of stock too
						// echo "select count(id) as total_product_stock from catalog_product_entity where id='$product_id' and status='1' and on_stock='n'";
						$totalproductstock=$conn->execute("select count(id) as total_product_stock from catalog_product_entity where catelog_id='$catelog_id' and status='1' and on_stock='n'")->fetch('assoc')['total_product_stock'];
						// echo $totalproductstock;
						// die;
						if($totalproductstock==$product_count)
						$conn->execute("update catalog_catelog_entity set on_stock='n' where id='$catelog_id'");
					}
					else
					{
						$product=$conn->execute("update catalog_product_entity set on_stock='y' where id='$product_id'");
						$conn->execute("update catalog_catelog_entity set on_stock='y' where id='$catelog_id'");
					}

				}

			return $this->redirect([ 'action' => 'catelogproduct',$catelog_id]);
		}
		else
		{
		if($catelog_id)
		{
			$ProductTable = TableRegistry::get('Product');
			$CatelogTable = TableRegistry::get('Catelog');
			$catelog_detail = $CatelogTable->find()->where(['id ='=>$catelog_id])->first();

			//$attribute_column = $this->getAttributes(0,"product");
			// $selected_categories = $this->getCatelogCategory($catelog_id);
			$product_data=array();
			$query = $ProductTable
				->find()
				->where(['catelog_id ='=>$catelog_id])
				->all();
				// pr($query);
				// die;
				foreach ($query as $data) {
				 $data['stock']=$this->productvarient($data['id']);
				   $product_data[]=$data;
				}
				// pr($product_data);die;
			$this->set(compact('product_data','catelog_detail'));
		}
		else
		{
			$this->Flash->error('Invalid Access');
			$this->redirect(['action' => 'dashboard','controller'=>'users']);
		}
		}

	}
	public function singleproduct()
    {
		$product_id = $this->request->getQuery('id');
		if($product_id)
		{
			$ProductTable = TableRegistry::get('Product');
			$product = $ProductTable->find()->where(['id ='=>$product_id])->first();
			// pr($product);
			// die;
			$attribute_column = $this->getAttributes(0,"product");
			$this->set(compact('product','catelog_detail','attribute_column'));

		}

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
    function getCatelogCategory($product_id){
    	$old_categories=[];
    	$product_categories_table = TableRegistry::get('CatelogCategory');
		$product_categories = $product_categories_table->find()->select(['category_id'])->where(['catelog_id ='=>$product_id])->toList();
		// pr($product_categories);die;
		foreach ($product_categories as $key => $value) {
			$old_categories[] = $value['category_id'];
		}
		return $old_categories;
    }
	function setCatelogCategory($new_categories,$product_id){
    	if((int)$product_id >0){
			$product_categories_table = TableRegistry::get('CatelogCategory');
			$product_categories = $product_categories_table->find()->select(['category_id'])->where(['catelog_id ='=>$product_id])->toList();
			// pr($product_categories);die;
			foreach ($product_categories as $key => $value) {
				$old_categories[] = $value['category_id'];
			}
			if(count($new_categories) != count($old_categories))
			{
				$product_categories_table->deleteAll(['catelog_id' => $product_id]);
				if(!empty($new_categories)){

					foreach($new_categories as $cid)
					{
						$sub_category[]=['category_id'=>$cid,'catelog_id'=>$product_id];
					}
					// $ProductCategoryTable = TableRegistry::get('ProductCategory');
					$entity = $product_categories_table->newEntities($sub_category);
					$product_categories_table->saveMany($entity);
				}
			}
			// pr($old_categories);die;
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
	  // pr($file);
	  // die;
    	if(!empty($file) && $file['error']==0){
    		$source = $file['tmp_name'];
    		$sub_dir = date('Y')."/".date('m')."/";
    		$dir = WWW_ROOT."image/".$sub_dir;
    		if(!file_exists($dir)){
    			mkdir($dir,0777,true);
    		}
    		// $name = time().str_replace(" ", "-", $file['name']);
			$uniquesavename=time().uniqid(rand());
    		$name= $uniquesavename . '.png';
    		move_uploaded_file($source, $dir.$name);
    		return $sub_dir.$name;
    	}

    }
    function index(){
		$user_id=$this->Auth->user('id');
		$login_role=$this->Auth->user('login_role');
		$filter='';
		if($login_role!=1)
		{
			$filter="and c.seller_id='$user_id'";
		}

	   if ($this->request->is('post')) {
		   // pr($this->request->getData());die;
		   $daterang=$this->request->getData('daterange');
		   $d_a=explode('-',$daterang);
		   $start_date=date('Y-m-d',strtotime($d_a[0]));
		   $end_date=date('Y-m-d',strtotime($d_a[1]));


		    $q="select c.*,s.manual_ship,s.display_name,a.sellerAddressId from catalog_catelog_entity as c inner join users as s on s.id=c.seller_id  inner join
			customer_address_entity as a on a.entity_id=c.seller_address_id where c.created >= '$start_date' AND c.created <= '$end_date' $filter order by created desc";
		}
		else
		{
			if($login_role==1)
			{
				 $q="select c.*,s.manual_ship,s.display_name,a.sellerAddressId  from catalog_catelog_entity as c inner join users as s on s.id=c.seller_id inner join customer_address_entity as a on a.entity_id=c.seller_address_id order by created desc";
			}
			else
			{
				$q="select c.*,s.manual_ship,s.display_name,a.sellerAddressId  from catalog_catelog_entity as c inner join users as s on s.id=c.seller_id  inner join customer_address_entity as a on a.entity_id=c.seller_address_id where c.seller_id='$user_id' order by created desc";
			}
		}
		// echo $q;
		// die;
    	$conn = ConnectionManager::get('default');

		$query = $conn->execute($q)->fetchAll('assoc');

    	$count=0;
	    foreach ($query as $key=>$data) {
		$data['category_list']=$this->categorylist($data['id']);
		$product_data[$key]=$data;
		   // $product_data['category']=
		   $count++;
		}

		// pr($product_data);die;
		$this->set(compact('product_data','daterang'));
    }
	function p()
	{
	   $this->viewBuilder()->setLayout('admin');
	}
  function categorylist($c_id)
	{
		$conn = ConnectionManager::get('default');
		$qc="select c.name as category_name from catalog_category as c inner join catalog_category_catelog as cc on cc.category_id=c.id  where cc.catelog_id='$c_id'";
		$cat_list = $conn->execute($qc)->fetchAll('assoc');
		$c='';
		// pr($cat_list);
		// die;
		foreach($cat_list as $ca)
		{
			$c=$ca['category_name']."</br>".$c;
			// $c.="</br>".$c;
		}
		return $c;
	}
	function getAttributes($product_id=0,$type){

    	$conn = ConnectionManager::get('default');
    	$attribute = TableRegistry::get('Attribute');
    	$query	=	$attribute
    				->find()
					 ->where(['att_type = '=>$type])
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
    function getAttributes2($product_id=0,$type){
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
					$data[$i]['attribute_id']=$select['attribute_id'];
					$data[$i]['attribute_value']=$select['value'];
					$data[$i]['attribute_name']=$query->attribute_name;
					$i++;
				}
		 }
		return $data;
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
  	//require 'vendor/autoload.php';
		// use PhpOffice\PhpSpreadsheet\Spreadsheet;
		// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

		// $spreadsheet = new Spreadsheet();
		// $sheet = $spreadsheet->getActiveSheet();
		// $sheet->setCellValue('A1', 'Hello World !');

		// $writer = new Xlsx($spreadsheet);
		// $writer->save('hello world.xlsx');
    }
}
