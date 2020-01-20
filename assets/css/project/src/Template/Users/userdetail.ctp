 <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
 <?php  $login_role=($Auth->user('login_role')); ?>
 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"> User Detail</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">User Detail</li>
                        </ol>
                    </div>
                   
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
				<?php echo $this->Form->create('User', array('url' => array('action' => 'updateprofile'), 'enctype' => 'multipart/form-data')) ?>
				
				<input type="hidden" name="customer_id" value="<?php echo $user['id']; ?>"/>
			
				<p><?= $this->Flash->render(); ?></p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                 <b> Basic Detail </b>
								 <span style="float:right;">
								 <?php if($ue['basic_profile']=="n"){ ?>
								 <i class="fa fa-check approve" type="basic"></i>
								 <i class="fa fa-ban reject" type="basic"></i>
								 <?php  }?>
								 </span>
									  <p>Name: <input type="text" name="fullname" class="form-control" value='<?php echo $user['fullname']; ?>'/></p>
									  <p>Display Name: <input type="text" name="display_name" class="form-control" required value='<?php echo $user['display_name']; ?>'/></p>
									  <p>Mobile: <input type="text" name="mobile" class="form-control" value='<?php echo $user['mobile']; ?>'/></p>
									  <p>Alternative Mobile: <input type="text" name=" alternative_mobile" class="form-control" value='<?php echo $ue['alternative_mobile']; ?>'/></p>
									  <p>Email: <input type="text" name="email" class="form-control" value='<?php echo $user['email']; ?>'/></p>
									  <p>City: <input type="text" name="city" class="form-control" value='<?php echo $user['city']; ?>'/></p>
									
									 <p>Latitude: <?php echo $user['latitude']; ?></p>
									  <p>Longitute:<?php echo $user['longitute']; ?></p>
									  <?php if($user['is_suplier']!='n'){ ?>
									 
									 <p>
									  Supplier Pic
									 <?php if($ue['supplier_pic']){ ?>
									<a target="_blank" href="<?php echo $ue['supplier_pic'] ?>">Supplier Pic</a>
									<br/> Change
									 <?php } ?>
									   <input type="file" name="supplier_pic" class="form-control"/>
									</p>
									  <?php } ?>
								
                            </div>
                        </div>
                        
                       
                    </div>
					 <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                  Bank Detail
								   <?php if($ue['bank_profile']=="n"){ ?>
								   <span style="float:right;">
								 <i class="fa fa-check approve" type="bank"></i>
								 <i class="fa fa-ban reject" type="bank"></i>
								 </span>
								   <?php } ?>
									<p>Account Holder Name:  <input type="text" name="account_holder_name" class="form-control" value='<?php echo $ue['account_holder_name']; ?>'/></p>
									<p>Account Number:  <input type="text" name="account_number" class="form-control" value='<?php echo $ue['account_number']; ?>'/></p>
									<p>Bank Name:  <input type="text" name="bank_name" class="form-control" value='<?php echo $ue['bank_name']; ?>'/></p>
									<p>IFSC:  <input type="text" name="ifsc_code" class="form-control" value='<?php echo $ue['ifsc_code']; ?>'/></p>
									<p>Branch Address:  <input type="text" name="bank_address" class="form-control" value='<?php echo $ue['bank_address']; ?>'/></p>
									<p>Branch City:  <input type="text" name="bank_city" class="form-control" value='<?php echo $ue['bank_city']; ?>'/></p>
								
									
									
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
				
				 <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                  Gst Detail 
								  <?php if($ue['gst_profile']=="n"){ ?>
								  <span style="float:right;">
								 <i class="fa fa-check approve" type="gst"></i>
								 <i class="fa fa-ban reject" type="gst"></i>
								 </span>
								  <?php } ?>
									 
									  <p>Gst Number:  <input type="text" name="gst_number" class="form-control" value='<?php echo $ue['gst_number']; ?>'/></p>
								  <p>Pan Number:  <input type="text" name="pancard" class="form-control" value='<?php echo $ue['pancard']; ?>'/></p>
								
									
									
									  <p>
									  <?php if($ue['gst_doc']){ ?>
									  <a target="_blank" href="<?php echo $ue['gst_doc'] ?>">Gst Doc</a>
									  </br>
									  Change
									  <?php } ?>
									   <input type="file" name="gst_doc" class="form-control"/></p>
								
									  </p>
									  <p> 
									    <?php if($ue['pan_card']){ ?>
									  <a target="_blank" href="<?php echo $ue['pan_card'] ?>">Pan card</a>
									   </br>
									  Change
										<?php } ?>
									   <input type="file" name="pan_doc" class="form-control"/></p>
								
									  </p>
									  
                            </div>
                        </div>
						
						<h4>Address List</h4>
						<?php if($is_suplier_p=="y" || $is_suplier_p){ ?>
						<span class="new_address btn btn-primary" style="float:right;">Add </span> <?php } ?>
						<?php if(count($customeradd)>0){ ?>
						    <table id="example24" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											    <?php if($user['is_suplier']=='y'){ ?>
													<th>Shiplite ID</th>
												<?php } ?>
											   <th>Sr No</th>
											   <th>Name</th>
                                                <th>Address</th>
                                                
                                                <th>Zip Code</th>
                                               
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                       
									<tbody>
									
									<?php foreach($customeradd as $a){ 
									$is_default=$a['is_default']; 
									$is_active=$a['is_active'];
									?>
									<tr <?php if($is_default=="y" && $is_active){ echo "style='color:green;font-weight:bold;'";} else if(!$is_active){ echo "style='color:red;'";} ?>>
									 <?php if($user['is_suplier']=='y'){ ?>
													<th><?php echo $a['sellerAddressId']; ?></th>
												<?php } ?>
									<td><?php echo $a['entity_id']; ?></td>
									<td><?php echo $a['name']; ?></td>
									<td><?php echo $a['address'].",".$a['address2']; ?></td>
									<td><?php echo $a['zipcode']; ?></td>
									<td>  
										<?php if($is_suplier_p=="y"){ ?>
                                                   <span  class="edit_address" add_address_prof="<?php echo $a['add_address_prof']; ?>" is_active="<?php echo $a['is_active']; ?>" name="<?php echo $a['name']; ?>" address="<?php echo $a['address']; ?>" address2="<?php echo $a['address2']; ?>"
												   contact="<?php echo $a['contact']; ?>" city="<?php echo $a['city']; ?>" zipcode="<?php echo $a['zipcode']; ?>" state="<?php echo $a['state']; ?>" alternate_contact="<?php echo $a['alternate_contact']; ?>" sellerAddressId="<?php echo $a['sellerAddressId']; ?>" 
												  address_status="<?php echo $a['address_status']; ?>"  is_default="<?php echo $a['is_default']; ?>"   data_id="<?php echo $a['entity_id'];?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </span>
                                                   <!--a href="<?php echo $this->Url->build(['controller'=>'users','action'=>'viewdetail',$user_id]);?>" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-user text-inverse m-r-10"></i> </a!-->
										<?php } ?>
												  </td>
									</tr>
									<?php } ?>
									</tbody>
							</table>
						<?php } ?>
                        
                       
                    </div>
					 <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                  Address Detail
								    <?php if($ue['address_profile']=="n"){ ?>
								  <span style="float:right;">
							 <i class="fa fa-check approve" type="address" ></i>
								 <i class="fa fa-ban reject" type="address"></i>
								 </span>
									<?php } ?>
								<textarea class="form-control" name="address" rows="3" placeholder="Address"><?php echo $ue['address']; ?></textarea>
								<textarea class="form-control" name="address2" rows="3" placeholder="Address 2"><?php echo $ue['address2']; ?></textarea>
									<p>
									 <?php if($ue['address_prof']){ ?>
									<a target="_blank" href="<?php echo $ue['address_prof'] ?>">Address Proff</a>
									<br/> Change
									 <?php } ?>
									   <input type="file" name="address_prof" class="form-control"/>
									</p>
									<?php if($user['is_suplier']!='n'){ ?>
								 <p>Earning Percentage :<input required type="text" name="per_value" class="form-control" value='<?php echo $user['per_value']; ?>'/> </p>
									<p>Delay/Reject/Cancel Penalty For order : 
									<input  required type="Number" maxlength="3" name="delay_penalty" class="form-control" value='<?php echo $user['delay_penalty']; ?>'/> </p>
									 <!--p>
									 Promoted Supplier
									 <?php  $promoted_supllier=$ue['promoted_supllier']; ?>
									   <select required class="form-control" name="promoted_supllier">
									   <option>Select Supplier Promotoion</option>
									   <option value="y" <?php if($promoted_supllier=="y") echo "selected";?>>Yes</option>
									   <option value="n" <?php if($promoted_supllier=="n") echo "selected";?>>No</option>
									   </select>
									 </p!-->
									 <p>Manual Shipping 
									 <?php $manual_ship=$user['manual_ship']; ?>
									 <select name="manual_ship" class="form-control">
									 <option <?php if($manual_ship=="y"){ echo "selected";} ?> value="on">Yes</option>
									 <option <?php if($manual_ship=="n"){ echo "selected";} ?> value="off">No</option>
									 </select>
									 
									 <p>Rating <input type="text" maxlength="3" class="form-control" name="user_rating" value="<?php echo $user['user_rating']; ?>"/></p>
									
									<?php } ?>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
				
				<?php if($user['latitude'] && $user['longitute']) { ?>
				 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> App  Map</h4>
								
								<div id="googleMap" style="width:100%;height:250px;"></div>
                                
                            </div>
                        </div>
                    </div>
                </div>
				<?php } ?>
				 <div class="card-footer">
				<input type="submit" class="btn btn-sm btn-primary" value="Update"/>
				<input type="reset" class="btn btn-sm btn-danger" value="Reset"/>
                
                  
                  
                </div>
					<?php if($user['is_suplier']=="requested"  || $user['is_suplier']=="adminadd") { ?>
					<p  type="make_supplier" class="btn btn-sm btn-primary change_status"><i class="fa fa-check"></i> Make Supplier</p>
					</br> <small>Note: Before Making Supplier Please Check Address is added or not</small>
				<?php } ?>
				<?php if($user['status']=="active"){ ?>
			
				<p   type="block_account" class="btn btn-sm btn-primary change_status"><i class="fa fa-ban change_status" id='block_account'></i> Block Account</p>
				<?php }  else{ ?>
				Account is Blocked ,
				<p   type="active_account" class="btn btn-sm btn-primary change_status"><i class="fa fa-check change_status" id='active_account'></i> Approve Account</p>
				
				<?php } ?>
				</form>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
		<div id="responsive-addaddress-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
								<?php echo $this->Form->create('updateaddress', array('id'=>'add_address','url' => array('action' => 'updateaddress'), 'enctype' => 'multipart/form-data')) ?>
				
								
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
													  <input type="hidden" class="form-control" value="1"  name="add_by">
													  <input type="hidden" class="form-control" value="<?php echo $user['id'];?>"  name="user_id">
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
													  <label for="pwd">Shyplite id:</label>
													  <input type="text" required class="form-control" id="sellerAddressId" placeholder="Shyplite Seller id" name="sellerAddressId">
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
													  <label for="email">Address Prof:</label>
													  <input type="file" name="add_address_prof" id="add_address_prof" class="form-control"/>
													</div>
													
													
													<div class="form-group">
													  <label for="pwd">Make Default:</label>
													  <input type="checkbox" class="form-control" id="is_default" placeholder="Enter text" name="is_default">
													</div>
													<div class="form-group">
													  <label for="pwd">Is Active:</label>
													  <select id="is_active" name="is_active" class="form-control">
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
                                                <button type="button" class="btn btn-primary waves-effect add_save" type="edit">Add</button>
                                                
                                               
                                            </div>
                                        </div>
								
                                    </div>
									</form>
                                </div>	
