  <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Tutorial List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Tutorial List</li>
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
                                <h4 class="card-title">Tutorial List</h4>
								<?= $this->Flash->render() ?>
								 <button type="button"  data-toggle="modal" data-target="#responsive-modal" style="float:left;" class="btn waves-effect waves-light btn-rounded btn-primary">Create New</button>
								 <br/>
								 <br/>
                              <!-- sample modal content -->
                                <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Add New Tutorial</h4>
                                            </div>  
											
                                            <div class="modal-body">
                                             
										<form action="" method="post" enctype="multipart/form-data" class="form-material m-t-40 row">
                                    <div class="form-group col-md-6 m-t-20">
                                        <input type="text" name="video_title" class="form-control form-control-line" id="title" placeholder="Video Title"> 
									    <small class="hoker_name_error" style="color:#fc4b6c;display:none;">Video Name is Required  </small> 
									</div>
									   <div class="form-group col-md-6 m-t-20">
                                        <input type="text" name="video_url"  required class="form-control form-control-line" id="title" placeholder="Youtube Url"> 
									    <small class="hoker_name_error" style="color:#fc4b6c;display:none;">Youtube Url is Required  </small> 
									</div>
									  <div class="form-group col-md-6 m-t-20">
                                        <input type="file" name="video_img" required class="form-control form-control-line" id="title" placeholder="Video Title"> 
									   
									</div>
                                  
									
                                  
									
									
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                               <input type="submit" class="btn btn-danger waves-light hoker_form" value="Save"/>
                                            </div>
											</form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->
								<!-- sample modal content -->
                                
                                <!-- /.modal -->
                                <div class="table-responsive m-t-40">
								<?php  if(count($data)>0){?>
                                    <table id="myTable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Video Link</th>
                                                <th>Video Thumb</th>
                                                
                                             
                                                <!--th>Action</th!-->
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php foreach($data as $h){
											$id=$h['id']; 
											if($h['video_img'])
											$image = $this->request->getAttribute("webroot") ."image/". $h['video_img'];
										else
											$image='';
											?>
                                            <tr>
                                                <td><?php echo $h['video_title']; ?></td>
                                                <td><a href="<?php echo $h['video_url']; ?>" target="_blank"><?php echo $h['video_url']; ?></a></td>
                                                <td>
												<?php if($image){ ?>
												<img src='<?php echo $image; ?>' style="max-width:80px;"/> <?php } ?>
												</td>
												
                                               
                                                <!--td class="text-nowrap">
                                                      <a class="hoker_edit" user_id="<?php echo $id; ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                    <a href="<?php echo $this->Url->build(['controller'=>'user','action'=>'deletehoker',$id]);?>" data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-close text-danger"></i> </a>
                                                </td!-->
                                            </tr>
										<?php } ?>
                                            
                                          
                                        </tbody>
                                    </table>
								<?php } else { echo "No Collection Found";} ?>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
	