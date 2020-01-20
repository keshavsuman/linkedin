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
                        <h3 class="text-themecolor m-b-0 m-t-0">Colection List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Colection List</li>
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
                                <h4 class="card-title">Colection List</h4>
								<?= $this->Flash->render() ?>
								 <button type="button"  data-toggle="modal" data-target="#responsive-modal" style="float:left;" class="btn waves-effect waves-light btn-rounded btn-primary">Create New</button>
								 <br/>
								 <br/>
                              <!-- sample modal content -->
                                <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Create New Collection</h4>
                                            </div>  
											
                                            <div class="modal-body">
                                             
										<form action="" method="post" enctype="multipart/form-data" class="form-material m-t-40 row">
                                    <div class="form-group col-md-6 m-t-20">
                                        <input type="text" name="title" class="form-control form-control-line" id="title" placeholder="Collection Name"> 
									    <small class="hoker_name_error" style="color:#fc4b6c;display:none;">Colection Name is Required  </small> 
									</div>
									  <!--div class="form-group col-md-6 m-t-20">
                                        <label>Make Slider <input type="checkbox" name="is_slider" class="form-control"/></label>
											
									   
									</div!-->
                                    <div class="form-group col-md-6 m-t-20">
                                        <input type="file" id="offer_image" name="offer_image" class="form-control">
									</div>
									  <div class="form-group col-md-6 m-t-20">
                                        <input type="text" name="search_keyword_1" id="search_keyword_1" class="form-control form-control-line" placeholder="Search Keyword"> 
									</div>
									 <div class="form-group col-md-6 m-t-20">
                                        <input type="text" name="search_keyword_2" id="search_keyword_2" class="form-control form-control-line" placeholder="Search Keyword 2"> 
									</div>
									 <div class="form-group col-md-6 m-t-20">
									 <label>Make Slider</label>
                                        <select name="is_slider" class="form-control">
										
										<option value="n">No</option>
										<option value="y">Yes</option>
										</select>
									</div>
                                  
									
									
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                               <input type="submit" class="btn btn-danger waves-light hoker_form" value="Save"/>
                                            </div>
											</form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->
								 <div id="responsive-edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                <h4 class="modal-title">Edit Collection</h4>
                                            </div>  
											
                                            <div class="modal-body">
                                             
								<form action="editcollection" method="post" enctype="multipart/form-data" class="form-material m-t-40 row">
                                    <div class="form-group col-md-6 m-t-20">
									<input type="hidden" name="collection_id" id="collection_id" />
                                        <input type="text" name="title" class="form-control form-control-line" id="edit_title" placeholder="Collection Name"> 
									    <small class="hoker_name_error" style="color:#fc4b6c;display:none;">Colection Name is Required  </small> 
									</div>
									  <!--div class="form-group col-md-6 m-t-20">
                                        <label>Make Slider <input type="checkbox" name="is_slider" class="form-control"/></label>
											
									   
									</div!-->
                                    <div class="form-group col-md-6 m-t-20">
                                        <input type="file" id="offer_image" name="offer_image" class="form-control">
									</div>
									  <div class="form-group col-md-6 m-t-20">
                                        <input type="text" name="search_keyword_1" id="edit_search_keyword_1" class="form-control form-control-line" placeholder="Search Keyword"> 
									</div>
									 <div class="form-group col-md-6 m-t-20">
                                        <input type="text" name="search_keyword_2" id="edit_search_keyword_2" class="form-control form-control-line" placeholder="Search Keyword 2"> 
									</div>
									 <div class="form-group col-md-6 m-t-20">
									 <label>Make Slider</label>
                                        <select name="is_slider" id="edit_is_slider" class="form-control">
										
										<option value="n">No</option>
										<option value="y">Yes</option>
										</select>
									</div>
                                  
									
									
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                               <input type="submit" class="btn btn-danger waves-light hoker_form" value="Save"/>
                                            </div>
									</form>
                                        </div>
                                    </div>
                                </div>
								<!-- sample modal content -->
                          
                                <!-- /.modal -->
                                <div class="table-responsive m-t-40">
								<?php  if(count($data)>0){?>
								 <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                      
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Is Slider</th>
                                                <th>Keyword 1</th>
                                                <th>Keyword 2</th>
                                             
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php foreach($data as $h){
											$id=$h['id']; 
											if($h['offer_image'])
											$image = $this->request->getAttribute("webroot") ."image/". $h['offer_image'];
										else
											$image='';
											?>
                                            <tr>
                                                <td><?php echo $h['title']; ?></td>
                                               
                                                <td>
												<?php if($image){ ?>
												<img src='<?php echo $image; ?>' style="max-width:80px;"/> <?php } ?>
												</td>
												 <td><?php echo $h['is_slider']; ?></td>
                                                <td><?php echo $h['search_keyword_1']; ?></td>
                                                <td><?php echo $h['search_keyword_2']; ?></td>
                                             
                                                <td class="text-nowrap">
                           <span collection_id="<?php echo $h['id']; ?>" c_title="<?php echo $h['title']; ?>" is_slider="<?php echo $h['is_slider']; ?>" search_keyword_1="<?php echo $h['search_keyword_1']; ?>" search_keyword_2="<?php echo $h['search_keyword_2']; ?>" class="collection_edit" user_id="<?php echo $id; ?>" data-toggle="tooltip" data-original-title="Edit"> <i class="fa fa-pencil text-inverse m-r-10"></i> </span>
                                           <a href="<?php echo $this->Url->build(['controller'=>'setting','action'=>'deletecollection',$h['id']]);?>" data-toggle="tooltip" data-original-title="Delete"> <i class="fa fa-close text-danger"></i> </a>
                                                </td>
                                            </tr>
										<?php } ?>
                                            
                                          
                                        </tbody>
                                    </table>
                                     
								<?php } else { echo "No Collection Found";} ?>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
<script>
$(document).ready(function(){
	 $(".collection_edit").on("click", function(e){   
	   e.preventDefault(); 
	   var search_keyword_2 = $(this).attr("search_keyword_2");
	   var search_keyword_1 = $(this).attr("search_keyword_1");
	   var title = $(this).attr("c_title");
	   var collection_id = $(this).attr("collection_id");
	   var is_slider = $(this).attr("is_slider");
	   $('#collection_id').val(collection_id);
	   $('#edit_title').val(title);
	   $('#edit_search_keyword_2').val(search_keyword_2);
	   $('#edit_search_keyword_1').val(search_keyword_1);
	   $('#edit_is_slider').val(is_slider);
	   $('#responsive-edit').modal('show'); 
	 });
});
</script>