 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Upload Catelog</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Upload Catelog</li>
                        </ol>
                    </div>
                   
                </div>
			</div>
	<div class="row">
       
		<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
		 <div class="col-md-9">
			<div class="card">
                <div class="card-header">
                  <strong>Catelog Upload  <?= $this->Flash->render() ?></strong>
                  
                </div>
                <div class="card-body">
				    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Catelog Doc Name</label>
                      <div class="col-md-9">
                        <input type="text" id="catelog_doc_name" maxlength="40" required name="catelog_doc_name"  class="form-control" placeholder="Catelog Doc Name">
                       <small>Maxlegth For catelog  Doc name is 40</small>
                      </div>
                    </div>
					<div class="form-group row">
                      <label class="col-md-3 form-control-label" for="email-input">Catelog Doc File</label>
                      <div class="col-md-9">

						  <input type="hidden" id="user_id" name="user_id" value="<?php echo $Auth->user('id');?>">
						  <input type="file" id="catelog_file" name="catelog_file">
						 
                      </div>   
                    </div>
					<div class="form-group row">
                      <label class="col-md-3 form-control-label" for="email-input">Image folder</label>
					 
                      <div class="col-md-9">

						
						  <input type="file" id="image_folder" name="image_folder">
					<small>upload images Folder in .zip or .rar format</small>	 
                      </div>
                    </div>
				</div>
				<div class="card-footer">
				  <p>Note: Check Sample Doc</p>
				<input type="submit" class="btn btn-sm btn-primary" value="save"/>
                
                  <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
                </div>
			</div>
		 </div>

		</form>
		
	</div>
	 <div class="table-responsive m-t-40">
	 
                                    <?php if(count($doc_data)>0){ 
									?>
									  <h4 class="card-title">Uploaded Catelog List</h4>
									<table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                 <th  data-toggle="tooltip" data-original-title="Sr No">Sr No</th>
                                                 <th  data-toggle="tooltip" data-original-title="Current Status">Catelog Doc Name</th>
                                                 <th  data-toggle="tooltip" data-original-title="Order id">Doc File</th>
                                                 <th  data-toggle="tooltip" data-original-title="Image Folder">Image Folder</th>
												 <th  data-toggle="tooltip" data-original-title="Order id">Uploaded Date</th>
                                                
                                                 
											  
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                                <th  data-toggle="tooltip" data-original-title="Sr No">Sr No</th>
                                                 <th  data-toggle="tooltip" data-original-title="Current Status">Catelog Doc Name</th>
                                                 <th  data-toggle="tooltip" data-original-title="Order id">Doc File</th>
												  <th  data-toggle="tooltip" data-original-title="Image Folder">Image Folder</th>
                                                 <th  data-toggle="tooltip" data-original-title="Order id">Uploaded Date</th>
                                                
                                               
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php $i=1; foreach($doc_data as $p):
											if($p['catelog_file'])
										   $doc_path = $this->request->getAttribute("webroot") ."catelog_doc/". $p['catelog_file'];
									   	if($p['image_folder'])
										   $image_path = $this->request->getAttribute("webroot") ."catelog_folder/". $p['image_folder'];
												// die;
											
										?>	
										<tr role="row" class="odd">
										<td><?php echo $i; ?></td>
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