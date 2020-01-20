  <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Catelog Style</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Catelog Style List</li>
                        </ol>
                    </div>
                   
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
				<?php echo  $this->Form->create('CatelogStyle', ['url' => ['action' => 'addpolicystyle']]); ?>
					
				 <div class="row">
 					
				   <div class="col-lg-6">
                        
                            <div class="card-body">
							 <h4 class="card-title">Add New Template Style</h4>
                               
                             <?php echo $this->Flash->render() ?>
							
                                    <div class="form-group">
                                        <label for="exampleInputuname2">Style Name</label>
                                        <div class="input-group">
                                            <input type="text" id="name" name="policy_name" placeholder="Style Name" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                                    </div>
									
                                     <div class="form-group">
											<label for="exampleInputEmail2">Policy  For </label>
											<div class="input-group">
												<select name="policy_for" required class="form-control select">
													<option value="">Select Policy  For </option>
													<option value="return">Return</option>
													<option value="cod">COD</option>
												</select>
											</div>
										</div>
                                     
                                 
                               
                            </div>
                     
                    </div>
					 <div class="col-lg-6">
					    <div class="form-group">
                                        <label for="exampleInputuname2">Content</label>
                                        <div class="input-group">
                                           <textarea id="textarea-input" style="max-height:80px;" name="content" rows="9" class="form-control" placeholder="Short Content.."></textarea>
                                            <div class="input-group-addon"></div>
                                        </div>
                                    </div>
							 <div class="form-group">
                                        <label for="exampleInputuname2">Pic</label>
                                        <div class="input-group">
                                            <input type="file" id="name" name="pic" placeholder="Style Name" class="required-entry form-control"/>
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
                                <h4 class="card-title">Policy List</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Policy ID</th>
                                                <th>Policy Name</th>
                                                <th>Content</th>
                                                <th>Policy For</th>
                                               
                                              
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                                <th>Policy ID</th>
                                                <th>Policy Name</th>
                                                <th>Content</th>
                                                <th>Policy For</th>
                                              
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php foreach($product_data as $product):?>	
                                            <tr>
                                               
                                              
									<td class="center"><?php echo $product['id'];?></td>
                                                <td><?php echo $product['policy_name'];?></td>
                                                <td><?php echo $product['content'];?></td>
                                                <td><?php echo $product['policy_for'];?></td>
                                               
                                               
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