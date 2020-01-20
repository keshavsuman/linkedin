<?php foreach($category_data as $category):
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
<li class="tree-item" role="treeitem"><span class="tree-item-name"><i class="icon-item ace-icon fa fa-times"></i><span class="tree-label node-link" data-element-id="<?php echo $category_id?>"><?php echo $name?></span></span></li>
<?php endif;?>
<?php endforeach;?>
