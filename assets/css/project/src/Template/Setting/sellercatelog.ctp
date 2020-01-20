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