<?php if($id==2) $user="Reseller"; if($id==3) $user="Supllier";?> 
 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"> <?php echo $user; ?> List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active"><?php echo $user; ?>  List</li>
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
                                <h4 class="card-title"><?php echo $user; ?> List
								<?php if($id==3){ ?>
								<a href="<?php echo $this->Url->build(['controller'=>'Users','action'=>'adduser','supplier'])?>">
								<span class="btn btn-primary" style="float:right">Add New</span>
								</a><?php } ?></h4>
                                
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                 <th><?php echo $user; ?> ID</th>
											   <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Password</th>
                                               
                                                <th>Email</th>
                                                 <th>Account Status</th>
												 
												  <?php if($id==3){ ?>
												 <th>Request Time</th>
												<?php } ?>
												 <th>Registration Time</th>
                                              
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                               <th><?php echo $user; ?> ID</th>
											   <th>Name</th>
                                                <th>Mobile</th>
                                                <th>Password</th>
                                                <th>Email</th>
                                                <th>Account Status</th>
                                              
												<?php if($id==3){ ?>
												 <th>Request Time</th>
												<?php } ?>
                                                <th>Registration Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php foreach($list as $l):
										    $user_id=$l['id'];
											if($l['status']=="active")
											{
												$status = "Active";
												$label = "success";
											}
											else
											{
												$status =$l['status'];	
												$label = "warning";	
											}
											if($l['is_suplier']=="requested")
											{
												$status = "Requeested Supllier";
												$label = "warning";
											}
											if($l['is_suplier']=="y")
											{
												$status = "Active Supllier";
												$label = "success";
											}
											if($l['is_suplier']=="adminadd")
											{
												$status = "Approval Pending From admin";
												$label = "warning";
											}
											if($l['manual_ship']=="y")
											{
												$s_colr="#7460EE";
												$s_label="Manual";
											}
											else
											{
												
												$s_colr="";
												$s_label="";
											}
										?>	
										<tr role="row" class="odd">
									
									<td class="center" data-toggle="tooltip"  data-original-title="<?php echo $s_label; ?>" style="background-color:<?php echo $s_colr;?>;color:black">
									<a style="color:black;" href="<?php echo $this->Url->build(['controller'=>'Users','action'=>'userdetail',$l['id']])?>"><?php echo $l['id']; ?></a></span>
									
									</td>
								
									<td><?php echo $l['fullname'];?></td>	
									<td><?php echo $l['mobile'];?></td>	
									<td><?php echo $l['pass'];?></td>	
									<td><?php echo $l['email'];?></td>	
										
										
										
									<td class="hidden-480">
										<span class="label label-sm label-<?php echo $label ?>"><?php echo $status?></span>
									</td>
									<?php if($id==3){ ?>
										<td><?php echo date('d-m-Y h:i A',$l['request_utc']); ?></td>
									<?php } ?>
									<td><?php echo date('d-m-Y h:i A',$l['created_utc']); ?></td>
									
									 <td class="text-nowrap">
                                                    
                                                  
                                                   <a href="<?php echo $this->Url->build(['controller'=>'users','action'=>'userdetail',$user_id]);?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                   <!--a href="<?php echo $this->Url->build(['controller'=>'users','action'=>'viewdetail',$user_id]);?>" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-user text-inverse m-r-10"></i> </a!-->
                                                   <?php if($l['status']=="active"){ ?>
                                             
												  <a href="<?php echo $this->Url->build(['controller'=>'users','action'=>'changeuserstatus/block/',$user_id,2]);?>" data-toggle="tooltip" data-original-title="Block User"> <i class="fa fa-close text-danger m-r-10"></i> </a>
										
												  <?php } else { ?>
												   <a href="<?php echo $this->Url->build(['controller'=>'users','action'=>'changeuserstatus/active/',$user_id,2]);?>" data-toggle="tooltip" data-original-title="Active User"> <i class="fa fa-check text-inverse m-r-10"></i> </a>
										
												   <?php } ?>
											   </td>
									
									
									
								</tr>
                                          <?php endforeach;?>
                                            
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
               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->