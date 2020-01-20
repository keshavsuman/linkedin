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
                        <h3 class="text-themecolor m-b-0 m-t-0">Penlty List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Penlty List</li>
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
                                <h4 class="card-title">Penlty List</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
								   <div class="row">
								<div class="col-8">
								     <form method="post">
  <div class="form-group">
    <label for="email">Filter By Date:</label>
  
	<input type="text" value='<?php if(isset($daterang)){echo $daterang;} ?>' name="daterange" style="width:50%;" class="form-control"/>
  </div>
 
  <input type="submit" class="btn btn-primary" value="Search"/>
  <a href="http://52.66.195.100/order/penlty" class="btn btn-primary">Reset</a>

 
</form> 
								</div>
								<div class="col-4">
								  <span class="btn btn-primary add_wavies">Add Penlty/Refund</span> 
								<!--
								Color Sheed  New catelog - Blue <br/>
								  <span class="label label-sm label-danger">Inactive</span>  - Inactive Catelog  <br/>
								  <span class="label label-sm label-success">Active</span>  - Live Catelog  <br/>
								  <span class="label label-sm label-warning">Blocked</span>  - Blocked Catelog <br/>
								 !-->
								</div>
								
								</div>
								<?= $this->Flash->render(); if(count($orderlist)>0){ ?>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                             <tr>
                                                 <th>Sr No</th>
												   <th>ORD ID</th>
												   <th>UID</th>
                                                  <th>Order Date</th>
                                                 <th>Payment Date</th>
                                               
                                                
                                                 <th>Amount</th>
												     <th>Payment Status</th>
												    
												<th>Payment Type</th>
											
                                                <th>Comment</th>
                                             
											       <th></th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                                 <th>Sr No</th>
												   <th>ORD ID</th>
												   <th>UID</th>
                                                  <th>Order Date</th>
                                                 <th>Payment Date</th>
                                               
                                             
                                                 <th>Amount</th>
												     <th>Payment Status</th>
												     <th>Payment Type</th>
												    
												
											
                                                <th>Comment</th>
                                            
                                              
											         <th></th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php $i=1; foreach($orderlist as $p):
										
										   $image = $this->request->getAttribute("webroot") ."image/". $p['pic'];
												// die;
											if($p['payment_status']=="approved")
											{
												$v_status = "Enabled";
												$label = "success";
											}
											elseif($p['payment_status']=="hold")
											{
												$v_status = "Disabled";	
												$label = "warning";	
											}
										?>	
										<tr role="row" class="odd">
									
									<td class="center order_detail" o_id="<?php echo $p['item_order_id'];?>" ><a href="#"><?php echo $i;?></a></td>
									<td class="center order_detail" o_id="<?php echo $p['item_order_id'];?>" ><?php echo "O".$p['item_order_id'];?></td>	
									<td  data-toggle="tooltip" data-original-title="<?php if($p['user_type']=="1"){ echo "Reseller";} else { echo "Supplier";}?>"><?php if($p['user_type']==2){ echo "S".$p['user_id'];} else { echo "R".$p['user_id'];}?></td>	
									
									
									<td><?php  echo date('d-m-Y h:i A',$p['created_utc']); ?></td>
									<td><?php  if($p['process_date']){echo date('d-m-Y h:i A',$p['process_date']);} else {echo date('d-m-Y h:i A',$p['created_utc']);}?></td>
									<td><?php echo $p['amount'];?></td>
									<td>
									
									<span class="label label-sm label-<?php echo $label; ?>">
									<a style="color:white;" href="<?php echo $this->Url->build(['action'=>'index'])?>">
									<?php echo $p['payment_status'];?>
									</a></span>
									  
									<br/>
									
									</td>
									<td><?php echo $p['payment_type'];?></td>
								
									<td><?php echo $p['comment'];?></td>
									
									
											
									
									
										
										
									<td class="hidden-480">
										<span class="label label-sm"><?php echo $status?></span>
									</td>
									
								</tr>
                                          <?php $i++; endforeach;?>
                                            
                                        </tbody>
                                    </table>
                                </div>
								<?php } ?>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                   
						 <div id="responsive-wavies-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
									 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											
									
									<form method="post" action='addextra' style="padding:3%;">
									
									 <input type="hidden" id='supplier_id' name='supplier_id'>
									 <input type="hidden" id='reseller_id' name='reseller_id'>
									 <input type="hidden" id='status_type' name='status_type' value='penlty'>
                                        <div class="modal-content" style="margin:2%;padding:3%;">
										 <div class="form-group" style="margin-left:6%;">
										   <label>Select Penlty Type</label> </br>
										   <input style="opacity:1;left:20px;/*! margin-left: 6%; */opac" checked type="radio" value="Penlty" name="wav_type">Penlty  </br>
										   <input  style="opacity:1;left:20px;/*! margin-left: 6%; */"  type="radio" value="extra" name="wav_type">Extra 
										 </div>
										  <div class="form-group user_list" style="display:none">
    <label for="email">Filter By User:</label>
  
	<select class="form-control" name="user_id">
	<option value="all">All user</option>
	<?php  foreach($users as $u){
		
		?>
	<option value="<?php echo $u['id'];?>"><?php echo  $u['display_name'].",".$u['mobile'];?></option>
	<?php } ?>
	</select>
  </div>
 
                                          <div class="form-group">
										 <span id="waiver_check">
										  <input type="text" placeholder="order item id" name="process_order_id" id="process_order_id" class='form-control'/>
										   <span style="float:right;" class="check_waiver btn btn-primary">Check</span>
										    <br/>
										   </span>
										  <br/>
										 <p id="alread_waiver" style="display:none;"> <b> Already Penlty of Rs <span id="waiver_exit_amount"></span> exit</b></p>
										  
										  <input type="text" placeholder="Penlty Amount" id="amount" min="0" name="amount" class='form-control'/>
										  <br/>
										 
										</div>
										 <div class="form-group" style="margin-left:6%;">
										   <label> Penlty For</label> </br>
										   <input style="opacity:1;left:20px;/*! margin-left: 6%; */opac" checked type="radio" value="1" name="wav_for">Reseller  </br>
										   <input  style="opacity:1;left:20px;/*! margin-left: 6%; */"  type="radio" value="2" name="wav_for">Supplier 
										 </div>
										 <div class="form-group" style="margin-left:6%;">
										 
											  <label>&nbsp;&nbsp;Comment</label>
											  <textarea id="form10" name="comment" style="margin: 9%;/*! padding: 8%; */width: 77%;" class="md-textarea form-control" rows="3"></textarea>
											 
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
  $('input[type=radio][name=wav_type]').change(function() {
    if (this.value == 'Penlty') {
        $('#waiver_check').show();
        $('.user_list').hide();
    }
    else if (this.value == 'extra') {
       $('#waiver_check').hide();
       $('.user_list').show();
    }
});
 $(".check_waiver").on("click", function(e){
	 var order_item_id=$('#process_order_id').val();
	  $.ajax({
            url:"/order/checkwaiver/",
            dataType: 'json',
            type: 'POST',
            // This is query string i.e. country_id=123
            data: {id :order_item_id},
            success: function(data) {  
				if(data.status==true)
				{
					$('#alread_waiver').show();
					$('#waiver_exit_amount').html(data.amount);
					$('#supplier_id').val(data.supplier_id);
					$('#reseller_id').val(data.reseller_id);
				}
				 
				else
				{
					alert(data.msg);
					$('#alread_waiver').hide();
				}
				 
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
	 
 });
 
  
	 $(".add_wavies").on("click", function(e){
	   e.preventDefault();   
	   
		   $('#responsive-wavies-model').modal('show'); 
	 });
});
</script>