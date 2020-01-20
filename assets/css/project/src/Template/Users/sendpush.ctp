
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a javascript::void(0);>Send Message</a>
				</li>
			</ul><!-- /.breadcrumb -->
		</div>

		<div class="page-content">
			<div class="row">
	<div class="col-xs-12 col-sm-12">
		<div class="box">
			
			<div class="box-content" style="height:100%;">
				<h4 class="page-header" id="head_text">Send Message </h4>
				
				<?php if(array_key_exists("msg",$_SESSION)){ 
				echo '<div class="alert">'.$_SESSION['msg'].'</div>';
				unset($_SESSION['msg']);
				}?>

				
					<form method="post" enctype="multipart/form-data"  style="width:50%;" action="">
					<div class="form-group">
						  <select  name="select_type" class="form-control">
						    <option value="-1">Select Type</option>
						    <option value="Text">Text</option>
						    <option value="Image">Image</option>
						    <option value="Textlink">TextLink</option>
						    <option value="Imagelink">ImageLink</option>
						   
						    <option value="Youtube">Youtube</option>
						  </select>
						
					</div>
					<div class="form-group">
						 <input type="text" id="tittle"  required name="tittle" placeholder="Enter Tittle" class="form-control"/>
						
					</div>
					<div class="image-area">
					<div class="form-group">
						 <input type="text" id="link" name="link" placeholder="Image Browse Path" class="form-control"/>
						
					</div>
					<div class="form-group">
						 <input type="text" id="url_link" name="url_link" placeholder="Extrnal Url Link or Youtube Link" class="form-control"/>
						
					</div>    
					<div class="form-group">
						 <input type="file" id="image_file" name="image" class="form-control"/>
						
					</div>
					</div>
					<div class="form-group has-success has-feedback">
						
						<div id="formdiv">
							<p>Google Cloud Messaging (GCM)</p>	
									<textarea rows="5" id="push_message" name="push_message" cols="45" placeholder="Message to send via GCM"></textarea> <br/>
							</div>
						
					</div>
					<div class="clearfix"></div>
					<div class="form-group">
						<input type="submit" class="btn  btn-primary" value="Send Push" />

						
						
					</div>
					
				</form>
			</div>
		</div>
	</div>
</div>
		</div>
	</div>
</div><!-- /.main-content -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
$(function(){
$("textarea").val("");
});
function checkTextAreaLen(){
var msgLength = $.trim($("textarea").val()).length;
// alert(msgLength);
if(msgLength == 0){
	alert("Please enter message before hitting submit button");
	return false;
}else{
	return true;
}
}


</script>