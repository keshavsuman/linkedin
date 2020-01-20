
 <div class="modal-header">
                                               
											
								<label>Track order<label>			
											
											
                                               
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
												<?php if($manual_ship=="n"){ ?>
													<div class="col-12 table-responsive catelog_body">   
													<?php if($i){
														if($i['awbNo']){?>
													   Awb No <?php echo $i['awbNo']; ?>  <br/>
													   Carrier Name <?php echo $i['carrierName']; ?>  <br/>
													   <?php  if($i['shipment_pdf']){?>
													   <a target="_blank" href="<?php echo $i['shipment_pdf']; ?>">Download Shipment</a> <br/> <br/> <?php } ?>
													  <?php
														 $track_output=$i['track_status'];
														 $res=json_decode($track_output,true);
														 if($res['data']['events'])
														 {
															echo "<h4>Track  Detail</h4>";
															$events=$res['data']['events'];
															foreach($events as $e)
															{  ?>
															<div>
															   <p><?php echo $e['Remarks']; ?></br>
																   &nbsp;&nbsp; <?php echo date('d-m-Y h:i A',strtotime($e['Time'])); ?></p>
															</div>
															<?php } }
													  ?>
													   
														<?php } else { echo "Awb No is not generated Yet";}} else { echo "No Order Detail Found";} ?>			
													</div>
												<?php } else { ?>
												   
												<?php ?>
													<form method="post" action='order/trackurl'>
													 <input type="hidden" id='select_order_id' name='select_order_id' value='<?php echo $i['item_order_id'];?>'>
													
														<div class="modal-content" style="margin:2%;">
														  <div class="form-group">
														  <br/>
														 
															  <label>&nbsp;&nbsp;Tracking Url  <a href="<?php echo $i['track_url'];?>"><?php echo $i['track_url'];?></a></label>
																 Edit  <br/>
															<input type="text" name='track_url' value='<?php echo $i['track_url'];?>'/>
														</div>
														  <div class="form-group">
														
														 
															  <label>Awb No</label>
																
															<input type="text" name='awbNo' value='<?php echo $i['awbNo'];?>'/>
														</div>
														  <div class="form-group">
														
														 
															  <label>Company Name</label>
																
															<input type="text" name='carrierName' value='<?php echo $i['carrierName'];?>'/>
														</div>
										   
												  <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
									</form>
												<?php  }?>
                       
                    
										</div>
				
                                            </div>
                <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
											 
												 
                                            </div>