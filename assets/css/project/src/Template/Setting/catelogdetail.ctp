
 <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											
											<div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Select Seller</label>
                                                    <select id="print_plan_route" onChange="SellerSearch(this.value);" class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1">
														<option value="-1">All</option>
													   <?php  foreach($sellerlist as $seller){?>    
														<option   value="<?php echo $seller['seller_id']; ?>"><?php echo $seller['seller_name']; ?></option>
														<?php } ?>
                                                    
                                                    </select>
                                                </div>
                                            </div>
											
											</div>
											
											
                                                <h4 class="modal-title">Define Listing Catelog</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                    
                        <div class="col-12 table-responsive catelog_body">   
						   
									<?php if(count($data)>0){ ?>
                                    <table id="example24" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Position</th>
                                                <th>Catelog Name</th>
                                               
                                                <th>Catelog  Price</th>
                                                <th>Seller name</th>
                                              
                                                
                                              
                                            </tr>
                                        </thead>
                                       
                                        <tbody> 
                                           <?php $totalcount=count($data);
										     $i=1; foreach($data as $user){  $shift_pos=$user['shift_pos']; ?>
                                            <tr>
                                                <td>
												
												<input  style="position:static;opacity:1;" id="catelog_id"   name="catelog_id" type="radio"  value="<?php echo $user['catelog_id']; ?>" <?php if($totalcount==$i){ echo "checked";} ?>  class="custom-control-input user_seq"></td>
                                                <td><?php if($shift_pos) echo $shift_pos; else echo "--"; ?></td>
												<td><?php echo $user['catelog_name']; ?></td>
												 <td><?php echo $user['selling_price']; ?></td>
                                                <td><?php echo $user['seller_name']; ?></td>
                                               
                                             
                                               
                                                
                                             
                                            </tr>
										<?php  $i++;} ?>
                                           
                                            
                                           
                                        </tbody>
                                    </table>
									<?php } else { echo "No Catelog Assiged Yet";} ?>
                                </div>
                       
                    
                </div>
				  <div class="row form-material">
				        
                                    <div class="col-md-6">
                                       
                                       <label class="m-t-40">Start Date Time</label>
                                       <input type="text"  id="start_date" name="start_date" class="form-control" placeholder="Saturday 24 June 2017 - 21:44">
                                       
                                    </div>
                                       <div class="col-md-6">
                                       
                                       <label class="m-t-40">End Date Time</label>
                                       <input type="text"   id="end_date" name="end_date"  class="form-control" placeholder="Saturday 24 June 2017 - 21:44">
                                       
                                    </div>
                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-danger waves-effect waves-light" value="Save Changes"/>
												 
                                            </div>