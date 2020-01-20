<?php  $user_id=($Auth->user('id')); ?>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"> <?php echo $user; ?> Warehouse List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Warehouse  List</li>
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
                                <h4 class="card-title"><?php echo $user; ?> Warehouse List
								<span class="new_address btn btn-primary" style="float:right;">Add </span></h4>
                                <?php  if(count($list)>0){?>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                 <th> ID</th>
											   <th>Name</th>
                                                <th>Mobile</th>
                                                
                                                <th>Address</th>
                                                 <th>Zip code</th>
												<th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                               <th>ID</th>
											     <th>Name</th>
                                                <th>Mobile</th>
                                                
                                                <th>Address</th>
                                                 <th>Zip code</th>
                                                 <th>Date</th>
                                             
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php foreach($list as $a):
										    // $user_id=$l['id'];
											$is_active=$a['is_active'];
											$is_default=$a['is_default'];
											if($a['address_status']=="requested")
											{
												$status = "Requeested Approval";
												$label = "warning";
											}
											if($a['address_status']=="approved")
											{
												$status = "Active";
												$label = "success";
											}
										?>	
										<tr <?php if($is_default=="y" && $is_active){ echo "style='color:green;'";} else if(!$is_active){ echo "style='color:red;'";} ?>>
									
									<td class="center">
									<?php  echo $a['entity_id'];?>
									</td>
								
									<td><?php echo $a['name'];?></td>	
									<td><?php echo $a['contact'];?></td>	
									
									<td><?php echo $a['address']." ".$a['address2'];?></td>	
										
										<td><?php echo $a['zipcode'];?></td>	
									<td><?php echo date('d-m-Y h:i A',strtotime($a['created'])); ?></td>
									<td class="hidden-480">
										<span class="label label-sm label-<?php echo $label ?>"><?php echo $status?></span>
									</td>
									
									 <td class="text-nowrap">
                                                    
                                                 <span  class="edit_address" is_active="<?php echo $a['is_active']; ?>" name="<?php echo $a['name']; ?>" address="<?php echo $a['address']; ?>" address2="<?php echo $a['address2']; ?>"
												   contact="<?php echo $a['contact']; ?>" city="<?php echo $a['city']; ?>" zipcode="<?php echo $a['zipcode']; ?>" state="<?php echo $a['state']; ?>" alternate_contact="<?php echo $a['alternate_contact']; ?>" sellerAddressId="<?php echo $a['sellerAddressId']; ?>" 
												  address_status="<?php echo $a['address_status']; ?>"  is_default="<?php echo $a['is_default']; ?>"   data_id="<?php echo $a['entity_id'];?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-eye text-inverse m-r-10"></i> </span> 
                                                  
											   </td>
									
									
									
								</tr>
                                          <?php endforeach;?>
                                            
                                        </tbody>
                                    </table>
                                </div>   
								<?php  } else { echo "No Warehouse Added, Add First";}?>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
			<div id="responsive-addaddress-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
								
								<form method="post" id="add_address">
							 <div class="modal-dialog" style="max-width:1000px !important;">
									
                                        <div class="modal-content catelog_plan_body">
                                           
										<div class="modal-header">
										  <h4>Add Address</h4>
                                         </div>
                                            <div class="modal-body">
                                                <div class="row">
													<div class="row">
       
										  
										 <div class="col-md-6">
											<div class="card">
												<div class="card-body">
												
													<div class="form-group">
													  <label for="email">Name:</label>
													  <input type="text" class="form-control" id="name" placeholder="Enter Name" name="name">
													  <input type="hidden" class="form-control" value="add"  name="type">
													  <input type="hidden" class="form-control" value="3"  name="add_by">
													  <input type="hidden" class="form-control" value="<?php echo $user_id;?>"  name="user_id">
													</div>
													<div class="form-group">
													  <label for="pwd">Contact:</label>
													  <input type="text" class="form-control" id="contact" placeholder="Enter Contact" name="contact">
													</div>
													<div class="form-group">
													  <label for="pwd">Alter native Contact:</label>
													  <input type="text" class="form-control" id="alternate_contact" placeholder="Extra Mobile No" name="alternate_contact">
													</div>
													
													<div class="form-group">
													  <label for="pwd">City:</label>
													  <input type="text" class="form-control" id="city" placeholder="Enter City Name" name="city">
													</div>
													<div class="form-group">
													  <label for="pwd">State:</label>
													  <input type="text" class="form-control" id="state" placeholder="Enter State Name" name="state">
													</div>
													<div class="form-group">
													  <label for="pwd">Zip:</label>
													  <input type="text" class="form-control" id="zipcode" placeholder="Enter Zip code" name="zipcode">
													</div>
												</div>
												
											</div>
										 </div>
										 <div class="col-md-6">
											<div class="card">
												<div class="card-body">
												
													<div class="form-group">
													  <label for="email">Address:</label>
													  <textarea class="form-control" id="address" name="address" rows="3" placeholder="Address "></textarea>
													</div>
													<div class="form-group">
													  <label for="pwd">Address 2:</label>
													   <textarea class="form-control" id="address2" name="address2" rows="3" placeholder="Address "></textarea>
													</div>
													
													
													
												</div>  
												
											</div>
										 </div>

										
										
									</div>
                      
                    
												</div>
				
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary waves-effect add_save" type="edit">Add</button>
                                                
                                               
                                            </div>
                                        </div>
								
                                    </div>
									</form>
                                </div>	
