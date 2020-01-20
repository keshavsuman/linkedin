
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
								 <?php $max_count=$pagedata['catelog_count']; ?>
								   <h3>Catelog List for <?php echo $pagedata['category']['name']; ?></h3>
								    <?php foreach ($pagelist as $key => $item) {
									   $shift_pos=$item['shift_pos'];
									   $arr[$shift_pos]=$item;
									   
									   }
									  ?>
									  	<div class="row">
									  <?php for($p=1;$p<=30;$p++){ 
									 
									    $list=$arr[$p];
									     if($list['shift_pos']==$p){ 
										   $image = $this->request->getAttribute("webroot") ."image/". $list['pic'];
										 ?>
										 <div class="card col-3">
											<div class="card-body" style="text-align:center;">
											<img src="<?php echo $image;?>" style="max-width: 80px;">
											  <p><?php echo $list['catelog_name']; ?>
											  <br/> Rs. <?php echo $list['selling_price']; ?><br/>
											  <?php echo $list['seller_name']; ?></p>    
											 <?php if($list['start_utc'] && $list['end_utc']){ 
											     echo "Active From ".$list['start_utc']." - To ".$list['end_utc'];
											 ?>
											   
											   
											 <?php } ?>
											 <i  class="add_catelog"  pos="<?php echo $p; ?>" catelog_count="<?php  echo $list['catelog_count'];?>" cat_id="<?php echo $list['category_id']; ?>" style="text-align:right;float:right;" id="<?php echo $list['id']; ?>" pos="<?php echo $p; ?>">Edit</i>
										
											</div>
											
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
    <div id="responsive-catelog-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog" style="max-width:1000px !important;">
									<form method="post">
									  <input  type="hidden" id="shift_pos" name="shift_pos"/>
									  <input  type="hidden" id="category_id" name="category_id" value="<?php  echo $id;?>"/>
                                        <div class="modal-content catelog_plan_body">
                                           
                                        </div>
									</form>
                                    </div>
                                </div>
   <div class="modal" id="EditCatelog">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Catelog For position <span id='edit_data_pos'></span></h4>
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
		// alert(3);
		var base_url = window.location.origin;
		// alert(base_url);
		r_data={};
		 // $("#AddCatelog").show();
		$(".select2").select2();
	    
		 $('.add_style').click(function() {
	   $("#dynamic_div").clone().appendTo(".apand_div");
	 });
	  $('.add_catelog').click(function() {
		  
			var pos = $(this).attr("pos");
			var category_id='<?php echo $id; ?>';
			// alert(pos);
			$('#shift_pos').val(pos);
			r_data['pos']=pos;
			r_data['category_id']=category_id;
			$.ajax({
			type: "POST",
			url: base_url+"/setting/catelogdetail",
			data:r_data,
			// return false;
			success: function(data){
				 $('#responsive-catelog-model').modal('show'); 
				$(".catelog_plan_body").html(data);
				
			}
			});
			
			
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
 	
<script>

function SellerSearch(val) {
	var base_url = window.location.origin;
		r_data={};
	var pos = $(this).attr("pos");
			var category_id='<?php echo $id; ?>';
			// alert(pos);
			// $('#shift_pos').val(pos);
			// r_data['pos']=pos;
			r_data['category_id']=category_id;
			r_data['seller_id']=val;
			$.ajax({
			type: "POST",
			url: base_url+"/setting/sellercatelog",
			data:r_data,
			// return false;
			success: function(data){
				 $('#print_plan_route').val(val);
				$(".catelog_body").html(data);
				
			}
			});
	
}

</script>