  <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Offer List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Offer List</li>
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
                                <h4 class="card-title">Offer List</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                 <th>Offer ID</th>
                                                 <th>Offer Title</th>
                                                 <th>Offer Sub Title</th>
											   <th>Offer Image</th>
											   <th>Status</th>
                                               
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                               <th>Offer ID</th>
                                                 <th>Offer Title</th>
                                                 <th>Offer Sub Title</th>
											   <th>Offer Image</th>
											   <th>Status</th>
                                               
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php foreach($offerlist as $offer):
											$image = $this->request->getAttribute("webroot") ."image/". $offer['offer_image'];
											if($offer['status']=='1')
											{
												$status = "Active";
												$label = "success";
											}
											elseif($offer['status']=='2')
											{
												$status = "Blocked";	
												$label = "warning";	
											}
										?>	
										<tr role="row" class="odd">
									
									<td class="center"><a href="<?php echo $this->Url->build(['controller'=>'setting','action'=>'offeredit','?'=>['id'=>$offer['id']]])?>"><?php echo $offer['id'];?></a></td>
									<td><?php echo $offer['title']; ?></td>
									<td><?php echo $offer['subtitle']; ?></td>
									<td><img src="<?php echo $image;?>" style="max-width: 80px;"></td>
										
										
									<td class="hidden-480">
										<span class="label label-sm label-<?php echo $label ?>"><?php echo $status?></span>
									</td>
									<td>
									 <a href="<?php echo $this->Url->build(['controller'=>'setting','action'=>'editoffer',$offer['id']]);?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                  
                                                   <?php if($offer['status']=="1"){ ?>
                                             
												  <a href="<?php echo $this->Url->build(['controller'=>'setting','action'=>'changeofferstatus/block/',$offer['id']]);?>" data-toggle="tooltip" data-original-title="Block Offer"> <i class="fa fa-close text-danger m-r-10"></i> </a>
										
												  <?php } else { ?>
												   <a href="<?php echo $this->Url->build(['controller'=>'setting','action'=>'changeofferstatus/active/',$offer['id']]);?>" data-toggle="tooltip" data-original-title="Active Offer"> <i class="fa fa-check text-inverse m-r-10"></i> </a>
										
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