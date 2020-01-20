
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
				<div class="col-xs-6">
					<!-- PAGE CONTENT BEGINS -->
					<?php echo $this->Flash->render() ?>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name(hindi)*</label>

							<div class="col-sm-9">
								<input type="text" id="name" name="name" placeholder="Default Category" class="col-xs-10 col-sm-5" />
							</div>
						</div>
						<?php if(!empty($attribute_column)):?>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php echo $attribute_label; ?></label>
									<div class="col-sm-9">
										<select id="is_active" name="attribute_id" class="select">
											<option value="">select</option>
											<?php foreach($attribute_column as $option):?>
											<option value="<?php echo $option['attribute_id'];?>"><?php echo $option['frontend_label'];?></option>
										<?php endforeach;?>
										</select>
									</div>
								</div>
							<?php endif;?>
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