<div id="responsive-address-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
								
								<form method="post" id="edit_address_form">
							 <div class="modal-dialog" style="max-width:1000px !important;">
									
                                        <div class="modal-content catelog_plan_body">
                                           
										<div class="modal-header">
										  <h4>View Address</h4>
                                         </div>
                                            <div class="modal-body">
                                                <div class="row">
													<div class="row">
       
										  
										 <div class="col-md-6">
											<div class="card">
												<div class="card-body">
												
													<div class="form-group">
													  <label for="email">Name:</label>
													  <input type="text" class="form-control" id="edit_name" placeholder="Enter Name" name="name">
													  <input type="hidden" class="form-control" value="edit"  name="type">
													  <input type="hidden" class="form-control" value="3"  name="add_by">
													  <input type="hidden" class="form-control" id='address_id'  name="address_id">
													  <input type="hidden" class="form-control" value="<?php echo $user_id;?>"  name="user_id">
													</div>
													<div class="form-group">
													  <label for="pwd">Contact:</label>
													  <input type="text" class="form-control" id="edit_contact" placeholder="Enter Contact" name="contact">
													</div>
													<div class="form-group">
													  <label for="pwd">Alter native Contact:</label>
													  <input type="text" class="form-control" id="edit_alternate_contact" placeholder="Extra Mobile No" name="alternate_contact">
													</div>
													
													<div class="form-group">
													  <label for="pwd">City:</label>
													  <input type="text" class="form-control" id="edit_city" placeholder="Enter City Name" name="city">
													</div>
													<div class="form-group">
													  <label for="pwd">State:</label>
													  <input type="text" class="form-control" id="edit_state" placeholder="Enter State Name" name="state">
													</div>
													<div class="form-group">
													  <label for="pwd">Zip:</label>
													  <input type="text" class="form-control" id="edit_zipcode" placeholder="Enter Zip code" name="zipcode">
													</div>
												</div>
												
											</div>
										 </div>
										 <div class="col-md-6">
											<div class="card">
												<div class="card-body">
												
													<div class="form-group">
													  <label for="email">Address:</label>
													  <textarea class="form-control" id="edit_address" name="address" rows="3" placeholder="Address "></textarea>
													</div>
													<div class="form-group">
													  <label for="pwd">Address 2:</label>
													   <textarea class="form-control" id="edit_address2" name="address2" rows="3" placeholder="Address "></textarea>
													</div>
													
													<div class="form-group">
													  <label for="pwd"> Default Status:</label>
													  <input type="checkbox" readonly class="form-control" id="edit_is_default" placeholder="Enter text" name="is_default">
													</div>
													<div class="form-group">
													  <label for="pwd">Is Active:</label>
													  <select id="edit_is_active" name="is_edit_active" class="form-control">
													    <option value="1">Yes</option>
													    <option value="0">No</option>
													  </select>
													</div>
												</div>  
												
											</div>
										 </div>

										
										
									</div>
                      
                    
												</div>
				
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <!--button type="button" class="btn btn-primary waves-effect edit_save" type="edit" data-dismiss="modal">Edit</button!-->
                                                
                                               
                                            </div>
                                        </div>
								
                                    </div>
									</form>
                                </div>
	
