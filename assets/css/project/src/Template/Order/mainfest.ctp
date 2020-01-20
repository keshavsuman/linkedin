 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Mainfest List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Mainfest List</li>
                        </ol>
                    </div>
                   
                </div>
			</div>
	<div class="row">
       
		
		
	</div>
	 <div class="table-responsive m-t-40">
	 
                                    <?php if(count($order_data)>0){ 
									?>
									  <h4 class="card-title">Mainfest List</h4>
									<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                 <th  data-toggle="tooltip" data-original-title="Sr No">Sr No</th>
												  <th  data-toggle="tooltip" data-original-title="MainFest id">MID</th>
												  <th  data-toggle="tooltip" data-original-title="Carrier Name">Carrier Name</th>
												 <th  data-toggle="tooltip" data-original-title="Date">Date</th>
                                                
                                                 <th>Action</th>
                                               
                                                
                                                 
											  
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                               <th  data-toggle="tooltip" data-original-title="Sr No">Sr No</th>
											    <th  data-toggle="tooltip" data-original-title="MainFest id">MID</th>
												 <th  data-toggle="tooltip" data-original-title="Carrier Name">Carrier Name</th>
                                               <th  data-toggle="tooltip" data-original-title="Date">Date</th>
                                                
                                                 <th>Action</th>
                                               
                                                
                                               
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php $i=1; foreach($order_data as $p):
										$doc_path=$p['mainfest_pdf'];
											
										?>	
										<tr role="row" class="odd">
										<td><?php echo $i; ?></td>
										
										<td><?php echo $p['manifestID']; ?></td>
										<td><?php echo $p['carrierName']; ?></td>
											<td><?php echo date('d-m-Y h:i A',$p['add_utc']);?></td>
										<td>
										<?php if($p['mainfest_pdf']){ ?>
										<a href="<?php echo $doc_path; ?>" target="_blank">Get MainFest</a>
										<?php  } else { echo "--";}?>
										</td>
									
										
										</tr>
                                          <?php $i++; endforeach;?>
                                            
                                        </tbody>
                                    </table>
									<?php } else { echo "No Catelog Uploaded";} ?>
                                </div>