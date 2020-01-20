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
                        <h3 class="text-themecolor m-b-0 m-t-0">Order Payment List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Order Payment  List</li>
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
                                <h4 class="card-title">Order Payment  List</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
								 	  <form method="post">
								 <div class="row">
								<div class="col-8">
								   
  <div class="form-group">
    <label for="email">Filter By Date:</label>
  
	<input type="text"  name="daterange" style="width:50%;" class="form-control"/>
  </div>
  <div class="form-group" style="width:60%;">
    <label for="email">Filter By Status:</label>
  
	<select class="form-control" name="status_id">
	<option value="all">All Status</option>
	<option value="approved">APPROVED</option>
	<option value="hold">HOLD</option>
	<option value="decline">Declined</option>
	<option value="paymentrequested">PAYMENT REQUESTED</option>
	<option value="paymentdone">PAYMENT DONE</option>
	
	<?php  foreach($users as $u){
		
		?>
	<option value="<?php echo $u['id'];?>"><?php echo  $u['display_name'].",".$u['mobile'];?></option>
	<?php } ?>
	</select>
  </div>
 


 
						</div>
								<div class="col-4" style="text-align:left;">
								<?php if($login_role==1){ ?>
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
								<?php } ?>
		
								<!--
								Color Sheed  New catelog - Blue <br/>
								  <span class="label label-sm label-danger">Inactive</span>  - Inactive Catelog  <br/>
								  <span class="label label-sm label-success">Active</span>  - Live Catelog  <br/>
								  <span class="label label-sm label-warning">Blocked</span>  - Blocked Catelog <br/>
								 !-->
								</div>
								  <input type="submit" class="btn btn-primary" value="Search"/>
								  &nbsp; &nbsp;
  <a href="http://52.66.195.100/order/trascation" class="btn btn-primary">Reset</a>
  </br>
  </br>
								</div>
								</form> 
								<?= $this->Flash->render(); ?>
								
                                <div class="table-responsive m-t-40">
								<?php if(isset($s_date)){ ?>
								<h3>Date Between <?php echo date('d-M-Y',$s_date);?> to <?php echo date('d-M-Y',$e_date); ?></h3>
								<?php } ?>
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                             <tr>
                                                 <th>Sr No</th>
                                                 <th  data-toggle="tooltip" data-original-title="Current Status">CS</th>
                                                 <th>Tra Id</th>
												   <th>ORD ID</th>
												   <th>UID</th>
                                                  <th>Order Date</th>
                                                 <th>Payment Date</th>
                                               
                                                
                                                 <th>Amount</th>
												     <th>Payment Status</th>
												    
												
                                                <th>Comment</th>
												<?php if($login_role==1 || $login_role==4){ ?>
                                              <th>Action</th>
												<?php } ?>
											       <th></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                                 <th>Sr No</th>
											<th  data-toggle="tooltip" data-original-title="Current Status">CS</th>
												                           <th>Tra Id</th>
												   <th>ORD ID</th>
												   <th>UID</th>
                                                  <th>Order Date</th>
                                                 <th>Payment Date</th>
                                               
                                             
                                                 <th>Amount</th>
												     <th>Payment Status</th>
												    
											
                                                <th>Comment</th>
                                            
                                              <th>Action</th>
											         <th></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php $i=1; foreach($orderlist as $p):
										  $order_status=$p['order_status'];
										  $payment_status=$p['payment_status'];
										
										  $payment_type=$p['payment_type'];
										  $show_status=$p['show_status'];
										   $min="n";
										  if($payment_type=="weiver" || $payment_type=="penlty")
										  {
											   $show_status=$payment_type;
											  if($payment_type=="penlty")
											  {
												  $min="y";
												  $p['s_color']="red";
											  }
										  }
										  $user_type=$p['user_type'];
										 
										  if($order_status==4 || $order_status==5 || $order_status==7)
											{
												$delay_penalty=(int)$p['delay_penalty'];
												if($delay_penalty>0)
													$show_pen=$delay_penalty;
												else
													$show_pen=0;
												$amount=$show_pen;
												 $min="y";
											}
											else
											{
												$amount=$p['amount'];
											}
											if($order_status==11)
												$min="y";
											if(($order_status==4) && $user_type==1)
											{
												$amount=0;
												 // $min="y";
											}
											
										   $image = $this->request->getAttribute("webroot") ."image/". $p['pic'];
												// die;
											$hold_status=$p['hold_status'];
											$tras_status=$p['tras_status'];
											if($hold_status=="y")
											 $payment_status="HOLD"; 
											else if($tras_status=="0")
												$payment_status="DECLINE"; 
											else if($payment_status=="requestedpayment")
												$payment_status="PAYMENT REQUESTED";
											else if($payment_status=="paymentdone")
												$payment_status="PAYMENT DONE";
											else 
											$payment_status="APPROVED"; 
											
											$payment_type=$p['payment_type'];
											if($payment_type=="weiver")
												$min="n";
											
											 
										?>	
										<tr role="row" class="odd">
									
									<td class="center order_detail" o_id="<?php echo $p['item_order_id'];?>" ><a href="#"><?php echo $i;?></a></td>
									<td class="hidden-480">
										<span style="color:<?php echo $p['color'];?>;background:<?php echo $p['s_color'];?>" class="label label-sm label-<?php echo $label ?>"><?php echo $show_status;?></span>
									</td>
									<td class="center" o_id="<?php echo $p['item_order_id'];?>" ><?php echo $p['id'];?></td>	
									<?php if($p['item_order_id']) {?>
									<td class="center order_detail" o_id="<?php echo $p['item_order_id'];?>"><?php echo "O".$p['item_order_id'];?></td>	
									<?php } else {echo "<td>--</td>"; }?>
									<td  data-toggle="tooltip" data-original-title="<?php echo  $p['display_name'].",".$p['mobile'];?>"><?php if($p['user_type']==2){ echo "S".$p['user_id'];} else { echo "R".$p['user_id'];}?></td>	
									
									
									<td><?php  echo date('d-m-Y h:i A',strtotime($p['created_date'])); ?></td>
									<td><?php  if($p['payment_status']=="paymentdone"){ echo date('d-m-Y h:i A',strtotime($p['payment_date']));} else { echo "--"; }?></td>
									<td style="<?php if($min=="y"){ echo "color:red;";} ?>"><?php
									 if($min=="y" && $amount>0){ echo "-";} echo $amount;?></td>   
									<td>
									
									<span class="label label-sm label-success">
									<a href="#">
									<?php echo $payment_status;?>
									</a></span>
									  
									<br/>
									
									</td>
								
									<td><?php echo $p['comment'];?></td>
										<?php if($login_role==1 || $login_role==4){ ?>
									<td>
										<?php 
									$arr=array('requestedpayment','paymentdone');
									if(in_array($p['payment_status'],$arr)==false) { if($login_role==1)
										{
										   if($p['tras_status']=='1')
										   { if(($p['hold_status']!="y")){ ?>		
												  <span class="reject_order" data-id='<?php echo $p['id']; ?>' data-toggle="tooltip" data-original-title="Hold"> <i class="fa fa-pause text-danger"></i> </span>
										
										   <?php } else { ?>
										    <a href="<?php echo $this->Url->build(['controller'=>'order','action'=>'changetrascation/',$p['id']."/unhold"]);?>" data-toggle="tooltip" data-original-title="Unhold"> <i class="fa fa-play text-danger m-r-10"></i> </a>
										
										   <?php } } else "&nbsp;&nbsp;";} ?> 
										   
											<?php if($p['tras_status']!="0"){ ?>
										  &nbsp;&nbsp;<span class="decline_order" data-id='<?php echo $p['id']; ?>' data-toggle="tooltip" data-original-title="Reject"> <i style="backgroud-color:red;" class="fa fa-close text-danger"></i> </span>
										<?php } else {?>
										 <a href="<?php echo $this->Url->build(['controller'=>'order','action'=>'changetrascation/',$p['id']."/approve"]);?>" data-toggle="tooltip" data-original-title="Approve"> <i class="fa fa-check text-danger m-r-10"></i> </a>
										
									  <?php } }?>
									    
									</td>
										<?php } ?>
											
									
									
										
										
									<td class="hidden-480">
										<span class="label label-sm"><?php echo $status?></span>
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
											
									
									<form method="post" action='trascationreject'>
									 <input type="hidden" id='select_order_id' name='select_order_id'>
									 <input type="hidden" id='status_type' name='status_type' value='reject'>
                                        <div class="modal-content" style="margin:2%;">
                                          <div class="form-group">
										  <br/>
											  <label>&nbsp;&nbsp;Comment For Hold</label>
											  <textarea id="form10" name="comment" style="margin: 9%;/*! padding: 8%; */width: 77%;" class="md-textarea form-control" rows="3"></textarea>
											 
										</div>
										   
									                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                               
												  <button type="submit" class="btn btn-primary">Hold</button>
                                        </div>
									</form>
                                    </div>
                                </div>
								   <div id="responsive-decline-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											
									
									<form method="post" action='trascationdecline'>
									 <input type="hidden" id='select_order_id_decline' name='select_order_id'>
									 <input type="hidden" id='status_type' name='status_type' value='reject'>
                                        <div class="modal-content" style="margin:2%;">
                                          <div class="form-group">
										  <br/>
											  <label>&nbsp;&nbsp;Comment For Decline</label>
											  <textarea id="form10" name="comment" style="margin: 9%;/*! padding: 8%; */width: 77%;" class="md-textarea form-control" rows="3"></textarea>
											 
										</div>
										   
									                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                               
												  <button type="submit" class="btn btn-primary">Reject</button>
                                        </div>
									</form>
                                    </div>
                                </div>
						 <div id="responsive-wavies-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											
									
									<form method="post" action='trascationreject' style="padding:3%;">
									 <input type="hidden" id='select_order_id' name='select_order_id'>
									 <input type="hidden" id='status_type' name='status_type' value='reject'>
                                        <div class="modal-content" style="margin:2%;padding:3%;">
                                          <div class="form-group">
										 
										  <input type="text" placeholder="order item id" id="process_order_id" class='form-control'/>
										  <br/>
										  <br/>
										  
										  <input type="text" placeholder="Waives Amount" id="waives_amount" class='form-control'/>
										  <br/>
										  <span style="float:right;" class="btn btn-primary">Check</span>
										</div>
										   
									                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                               
												  <button type="submit" class="btn btn-primary">Procced</button>
                                        </div>
									</form>
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
		// $(".catelog_plan_body").html(data);
				 
	});
  $(".reject_order").on("click", function(e){
	   e.preventDefault();   
	   var data_id = $(this).attr("data-id");
	    var r = confirm("Are you sure you want to Hold trascation ??");
	  if (r == true) {
		   $('#select_order_id').val(data_id);
		 $('#responsive-reject-model').modal('show'); 
		// $(".catelog_plan_body").html(data);
	  } else {
		
	  }
	   // var select_catelog_id = $(this).attr("select_catelog_id");
		
				 
	});
	 $(".decline_order").on("click", function(e){
	   e.preventDefault();   
	   var data_id = $(this).attr("data-id");
	    var r = confirm("Are you sure you want to confirm Reject ??");
	  if (r == true) {
		   $('#select_order_id_decline').val(data_id);
		 $('#responsive-decline-model').modal('show'); 
		// $(".catelog_plan_body").html(data);
	  } else {
		
	  }
	   // var select_catelog_id = $(this).attr("select_catelog_id");
		
				 
	});
	 $(".add_wavies").on("click", function(e){
	   e.preventDefault();   
	   
		   $('#responsive-wavies-model').modal('show'); 
	 });
});
</script>