  <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">App  List Setup</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">App  List Setup</li>
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
                              
                                 <div class=" m-t-40">
								 
								   <h3>Home page order list</h3>
								   <?php foreach ($pagelist as $key => $item) {
									   $shift_pos=$item['shift_pos'];
									   $arr[$shift_pos]=$item;
									   
									   }
									  
									   ?>
									<div class="row">
									  <?php for($p=1;$p<=10;$p++){ 
									 
									    $list=$arr[$p];
									     if($list['shift_pos']==$p){ 
										    $image= $this->request->getAttribute("webroot") ."category-thumbnail/". $list['category']['thumbnail'];
										 ?>
										 <div class="card col-3">
											<div class="card-body" style="text-align:center;">
											<img src="<?php echo $image;?>" style="max-width: 80px;">
											  <p><?php echo $list['category']['name']; ?></p>
											  <p> Catelog Count : <?php echo $list['catelog_count']; ?></p>
											 
											  <a href="<?php echo $this->Url->build(['controller'=>'setting','action'=>'cateloglist',$list['category']['id']])?>">Catelog List</a>
											</div>
											<i  class="edit_catelog" catelog_count="<?php  echo $list['catelog_count'];?>" cat_id="<?php echo $list['category_id']; ?>" style="text-align:right" id="<?php echo $list['id']; ?>" pos="<?php echo $p; ?>">Edit</i>
										</div>
										 <?php } else {
									  ?>
									     <div class="card col-3 add_catelog"  data-toggle="modal" data-target="#myModal"  pos="<?php echo $p; ?>">
											<div class="card-body" style="text-align:center;">
											<p> Add </p>
											</div>
										</div>
										 <?php  } } ?>
									</div>
								  
									
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
				 
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
               <!-- The Modal -->
  <div class="modal" id="AddCatelog">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Catelog Category For position <span id='data_pos'></span></h4>
          <button type="button" class="close close_pop" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<form method="post">
             <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input">Select Category</label>
					  <div class="col-md-8 autocomplete">
                       <input type="hidden" name="shift_pos" id="shift_pos"/>
                         <select id="category_id" name="category_id" required  class="select2 seller_name form-control" style="width: 100%">
                                    <option>Select Category</option>
									<?php foreach($root_category as $category){ ?>
                                    <option  value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
									<?php } ?>   
                                </select>
								
                      </div>
                    
            </div> 
			   <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input">Catelog Count</label>
					  <div class="col-md-8 autocomplete">
                        <input type="Number" class="form-control" maxlength="2" name="catelog_count" required/>
						</br>
					  </br>
					  <input type="submit" class="btn btn-primary" value="Add"/>
                      </div>
					  
                    
            </div> 
			</form>
			
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger close_pop" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
   <div class="modal" id="EditCatelog">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Catelog Category For position <span id='edit_data_pos'></span></h4>
          <button type="button" class="close close_pop" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<form method="post" id="edit_catelog_form">
             <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input">Select Category</label>
					  <div class="col-md-8 autocomplete">
                       <input type="hidden" name="shift_pos" id="edit_shift_pos"/>
                         <select id="edit_category_id" name="category_id" required  class="form-control" style="width: 100%">
                                   
									<?php foreach($root_category as $category){ ?>
                                    <option  value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
									<?php } ?>   
                                </select>
								
                      </div>
                    
            </div> 
			   <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input">Catelog Count</label>
					  <div class="col-md-8 autocomplete">
                        <input type="Number" class="form-control" id="catelog_count" maxlength="2" name="catelog_count" required/>
						</br>
					  </br>
					  <input type="submit" class="btn btn-primary" value="Edit"/>
					  
                      </div>
					  
                    
            </div> 
			</form>
			
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger close_pop" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
	

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
 <script>
    jQuery(document).ready(function() {
		 // $("#AddCatelog").show();
		$(".select2").select2();
	
		 $('.add_style').click(function() {
	   $("#dynamic_div").clone().appendTo(".apand_div");
	 });
	    $('.add_catelog').click(function() {
			var pos = $(this).attr("pos");
			// alert(pos);
				$("#shift_pos").val(pos);
			$('#data_pos').html(pos);
		
			 $("#AddCatelog").show();
			
		});
		 $('.edit_catelog').click(function() {
			var pos = $(this).attr("pos");
			var catelog_count = $(this).attr("catelog_count");
			var category_id = $(this).attr("cat_id");
			// alert(pos);
				$("#edit_shift_pos").val(pos);
				$("#edit_category_id").val(category_id);
				$("#catelog_count").val(catelog_count);
			$('#edit_data_pos').html(pos);
		
			 $("#EditCatelog").show();
			
		});
		$('.close_pop').click(function() {
			
			 $("#EditCatelog").hide();
			 $("#AddCatelog").hide();
			
		});
		$("#edit_catelog_form").submit(function(e) {

				e.preventDefault(); // avoid to execute the actual submit of the form.
				
				var form = $(this);
				var url = form.attr('action');

				$.ajax({
					   type: "POST",
					   url:'edithomepage',
					   data: form.serialize(), // serializes the form's elements.
					   success: function(data)
					   {
						   location.reload();
					   }
					 });


});
  
	});
 </script>