
 <div class="modal-header">
                                            
											
											<div class="row">
       
										<form action="" method="post"  class="form-horizontal">
										 <div class="col-md-9">
											<div class="card">
												<div class="card-header">
												  <strong>Add Stock  <?= $this->Flash->render() ?></strong>
												  
												</div>
												<div class="card-body">
													<div class="form-group row">
													  <label class="col-md-3 form-control-label" for="password-input">Add Stock</label>
													  <div class="col-md-9">
														<input type="text" id="add_stock" maxlength="40" required name="add_stock"  class="form-control" placeholder="Add Stock">
													<input type="hidden" value="<?php echo $stockdata['id']; ?>" name="stock_id"/> 
													  </div>
													</div>
													
												</div>
												<div class="card-footer">
												 
												<input type="submit" class="btn btn-sm btn-primary" value="save"/>
												
												  <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
												</div>
											</div>
										 </div>
										 <div class="col-md-3" style="font-weight:bold;">
										 <p>Product Name : <span id="detail_product"></span></p>
										 <p>Stock Type : <?php echo $stockdata['attribute_option_value']['value']; ?></p>
										 <p>Total Stock : <?php echo $stockdata['stock_qty']; ?></p>
										 <p>Current Stock : <?php echo $stockdata['pending_stock']; ?></p>
										
										 </div>

										</form>
										
									</div>
											
                                                
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                    
                        <div class="col-12 table-responsive catelog_body">   
						            <h4 class="modal-title">Stock List</h4>
									<?php if(count($data)>0){ ?>
                                    <table id="example24" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>SrNo</th>
                                                <th>Stock Count</th>
                                               
                                                <th>Added Date</th>
                                                
                                              
                                                
                                              
                                            </tr>
                                        </thead>
                                       
                                        <tbody> 
                                           <?php $totalcount=count($data);
										     $i=1; foreach($data as $user){  ?>
                                            <tr>
                                                <td>
												
												
											  <td><?php echo $i;?></td>
												<td><?php echo $user['stock_value']; ?></td>
												 <td><?php echo date('d-m-y h:i A',strtotime($user['created'])); ?></td>
                                                
                                             
                                               
                                                
                                             
                                            </tr>
										<?php  $i++;} ?>
                                           
                                            
                                           
                                        </tbody>
                                    </table>
									<?php } else { echo "No Stock Maintain Yet";} ?>
                                </div>
                       
                    
                </div>
				
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                               
                                            </div>