  <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Courier Mode Style</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Courier Mode  Style </li>
                        </ol>
                    </div>
                   
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
				<?php echo  $this->Form->create('CatelogStyle', ['url' => ['action' => 'modelist']]); ?>
					
				 <div class="row">
 					
				   <div class="col-lg-6">
                        
                            <div class="card-body">
							 <h4 class="card-title">Add New Courier Mode  Style</h4>
                               
                             <?php echo $this->Flash->render() ?>
							
                                    <div class="form-group">
                                        <label for="exampleInputuname2">Mode Name</label>
                                        <div class="input-group">
                                            <input type="text" id="name" name="mode_name" placeholder="Mode Name" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                                    </div>
									  <div class="form-group">
                                        <label for="exampleInputuname2">Package Length</label>
                                        <div class="input-group">
                                            <input type="text" id="name" name="packageLength" placeholder="Package Length" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                                    </div>
									
                                     
                                     
                                 
                               
                            </div>
                     
                    </div>
					 <div class="col-lg-6">
							<div class="form-group">
                                        <label for="exampleInputuname2">Package Width</label>
                                        <div class="input-group">
                                            <input type="text" id="name" name="packageWidth" placeholder="Package Width" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                            </div>
							<div class="form-group">
                                        <label for="exampleInputuname2">Package Height</label>
                                        <div class="input-group">
                                            <input type="text" id="name" name="packageHeight" placeholder="Package Height" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                            </div>
							<div class="form-group">
                                        <label for="exampleInputuname2">Package Weight</label>
                                        <div class="input-group">
                                            <input type="text" id="name" name="packageWeight" placeholder="Package Weight" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                            </div>
						   <div class="text-right">
                                        
										<button type="submit" name="save" value="save" class="btn btn-sm btn-success">
									Save
									<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
								</button>
								<button type="reset" name="delete" value="delete" class="btn btn-sm btn-danger">
									Reset 
									<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
								</button>
                                    </div>
					 </div>
				
			</div><!-- /.page-content -->
			 </form>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Mode List</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                               
                                                <th>Mode Name</th>
                                                <th>Package Length</th>
                                                <th>Package Width</th>
                                                <th>Package Height</th>
                                                <th>Package Weight</th>
                                               
                                              
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                          <tr>
                                               
                                                <th>Mode Name</th>
                                                <th>Package Length</th>
                                                <th>Package Width</th>
                                                <th>Package Height</th>
                                                <th>Package Weight</th>
                                               
                                              
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php foreach($mode_data as $m):?>	
                                            <tr>
                                               
                                              
									<td class="center"><?php echo $m['mode_name'];?></td>
                                                <td><?php echo $m['packageLength'];?></td>
                                                <td><?php echo $m['packageWidth'];?></td>
                                                <td><?php echo $m['packageHeight'];?></td>
                                                <td><?php echo $m['packageWeight'];?></td>
                                               
                                               
                                                <td></td>
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