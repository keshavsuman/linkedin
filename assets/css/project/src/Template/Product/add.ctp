	
<style>
	.category-tree{
		height: 400px;
		width: 40%;
		border: 1px solid #ccc;
	}
</style>
	<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a javascript::void(0);>Manage Category</a>
				</li>
			</ul><!-- /.breadcrumb -->
		</div>

		<div class="page-content">
			<div class="row">
				<?php echo $this->Form->create('',['class'=>"form-horizontal","id"=>"category_form",'type'=>'file']) ?>
 				<div class="col-sm-6">
					<div class="widget-box widget-color-blue2">
						<div class="widget-header">
							<h4 class="widget-title lighter smaller">Catelog</h4>
						</div>
						<div class="widget-body">
							<div class="widget-main padding-8">
								<!-- <?php pr($root_category);?> -->
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
											<input type="checkbox" name="category_node[]" class="category_x_box" value="<?php echo $category_id?>">
											<span class="tree-label node-link" data-element-id="<?php echo $category_id?>"><?php echo $name?></span></span>
										</div>
										<ul class="tree-branch-children" role="group"></ul>
										<div class="tree-loader hidden" role="alert">
											<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>
										</div>
									</li>
									<?php else:?>
									<li class="tree-item" role="treeitem"><span class="tree-item-name">
										<input type="checkbox" name="category_node[]" class="category_x_box" value="<?php echo $category_id?>">
										<span class="tree-label node-link" data-element-id="<?php echo $category_id?>"><?php echo $name?></span></span></li>
									<?php endif;?>
									<?php endforeach;?>
								</ul>
							</div>
						</div>
					</div>
				</div>	
				<div class="col-xs-6">
					<!-- PAGE CONTENT BEGINS -->
					<?php echo $this->Flash->render() ?>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name(hindi)*</label>

							<div class="col-sm-9">
								<input type="text" id="name" name="name_hn" placeholder="Default Category" class="col-xs-10 col-sm-5" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name(english)*</label>

							<div class="col-sm-9">
								<input type="text" id="name" name="name_en" placeholder="Default Category" class="col-xs-10 col-sm-5" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Sku*</label>

							<div class="col-sm-9">
								<input type="text" id="sku" name="sku" placeholder="Default Category" class="col-xs-10 col-sm-5" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Primary Price*</label>

							<div class="col-sm-9">
								<input type="number" id="name" name="primary_price" placeholder="Default Category" class="col-xs-10 col-sm-5" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Special Price*</label>

							<div class="col-sm-9">
								<input type="number" id="name" name="selling_price" placeholder="Default Category" class="col-xs-10 col-sm-5" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Image*</label>

							<div class="col-sm-9">
								<input type="file" id="pic" name="pic" class="col-xs-10 col-sm-5" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Is Active*</label>
							<div class="col-sm-9">
								<select id="is_active" name="is_active" class="required-entry required-entry select">
									<option value="1">Yes</option>
									<option value="0" selected="selected">No</option>
								</select>
							</div>
						</div>
						<?php if(!empty($attribute_column)):?>
							<?php foreach($attribute_column as $column):
							// pr($column); 
								$attribute_code = $column['attribute_code'];
								$attribute_input = $column['frontend_input'];
								$attribute_label = $column['frontend_label'];
								$options = !empty($column['options'])?$column['options']:array();
			
						
							if($attribute_input=='text') { ?>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php echo $attribute_label; ?></label>
									<div class="col-sm-9">
										<input type="text" id="<?php echo $attribute_code;?>" name="attributes[][<?php echo $attribute_code;?>]" class="col-xs-10 col-sm-5" />
									</div>
								</div>		
							<?php } elseif($attribute_input=='select'){?>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php echo $attribute_label; ?></label>
									<div class="col-sm-9">
										<select id="is_active" name="attributes[][<?php echo $attribute_code;?>]" class="select">
											<option value="">select</option>
											<?php foreach($options as $option):?>
											<option value="<?php echo $option['option_id'];?>"><?php echo $option['value'];?></option>
										<?php endforeach;?>
										</select>
									</div>
								</div>
							<?php } ?>
						

						<?php endforeach;endif;?>

						<div class="form-group">
							<div class="form-actions left">
								<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
								<button type="submit" name="save" value="save" class="btn btn-sm btn-success">
									Save
									<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
								</button>
							</div>	
						</div>
					</div>
				</form>
			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->

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
				url:"<?php echo $this->Url->build(['controller'=>'category','action'=>'getCategoryData'])?>",
				type:'post',
				data:{'cat_id':cat_id},
				success:function(res){
					category = JSON.parse(res);
					$("#name").val(category.name);
					$("#is_active").val(category.is_active);
					$("#category_id").val(category.id);
					console.log(category.name);
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
			
			console.log(x_tree_expended);
			if(x_tree_expended == true){
				$(element).siblings('.tree-loader').removeClass('hidden');
				var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;

				$.ajax({
					headers: {
				        'X-CSRF-Token': csrfToken
				    },
					url:"<?php echo $this->url->Build(['controller'=>'product','action'=>'subCategoryTree'])?>",
					type:'post',
					data:{'cat_id':cat_id},
					success:function(res){
						$(element).siblings('ul').html(res);
						$(element).siblings('.tree-loader').addClass('hidden');
					}
				});
			}
		});
	});
</script>