<script>
$(document).ready(function(){
	
	var base_url = window.location.origin;
	r_data={};
      $('.approve').click(function() {
			
			var type = $(this).attr("type");
			// alert(type);
			
			var type = $(this).attr("type");
			r_data['type']=type;
			r_data['customer_id']='<?php echo $user['id']; ?>';
			$.ajax({
			type: "POST",
			 url: base_url+"/users/updateprofile",
			data:r_data,
			// return false;
			success: function(data){
				
				    location.reload();
			}
			});
			
	  });
	  
	   $('.add_save').click(function(e) {
		      $("input.add_save").prop("disabled",false);
			 e.preventDefault();
			 var name=$('#name').val();
			 var zipcode=$('#zipcode').val();
			 
			 if(name  && zipcode)
			 {
				$.ajax({
					type: "POST",
					 url: base_url+"/users/updateaddress",
					data: $('#add_address').serialize(),
					dataType: 'json',
					// return false;
					success: function(data){
						// var result = JSON.parse(data);
						// result = JSON.parse(data);
						// alert(data);
						alert(data.msg);
						location.reload();
					}
					});	
			 }
              else 
			  {
				    alert("Name & ZipCode are required Field");
					return false;
			  }				  
					 
		});
		$('.edit_save').click(function(e) {
		      $("input.edit_save").prop("disabled",false);
			 e.preventDefault();
			 var name=$('#edit_name').val();
			 var zipcode=$('#edit_zipcode').val();
		
			 if(name  && zipcode)
			 {
				$.ajax({
					type: "POST",
					 url: base_url+"/users/updateaddress",
					data: $('#edit_address_form').serialize(),
					dataType: 'json',
					// return false;
					success: function(data){
						// var result = JSON.parse(data);
						// result = JSON.parse(data);
						// alert(data);
						alert(data.msg);
						location.reload();
					}
					});	
			 }
              else 
			  {
				    alert("Name & ZipCode are required Field");
					return false;
			  }				  
					 
		});
		$(".new_address").on("click", function(e){
				e.preventDefault();  
				  $('#responsive-addaddress-model').modal('show'); 
		});
		$(".edit_address").on("click", function(e){
			
		   e.preventDefault();   
		   var data_id = $(this).attr("data_id");
		   // alert(data_id);
		   var product_id = $(this).attr("product_id");
		   $('#address_id').val(data_id);
		   $('#edit_name').val($(this).attr("name"));
		   $('#edit_address').val($(this).attr("address"));
		   $('#edit-address2').val($(this).attr("address2"));
		   $('#edit_contact').val($(this).attr("contact"));
		   $('#edit_city').val($(this).attr("city"));
		   $('#edit_zipcode').val($(this).attr("zipcode"));
		   $('#edit_state').val($(this).attr("state"));
		   $('#edit_alternate_contact').val($(this).attr("alternate_contact"));
		   $('#edit_sellerAddressId').val($(this).attr("sellerAddressId"));
		   $('#edit_address_status').val($(this).attr("address_status"));
		   var is_default=$(this).attr("is_default");
		   if(is_default=="y")  
			   $('#edit_is_default').prop('checked', true);
			else
			$('#edit_is_default').prop('checked', false);	
		   // $('#is_default').val($(this).attr("is_default"));
		   $('#edit_is_active').val($(this).attr("is_active"));
		   $('#responsive-address-model').modal('show'); 
		  });
	  $('.reject').click(function() {
			
			var type = $(this).attr("type");
			$("#reject_type").val(type);
			$("#RejectModel").show();
			
	  });
	  $('.close_pop').click(function() {
			
			 $("#RejectModel").hide();
			 // $("#AddCatelog").hide();
			
		});
	    $('.change_status').click(function() {
			
			var status_type = $(this).attr("type");
			// alert(status_type);
			if(status_type=="make_supplier")
			{
				r_data['supplier_status']='y';
			}
			if(status_type=="block_account")
			{
				r_data['user_status']='block';
			}
			if(status_type=="active_account")
			{
				r_data['user_status']='active';
			}
		
			r_data['customer_id']='<?php echo $user['id']; ?>';
			$.ajax({
			type: "POST",
			 url: base_url+"/users/updateprofile",
			data:r_data,
			// return false;
			success: function(data){
				
				    location.reload();
			}
			});
			
	  });
});
</script>