 
	<!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Single Product</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active"></li>
                        </ol>
                    </div>
                   
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                  <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                  Catelog Name : <?php echo $product['name_en']; ?><br/>
                                  Catelog Hindi : <?php echo $product['name_hn']; ?><br/>
								   <a style="float:right;" href="<?php echo $this->Url->build(['controller'=>'catelog','action'=>'catelogproduct',$product['catelog_id']])?>"  class="btn btn-sm btn-danger">Back</a>
                 
                            </div>
                        </div>
                    </div>
                </div>
				  <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
				<div class="row">
				 
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                              <h4 class="card-title">Product Info</h4>
						
					
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="text-input">Percantage </label>
                      <div class="col-md-9">
                        <input type="number" id="percantage_value" value="<?php echo $product['percantage_value']; ?>" name="percantage_value" class="form-control" placeholder="Percantage Value"> 
                    
                      </div>
                    </div>
                   
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Catelog Name (EN)</label>
                      <div class="col-md-9">
                        <input type="text" id="password-input" name="name_en" value="<?php echo $product['name_en']; ?>"  class="form-control" placeholder="Catelog Name">
                       
                      </div>
                    </div>
					  <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Catelog Name (Hindi)</label>
                      <div class="col-md-9">
                        <input type="text" id="password-input" name="name_hn" value="<?php echo $product['name_hn']; ?>"  class="form-control" placeholder="Catelog Name Hindi">
                       
                      </div>
                    </div>
                   
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="textarea-input">Short Description</label>
                      <div class="col-md-9">
                        <textarea id="textarea-input" style="max-height: 100px;" name="short_desc" rows="9" class="form-control" placeholder="Short Description.."><?php echo $product['percantage_value']; ?></textarea>
                      </div>
                    </div>
					
						
					 <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Price by Suppiler</label>
                      <div class="col-md-9">
                        <input type="number" id="primary_price" name="primary_price" value="<?php echo $product['primary_price']; ?>"  class="form-control" placeholder="Price by Suppiler">
                       
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Price Added</label>
                      <div class="col-md-9">
                        <input type="number" id="price_added" name="price_added" value="<?php echo $product['price_added']; ?>"   class="form-control" placeholder="Price Added">
                       
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Final Price</label>
                      <div class="col-md-9">
                        Rs <span id="final_price"><?php echo $product['selling_price']; ?> </span>
						<input type="hidden" id="selling_price" name="selling_price"/>
                      </div>
                    </div>
                     <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Shipping Charges</label>
                      <div class="col-md-9">
                        <input type="Number" id="password-input" name="shipping_charges" value="<?php echo $product['shipping_charges']; ?>"  class="form-control" placeholder="Shipping Value">
                       
                      </div>
                    </div>
                
                 
                  
                   
                    <div class="form-group row">
                     
                      <div class="col-md-9">
                        <label class="radio-inline" for="inline-radio1">
                          <input style="display:inherit;opacity:100;position: static;" type="checkbox" id="inline-radio1" name="instock" checked value="option1"> In Stock
                        </label>
                        <label class="radio-inline" for="inline-radio2">
                          <input style="display:inherit;opacity:100;position: static;" type="checkbox" id="inline-radio2" name="cod" checked value="option2"> COD
                        </label>
						<label class="radio-inline" for="inline-radio2">
                          <input style="display:inherit;opacity:100;position: static;" type="checkbox" id="inline-radio2" name="top_catelog" value="option2"> Top Catelog
                        </label>
                       
                      </div>
                    </div>
					
                  
                   
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Product Pic</h4>
                               
                                <input type="file" id="input-file-now-custom-3" class="dropify" data-height="500" data-default-file="<?php echo $this->request->getAttribute('webroot') . 'image/'. $product['pic'];?>" />
								<div>
					  Dynamic Fields
					</div>
					<?php if(!empty($attribute_column)):?>
					<?php foreach($attribute_column as $column):
							// pr($column); 
								$attribute_code = $column['attribute_code'];
								$attribute_input = $column['frontend_input'];
								$attribute_label = $column['frontend_label'];
								$options = !empty($column['options'])?$column['options']:array();
			
						
							if($attribute_input=='text') { ?>
					 <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input"><?php echo $attribute_label; ?></label>
                      <div class="col-md-9">
                       
                       <input type="text" id="<?php echo $attribute_code;?>" name="attributes[][<?php echo $attribute_code;?>]" class="form-control" />
                      </div>
                    </div>
					<?php } elseif($attribute_input=='select'){?>
						 <div class="form-group row">
						  <label class="col-md-3 form-control-label" for="password-input"><?php echo $attribute_label; ?></label>
						  <div class="col-md-9">
							<select id="is_active" name="attributes[][<?php echo $attribute_code;?>]" class="form-control select">
											<option value="">select</option>
											<?php foreach($options as $option):?>
											<option value="<?php echo $option['option_id'];?>"><?php echo $option['value'];?></option>
										<?php endforeach;?>
										</select>
						   
						  </div>
						</div>
					<?php } ?>
					<?php endforeach;endif;?>
						   </div>
                        </div>
						 <div class="card-footer">
				<input type="submit" class="btn btn-sm btn-primary" value="update"/>
                   <a href="<?php echo $this->Url->build(['controller'=>'catelog','action'=>'catelogproduct',$product['catelog_id']])?>"  class="btn btn-sm btn-danger">Back</a>
                 
                </div>   
                    </div>
					
					
                </div>
				</form>
				
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
              
            </div>
 <!-- Dropzone Plugin JavaScript -->
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/dropzone-master/dist/dropzone.js"></script>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript">
	  jQuery(document).ready(function() {
		  	$("#primary_price").keyup(function(){
			  var primary_value=$('#primary_price').val();
			  var price_added=$('#price_added').val();
			  var final_value=parseInt(primary_value, 10) + parseInt(price_added, 10);
			  $('#final_price').html(final_value);
			  $('#selling_price').val(final_value);
		});
		$("#price_added").keyup(function(){
			var primary_value=$('#primary_price').val();
			  var price_added=$('#price_added').val();
			  var final_value=parseInt(primary_value, 10) + parseInt(price_added, 10);
			  $('#final_price').html(final_value);
			  $('#selling_price').val(final_value);
		});
	  });
	Dropzone.options.imageUpload = {

        maxFilesize:1,

        acceptedFiles: ".jpeg,.jpg,.png,.gif"

    };

</script>