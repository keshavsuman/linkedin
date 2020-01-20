<?php foreach($category_data as $category):
	$children_count = $category['children_count'];
	$category_parent_id = $category['parent_id'];
	$category_id = $category['id'];
	$name = $category['name'];
	$is_active = $category['is_active'];
	if(in_array($category_id,$selected_categories)){
		$checked="checked";
	}
	else{
		$checked="";
	}
	
?>
<?php if($children_count>0):?>
<li class="tree-branch" role="treeitem" aria-expanded="false">
	<i class="icon-caret ace-icon tree-plus tree-children" data-element-id="<?php echo $category_id?>"></i>
	<div class="tree-branch-header">
		<span class="tree-branch-name">
		<input type="checkbox" name="category_node[]" class="category_x_box" <?php echo $checked;?> value="<?php echo $category_id?>">
		<span class="tree-label node-link" data-element-id="<?php echo $category_id?>"><?php echo $name?></span></span>
	</div>
	<ul class="tree-branch-children" role="group"></ul>
	<div class="tree-loader hidden" role="alert">
		<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>
	</div>
</li>
<?php else:?>
<li class="tree-item" role="treeitem">
	<input type="checkbox" name="category_node[]" class="category_x_box" <?php echo $checked;?> value="<?php echo $category_id?>"><span class="tree-item-name"><span class="tree-label node-link" data-element-id="<?php echo $category_id?>"><?php echo $name?></span></span></li>
<?php endif;?>
<?php endforeach;?>
