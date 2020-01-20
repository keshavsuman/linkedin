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
                        <h3 class="text-themecolor m-b-0 m-t-0">Order Return By Customer List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Order Return By Customer  List</li>
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
                                <h4 class="card-title">Order Return By Customer  List</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
										  <form method="post">
								 <div class="row">
								<div class="col-8">
								   
  <div class="form-group">
    <label for="email">Filter By Date:</label>
  
	<input type="text" value='<?php if(isset($daterang)){echo $daterang;} ?>' name="daterange" style="width:50%;" class="form-control"/>
  </div>
  <!--div class="form-group" style="width:60%;">
    <label for="email">Filter By Status:</label>
  
	<select class="form-control" name="status_id">
	<option value="all">All Status</option>
	<option value="1">APPROVAL PENDING</option>
	<option value="2">Waiting for pickup</option>
	<option value="3">Delivery Pending</option>
	<option value="4">Cancel</option>
	<option value="5">Cancel with penalty</option>
	<option value="6">Delivered</option>
	<option value="7">Rto</option>
	<option value="8">Return By customer</option>
	<option value="9">Approval For payment</option>
	<option value="10">Close/Payment Done</option>
	<option value="11">Rejected</option>
	<option value="12">Dispute with penalty</option>
	<?php  foreach($users as $u){
		
		?>
	<option value="<?php echo $u['id'];?>"><?php echo  $u['display_name'].",".$u['mobile'];?></option>
	<?php } ?>
	</select>
  </div!-->
 


 
						</div>
								<div class="col-4" style="text-align:left;">
								    <div class="form-group">
    <label for="email">Filter By Supplier:</label>
  
	<select class="form-control" name="seller_id">
	<option value="all">All user</option>
	<?php  foreach($sellerdata as $u){
		
		?>
	<option value="<?php echo $u['id'];?>"><?php echo  $u['display_name'].",".$u['mobile'];?></option>
	<?php } ?>
	</select>
  </div>
     <div class="form-group">
    <label for="email">Filter By Reseller:</label>
  
	<select class="form-control" name="reseller_id">
	<option value="all">All user</option>
	<?php  foreach($resellerdata as $u){
		
		?>
	<option value="<?php echo $u['id'];?>"><?php echo  $u['display_name'].",".$u['mobile'];?></option>
	<?php } ?>
	</select>
  </div>
		
								<!--
								Color Sheed  New catelog - Blue <br/>
								  <span class="label label-sm label-danger">Inactive</span>  - Inactive Catelog  <br/>
								  <span class="label label-sm label-success">Active</span>  - Live Catelog  <br/>
								  <span class="label label-sm label-warning">Blocked</span>  - Blocked Catelog <br/>
								 !-->
								</div>
								  <input type="submit" class="btn btn-primary" value="Search"/>
								  &nbsp; &nbsp;
  <a href="http://52.66.195.100/order/rto" class="btn btn-primary">Reset</a>
  </br>
  </br>
								</div>
								</form> 
		
								<?= $this->Flash->render(); ?>
								
								
                                <div class="table-responsive m-t-40">
                                    <?php if(count($product_data)>0){ ?>
									<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                 <th  data-toggle="tooltip" data-original-title="Sr No">Sr No</th>
                                                 <th  data-toggle="tooltip" data-original-title="Current Status">CS</th>
                                                 <th  data-toggle="tooltip" data-original-title="Comment">Comment</th>
                                                 <th  data-toggle="tooltip" data-original-title="Reason">Reason</th>
                                                 <th  data-toggle="tooltip" data-original-title="Order id">ORD ID</th>
                                                 <th  data-toggle="tooltip" data-original-title="Order Date">Date</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Name">PNAME</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product ID">PID</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Image">image</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Size">size</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Unit Price">Price</th>
												 <th  data-toggle="tooltip" data-original-title="Product Qty">Qty</th>
                                                 <th  data-toggle="tooltip" data-original-title="Final Price">FPrice</th>
                                                 <th  data-toggle="tooltip" data-original-title="Payment Mode">PMODE</th>
                                                 <th  data-toggle="tooltip" data-original-title="Supplier ID">SID</th>
                                                 <th  data-toggle="tooltip" data-original-title="Reseller ID">RID</th>
                                               
                                                  <th  data-toggle="tooltip" data-original-title="Customer Name">Cus Name </th>
                                                 <th  data-toggle="tooltip" data-original-title="Pincode">Pincode</th>
                                                
                                                <th  data-toggle="tooltip" data-original-title=""></th>
                                                 <th>Action</th>
											  
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                                <th  data-toggle="tooltip" data-original-title="Sr No">Sr No</th>
                                                 <th  data-toggle="tooltip" data-original-title="Current Status">CS</th>
												   <th  data-toggle="tooltip" data-original-title="Comment">Comment</th>
                                                 <th  data-toggle="tooltip" data-original-title="Reason">Reason</th>
                                                 <th  data-toggle="tooltip" data-original-title="Order id">ORD ID</th>
                                                 <th  data-toggle="tooltip" data-original-title="Order Date">Date</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Name">PNAME</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product ID">PID</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Image">image</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Size">size</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Unit Price">Price</th>
												 <th  data-toggle="tooltip" data-original-title="Product Qty">Qty</th>
                                                 <th  data-toggle="tooltip" data-original-title="Final Price">FPrice</th>
                                                 <th  data-toggle="tooltip" data-original-title="Payment Mode">PMODE</th>
                                                 <th  data-toggle="tooltip" data-original-title="Supplier ID">SID</th>
                                                 <th  data-toggle="tooltip" data-original-title="Reseller ID">RID</th>
                                               
                                                  <th  data-toggle="tooltip" data-original-title="Customer Name">Cus Name </th>
                                                 <th  data-toggle="tooltip" data-original-title="Pincode">Pincode</th>
                                                
                                                <th  data-toggle="tooltip" data-original-title=""></th>
                                                 <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php $i=1; foreach($product_data as $p):
										
										   $image = $this->request->getAttribute("webroot") ."image/". $p['pic'];
												// die;
											if($p['status']==1)
											{
												$v_status = "Enabled";
												$label = "success";
											}
											elseif($p['status']==2)
											{
												$v_status = "Disabled";	
												$label = "warning";	
											}
												if($p['manual_ship']=="y")
											{
												
												$s_colr="#7460EE";
												$s_label="Manual";
											}
											else
											{
												$s_colr="";
												$s_label="Ship";
											}
										?>	
										<tr role="row" class="odd">
									<a style="color:black;" href="<?php echo $this->Url->build(['controller'=>'order','action'=>'orderdetail',$p['item_order_id']])?>">
									<td class="center" data-toggle="tooltip" data-original-title="<?php echo $s_label; ?>" style="background-color:<?php echo $s_colr;?>;color:black">
									<?php echo $i;?>
									</td></a>
									
										<td class="hidden-480">
										<span style="color:black;" class="label label-sm label-<?php echo $label ?>"><?php echo $p['show_status'];?></span>
										<?php  $arr = array('applied','pickup');
										     
												if(in_array($p['is_return_applicable'],$arr)==true) { ?>
										  <span class="change_status"  data-id='<?php echo $p['item_order_id']; ?>' order_status="<?php echo $p['is_return_applicable'];?>" show_status="<?php echo $p['show_status'];?>" data-toggle="tooltip" data-original-title="Change Status"> <i class="fa fa-check text-inverse m-r-10"></i> </span>
										 
										<?php } 
										     
												if(in_array($p['is_return_applicable'],$arr)==true) { ?>
										 <span class="track_order" manual_ship='y' return_carrierName='<?php echo $p['return_carrierName'];?>' 
										 return_track_url='<?php echo $p['return_track_url']; ?>'  return_awbNo='<?php echo $p['return_awbNo']; ?>' data-id='<?php echo $p['item_order_id']; ?>' data-toggle="tooltip" data-original-title="Track Status"><i class="fa fa-map-marker text-inverse m-r-10"></i> </span>
												
												<?php } ?>
										
									
										
										<!--a href="#" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a!-->
                                       <?php // $arr = array('4','11','8','6');
												if(in_array($p['is_return_applicable'],$arr)==true) {?>
										 <span class="reject_order" data-id='<?php echo $p['item_order_id']; ?>' data-toggle="tooltip" data-original-title="Reject Return"> <i class="fa fa-close text-danger"></i> </span>
												
												<?php } ?>  
									</td>
									<td><?php echo $p['comment'];?></td>
									<td><?php echo $p['reason'];?></td>
									<td class="center order_detail" o_id="<?php echo $p['item_order_id'];?>">
									
									<?php echo "O".$p['item_order_id'];?></td>	
									
									<td><?php echo date('d-m-Y h:i A',$p['add_utc']);?></td>
									<td><?php echo $p['name'];?></td>
									<td><?php echo $p['product_id'];?></td>
									<td><img src="<?php echo $image;?>" style="max-width: 80px;"></td>
									<td><?php echo $p['size_name'];?></td>	
									<td><?php echo (int)$p['price'];?></td>	
									<td><?php echo (int)$p['qty'];?></td>	
									<td><?php echo (int)$p['base_price'];?></td>	
									<td><?php if($p['payment_method']==1){ echo "P";} else { echo "C";}?></td>	
									<td data-toggle="tooltip" data-original-title="<?php echo $p['seller_name']; ?>"><?php echo "S".$p['sid'];?></td>		
									<td data-toggle="tooltip" data-original-title="<?php echo $p['r_name']; ?>"><?php echo "R".$p['rid'];?></td>		
											
									
									<td><?php echo $p['aname'];?></td>		
									<td><?php echo $p['zipcode'];?></td>		
									<td>
									<?php 
									$track_output=$p['track_status'];
														 if($track_output)
														 { ?>
									<span class="label label-sm label-success">
									<a style="color:white;" href="<?php echo $this->Url->build(['action'=>'index'])?>">
									<?php
														  
														 $res=json_decode($track_output,true);
														 if($res['data']['events'])
														 {
															
															$events=$res['data']['events'];
															$events = array_reverse($events);
															foreach($events as $e)
															{  ?>
															
															   <p><?php echo $e['status']; ?></br>
																  
															
															<?php } } 
													  ?>
									</a></span> <?php } ?>
									  
									<br/>
									
									</td>	
										
									<td class="hidden-480">
									<a href="<?php echo $this->Url->build(['controller'=>'order','action'=>'orderdetail',$p['item_order_id']])?>">Detail
										<span class="label label-sm label-<?php echo $label ?>"><?php echo $status?></span></a>
									</td>
									
								</tr>
                                          <?php $i++; endforeach;?>
                                            
                                        </tbody>
                                    </table>
									<?php } else { echo "No Order In Return By Customer";} ?>
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                   <div id="responsive-reject-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<?php echo  $this->Form->create('Reject', array(
		'url' => array('controller' => 'order', 'action' => 'changeorderstatus')
	)); ?>		
								
									 <input type="hidden" id='select_order_id' name='select_order_id'>
									 <input type="hidden" id='status_type' name='status_type' value='rejectreturn'>
                                        <div class="modal-content" style="margin:2%;">
                                          <div class="form-group">
										  <br/>
											  <label>&nbsp;&nbsp;Comment For rejection</label>
											  <textarea id="form10" name="comment" style="margin: 9%;/*! padding: 8%; */width: 77%;" class="md-textarea form-control" rows="3"></textarea>
											 
										</div>

									                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                               
												  <button type="submit" class="btn btn-primary">Reject</button>
                                        </div>
									</form>
                                    </div>
                                </div>
						  <div id="responsive-status-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											
									<?php echo  $this->Form->create('Reject', array(
					'url' => array('controller' => 'order', 'action' => 'changeorderstatus')
				)); ?>		
												  <input type="hidden" id='change_order_id' name='select_order_id'>
									 <input type="hidden" id='status_type' name='status_type' value='returnaccept'>
                                        <div class="modal-content" style="margin:2%;">
                                          <div class="form-group">
										  <br/>
											  <label>&nbsp;&nbsp;Current Status <span id='cur_order_status'></span></label>
											
										</div>
										<div class="form-group" id='change_status_order' style="padding:3%;">
											  <label for="sel1">Change Status:</label>
											  <select class="form-control" name="change_status">
												<option value='-1'>Select Status</option>
											
												<option value='returnpickup'>Retrun Accepted</option>
												<option value='completed'>Completed Refund</option>
												
											  </select>
											    <label for="sel1">Comment:</label>
											   <textarea id="form10" name="comment" style="margin: 9%;/*! padding: 8%; */width: 77%;" class="md-textarea form-control" rows="3"></textarea>
											 
											</div>
											
										                                          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                               
												  <button type="submit" class="btn btn-primary">Change Status</button>
                                        </div>
									</form>
                                    </div>
                                </div>
					 <div id="responsive-track-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											
									
									  
                                       <div class="modal-content catelog_plan_body">
                                           
 <div class="modal-header">
                                               
											
								<label>Return Track order<label>			
											
											
                                               
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
												
													<?php echo  $this->Form->create('Reject', array(
					'url' => array('controller' => 'order', 'action' => 'returnupdate')
				)); ?>		
												
													 <input type="hidden" id='return_order_id' name='return_order_id' value='<?php echo $i['item_order_id'];?>'>
													
														<div class="modal-content" style="margin:2%;">
														<div class="form-group">
														
														 
															  <label> Carrier Name</label>
																
															<input type="text" name='return_carrierName' id='return_carrierName'/>
														</div>
														  <div class="form-group">
														 
														 
															  <label>&nbsp;&nbsp; Tracking Url </label>
																
															<input type="text" name='return_track_url' id="return_track_url"/>
														</div>
														  <div class="form-group">
														
														 
															  <label>Awb No</label>
																
															<input type="text" name='return_awbNo' id='return_awbNo'/>
														</div>
										   
												  <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
									</form>
											
                    
										</div>
				
                                            </div>
										<div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
											 
												 
                                            </div>
                                        </div>
										 </div>
									
                                    </div>
                                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
