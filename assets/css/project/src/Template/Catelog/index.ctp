<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<?php  $login_role=($Auth->user('login_role')); ?>
 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Catelog List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Catelog List</li>
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
                                <h4 class="card-title">Catelog List</h4>
                                <div class="row">
								<div class="col-8">
								     <form method="post">
  <div class="form-group">
    <label for="email">Filter By Date:</label>
  
	<input type="text" value='<?php if(isset($daterang)){echo $daterang;} ?>' name="daterange" style="width:50%;" class="form-control"/>
  </div>
 
  <input type="submit" class="btn btn-primary" value="Search"/>
  <a href="http://52.66.195.100/catelog" class="btn btn-primary">Reset</a>
  </br>
  </br>
  Categories   - Cat </br>
								Catelogue Commission    - Commi. </br>
								Product Cost - A</br>
								  <?php if($login_role==1 || $login_role==4) {?>
								  Addon - B</br><?php } ?>
								Shipping Charge - C</br>
								Payment Mode - P.Mode</br>
								Inventrory Stock - Stock</br>
 
</form> 
								</div>
								<div class="col-4">
								    Sr No- Sr No </br>
								    Created Date- Date </br>
								Catelogue Id -C.ID </br>
								Image - Image </br>
								Name - Name </br>
								Supplier Name  - S.Name </br>
								Supller Name   - S.NAME </br>
								Supplier Address Code   - A.Code </br>
								
								Color Sheed  New catelog <br/>
								  <span class="label label-sm label-danger">Inactive</span>  - Inactive Catelog  <br/>
								  <span class="label label-sm label-success">Active</span>  - Live Catelog  <br/>
								  <span class="label label-sm label-warning">Blocked</span>  - Blocked Catelog <br/>
								</div>
								
								</div>
                                <div class="table-responsive m-t-40">
								<?php if(count($product_data)>0){ ?>
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
											   <th>Sr No</th>
											      <th>Status</th>
											      <th>Stock</th>
											      <th>C.ID</th>
											      <th>Image</th>
											      <th>Name</th>
											      <th>S.Name</th>
											      <th>cat</th>
											      <th>Commi. </th>
											      <th>A </th>
											       <?php if($login_role==1 || $login_role==4) {?>
											      <th>B </th>
												  <?php } ?>
											      <th>C </th>
											   <th>P.Mode</th>
											     <th  data-toggle="tooltip" data-original-title="Seller Address Id">SAID</th>
											  <th>Date</th>
                                                <th>Action</th>
                                              
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
											   <th>Sr No</th>
											    <th>Status</th>
												<th>Stock</th>
											      <th>C.ID</th>
											      <th>Image</th>
											      <th>Name</th>
											      <th>S.Name</th>
											      <th>cat</th>
											      <th>Commi. </th>
											      <th>A </th>
												  <?php if($login_role==1 || $login_role==4) {?>
											      <th>B </th>
												  <?php } ?>
											      <th>C </th>
											   <th>P.Mode</th>
											    <th  data-toggle="tooltip" data-original-title="Seller Address Id">SAID</th>
											  <th>Date</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php  $i=1; foreach($product_data as $product):
										// pr($product);
										// die;
										
										extract($product);
											if($on_stock=="y")
												$stock_label="ON STOCK";
											else
											$stock_label="OUT OF STOCK";
											$image = $this->request->getAttribute("webroot") ."image/". $product['pic'];
											if($product['status']==1)
											{
												$v_status = "Active";
												$label = "success";
											}
											elseif($product['status']==2)
											{
												$v_status = "Blocked";	
												$label = "warning";	
											} else if($product['status']==0)
											{
												$v_status = "Inactive";	
												$label = "danger";	
											}
											if($product['manual_ship']=="y")
											{
												$s_colr="#7460EE";
												$s_label="Manual";
											}
											else
											{
												
												$s_colr="";
												$s_label="";
											}
										?>	
										<tr role="row" class="odd">
									
									<td class="center"  data-toggle="tooltip"  data-original-title="<?php echo $s_label; ?>" style="background-color:<?php echo $s_colr;?>;color:black"><?php echo $i; ?></td>
										<td class="hidden-480">
										<span class="label label-sm label-<?php echo $label ?>"><?php echo $v_status?></span>
										<?php if($login_role==1 || $login_role==4) {?>
										<?php if($status==2 || $status==0) {?>
										  <a href="<?php echo $this->Url->build(['controller'=>'catelog','action'=>'changecatelogstatus/live/',$id]);?>" data-toggle="tooltip" data-original-title="Make Live"> <i class="fa fa-check text-inverse m-r-10"></i> </a>
										
										<?php } ?>      
										<a href="<?php echo $this->Url->build(['controller'=>'catelog','action'=>'bellcatelog/',$id]);?>" data-toggle="tooltip" data-original-title="Send Push"> <i class="fa fa-bell text-inverse m-r-10"></i> </a>
										
										<a href="<?php echo $this->Url->build(['controller'=>'catelog','action'=>'editcatelog/',$id]);?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                         <?php if($status==1){ ?>
										 <a href="<?php echo $this->Url->build(['controller'=>'catelog','action'=>'changecatelogstatus/block/',$id]);?>" data-toggle="tooltip" data-original-title="Block"> <i class="fa fa-close text-danger"></i> </a>
										<?php } } ?>	 
									</td>
									<td><span class="label label-sm label-success"><?php echo $stock_label?></span>
									</td>
											
									<td class="center"><a href="<?php echo $this->Url->build(['controller'=>'catelog','action'=>'catelogproduct',$product['id']])?>"><?php echo $product['id'];?></a></td>
									<td><img src="<?php echo $image;?>" style="max-width: 80px;"></td>
									<td><?php echo $product['name_en'];?></td>	
									<td><?php echo $product['display_name'];?></td>	
									<td><?php echo $product['category_list'];?></td>	
									<td><?php echo $product['percantage_value'];?></td>	
									<td><?php echo $product['primary_price'];?></td>	
									  <?php if($login_role==1 || $login_role==4) {?>
										<td><?php echo $product['price_added'];?></td>	
												  <?php } ?>
									
									
									<td><?php echo $product['shipping_charges'];?></td>	
									<td><?php  if($cod){ echo "C";} else { echo "";}?></td>	
								
									<td><?php echo $product['sellerAddressId'];?></td>	
								
										<td><?php echo date('d-m-Y h:i A',strtotime($product['created']));?></td>
									<td>
									<?php if($login_role==1 || $login_role==4) {?>
									   <a href="<?php echo $this->Url->build(['controller'=>'catelog','action'=>'addproduct',$product['id']])?>">Add Product</a>
									<?php } ?>
									<?php if($login_role==3) {?>
									  <a href="<?php echo $this->Url->build(['controller'=>'catelog','action'=>'catelogproduct',$product['id']])?>">Manage Inventrory</a>
									<?php } ?>
										<span class="label label-sm label-success"><a style="color:black;" href="<?php echo $this->Url->build(['controller'=>'catelog','action'=>'catelogproduct',$product['id']])?>">List Product</a></span>
										
									<span  class="label label-sm label-success show_address" select_catelog_id='<?php echo $product['id'];?>' data-id="<?php echo $product['seller_address_id']?>">Change P. Address</span>
									</td>	
										
									
									
								</tr>
                                          <?php $i++; endforeach;?>
                                            
                                        </tbody>
                                    </table>
								<?php }  else { echo "No Catelog Uploaded";}?>
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
				    <div id="responsive-catelog-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog" style="max-width:1000px !important;">
									<form method="post" action='users/selleraddress'>
									 <input type="hidden" id='select_catelog_id' name='select_catelog_id'>
                                        <div class="modal-content catelog_plan_body">
                                           
                                        </div>
									</form>
                                    </div>
                                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
<script>
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
  $(".show_address").on("click", function(e){
	   e.preventDefault();   
	   var data_id = $(this).attr("data-id");
	   var select_catelog_id = $(this).attr("select_catelog_id");
	 $.ajax({
           
              url:"/users/selleraddress/",
            type: 'GET',
            // This is query string i.e. country_id=123
            data: {id :data_id},
            success: function(data) {  
					
				 $('#select_catelog_id').val(select_catelog_id);
				  $('#responsive-catelog-model').modal('show'); 
				$(".catelog_plan_body").html(data);
				 
				 
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
	});
});
</script>