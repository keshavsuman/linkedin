
 <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
											
											
											
											
                                                <h4 class="modal-title">Define Seller  Catelog Address</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                    
                        <div class="col-12 table-responsive catelog_body">   
						   
									<?php if(count($data)>0){ ?>
                                    <table id="example24" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Contact</th>
                                                <th>Address</th>
                                                <th>Shiplite Address Id</th>
                                               
                                                <th>City</th>
                                                <th>Pincode</th>
                                                <th>Action</th>
                                              
                                                
                                              
                                            </tr>
                                        </thead>
                                       
                                        <tbody> 
                                           <?php $totalcount=count($data);
										     $i=1; foreach($data as $add){  $shift_pos=$user['shift_pos']; ?>
                                            <tr>
                                                <td>
												
												<input  style="position:static;opacity:1;" id="entity_id"   name="entity_id" type="radio"  value="<?php echo $add['entity_id']; ?>" <?php if($add['entity_id']==$id){ echo "checked";} ?>  class="custom-control-input user_seq"></td>
                                                
												<td><?php echo $add['name']; ?></td>
												<td><?php echo $add['contact']; ?></td>
												 <td><?php echo $add['address'].",".$add['address2']; ?></td>
												 <td><?php echo $add['sellerAddressId']; ?></td>
												 <td><?php echo $add['city'].",".$add['state']; ?></td>
                                                <td><?php echo $add['zipcode']; ?></td>
                                                <td>
                                                   <a href="<?php echo $this->Url->build(['controller'=>'users','action'=>'userdetail',$add['customer_id']]);?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                 
												</td>
                                               
                                             
                                               
                                                
                                             
                                            </tr>
										<?php  $i++;} ?>
                                           
                                            
                                           
                                        </tbody>
                                    </table>
									<?php } else { echo "No Address Assiged Yet";} ?>
                                </div>
                       
                    
                </div>
				
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                <input type="submit" class="btn btn-danger waves-effect waves-light" value="Changes"/>
												 
                                            </div>