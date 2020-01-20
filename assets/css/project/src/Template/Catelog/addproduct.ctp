 
	<!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Add Product</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Add Prdouct</li>
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
                                <h4 class="card-title">Product For Catelog</h4>
                                <h6 class="card-subtitle">Select No of Image of Product</h6>
                              
								<?php echo $this->Form->create('Upload',['type' => 'file','class'=>'dropzone','style'=>'border:1px dashed #d9d9d9;']); ?>
                                    <div class="fallback">
                                        <input name="file" type="file" multiple />
                                        <input name="text" type="catelog_id" value="<?php echo $catelog_id;?>"/>
                                    </div>
                                </form>
								 <h5 class="card-title" style="text-align:center;">
								 <a class="btn btn-primary" href="<?php echo $this->Url->Build(['action'=>'catelogproduct',$catelog_id])?>">Proceeed</a>  </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
              
            </div>
 <!-- Dropzone Plugin JavaScript -->
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/dropzone-master/dist/dropzone.js"></script>
	<script type="text/javascript">

	Dropzone.options.imageUpload = {

        maxFilesize:1,

        acceptedFiles: ".jpeg,.jpg,.png,.gif"

    };

</script>