  <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Ads  List Setup</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Ads  List Setup</li>
                        </olAds
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
                              
                                 <div class=" m-t-40">
								  <a href="<?php echo $this->Url->Build(['controller'=>'setting','action'=>'createads'])?>" class="btn btn-primary">Create New Ads</a>     
								   <h3>Ads page order list</h3>
								   <?php foreach ($pagelist as $key => $item) {
									   $shift_pos=$item['shift_pos'];
									   $arr[$shift_pos]=$item;
									   
									   }
									  
									   ?>
									<div class="row">
									  <?php for($p=1;$p<=10;$p++){ 
									 
									    $list=$arr[$p];
									     if($list['shift_pos']==$p){ 
										 if($list['ad_image'])
										    $image= $this->request->getAttribute("webroot") ."image/". $list['ad_image'];
										else
											$image='';
										 ?>
										 <div class="card col-3">
											<div class="card-body" style="text-align:center;">
											<?php if($image) {?>
											<img src="<?php echo $image;?>" style="max-width: 80px;">
											<?php }?><p><?php echo $list['title']; ?></p>
											  <p> Search Keywords : <?php echo $list['search_keyword_1']; ?></p>
											  <p> Search Keywords 2 : <?php echo $list['search_keyword_2']; ?></p>
											 
											 
											</div>
											<i  class="edit_catelog" title="<?php  echo $list['title'];?>" image_url="<?php echo $image; ?>" search_keyword_2="<?php echo $list['search_keyword_2']; ?>" search_keyword_1="<?php echo $list['search_keyword_1']; ?>" style="text-align:right" id="<?php echo $list['id']; ?>" pos="<?php echo $p; ?>">Edit</i>
										</div>
										 <?php } else {
									  ?>
									     <div class="card col-3 add_catelog"  data-toggle="modal" data-target="#myModal"  pos="<?php echo $p; ?>">
											<div class="card-body" style="text-align:center;">
											<p> Add </p>
											</div>
										</div>
										 <?php  } } ?>
									</div>
								  
									
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
				 
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
               <!-- The Modal -->
  <div class="modal" id="AddCatelog">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Add Ads For position <span id='data_pos'></span></h4>
          <button type="button" class="close close_pop" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<form  action="" method="post" enctype="multipart/form-data">
             <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input">Ad Title</label>
					  <div class="col-md-8 autocomplete">
                       <input type="hidden" name="shift_pos" id="shift_pos"/>
                        <input type="text" class="form-control" maxlength="40" name="title" required/>
                      </div>
                    
            </div> 
			  <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input">Ad Image</label>
					  <div class="col-md-8 autocomplete">
                        <input type="file" class="form-control"   name="ad_image" required/>
						
                      </div>
					  
                    
            </div>
			   <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input">Search keyword</label>
					  <div class="col-md-8 autocomplete">
                        <input type="text" class="form-control" maxlength="40" name="search_keyword_1" required/>
						
					  
                      </div>
					  
                    
            </div> 
			  <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input"> Search keyword 2</label>
					  <div class="col-md-8 autocomplete">
                        <input type="text" class="form-control" maxlength="40" name="search_keyword_2" required/>
						</br>
					  </br>
					  <input type="submit" class="btn btn-primary" value="Add"/>
                      </div>
					  
                    
            </div> 
			</form>
			
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger close_pop" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
   <div class="modal" id="EditCatelog">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Edit Catelog Category For position <span id='edit_data_pos'></span></h4>
          <button type="button" class="close close_pop" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		
		<?php  echo $this->Form->create('Ads', array('url' => array('action' => 'adssetup'), 'enctype' => 'multipart/form-data')); ?>
              <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input">Ad Title</label>
					  <div class="col-md-8 autocomplete">
                       <input type="hidden" name="shift_pos" id="edit_shift_pos"/>
                        <input type="text" id="title" class="form-control" maxlength="40" name="title" required/>
                      </div>
                    
            </div> 
			  <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input">Change Ad Image</label>
					 
					  <div class="col-md-8 autocomplete">
                        <input type="file" class="form-control"   name="ad_image"/>
						
                      </div>
					  
                    
            </div>
			   <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input">Search keyword</label>
					  <div class="col-md-8 autocomplete">
                        <input type="text" class="form-control" maxlength="40" id='search_keyword_1' name="search_keyword_1" required/>
						
					  
                      </div>
					  
                    
            </div> 
			  <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input"> Search keyword 2</label>
					  <div class="col-md-8 autocomplete">
                        <input type="text" class="form-control" maxlength="40" id="search_keyword_2" name="search_keyword_2" required/>
						</br>
					  </br>
					  <input type="submit" class="btn btn-primary" value="Edit"/>
                      </div>
					  
                    
            </div> 
			</form>
			
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger close_pop" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
	

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
 <script>
    jQuery(document).ready(function() {
		 // $("#AddCatelog").show();
		$(".select2").select2();
	
		 $('.add_style').click(function() {
	   $("#dynamic_div").clone().appendTo(".apand_div");
	 });
	    $('.add_catelog').click(function() {
			var pos = $(this).attr("pos");
			// alert(pos);
				$("#shift_pos").val(pos);
			$('#data_pos').html(pos);
		
			 $("#AddCatelog").show();
			
		});
		 $('.edit_catelog').click(function() {
			var title = $(this).attr("title");
			var pos = $(this).attr("pos");
			var search_keyword_1 = $(this).attr("search_keyword_1");
			var search_keyword_2 = $(this).attr("search_keyword_2");
			// alert(pos);
				$("#edit_shift_pos").val(pos);
				$("#title").val(title);
				$("#search_keyword_2").val(search_keyword_2);
				$("#search_keyword_1").val(search_keyword_1);
			$('#edit_data_pos').html(pos);
		
			 $("#EditCatelog").show();
			
		});
		$('.close_pop').click(function() {
			
			 $("#EditCatelog").hide();
			 $("#AddCatelog").hide();
			
		});
	
  
	});
 </script>