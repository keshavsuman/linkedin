<link href="<?php echo $this->request->getAttribute("webroot"); ?>css/custom.css" rel="stylesheet">
<link href="http://54.169.217.26/assets/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Category Managment</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Treeview</li>
                        </ol>
                    </div>
                    
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row" style="margin-bottom: 50px;">
 				<div class="col-sm-6">
					<div class="widget-box widget-color-blue2">
						<div class="widget-header">
							<h4 class="widget-title lighter smaller">Categories</h4>
						</div><BR>
						<button type="button" id="add_root_category_button" class="btn btn-sm btn-success"><i class="ace-icon fa fa-plus"></i> Add Root Category</button>
						<button type="button" id="add_sub_category_button" class="btn btn-sm btn-success"><i class="ace-icon fa fa-plus"></i> Add Sub Category</button>
						<div class="widget-body">
							<div class="widget-main padding-8">
								<ul id="tree" class="tree tree-unselectable" role="tree">
									<?php foreach($root_category as $category):
									  
										$children_count = $category['children_count'];
										$category_parent_id = $category['parent_id'];
										$category_id = $category['id'];
										$name = $category['name'];
										$is_active = $category['is_active'];	
									?>
									<?php if($children_count>0):?>
									<li class="tree-branch" role="treeitem" aria-expanded="false">
										<i class="icon-caret ace-icon tree-plus tree-children" data-element-id="<?php echo $category_id?>"></i>
										<div class="tree-branch-header">
											<span class="tree-branch-name">
											<i class="icon-folder red ace-icon fa fa-folder"></i>
											<span class="tree-label node-link" data-element-id="<?php echo $category_id?>"><?php echo $name?></span></span>
										</div>
										<ul class="tree-branch-children" role="group"></ul>
										<div class="tree-loader hidden" role="alert">
											<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>
										</div>
									</li>
									<?php else:?>
									<li class="tree-item" role="treeitem"><i class="icon-folder red ace-icon fa fa-folder"></i><span class="tree-item-name"><span class="tree-label node-link" data-element-id="<?php echo $category_id?>"><?php echo $name?></span></span></li>
									<?php endif;?>
									<?php endforeach;?>
								</ul>
							</div>
						</div>
					</div>
				</div>	
				   <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                               
                             <?php echo $this->Flash->render() ?>
					<?php echo $this->Form->create('',['class'=>"form-horizontal","id"=>"category_form",'type'=>'file']) ?>
					<input type="hidden" name="parent_id" id="parent_id">
						<input type="hidden" name="category_id" id="category_id">
                                    <div class="form-group">
                                        <label for="exampleInputuname2">Category Name</label>
                                        <div class="input-group">
                                            <input type="text" id="name" required name="name" placeholder="Default Category" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail2">is Active *</label>
                                        <div class="input-group">
										   <select id="is_active" name="is_active" class="form-control required-entry select">
												<option value="1">Yes</option>
												<option value="0" selected="selected">No</option>
											</select>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputpwd2">Category Image</label>
                                        <div class="input-group">
                                           <input type="file" class="form-control required-entry" name="thumbnail">
								<div class="category_image"></div>
                                        </div>
                                    </div>
									   <div class="form-group">
                                        <label for="exampleInputEmail2">Category Type *</label>
                                        <div class="input-group">
										   <select id="category_type" name="category_type" required class="form-control required-entry select">   
												<option value="-1">Select Category Type</option>
												<option value="Consumer Goods">Consumer Goods</option>
												<option value="Toys and Baby Products">Toys and Baby Products</option>
												<option value="Handbags and Luggage">Handbags and Luggage</option>
												<option value="Computers and Accessories">Computers and Accessories</option>
												<option value="Food Articles">Food Articles</option>
												<option value="Home Kitchen and Pets">Home Kitchen and Pets</option>
												<option value="Shoes">Shoes</option>
												<option value="Clothing and Accessories">Clothing and Accessories</option>
												<option value="Gift Item">Gift Item</option>
												<option value="Movies Music and Video Games">Movies Music and Video Games</option>
												<option value="Mobiles and Tablets">Mobiles and Tablets</option>
												<option value="Cameras Audio and Video">Cameras Audio and Video</option>
												<option value="Sports Fitness and Outdoors">Sports Fitness and Outdoors</option>
												<option value="Beauty Health and Gourmet">Beauty Health and Gourmet</option>
												<option value="Jewellery Watches and Eyewear">Jewellery Watches and Eyewear</option>
												<option value="Car Motorbike and Industrial">Car Motorbike and Industrial</option>
												<option value="Other">Other</option>
												
											</select>
                                            
                                        </div>
                                    </div>
                                  
                                    <div class="text-left">
                                        
										<button type="submit" name="save" value="save" class="btn btn-sm btn-success">
									Save Category
									<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
								</button>
								<button type="submit" name="delete" value="delete" class="btn btn-sm btn-danger">
									Delete Category
									<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
								</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
				
			</div><!-- /.page-content -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
	$(function(){
		$(document).on('click','.node-link',function(){
			cat_id = $(this).attr('data-element-id');
			
			$('li').removeClass('tree-selected');
			$(this).closest('li').addClass('tree-selected');

			if($(this).hasClass('x_tree_selected') == false){
				$('span').removeClass('x_tree_selected');
				$(this).addClass('x_tree_selected');
			}
			var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
			$.ajax({
				headers: {
			        'X-CSRF-Token': csrfToken
			    },
				url:"<?php echo $this->url->Build(['controller'=>'category','action'=>'getCategoryData'])?>",
				type:'post',
				data:{'cat_id':cat_id},
				success:function(res){
					 
					category = JSON.parse(res);
					// alert(category.category_type);  
					$("#name").val(category.name);
					$("#is_active").val(category.is_active);
					$("#category_id").val(category.id);
					$("#category_type").val(category.category_type);
					image = '<img src="'+category.thumbnail+'" width="150px">';
					$(".category_image").html(image);
					// console.log(category.thumbnail);
				}
			});
		});
		$(document).on('click','.tree-children',function(){
			cat_id = $(this).attr('data-element-id');
			element = $(this);
			x_tree_expended = true;
			if($(this).hasClass('x_tree_expended') == true){
				x_tree_expended = false;
			}
			if($(this).hasClass('x_tree_expended') == false){
				$(this).addClass('x_tree_expended');
			}
			if(x_tree_expended == true){
				$(element).siblings('.tree-loader').removeClass('hidden');
				var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;

				$.ajax({
					headers: {
				        'X-CSRF-Token': csrfToken
				    },
					url:"<?php echo $this->url->Build(['controller'=>'category','action'=>'subCategoryTree'])?>",
					type:'post',
					data:{'cat_id':cat_id},
					success:function(res){
						$(element).siblings('ul').html(res);
						$(element).siblings('.tree-loader').addClass('hidden');
					}
				});
			}
		});
		$(document).on('click','#add_root_category_button',function(){
			
			$("#category_form")[0].reset();
			$("#parent_id").val(0);
			$("#category_id").val(0);
		});
		$(document).on('click','#add_sub_category_button',function(){
			$('.category_image').html('');
			$("#category_form")[0].reset();
			$("#parent_id").val(0);
			$("#category_id").val(0);
			if($('.x_tree_selected').length > 0){
				$("#parent_id").val($('.x_tree_selected').last().attr('data-element-id'));
			}
		});
	});
</script>
 