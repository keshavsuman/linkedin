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
                        <h3 class="text-themecolor m-b-0 m-t-0">D+5 Order List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">D+5 Order List</li>
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
                                <h4 class="card-title">All Payment Proceed Order</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
								   <div class="row">
								<div class="col-8">
								     <form method="post">
  <div class="form-group">
    <label for="email">Filter By Date:</label>
  
	<input type="text" value='<?php if(isset($daterang)){echo $daterang;} ?>' name="daterange" style="width:50%;" class="form-control"/>
  </div>
 
  <input type="submit" class="btn btn-primary" value="Search"/>
  <a href="http://52.66.195.100/catelog" class="btn btn-primary">Reset</a>
 
 
</form> 
								</div>
								<div class="col-4">

								<!--
								Color Sheed  New catelog - Blue <br/>
								  <span class="label label-sm label-danger">Inactive</span>  - Inactive Catelog  <br/>
								  <span class="label label-sm label-success">Active</span>  - Live Catelog  <br/>
								  <span class="label label-sm label-warning">Blocked</span>  - Blocked Catelog <br/>
								 !-->
								</div>
								
								</div>
								<?= $this->Flash->render(); ?>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                 <th>Sr No</th>
												 	<th>ORD ID</th>
												  <th>SID</th>
                                                 <th>RID</th>
												 <th>PID</th>
												 <th>Image</th>
												 <th>RM Comm.</th>
												
													<th>Order Date</th>
												 <th>Qty</th>
												 <th>Price</th>
                                                 <th>FPrice</th>
                                                 <th>TCS</th>
                                                 <th>Total RM Comm.</th>
                                                 <th>18% GST</th>
                                                 <th>Penalty Charges </th>
                                                 <th>Settl Amount </th>
                                                 <th>R Comm. </th>
                                                 <th>R offer </th>
                                                 <th>R Earning </th>
                                               
                                                 <th>Action</th>
												   
											  
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                                 <th data-toggle="tooltip" data-original-title="Sr No">Sr No</th>
												 	<th>ORD ID</th>
												  <th>SID</th>
                                                 <th>RID</th>
												 <th>PID</th>
												 <th>Image</th>
												 <th>RM Comm.</th>
												
													<th>Order Date</th>
												 <th>Qty</th>
												 <th>Price</th>
                                                 <th>FPrice</th>
                                                 <th>TCS</th>
                                                 <th>Total RM Comm.</th>
                                                 <th>18% GST</th>
                                                 <th>Penalty Charges </th>
                                                 <th>Settl Amount </th>
                                                 <th>R Comm. </th>
                                                 <th>R offer </th>
                                                 <th>R Earning </th>
                                                
                                                 <th>Action</th>
												 
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php $i=1; foreach($pproduct_data as $p):
										// pr($p);
										// die;
										   $image = $this->request->getAttribute("webroot") ."image/". $p['pic'];
												// die;
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
										?>	
										<tr role="row" class="odd">
									
									<td class="center order_detail" o_id="<?php echo $p['item_order_id'];?>" data-toggle="tooltip" data-original-title="<?php echo $s_label; ?>" style="background-color:<?php echo $s_colr;?>;color:black"><?php echo $i;?></td>
									<td class="center order_detail" o_id="<?php echo $p['item_order_id'];?>"><?php echo "O".$p['item_order_id'];?></td>	
									<td data-toggle="tooltip" data-original-title="<?php echo $p['seller_name']; ?>"><?php echo "S".$p['sid'];?></td>		
									<td data-toggle="tooltip" data-original-title="<?php echo $p['r_name']; ?>"><?php echo "R".$p['rid'];?></td>	
									<td data-toggle="tooltip" data-original-title="<?php echo $p['name']; ?>"><?php echo $p['product_id'];?></td>	
									<td><img src="<?php echo $image;?>" style="max-width: 80px;"></td>
									<td><?php echo $p['percantage_value'];?></td>
									
									<td><?php echo date('d-m-Y h:i A',$p['add_utc']);?></td>
										<td><?php echo (int)$p['qty'];?></td>	
										<td data-toggle="tooltip" data-original-title="<?php echo "Seller Amount: ".(int)$p['orignal_amount']; ?>"><?php echo (int)$p['price']; $orignal_value=(int)$p['orignal_amount'];?></td>	
										<td data-toggle="tooltip" data-original-title="<?php echo "Seller Total Amount: ".(int)$p['orignal_amount']*(int)$p['qty']; ?>"> <?php echo (int)$p['base_price'];?></td>	
										<td><?php   
										$org_sale_total=$orignal_value*(int)$p['qty'];
										$tcs=(1/ 100) * $org_sale_total;
										echo round($tcs);	
											$comission_set=$p['percantage_value'];
											$comission=($comission_set/ 100) * $org_sale_total;
											$gst=round((18/ 100) * $comission);
											$settlement_amount=$org_sale_total-($tcs+$gst+$comission);
										?></td>
												<td data-toggle="tooltip" data-original-title="<?php echo $comission_set." %"; ?>"><?php echo $comission;?></td>	
												<td><?php echo (int)$gst;?></td>	
												<td><?php echo (int)$p['delay_penalty'];?></td>
												<td><?php echo (int)$settlement_amount; ?></td>
												<td><?php echo (int)$comission; ?></td>
												<td><?php echo (int)$p['discount_amount'];?></td>
												<td><?php echo (int)$p['my_earning']*(int)$p['qty'];?></td>
										<td class="hidden-480">
										
										<?php if(($p['return_time']=="n") && $p['order_status']==6 && $p['payment_status']=="n"){ ?>
										  <span class="make_payment"  data-id='<?php echo $p['item_order_id']; ?>' r_payable_amount='<?php echo round($p['my_earning']*(int)$p['qty']);?>' s_payable_amount='<?php echo round($settlement_amount);?>' order_status="<?php echo $p['order_status'];?>"  data-toggle="tooltip" data-original-title="Make Payment"> <i class="fa fa-check text-inverse m-r-10"></i> </span>
										 
										<?php } ?>    
										
									
										
										
									</td>
									
										
										
									
								</tr>
                                          <?php $i++; endforeach;?>
                                            
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
                   <div id="responsive-reject-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											
									<form method="post" action='order/changeorderstatus' style="padding:3%;">
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
											
								<form action="makepayment" method="post" style="padding:3%;">
									 <input type="hidden" id='change_order_id' name='select_order_id'>
									
                                        <div class="modal-content" style="margin:2%;">
                                          <div class="form-group">
										  <br/>
											  <label>&nbsp;&nbsp;Proceed For Payment <span id='cur_order_status'></span></label>
											
										</div>
										<div class="form-group" id='change_status_order' style="padding:3%;">
											 <p>Reseller Payable Amount : <span id='r_payable_amount'></span></p>
											 <p>Supplier Payable Amount : <span id='s_payable_amount'></span></p>
											 <select class="form-control" name="final_approve_by">
											  <option value='-1'>Final Approve By</option>
											  <option value='sourabh'>Sourabh</option>
											  <option value="shyam">Shyam</option>
											  <option value="pravin">Pravin</option>
											 </select>
											    <label for="sel1">Comment:</label>
											   <textarea id="form10" name="comment" style="margin: 9%;/*! padding: 8%; */width: 77%;" class="md-textarea form-control" rows="3"></textarea>
											 
											</div>
											
										                                          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                               
												  <button type="submit" class="btn btn-primary">Proceed Payment</button>
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
  
	$(".make_pre_payment").on("click", function(e){
		 // alert(3);
	   e.preventDefault();   
	     var data_id = $(this).attr("data-id");
	    $("#change_pre_order_id").val(data_id);
		   $('#responsive-prestatus-model').modal('show'); 
	 });
	 $(".make_payment").on("click", function(e){
		 // alert(3);
	   e.preventDefault();   
	     var data_id = $(this).attr("data-id");
	     var order_status = $(this).attr("order_status");
	     var s_payable_amount = $(this).attr("s_payable_amount");
	     var r_payable_amount = $(this).attr("r_payable_amount");
		 
	     var show_status = $(this).attr("show_status");
		 $('#r_payable_amount').html(r_payable_amount);
		 $('#s_payable_amount').html(s_payable_amount);
		 $('#change_order_id').val(data_id);
		 $('#cur_order_status').html(show_status);
		   $('#responsive-status-model').modal('show'); 
	 });
});
</script>