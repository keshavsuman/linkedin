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
                        <h3 class="text-themecolor m-b-0 m-t-0">Order List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Order List</li>
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
                                <h4 class="card-title">Order List</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
										  <form method="post">
								 <div class="row">
								<div class="col-8">
								   
  <div class="form-group">
    <label for="email">Filter By Date:</label>
  
	<input type="text" value='<?php if(isset($daterang)){echo $daterang;} ?>' name="daterange" style="width:50%;" class="form-control"/>
  </div>
  <div class="form-group" style="width:60%;">
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
  </div>
 


 
						</div>
						
								<div class="col-4" style="text-align:left;">
								<?php  if($login_role==1){?>
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
								 	<?php } ?>
								</div>
					
								  <input type="submit" class="btn btn-primary" value="Search"/>
								  &nbsp; &nbsp;
  <a href="http://resellermantra.com/catelog" class="btn btn-primary">Reset</a>   
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
                                                 <th  data-toggle="tooltip" data-original-title="Order id">ORD ID</th>
                                                 <th  data-toggle="tooltip" data-original-title="Order Date">Date</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Name">PNAME</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product ID">PID</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Image">image</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Size">size</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Unit Price">Price</th>
												 <th  data-toggle="tooltip" data-original-title="Product Qty">Qty</th>
												 <?php if($login_role!=2){ if($login_role!=3){ ?>
                                                 <th  data-toggle="tooltip" data-original-title="Final Price">FPrice</th>
												 <?php } else { ?>
												    <th  data-toggle="tooltip" data-original-title="Settelment">Settelment</th>
												 <?php } } ?>
												  <?php if($login_role==2){ ?>
												 <th  data-toggle="tooltip" data-original-title="Shipping">Shipping</th>
												 <th  data-toggle="tooltip" data-original-title="Final Price">Final Price</th>
												 <th  data-toggle="tooltip" data-original-title="Your Profit">Your Profit</th>
												 <?php } ?>
                                                 <th  data-toggle="tooltip" data-original-title="Payment Mode">PMODE</th>
                                                 <th  data-toggle="tooltip" data-original-title="Supplier ID">SID</th>
                                                 <?php if($login_role!=2){ ?>
                                                 <th  data-toggle="tooltip" data-original-title="Reseller ID">RID</th>
												 <?php } ?>
                                               
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
                                                 <th  data-toggle="tooltip" data-original-title="Order id">ORD ID</th>
                                                 <th  data-toggle="tooltip" data-original-title="Order Date">Date</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Name">PNAME</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product ID">PID</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Image">image</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Size">size</th>
                                                 <th  data-toggle="tooltip" data-original-title="Product Unit Price">Price</th>
												 <th  data-toggle="tooltip" data-original-title="Product Qty">Qty</th>
                                                <?php if($login_role!=2){ if($login_role!=3){ ?>
                                                 <th  data-toggle="tooltip" data-original-title="Final Price">FPrice</th>
												 <?php } else { ?>
												    <th  data-toggle="tooltip" data-original-title="Settelment">Settelment</th>
												 <?php } } ?>
												 <?php if($login_role==2){ ?>    
												 <th  data-toggle="tooltip" data-original-title="Shipping">Shipping</th>
												 <th  data-toggle="tooltip" data-original-title="Final Price">Final Price</th>
												 <th  data-toggle="tooltip" data-original-title="Your Profit">Your Profit</th>
												 <?php } ?>
                                                 <th  data-toggle="tooltip" data-original-title="Payment Mode">PMODE</th>
                                                 <th  data-toggle="tooltip" data-original-title="Supplier ID">SID</th>
												 <?php if($login_role!=2){ ?>
                                                 <th  data-toggle="tooltip" data-original-title="Reseller ID">RID</th>
												 <?php } ?>
                                               
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
										
									
									<td  class="center order_detail" o_id="<?php echo $p['item_order_id'];?>" data-toggle="tooltip" data-original-title="<?php echo $s_label; ?>" style="background-color:<?php echo $s_colr;?>;color:black">
									<?php echo $i;?>
									</td>
									
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
															// $events = array_reverse($events);
															foreach($events as $e)
															{  ?>
															
															   <p><?php echo $e['status']; ?></br>
																  
															
															<?php  break;} } 
													  ?>
									</a></span> <?php } ?>
									  
									<br/>
									
									</td>
									<?php
										 if($p['payment_method']==1)
											$order_type="COD";
											else 
											$order_type="PREPAID";
											$shipping_charges=(int)$p['shipping_charges'];
											$qty=$p['qty'];
											$total_shipping=(int)$shipping_charges*$qty;
											$sale_base=(int)$p['sale_base'];
											$r_product_price=(int)$p['sale_base']-$total_shipping;    
											$orignal_value=(int)$p['orignal_value'];
											$cod_amount=(int)$p['cod_amount'];
											$discount_amount=(int)$p['discount_amount'];
											$my_earning=(int)$p['my_earning'];
											$orignal_value_total=$orignal_value*$p['qty'];
											$tcs=(1/ 100) * $orignal_value_total;
											$comission_set=$p['percantage_value'];   
											$comission=($comission_set/ 100) * $orignal_value_total;
											$gst=round((18/ 100) * $comission);
											 $settlement_amount=$orignal_value_total-($tcs+$gst+$comission);
									?>
									<td class="center order_detail" o_id="<?php echo $p['item_order_id'];?>">
									<?php echo "O".$p['item_order_id'];?></td>	
									<td><?php echo date('d-m-Y h:i A',$p['add_utc']);?></td>
									<td><?php echo $p['name'];?></td>
									<td><?php echo $p['catelog_id']."_".$p['product_id'];?></td>
									<td><img src="<?php echo $image;?>" style="max-width: 80px;"></td>
									<td><?php echo $p['size_name'];?></td>
									<td><?php echo (int)$p['primary_price'];?></td>
									<td><?php echo (int)$p['qty'];?></td>	
										
								<?php if($login_role!=2){if($login_role==3){ ?>
								
										<td><?php echo (int)$settlement_amount;?></td>	
									<?php } else { ?>
									<td><?php echo (int)$p['price']*(int)$p['qty'];?></td>	
								<?php } } ?>	
									<?php if($login_role==2){ ?>
									<td><?php echo (int)$total_shipping;?></td>	
									<td><?php echo (int)$p['sale_base'];?></td>	
									<td><?php echo (int)$p['my_earning'];?></td>	
									<?php } ?>
									<td><?php if($p['payment_method']==1){ echo "C";} else { echo "P";}?></td>	
									<td data-toggle="tooltip" data-original-title="<?php echo $p['seller_name']; ?>"><?php echo "S".$p['sid'];?></td>
									<?php if($login_role!=2){ ?>									
									<td data-toggle="tooltip" data-original-title="<?php echo $p['r_name']; ?>"><?php echo "R".$p['rid'];?></td>		
									<?php } ?>		
									
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
															// $events = array_reverse($events);
															foreach($events as $e)
															{  ?>
															
															   <p><?php echo $e['status']; ?></br>
																  
															
															<?php  break;} } 
													  ?>
									</a></span> <?php } ?>
									  
									<br/>
									
									</td>	
										
									<td class="hidden-480">
									<a href="#" class="center order_detail" o_id="<?php echo $p['item_order_id'];?>">Detail
										<span class="label label-sm label-<?php echo $label ?>"><?php echo $status?></span></a>
									</td>
									
								</tr>
                                          <?php $i++; endforeach;?>
                                            
                                        </tbody>
                                    </table>
									<?php } else { echo "No Order";} ?>
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
											
									<form method="post" action='order/changeorderstatus'>
									 <input type="hidden" id='select_order_id' name='select_order_id'>
									 <input type="hidden" id='status_type' name='status_type' value='reject'>
                                        <div class="modal-content" style="margin:2%;">
                                          <div class="form-group">
										  <br/>
											  <label>&nbsp;&nbsp;Comment For rejection</label>
											  <textarea id="form10" name="comment" style="margin: 9%;/*! padding: 8%; */width: 77%;" class="md-textarea form-control" rows="3"></textarea>
											 
										</div>
										   <div class="form-group">
										 
											  <label>&nbsp;&nbsp;Penlty </label>
												<input type="checkbox" name="penlty" value="y"> Yes  
										
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
											
									<form method="post" action='order/changeorderstatus'>
									 <input type="hidden" id='change_order_id' name='select_order_id'>
									
                                        <div class="modal-content" style="margin:2%;">
                                          <div class="form-group">
										  <br/>
											  <label>&nbsp;&nbsp;Current Status <span id='cur_order_status'></span></label>
											
										</div>
										<div class="form-group" id='change_status_order' style="padding:3%;">
											  <label for="sel1">Change Status:</label>
											  <select class="form-control" name="change_status">
												<option value='-1'>Select Status</option>
											
												<option value='3'>Dispatch</option>
												<option value='6'>Delivered</option>
												<option value='7'>RTO</option>
												
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
$(document).ready(function(){
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
  $(".track_order").on("click", function(e){
		e.preventDefault();   
		var data_id = $(this).attr("data-id");
		var manual_ship = $(this).attr("manual_ship");
		 $.ajax({
           
			  url:"/order/trackorder/",
			type: 'GET',
            // This is query string i.e. country_id=123
            data: {id :data_id,manual_ship:manual_ship},
            success: function(data) {  
					
				 // $('#select_catelog_id').val(select_catelog_id);
				  $('#responsive-track-model').modal('show'); 
				$(".catelog_plan_body").html(data);
				 
				 
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
		 $('#responsive-track-model').modal('show'); 
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