<script>
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
  $(".track_order").on("click", function(e){
	   e.preventDefault();   
	    var data_id = $(this).attr("data-id");
		// alert(data_id);
	    var return_carrierName = $(this).attr("return_carrierName");
	    var return_track_url = $(this).attr("return_track_url");
	    var return_awbNo = $(this).attr("return_awbNo");
	     $('#return_order_id').val(data_id);
	     $('#return_carrierName').val(return_carrierName);
	     $('#return_track_url').val(return_track_url);
	     $('#return_awbNo').val(return_awbNo);
		 $('#responsive-track-model').modal('show'); 
		// $(".catelog_plan_body").html(data);
				 
	});
  $(".reject_order").on("click", function(e){
	   e.preventDefault();   
	   var data_id = $(this).attr("data-id");
	   // var select_catelog_id = $(this).attr("select_catelog_id");
		 $('#select_order_id').val(data_id);
		 $('#responsive-reject-model').modal('show'); 
		// $(".catelog_plan_body").html(data);
				 
	});
	 $(".change_status").on("click", function(e){
	   e.preventDefault();   
	     var data_id = $(this).attr("data-id");
	     var order_status = $(this).attr("order_status");
		 // alert(order_status);
		 if(order_status==4)
		 {
			 $('#change_status_order').hide();
		 }
	     var show_status = $(this).attr("show_status");
		 $('#change_order_id').val(data_id);
		 $('#cur_order_status').html(show_status);
		   $('#responsive-status-model').modal('show'); 
	 });
});
</script>