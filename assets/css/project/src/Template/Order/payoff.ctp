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
                        <h3 class="text-themecolor m-b-0 m-t-0">Payoff  List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Payoff List</li>
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
                                <h4 class="card-title">Payoff List</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
									<?php if($login_role==1){ ?>
								  <div class="row">
								<div class="col-8">
								     <form method="post">
  <div class="form-group">
    <label for="email">Filter By User:</label>
  
	<select class="form-control" name="user_id">
	<option value="all">All user</option>
	<?php  foreach($users as $u){
		
		?>
	<option value="<?php echo $u['id'];?>"><?php echo  $u['display_name'].",".$u['mobile'];?></option>
	<?php } ?>
	</select>
  </div>
 
  <input type="submit" class="btn btn-primary" value="Search"/>
  <a href="http://52.66.195.100/order/payoff" class="btn btn-primary">Reset</a>
  </br>
  </br>

 
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
								
									</div> <?php } ?>
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
												 <th> Hold Amount</th>
												 <th>Total Amount</th>
                                                 
                                                 <th>Payment Status</th>
												  <th>Payment Date</th>
												   <th>Created Date</th>
                                                <th>Action</th>
											  
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
												 <th>Hold Amount</th>
												 <th>Total Amount</th>
                                               
                                                 <th>Payment Status</th>
												   <th>Payment Date</th>
												   <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php $i=1; foreach($allpayoff as $p):
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
									<td  data-toggle="tooltip" data-original-title="<?php echo $p['user_name']; ?>"><?php echo $sid;?></td>	
										
									
									<td><?php echo $p['user_name'];?></td>
								
									<td><?php  if($p['start_date']!="ALL"){ echo date('d-m-Y h:i A',strtotime($p['start_date']));} else { echo $p['start_date'];}?></td>
									<td><?php echo date('d-m-Y h:i A',strtotime($p['end_date']));?></td>
									<td><?php echo $p['total_sale'];?></td>
									<td><?php echo $p['total_penlty'];?></td>
									<td><?php echo $p['total_wavies'];?></td>
									
								
										<td><?php echo (int)$p['past_hold'];?></td>	
									
									<td><?php echo $total_amount=$p['total_amount'];?></td>	
								<td><?php echo $p['payment_status'];?></td>										
										
										<td><?php  if($p['payment_status']=="paid"){echo date('d-m-Y h:i A',strtotime($p['payment_date']));} else { echo "--";} ?></td>
									<td><?php  echo date('d-m-Y h:i A',strtotime($p['created'])); ?></td>
										<td>
										<?php  if($p['payment_status']=="unpaid"){?>
										<span  style="color:white;" payoff_id="<?php echo $p['id']; ?>" user_type="<?php echo $p['user_type']; ?>" user_name="<?php echo $p['user_name'];?>" past_hold="<?php echo $p['total_hold']; ?>" user_id="<?php echo $p['user_id'];?>"   total_penlty="<?php echo $p['total_penlty'];?>"   
total_waiver="<?php echo $p['total_wavies'];?>"  start_date="<?php echo $p['start_date'];?>"  total_order="<?php echo $p['invoice_count'];?>" end_date="<?php echo $p['end_date'];?>" total_sale="<?php echo $p['total_sale'];?>" total_amount="<?php echo $total_amount; ?>" class="pay_now label label-sm label-success">
									
									
									Pay Now
									
										</span> <?php } ?></td>	
									
										
									
										
									
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
                   
						 <div id="responsive-payment-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											
								<form id="final_form" action="confirmbankpayment" method="post" style="padding:3%;">
									 <input type="hidden" id='payoff_id' name='payoff_id'>
									 <input type="hidden" id='user_id' name='user_id'>
									 <input type="hidden" id='total_sale' name='total_sale'>
									 <input type="hidden" id='total_penlty' name='total_penlty'>
									 <input type="hidden" id='total_order' name='total_order'>
									 <input type="hidden" id='total_wavies' name='total_wavies'>
									 <input type="hidden" id='total_qty' name='total_qty'>
									 <input type="hidden" id='total_amount' name='total_amount'>
									 <input type="hidden" id='start_date' name='start_date'>
									 <input type="hidden" id='end_date' name='end_date'>
									
                                        <div class="modal-content" style="margin:2%;">
                                          <div class="form-group">
										  <br/>
											  <label>&nbsp;&nbsp;Final Payment <span id='cur_order_status'></span></label>
											
										</div>
										<div class="form-group" id='change_status_order' style="padding:3%;">
											 <p>Name : <span id='user_name_label'></span></br>
											 Total sale : <span id='total_sale_label'></span></br>
											 Total Penlty : <span id='total_penlty_label'></span></br>
											 Total Waives : <span id='total_wavies_label'></span></br>
											
											 Total Invoice ids : <span id='total_qty_label'></span></br>
											Start  Date : <span id='start_date_label'></span></br>
											End  Date : <span id='end_date_label'></span></br>
											
											 </p>
											 <h4> <b>Total Amount : <span id='total_amount_label'></span></b></h4>
											 <label for="sel1">Bank Ref No:</label>
											 <input type="text" class="form-control" name="bank_ref_id"/>
											    <label for="sel1">Comment:</label>
											   <textarea id="form10" name="comment" style="margin: 9%;/*! padding: 8%; */width: 77%;" class="md-textarea form-control" rows="3"></textarea>
											 
											</div>
											
										                                          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                               
												  <button type="submit" class="btn btn-primary final_payment">Make Payment</button>
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
	     var payoff_id = $(this).attr("payoff_id");
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
		$('#payoff_id').val(payoff_id);
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
	  $(".final_payment").on("click", function(e){
		  var r = confirm("Are You Sure You want to make Payment");
		  if (r == true) {
			$('#final_form').submit();
		  } else {
		     $('#responsive-payment-model').modal('hide'); 
			 return false;
		  }
	  });
	 
});
</script>