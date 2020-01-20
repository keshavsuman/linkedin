  <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Size list for <b style="font-size:16px;"><?php echo $styledata['style_name'];?></b> </h3>
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
                                <h4 class="card-title">Size List For <b style="font-size:16px;"><?php echo $styledata['style_name'];?></b></h4>
                               
                                <div class="table-responsive m-t-40">
                                     <a  class="btn btn-primary" style="float:right" href="<?php echo $this->Url->build(['controller'=>'attribute','action'=>'addOption','?'=>['id'=>$id]])?>">Add New Size Value</a>
								   <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Option ID</th>
                                                <th>Option value</th>
                                               
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                               <th>Option ID</th>
                                                <th>Option value</th>
                                               
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php foreach($product_data as $product):
										if($product['attribute_option_value']['value']){
										?>			
                                          <tr role="row" class="odd">
											<td><?php echo $product['option_id'];?></a></td>
											<td><a href="<?php echo $this->Url->build(['controller'=>'attribute','action'=>'editOption','?'=>['value_id'=>$product['attribute_option_value']['value_id'],'attribute_id'=>$product['attribute_id']]])?>"><?php echo $product['attribute_option_value']['value'];?></a></td>
											<td>-</td>
										</tr>
								
										<?php  } endforeach;?>
                                           
                                            
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