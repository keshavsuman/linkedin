
 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Catelog</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Catelog List</a></li>
                            <li class="breadcrumb-item active">Add Catelog</li>
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
            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <strong>Catelog Upload</strong>
                  
                </div>
                <div class="card-body">
                  <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group row">
					 <label class="col-md-3 form-control-label" for="text-input">Select Seller</label>
					  <div class="col-md-9 autocomplete">
                        <input  type="text" class="seller_name form-control" name="seller_name" id="seller_name" placeholder="Select Seller">
                        
                      </div>
                    
                    </div>
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="text-input">Percantage </label>
                      <div class="col-md-9">
                        <input type="number" id="text-input" name="text-input" class="form-control" placeholder="Percantage Value">
                    
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="email-input">Catelog Images</label>
                      <div class="col-md-9">

						  <input type="file" id="file-multiple-input" name="file-multiple-input" multiple="">
                     
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Catelogo Name</label>
                      <div class="col-md-9">
                        <input type="text" id="password-input" name="password-input" class="form-control" placeholder="Catelog Name">
                       
                      </div>
                    </div>
                   
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="textarea-input">Short Description</label>
                      <div class="col-md-9">
                        <textarea id="textarea-input" name="textarea-input" rows="9" class="form-control" placeholder="Short Description.."></textarea>
                      </div>
                    </div>
					
						<div class="form-group row">
					  
							<div class="col-md-5 autocomplete">
								<input id="myInput2" type="text" class="form-control" name="myCountry" placeholder="Select key">
							</div>
							<div class="col-md-6">
								<input  type="text" class="form-control" name="myCountry" placeholder="Set value">
							</div>
							<div class="col-md-1">
							  <i class="fa fa-plus" aria-hidden="true"></i>

							</div>
						</div>
					 <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Price by Suppiler</label>
                      <div class="col-md-9">
                        <input type="text" id="password-input" name="password-input" class="form-control" placeholder="Price by Suppiler">
                       
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Price Added</label>
                      <div class="col-md-9">
                        <input type="text" id="password-input" name="password-input" class="form-control" placeholder="Price Added">
                       
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Final Price</label>
                      <div class="col-md-9">
                        Rs 500
                      </div>
                    </div>
                     <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Shipping Charges</label>
                      <div class="col-md-9">
                        <input type="Number" id="password-input" name="password-input" class="form-control" placeholder="Shipping Value">
                       
                      </div>
                    </div>
                
                 
                  
                   
                    <div class="form-group row">
                     
                      <div class="col-md-9">
                        <label class="radio-inline" for="inline-radio1">
                          <input style="display:inherit;opacity:100;position: static;" type="checkbox" id="inline-radio1" name="inline-radios" checked value="option1"> In Stock
                        </label>
                        <label class="radio-inline" for="inline-radio2">
                          <input style="display:inherit;opacity:100;position: static;" type="checkbox" id="inline-radio2" name="inline-radios" checked value="option2"> COD
                        </label>
                       
                      </div>
                    </div>
                  
                   
                   
                  </form>
                </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-dot-circle-o"></i> Submit</button>
                  <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
                </div>
              </div>

          
            </div>
            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <strong>Catelog Image</strong>
                     
                </div>
                <div class="card-body">
                  images goes here
                </div>
            
              </div>
              <div class="card">
                <div class="card-header">
                  <strong>Description</strong>
                  For Share
				   <select class="form-control" id="ccmonth">
                        <option>Select Template</option>
                        <option>1</option>
                        <option>2</option>
                       
                      </select>
                </div>
                <div class="card-body">
                   Text goes here
                </div>
             
              </div>

            

             
            </div>
            <!--/.col-->
          </div>
          <!--/.row-->
               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	 <script type="text/javascript" src="<?php echo $this->request->getAttribute("webroot"); ?>js/typeahead.js"></script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
 jQuery(".other_product_name").autocomplete({
      source: "auto_complete_product_name.php",
      minLength: 1, 
      select: function(event, ui) {
        var id = $(this).attr('id').split('_')[3];
		var qty_id='other_qty_'+id;
		var qty_no=document.getElementById(qty_id).value;
		 var total_cart=qty_no*(ui.item.price);
		 // alert(total_cart);
        $("#other_product_id_"+id).val(ui.item.id);
        $("#other_product_code_"+id).val(ui.item.code);
        $("#other_product_price_"+id).val(ui.item.price);
        $("#other_product_remark_"+id).val(ui.item.remark);
        var cart_id=id+"_cat_total";
		document.getElementById(cart_id).value =total_cart;
      }
    });
</script>


 