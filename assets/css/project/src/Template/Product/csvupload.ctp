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

		<div class="page-content center">
			<div class="row">
				<?php echo $this->Form->create('',['class'=>"form-horizontal","id"=>"category_form",'type'=>'file']) ?>
 				<div class="col-sm-6">
				<?php echo $this->Form->create('',['class'=>"form-horizontal","id"=>"csv_upload",'type'=>'file']) ?>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">csv*</label>
						<div class="col-sm-9">
							<input type="file" name="csv">
						</div>
					</div>
					<div class="form-group">
						<div class="form-actions left">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
							<button type="submit" name="save" value="save" class="btn btn-sm btn-success">
								Upload
								<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
							</button>
						</div>	
					</div>
				</form>
			</div>
		</div>
	</div>
</div>				

