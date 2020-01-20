  <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Size Style</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Size Style List</li>
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
 					
				   <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
							 <h4 class="card-title">Add New Size Style</h4>
                               
                             <?php echo $this->Flash->render() ?>
							<?php echo  $this->Form->create('CatelogStyle', ['url' => ['action' => 'addattributestyle']]); ?>
					
                                    <div class="form-group">
                                        <label for="exampleInputuname2">Size Name</label>
                                        <div class="input-group">
                                            <input type="text" id="name" name="style_name" placeholder="Style Name" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                                    </div>
									 <div class="form-group">
                                        <label for="exampleInputuname2">Comment</label>
                                        <div class="input-group">
                                            <input type="text" id="name" name="comment" placeholder="Comment" class="required-entry form-control"/>
                                            <input type="hidden"  name="style_type" placeholder="Comment" value="size"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                                    </div>
                                   
                                     
                                    <div class="text-left">
                                        
										<button type="submit" name="save" value="save" class="btn btn-sm btn-success">
									Save
									<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
								</button>
								<button type="reset" name="delete" value="delete" class="btn btn-sm btn-danger">
									Reset 
									<i class="ace-icon fa fa-arrow-right icon-on-right bigger-110"></i>
								</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
				
			</div><!-- /.page-content -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Size Style List</h4>
                                
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Style ID</th>
                                                <th>Style Name</th>
                                                <th>Comment</th>
                                               
                                              
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                                 <th>Style ID</th>
                                                <th>Style Name</th>
                                                <th>Comment</th>
                                              
                                              
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php foreach($product_data as $product):?>	
                                            <tr>
                                               
                                              
									<td class="center">
									<a href="<?php echo $this->Url->build(['controller'=>'attribute','action'=>'attributeOptions','?'=>['style_id'=>$product['id']]])?>"><?php echo $product['id'];?></a>
									
									</td>
                                                <td><?php echo $product['style_name'];?></td>
                                                <td><?php echo $product['comment'];?></td>
                                               
                                               
                                                <td>
												<a href="<?php echo $this->Url->build(['controller'=>'attribute','action'=>'attributeOptions','?'=>['style_id'=>$product['id']]])?>">VIEW</a>
									
												<a href="<?php echo $this->Url->build(['controller'=>'attribute','action'=>'attributeOptions','?'=>['style_id'=>$product['id']]])?>">ADD</a>
												
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