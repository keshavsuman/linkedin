
 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Offer Add</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Offer Add</li>
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
 			
				   <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                               
                             <?php echo $this->Flash->render() ?>
					<?php echo $this->Form->create('',['class'=>"form-horizontal","id"=>"offer_form",'type'=>'file']) ?>
					<div class="form-group">
                                        <label for="exampleInputpwd2">Offer Title</label>
                                        <div class="input-group">
                                           <input type="text" id="title" value="<?php echo $detail['title']; ?>" class="form-control required-entry" name="title">
								
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="exampleInputpwd2">Offer Sub Title</label>
                                        <div class="input-group">
                                           <input type="text" value="<?php echo $detail['subtitle']; ?>"   class="form-control required-entry" name="subtitle">
								
                                        </div>
                                    </div> 
									<div class="form-group">
                                        <label for="exampleInputpwd2">Search Keyword 1</label>
                                        <div class="input-group">
                                           <input type="text" value="<?php echo $detail['search_keyword_1']; ?>"  required class="form-control required-entry" name="search_keyword_1">
								
                                        </div>
                                    </div> 
									<div class="form-group">
                                        <label for="exampleInputpwd2">Search Keyword 2</label>
                                        <div class="input-group">
                                           <input type="text"  value="<?php echo $detail['search_keyword_2']; ?>"  class="form-control required-entry" name="search_keyword_2">
								
                                        </div>
                                    </div> 
					                <div class="form-group">
                                        <label for="exampleInputpwd2">Offer Image</label>
                                        <div class="input-group">
									
									  
									
									<br/>
                                           <input type="file" id="offer_image" class="form-control required-entry" name="offer_image">
										   <br/>
										   <br/>
									 <?php if($detail['offer_image']){
										 $image = $this->request->getAttribute("webroot") ."image/". $detail['offer_image'];
										 ?>
									<p>
									<img src="<?php echo $image;?>" style="max-width:200px;"></p>
									
									 <?php } ?>
								<div class="category_image"></div>
                                        </div>
                                    </div>
									 <div class="form-group">
                                        <label for="exampleInputEmail2">Offer Type *</label>
                                        <div class="input-group">
										   <select id="is_active" name="offer_type" class="form-control required-entry">
												<option value="fix" <?php if($detail['offer_type']=="fix"){echo "selected='selected'";} ?> >Fix</option>
												<option value="per" <?php if($detail['offer_type']=="per"){echo "selected='selected'";} ?>>Percentage </option>
											</select>
                                            
                                        </div>
                                    </div>
									   <div class="form-group">
                                        <label for="exampleInputpwd2">Offer Value</label>
                                        <div class="input-group">
                                           <input type="Number" id="offer_value"  value="<?php echo $detail['offer_value']; ?>" class="form-control required-entry" name="offer_value">
								<div class="category_image"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail2">is Active *</label>
                                        <div class="input-group">
										   <select id="is_active" name="status" class="form-control required-entry select">
												<option value="1" <?php if($detail['status']=="1"){echo "selected='selected'";} ?> >Yes</option>
												<option value="2" <?php if($detail['status']=="2"){echo "selected='selected'";} ?> >No</option>
											</select>
                                            
                                        </div>
                                    </div>
                                    
                                  
                                    <div class="text-left">
                                        
										<button type="submit" name="save" value="save" class="btn btn-sm btn-success">
									Save
									<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
								</button>
								
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
					 <div class="col-lg-6 offer_preview_div" style="display:none;">
					      <img id="offer_preview" style="max-width:100%;" src="#" alt="your image" />
                  
					 </div>
				
			</div><!-- /.page-content -->
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
			  <script language="JavaScript"  src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.0/jquery.min.js"></script>
	 <script>
    jQuery(document).ready(function() {
		
		 // For select 2
        $(".select2").select2();
		  $('.select2').change(function() {
			  var id=$(this).val();
			  
        $.ajax({
            url: '<?php echo $this->url->Build(['controller'=>'users','action'=>'sellerdetail'])?>',
            dataType: 'json',
            type: 'GET',
            // This is query string i.e. country_id=123
            data: {id :id},
            success: function(data) {  
					
				 $('.seller_detail').show();
				  $('#seller_label').html(data.seller_name);
					 $('#seller_catelog').html(data.total_catelog);
				 
				 
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
	function readURL(input) {

	  if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$('.offer_preview_div').show();
		  $('#offer_preview').attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	  }
	}

	$("#offer_image").change(function() {
	  readURL(this);
	});
	
	});
</script>
 