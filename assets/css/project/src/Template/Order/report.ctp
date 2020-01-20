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
                        <h3 class="text-themecolor m-b-0 m-t-0">Payment Report List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Payment Report List</li>
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
                                <h4 class="card-title">Payment Report List</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
								   <div class="row">
								
								
								</div>
								<?= $this->Flash->render(); ?>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                 <th>Sr No</th>
												 	<th>ID</th>
												 
												 <th>Name</th>
												 <th>Start Date</th>
												 <th>End Date</th>
												 <th>Total Sale</th>
												
													<th>Total Penalty</th>
												 <th>Total Weiver</th>
												 <th>Hold</th>
												 <th>Total Amount</th>
                                                 <th>Order Count</th>
                                                
                                               
                                               
												    <th>Action</th>
												    <th></th>
											  
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                                 <th>Sr No</th>
												 	<th>ID</th>
												 
												 <th>Name</th>
												 	 <th>Start Date</th>
												 <th>End Date</th>
												 <th>Total Sale</th>
												
													<th>Total Penalty</th>
												 <th>Total Weiver</th>
												 <th>Hold</th>
												 <th>Total Amount</th>
                                                 <th>Order Count</th>
                                                
                                               
                                               
												    <th>Action</th>
												    <th></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php $i=1; foreach($u as $p):
										// pr($p);
										// die;
										  $user_type=$p['user_type'];
										  if($user_type==1)
										  $sid="R".$p['user_id'];
									  else
										  $sid="S".$p['user_id'];
										?>	
										<tr role="row" class="odd">
									
									<td class="center"><?php echo $i;?></td>
									<td  data-toggle="tooltip" data-original-title="<?php echo $p['display_name'].",".$p['mobile']; ?>"><?php echo $sid;?></td>	
										
									
									<td><?php echo $p['display_name'];?></td>
								
									<td><?php  if($p['start_date']!="ALL"){ echo date('d-m-Y h:i A',strtotime($p['start_date']));} else { echo $p['start_date'];}?></td>
									<td><?php echo date('d-m-Y h:i A',strtotime($p['end_date']));?></td>
									<td><?php echo $p['total_sale'];?></td>
									<td><?php echo $p['total_penlty'];?></td>
									<td><?php echo $p['total_waiver'];?></td>
									
								
										<td><?php echo (int)$p['total_hold'];?></td>	
									
									<td><?php $total_amount=($p['total_sale']+$p['total_waiver'])-$p['total_penlty']; echo $total_amount;?></td>									
										<td><?php echo (int)$p['total_order'];?></td>	
									
									<td>
									
		<span  style="color:white;" user_type="<?php echo $p['user_type']; ?>" user_name="<?php echo $p['display_name'];?>" past_hold="<?php echo $p['total_hold']; ?>" user_id="<?php echo $p['user_id'];?>"   total_penlty="<?php echo $p['total_penlty'];?>"   
total_waiver="<?php echo $p['total_waiver'];?>"  start_date="<?php echo $p['start_date'];?>"  total_order="<?php echo $p['total_order'];?>" end_date="<?php echo $p['end_date'];?>" total_sale="<?php echo $p['total_sale'];?>" total_amount="<?php echo $total_amount; ?>" class="pay_now label label-sm label-success">
									
									
									Make Invoice
									
									</span>
									  
									<br/>
									<span><a style="color:black;" target="_blank" href="<?php echo $this->Url->build(['controller'=>'order','action'=>'trascation','s_date'=>$p['start_date'],'e_date'=>$p['end_date'],'u_id'=>$p['user_id'],'u_type'=>$p['user_type']])?>">Detail</a></span>
								
									</td>	
									<td><?php echo "";?></td>
										
									
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
						 <div id="responsive-payment-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											
								<form action="paynow" method="post" style="padding:3%;">
									 <input type="hidden" id='user_id' name='user_id'>
									 <input type="hidden" id='total_sale' name='total_sale'>
									 <input type="hidden" id='total_penlty' name='total_penlty'>
									 <input type="hidden" id='total_order' name='total_order'>
									 <input type="hidden" id='total_wavies' name='total_wavies'>
									 <input type="hidden" id='total_qty' name='total_qty'>
									 <input type="hidden" id='total_amount' name='total_amount'>
									 <input type="hidden" id='start_date' name='start_date'>
									 <input type="hidden" id='end_date' name='end_date'>
									 <input type="hidden" id='past_hold' name='past_hold'>
									 <input type="hidden" id='user_name' name='user_name'>
									 <input type="hidden" id='user_type' name='user_type'>
									
                                        <div class="modal-content" style="margin:2%;">
                                          <div class="form-group">
										  <br/>
											  <label>&nbsp;&nbsp;Proceed For Payment <span id='cur_order_status'></span></label>
											
										</div>
										<div class="form-group" id='change_status_order' style="padding:3%;">
											 <p>Name : <span id='user_name_label'></span></br>
											 Total sale : <span id='total_sale_label'></span></br>
											 Total Penlty : <span id='total_penlty_label'></span></br>
											 Total Waives : <span id='total_wavies_label'></span></br>
											 Hold Amount : <span id='past_hold_label'></span></br>
											
											 Total Order : <span id='total_qty_label'></span></br>
											Start  Date : <span id='start_date_label'></span></br>
											End  Date : <span id='end_date_label'></span></br>
											
											 </p>
											 <h4> <b>Total Amount : <span id='total_amount_label'></span></b></h4>
											    <label for="sel1">Comment:</label>
											   <textarea id="form10" name="comment" style="margin: 9%;/*! padding: 8%; */width: 77%;" class="md-textarea form-control" rows="3"></textarea>
											 
											</div>
											
										                                          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                               
												  <button type="submit" class="btn btn-primary">Make Invoice</button>
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
  
 
	 $(".pay_now").on("click", function(e){
		 // alert(3);
	   e.preventDefault();   
	     var user_id = $(this).attr("user_id");
	     var user_name= $(this).attr("user_name");
	     var user_type = $(this).attr("user_type");
	     var total_amount = $(this).attr("total_amount");
	     var total_sale = $(this).attr("total_sale");
	     var total_penlty = $(this).attr("total_penlty");
	     var total_waiver = $(this).attr("total_waiver");
	     var past_hold = $(this).attr("past_hold");
	   
	     var total_qty = $(this).attr("total_order");
	     var start_date = $(this).attr("start_date");
	     var end_date = $(this).attr("end_date");
		// html label to show data
		$('#user_name_label').html(user_name);
		$('#total_amount_label').html(total_amount);
		$('#total_sale_label').html(total_sale);
		$('#total_wavies_label').html(total_waiver);
		$('#total_penlty_label').html(total_penlty);
		$('#total_qty_label').html(total_qty);
		$('#start_date_label').html(start_date);
		$('#end_date_label').html(end_date);
		$('#past_hold_label').html(past_hold);
		//   all input 
		$('#past_hold').val(past_hold);
		$('#user_name').val(user_name);
		$('#user_type').val(user_type);
		$('#user_id').val(user_id);
		$('#total_sale').val(total_sale);
		$('#total_penlty').val(total_penlty);
		$('#total_wavies').val(total_waiver);
		$('#total_qty').val(total_qty);
		$('#total_amount').val(total_amount);
		$('#start_date').val(start_date);
		$('#end_date').val(end_date);
		 // $('#cur_order_status').html(show_status);
		   $('#responsive-payment-model').modal('show'); 
	 });
});
</script>