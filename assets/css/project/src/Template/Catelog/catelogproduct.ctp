 <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Catelog Product List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Catelog Product List</li>
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
                                <h4 class="card-title">Product List For <?php echo $catelog_detail['name_en']; ?> Catelog</h4>
                               
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                 <th>Sr No</th>
												 <th>Stock</th>
                                                 <th>Product ID</th>
											   <th>Image</th>
                                                <th>Name</th>
                                                <th>A+B</th>
                                                <th>Shipping Charges</th>
                                                
                                                <th>Stock Varient</th>
                                              
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                                  <th>Sr No</th>
												  <th>Stock</th>
                                                 <th>Product ID</th>
											   <th>Image</th>
                                                <th>Name</th>
                                                <th>A+B</th>
                                                <th>Shipping Charges</th>
                                                
                                                <th>Stock Varient</th>
                                              
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php $i=1; foreach($product_data as $product):
											// pr($product);
											// extract($product);
											$on_stock=$product['on_stock'];
											if($on_stock=="y")
												$stock_label="ON STOCK";
											else
											$stock_label="OUT OF STOCK";
											$image = $this->request->getAttribute("webroot") ."image/". $product['pic'];
											if($product['status']==1)
											{
												$status = "Enabled";
												$label = "success";
											}
											elseif($product['status']==2)
											{
												$status = "Disabled";	
												$label = "warning";	
											}
											$on_stock=$product['on_stock'];
											// if($$on_stock)
											?>	
										<tr role="row" class="odd" style="<?php if($on_stock=='n'){ echo "color:red;";} ?>">
									<td><?php echo $i; ?></td>
									<td><span class="label label-sm label-success"><?php echo $stock_label?></span>
									<td class="center"><a href="#"><?php echo $product['catelog_id']."_".$product['id'];?></a></td>
									<td><img src="<?php echo $image;?>" style="max-width: 80px;"></td>
									<td><?php echo $product['name_en']; ?></td>	
									<td><?php echo $product['primary_price']+$product['price_added'];?></td>	
									<td><?php echo $product['shipping_charges']; ?></td>
									<td><?php foreach($product['stock'] as $s){  $stock_qun=$s['stock']; ?>
										<span style="<?php  if($stock_qun<=2){ echo "color:red";} ?>" product_count='<?php echo $catelog_detail['product_count']; ?>' catelog_id='<?php echo $product['catelog_id'];?>' detail_product='<?php echo $product['name_en'];?>' class="stock_edit" product_id="<?php echo $product['id']; ?>" data-id='<?php echo $s['id'];?>'><?php echo $s['name'].": ".$s['stock'];?><i class="fa fa-pencil text-inverse m-r-10"></i><?php echo "</br>"; ?></span>
										<?php }?></td>
									
										
								
									 <td class="text-nowrap">
                                                    
                                                  
                                                   <!--a href="<?php echo $this->Url->build(['controller'=>'users','action'=>'userdetail',$user_id]);?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </a>
                                                 
                                                   <a href="<?php echo $this->Url->build(['controller'=>'users','action'=>'deleteuser',$user_id]);?>" data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-close text-danger"></i> </a!-->
											   </td>   
								</tr>
                                          <?php $i++; endforeach;?>
                                            
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
			 <div id="responsive-catelog-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog" style="max-width:1000px !important;">
									<form method="post">
									  <input  type="hidden" id="product_id" name="product_id"/>
									  <input  type="hidden" id="catelog_id" name="catelog_id"/>
									  <input  type="hidden" id="product_count" name="product_count"/>
									
                                        <div class="modal-content catelog_plan_body">
                                           
                                        </div>
									</form>
                                    </div>
                                </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
<script>
$(document).ready(function(){
	$(".stock_edit").on("click", function(e){
	   e.preventDefault();   
	   var data_id = $(this).attr("data-id");
	   var product_id = $(this).attr("product_id");
	   var catelog_id = $(this).attr("catelog_id");
	   var product_count = $(this).attr("product_count");
	   var detail_product = $(this).attr("detail_product");
	   $('#product_id').val(product_id);
	   $('#catelog_id').val(catelog_id);
	   $('#product_count').val(product_count);
	   // alert(data_id);
	    $.ajax({
           
			  url:"/catelog/stockdetail/",
			type: 'POST',
            // This is query string i.e. country_id=123
            data: {id :data_id},
            success: function(data) {  
					
				 // $('#select_catelog_id').val(select_catelog_id);
			
				$(".catelog_plan_body").html(data);
					$('#detail_product').html(detail_product);
				  $('#responsive-catelog-model').modal('show'); 
				 
				 
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
		 // $('#').modal('show');
	});
});
</script>