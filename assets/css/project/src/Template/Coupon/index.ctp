<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script> 
 <link href="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet"> 
   <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Coupon List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Coupon List </li>
                        </ol>
                    </div>
                   
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
				<form method="post">
				 <div class="row">
 					
				   <div class="col-lg-6">
                        
                            <div class="card-body">
							 <h4 class="card-title">Add New Coupon</h4>
                               
                             <?php echo $this->Flash->render() ?>
							
                                    <div class="form-group">
                                   
                                        <div class="input-group">
                                            <input type="text" id="name" name="title" placeholder="Label Name" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                                    </div>
							<div class="form-group">
                                  
                                        <div class="input-group">
                                            <input type="text" id="name" name="coupon_code" placeholder="Coupon Code" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                                    </div>
									  <div class="form-group">
                                        <label for="exampleInputuname2">Coupon Method</label>
                                        <div class="input-group">
                                           <select class="form-control" name="coupon_method">
										     <option value="fix">Fix Coupon</option>
										     <option value="bulk"> Random Coupon</option>
										   </select>
                                        </div>
                                    </div>
									 <div class="form-group">
                                        <label for="exampleInputuname2">Coupon Count</label>
                                        <div class="input-group">
											<input type="text" value="1"  required name="coupon_stock" placeholder="Coupon Count" class="required-entry form-control"/>
                                        </div>
                                    </div>
										<div class="form-group">
                                        <label for="exampleInputuname2">Assign To</label>
                                        <div class="input-group">
                                         <select class="form-control" name="assign_to">
										     <option value="all">All user</option>
										     <option value="specific">Specific User</option>
										   </select>
                                        </div>
                            </div>
									
									
                                     
                                     
                                 
                               
                            </div>
                     
                    </div>
					 <div class="col-lg-6">
					    <div class="form-group">
                                   
                                        <div class="input-group">
											<input type="text" id="name" name="min_amount" placeholder="Min Amount" class="required-entry form-control"/>
                                        </div>
                                    </div>
									 <div class="form-group">
                                   
                                        <div class="input-group">
											<input type="text" id="name" name="max_amount" placeholder="Max Amount" class="required-entry form-control"/>
                                        </div>
                                    </div>
							<div class="form-group">
                                        <label for="exampleInputuname2">Discount Amount</label>
                                        <div class="input-group">
                                            <input type="text" required id="discount" name="discount" placeholder="Discount Amount" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                            </div>
							<div class="form-group">
                                        <label for="exampleInputuname2">Coupon Value</label>
                                        <div class="input-group">
                                         <select class="form-control" name="coupon_type">
										     <option value="fix">Fix value</option>
										     <option value="per">Percentage Based Coupon</option>
										   </select>
                                        </div>
                            </div>
							<div class="form-group">
                                        <label for="exampleInputuname2">Valid From</label>
                                        <div class="input-group">
                                            <input type="text" id="valid_from" name="valid_from" placeholder="Valid From" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                            </div>
							<div class="form-group">
                                        <label for="exampleInputuname2">Valid To</label>
                                        <div class="input-group">
                                            <input type="text" id="valid_to" name="valid_to" placeholder="Valid to" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                            </div>
							                                 
						   <div class="text-right">
                                        <input type="submit" value="Save" class="btn btn-sm btn-success"/>
									
								<button type="reset" name="delete" value="delete" class="btn btn-sm btn-danger">
									Reset 
									<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
								</button>   
                                    </div>
					 </div>
				
			</div><!-- /.page-content -->
			 </form>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Coupon List</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                               
                                                <th>Coupon Label</th>
                                                <th>Coupon  Code</th>
                                                <th>Type</th>
                                                <th>Count</th>
                                                <th>Amount</th>
                                             
                                                <th>Valid From</th>
                                                <th>Valid To</th>
                                               
                                              
                                                <th>Action</th>
                                              
                                            </tr>
                                        </thead>
                                        <tfoot>
                                          <tr>    
                                               <th>Coupon Label</th>
                                                <th>Coupon  Code</th>
                                                <th>Type</th>
                                                <th>Count</th>
                                                <th>Amount</th>
                                              
                                                <th>Valid From</th>
                                                <th>Valid To</th>
                                               
                                              
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php foreach($record as $m): ?>	
                                            <tr>
                                               
                                              
									<td class="center"><?php echo $m['title'];?></td>
                                                <td><?php echo $m['coupon_code'];?></td>
                                                <td><?php echo $m['coupon_type'];?></td>
                                                <td><?php echo $m['coupon_stock'];?></td>
                                                <td data-toggle="tooltip" data-original-title="Change Status"><?php echo $m['discount'];?></td>
                                               <td><?php if($m['valid_from']){ echo $m['valid_from'];} else { echo "--";} ?></td>
                                               <td><?php if($m['valid_to']){ echo $m['valid_to'];} else { echo "--";} ?></td>
                                               
                                                <td>
												<?php  if($m['assign_to']!='all'){?>
												 <span class="change_status"><i class="fa fa-plus text-inverse m-r-10 add_user" coupon_id="<?php echo $m['id']; ?>"></i> </span>
												
												 <span class="change_status"><i class="fa fa-user text-inverse m-r-10 assign_user" coupon_id="<?php echo $m['id']; ?>"></i> </span>
												
												<?php  } ?>
												 <span class="change_status"><i class="fa fa-edit text-inverse m-r-10 edit_coupon" coupon_id="<?php echo $m['id']; ?>"></i> </span>
												 </td>
                                            </tr>
											<?php endforeach;?>
                                           
                                            
                                        </tbody>
                                    </table>
                                </div>
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
	
  <div class="modal" id="Adduser">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add User To Coupon</h4>
          <button type="button" class="close close_pop" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<form method="post" action="coupon/assigncouponuser">
             <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input">Select User</label>
					  <div class="col-md-8 autocomplete">
                       <input type="hidden" name="promo_id" id="promo_id"/>   
                         <select id="user_id" name="user_id" required  class="select2 seller_name form-control" style="width: 100%">
                                    <option>Select User</option>
									<?php foreach($userlist as $u){ 
									
									?>
                                    <option  value="<?php echo $u['id']; ?>"><?php if($u['is_suplier']=="y"){ echo "S";}else {echo "R";} echo $u['id'].",".$u['mobile']; ?></option>
									<?php } ?>   
                                </select>
								
                      </div>
                    
            </div> 
			   <div class="form-group row">
					
					  <div class="col-md-8 autocomplete">
                       
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
<script>
$(document).ready(function() {
	$('.close_pop').click(function() {
			$("#Adduser").hide();
			$("#AddCatelog").hide();
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
			url: base_url+"/coupon/  $('.add_catelog').click(function() {
		  
			var pos = $(this).attr("pos");
			var category_id='<?php echo $id; ?>';
			// alert(pos);
			$('#shift_pos').val(pos);
			r_data['pos']=pos;
			r_data['category_id']=category_id;
			$.ajax({
			type: "POST",
			url: base_url+"/setting/couponuser",
			data:r_data,
			// return false;
			success: function(data){
				 $('#responsive-catelog-model').modal('show'); 
				$(".catelog_plan_body").html(data);
				
			}
			});
			
			
	  });",
			data:r_data,
			// return false;
			success: function(data){
				 $('#responsive-catelog-model').modal('show'); 
				$(".catelog_plan_body").html(data);
				
			}
			});
			
			
	  });
		$(".select2").select2();
   $('.add_user').click(function() {
	   var coupon_id= $(this).attr("coupon_id");
	   $('#promo_id').val(coupon_id);
	   $("#Adduser").show();
	 });
   
});
 $('#valid_to').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY HH:mm', minDate : new Date() });
 $('#valid_from').bootstrapMaterialDatePicker({ format : 'DD/MM/YYYY HH:mm', minDate : new Date() });
</script>