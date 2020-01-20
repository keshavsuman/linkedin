<link href="<?php echo $this->request->getAttribute("webroot"); ?>css/custom.css" rel="stylesheet">
<link href="http://54.169.217.26/assets/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Create New Ad</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Create New Ad</li>
                        </ol>
                    </div>
                  
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row" style="margin-bottom: 50px;">
 					
				   <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                               
                             <?php echo $this->Flash->render() ?>
								<?php echo $this->Form->create('',['class'=>"form-horizontal","id"=>"category_form",'type'=>'file','multiple' => 'true']) ?>
					
                                    <div class="form-group">
                                        <label for="exampleInputuname2">Ad Title</label>
                                        <div class="input-group">
                                            <input type="text" id="ads_title" name="ads_title" placeholder="Ads Title" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                                    </div>
									 <div class="form-group">
                                        <label for="exampleInputuname2">Ad Image</label>
                                        <div class="input-group">
                                            <input type="file" id="ads_image" name="ads_image" placeholder="Ads Image" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                                    </div>
									<div class="form-group">
                                       
                                        <div class="input-group">
										<?php  echo $this->Form->input('extra_image[]', ['type' => 'file', 'multiple' => 'multiple', 'label' => 'Add Some Photos','class'=>'form-control']); ?>
                                           
										  
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="exampleInputuname2">Search Keyword</label>
                                        <div class="input-group">
                                            <input type="text" id="search_keyword_1" name="search_keyword_1" placeholder="Search Keyword" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                                    </div>
									<div class="form-group">
                                        <label for="exampleInputuname2">Search Keyword 2</label>
                                        <div class="input-group">
                                            <input type="text" id="search_keyword_2" name="search_keyword_2" placeholder="Search Keyword 2" class="required-entry form-control"/>
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
                                <h4 class="card-title">Ads List</h4>
                               
                                <div class="table-responsive m-t-40">
								  <?php if(count($ads_data)>0){ ?>
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Ads Name</th>
                                                <th>Ads Main Image</th>
                                                <th>Search Keyword 1</th>
                                                <th>Search Keyword 2</th>
                                               
                                              
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                              <th></th>
                                                <th>Ads Name</th>
                                                <th>Ads Main Image</th>
                                                <th>Search Keyword 1</th>
                                                <th>Search Keyword 2</th>
                                               
                                              
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
										<?php $i=1; foreach($ads_data as $ads){
											if(isset($ads['ads_image']))
											{
												$image = $this->request->getAttribute("webroot") ."image/". $ads['ads_image'];
											}
											else
											{
											$image='';
											}
											?>
											<tr>
                                               <td><?php echo $i; ?></td>
                                               <td><?php echo $ads['ads_title']; ?></td>
											   <td><?php if($image){ ?>
											   <img src="<?php echo $image;?>" style="max-width: 80px;">
											   <?php } ?>
											   </td>
											   <td><?php echo $ads['search_keyword_1']; ?></td>
											   <td><?php echo $ads['search_keyword_2']; ?></td>
											   <td></td>
											 </tr>
											<?php  $i++;
										}?>
                                           
                                            
                                        </tbody>
                                    </table>
								  <?php } else { echo "No Ads Created ";} ?>
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

 