<div id="responsive-address-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
								
							
								<?php echo $this->Form->create('updateaddress', array('id'=>'edit_address_form','url' => array('action' => 'updateaddress'), 'enctype' => 'multipart/form-data')) ?>
				
							 <div class="modal-dialog" style="max-width:1000px !important;">
									
                                        <div class="modal-content catelog_plan_body">
                                           
										<div class="modal-header">
										  <h4>Edit Address</h4>
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
													  <input type="hidden" class="form-control" value="1"  name="add_by">
													  <input type="hidden" class="form-control" id='address_id'  name="address_id">
													  <input type="hidden" class="form-control" value="<?php echo $user['id'];?>"  name="user_id">
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
													  <label for="pwd">Shyplite id:</label>
													  <input type="text" required class="form-control" id="edit_sellerAddressId" placeholder="Shyplite Seller id" name="sellerAddressId">
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
													    <a target="_blank" href="" style="display:none;" id="address_doc">Address Doc</a>
														</br>
														 <input type="file" name="edit_address_prof" class="form-control"/>
													</div>
													
													<div class="form-group">
													  <label for="pwd">Make Default:</label>
													  <input type="checkbox" class="form-control" id="edit_is_default" placeholder="Enter text" name="is_default">
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
                                                <button type="button" class="btn btn-primary waves-effect edit_save" type="edit" data-dismiss="modal">Edit</button>
                                                
                                               
                                            </div>
                                        </div>
								
                                    </div>
									</form>
                                </div>
	<?php if($user['latitude'] && $user['longitute']) { ?>

 <script>
function myMap() {
	 var latitude='<?php echo $user['latitude']; ?>';
	 var longitute='<?php echo $user['longitute']; ?>';
var mapProp= {
	
  center:new google.maps.LatLng(latitude,longitute),
  zoom:15,
};
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
</script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEgme0IQxpYJUG43PZO9Dg-G0yWG6ompk&callback=myMap"></script>
	<?php } ?>
	
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
			 var sellerAddressId=$('#sellerAddressId').val();
			 if(name && sellerAddressId && zipcode)
			 {
				 $('#add_address').submit();
				// $.ajax({
					// type: "POST",
					 // url: base_url+"/users/updateaddress",
					// data: $('#add_address').serialize(),
					// dataType: 'json',
					// return false;
					// success: function(data){
						
						// alert(data.msg);
						// location.reload();
					// }
					// });	
			 }
              else 
			  {
				    alert("Name,Seller Address Id & ZipCode are required Field");
					return false;
			  }				  
					 
		});
		$('.edit_save').click(function(e) {
		      $("input.edit_save").prop("disabled",false);
			 e.preventDefault();
			 var name=$('#edit_name').val();
			 var zipcode=$('#edit_zipcode').val();
			 var sellerAddressId=$('#edit_sellerAddressId').val();
			 if(name && sellerAddressId && zipcode)
			 {
				$('#edit_address_form').submit();
					
			 }
              else 
			  {
				    alert("Name,Seller Address Id & ZipCode are required Field");
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
		  var add_address_prof=$(this).attr("add_address_prof");
		   $('#address_id').val(data_id);
		   $('#edit_name').val($(this).attr("name"));
		   if(add_address_prof)
		   {
			   $('#address_doc').show();
			  $('#address_doc').attr("href", add_address_prof);
		   }
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
			$(this).attr('disabled', 'disabled');
			$(this).css("display", "none");
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