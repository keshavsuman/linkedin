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
                        <h3 class="text-themecolor m-b-0 m-t-0">Attribute Edit Option</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Attribute Edit Option</li>
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
					<?php echo $this->Form->create('',['class'=>"form-horizontal","id"=>"category_form",'type'=>'file']) ?>
					
                                    <div class="form-group">
                                        <label for="exampleInputuname2"> option Value</label>
                                        <div class="input-group">
                                            <input type="text" id="name"  name="value" value="<?php echo $entity['value']; ?>" placeholder="Option" class="required-entry form-control"/>
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
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->

 