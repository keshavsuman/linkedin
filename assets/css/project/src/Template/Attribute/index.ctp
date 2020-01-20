  <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Values for  <b style="font-size:16px;"><?php echo $styledata['style_name'];?></b></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            
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
                                <h4 class="card-title">Values For  <b style="font-size:22px;"><?php echo $styledata['style_name'];?></b> Style</h4>
                                
                                <div class="table-responsive m-t-40">
								  <a  class="btn btn-primary" style="float:right" href="<?php echo $this->Url->build(['controller'=>'attribute','action'=>'addAttribute','?'=>['id'=>$id]])?>">Add New Value</a>
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Value ID</th>
                                                <th>Value Name</th>
                                                <th>Value Code</th>
                                                <th>Value Style</th>
                                               
                                                <th>Attribute For</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                                <th>Value ID</th>
                                                <th>Value Name</th>
                                                <th>Value Code</th>
                                                <th>Value Style</th>
                                                <th>Value For</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php foreach($product_data as $product):?>	
                                            <tr>
                                               <?php if($product['frontend_input'] == "select"):?>
												<td class="center"><a title="click here to add options" href="<?php echo $this->Url->build(['controller'=>'attribute','action'=>'AttributeOptions','?'=>['attribute_id'=>$product['attribute_id']]])?>"><?php echo $product['attribute_id'];?></a></td>
												<?php else:?>
													<td class="center"><?php echo $product['attribute_id'];?></td>
												<?php endif;?>	
                                                <td><?php echo $product['frontend_label'];?></td>
                                                <td><?php echo $product['attribute_code'];?></td>
                                                <td><?php echo $product['style_id'];?></td>
                                                <td><?php echo $product['att_type'];?></td>
                                               
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