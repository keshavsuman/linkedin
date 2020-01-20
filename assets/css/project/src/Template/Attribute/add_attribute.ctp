
 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Add Style Value</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Add Style Value</li>
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
                                        <label for="exampleInputuname2">Attribute Name</label>
                                        <div class="input-group">
                                            <input type="text" id="name" name="attribute_name" placeholder="Attribute Name" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                                    </div>
                                    <!--div class="form-group">
                                        <label for="exampleInputEmail2">Attribute Type </label>
                                        <div class="input-group">
											<select name="frontend_input" class="form-control select">
									<option value="">Select input type</option>
									<option value="text">TextField</option>
									<option value="textarea">TextArea</option>
									<option value="select">DropDown</option>
									<option value="datetime">Datetime</option>
									<option value="decimal">Decimal</option>
								</select>
										  
                                            
                                        </div>
                                    </div!-->
                                      <!--div class="form-group">
											<label for="exampleInputEmail2">Attribute For </label>
											<div class="input-group">
												<select name="att_type" required class="form-control select">
													<option value="">Select Attribute For</option>
													<option value="catelog">Catelog</option>
													<option value="product">Product</option>
												</select>
											</div>
										</div!-->
										<div class="form-group">
											<label for="exampleInputEmail2">Attribute Style </label>
											<div class="input-group">
												<select name="style_id" required class="form-control select">
													<option value="">Select Attribute Style</option>
													<?php foreach($attributestyle as $style){  $style_id=$style['id']; ?>
											             
													<option value="<?php echo $style_id;?>" <?php if($style_id==$id) echo "selected"; ?>><?php echo $style['style_name']; ?></option>
													<?php } ?>
												
												</select>
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

 