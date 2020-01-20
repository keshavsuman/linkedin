 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Uploaded Catelog</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Uploaded Catelog</li>
                        </ol>
                    </div>
                   
                </div>
			</div>
	<div class="row">
       
		
		
	</div>
	 <div class="table-responsive m-t-40">
	 
                                    <?php if(count($doc_data)>0){ 
									?>
									  <h4 class="card-title">Uploaded Catelog List</h4>
									<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                 <th  data-toggle="tooltip" data-original-title="Sr No">Sr No</th>
                                                 <th  data-toggle="tooltip" data-original-title="Seller ID">SID</th>
                                                 <th  data-toggle="tooltip" data-original-title="Seller Mobile">SMOBILE</th>
                                                 <th  data-toggle="tooltip" data-original-title="Catelog Doc Name">Catelog Doc Name</th>
                                                 <th  data-toggle="tooltip" data-original-title="Doc">Doc File</th>
												   <th  data-toggle="tooltip" data-original-title="Image Folder">Image Folder</th>
												 <th  data-toggle="tooltip" data-original-title="Uploaded Date">Uploaded Date</th>
                                                
                                                 
											  
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                                 <th  data-toggle="tooltip" data-original-title="Sr No">Sr No</th>
                                                 <th  data-toggle="tooltip" data-original-title="Seller ID">SID</th>
                                                 <th  data-toggle="tooltip" data-original-title="Seller ID">SNAME</th>
                                                
                                                 <th  data-toggle="tooltip" data-original-title="Catelog Doc Name">Catelog Doc Name</th>
                                                 <th  data-toggle="tooltip" data-original-title="Doc">Doc File</th>
												   <th  data-toggle="tooltip" data-original-title="Image Folder">Image Folder</th>
												 <th  data-toggle="tooltip" data-original-title="Uploaded Date">Uploaded Date</th>
                                                
                                               
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php $i=1; foreach($doc_data as $p):
											if($p['catelog_file'])
										   $doc_path = $this->request->getAttribute("webroot") ."catelog_doc/". $p['catelog_file'];
												// die;
												if($p['image_folder'])
										   $image_path = $this->request->getAttribute("webroot") ."catelog_folder/". $p['image_folder'];
											
										?>	
										<tr role="row" class="odd">
										<td><?php echo $i; ?></td>
										<td><?php echo "S".$p['user_id']; ?></td>
										<td  data-toggle="tooltip" data-original-title="<?php  echo $p['mobile'];?>"><?php echo $p['display_name']; ?></td>
										<td><?php echo $p['catelog_doc_name']; ?></td>
										<td>
										<?php if($doc_path){ ?>
										<a href="<?php echo $doc_path; ?>" target="_blank">Get File</a>
										<?php  } else { echo "--";}?>
										</td>
										<td>
										<?php if($image_path){ ?>
										<a href="<?php echo $image_path; ?>" target="_blank">Get Folder Images</a>
										<?php  } else { echo "--";}?>
										</td>
											<td><?php echo date("d-m-y h:i A",$p['upload_utc']); ?></td>
									
										
										</tr>
                                          <?php $i++; endforeach;?>
                                            
                                        </tbody>
                                    </table>
									<?php } else { echo "No Catelog Uploaded";} ?>
                                </div>