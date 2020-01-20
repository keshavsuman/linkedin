  <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Order List</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Order List</li>
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
                               
								<?= $this->Flash->render() ?>
								
								
                                <div class="table-responsive">
								<?php if(count($orderlist)>0){?>
								
                                    <table id="example24" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                             <tr>
                                                 <th>Order ID</th>
											   <th>Product name</th>
                                                <th>Product Pic</th>
                                                  <th>Amount</th>
                                                <th>Pending Time</th>
                                              
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
										<?php foreach($orderlist as $order){ $image = $this->request->getAttribute("webroot") ."image/". $order['product_pic'];
											?>
                                            <tr role="row" class="odd">
									
									<td class="center"><a href="#"><?php echo $order['order_id'];?></a></td>
									
									<td><?php echo $order['name_en'];?></td>	
								
										<td><img src="<?php echo $image;?>" style="max-width: 80px;"></td>
										<td><?php echo (int)$order['base_price'];?></td>	
									<td><span class="label label-sm label-success">
									
									<span class="label label-sm label-success">48:30 Hrs</span>
									</td>	
										
									<td class="hidden-480">
										 <a href="<?php echo $this->Url->build(['controller'=>'user','action'=>'edituser',$user_code]);?>" data-toggle="tooltip" data-original-title="Accept order"> <i class="fa fa-check text-inverse m-r-10"></i> </a>
                                                    
                                                   <a href="<?php echo $this->Url->build(['controller'=>'user','action'=>'deleteuser',$user_code]);?>" data-toggle="tooltip" data-original-title="Reject order"> <i class="fa fa-close text-danger"></i> </a>
											  <a href="<?php echo $this->Url->build(['controller'=>'user','action'=>'viewuser',$user_code]);?>" data-toggle="tooltip" data-original-title="View"> <i class="fa fa-shopping-cart text-inverse m-r-10"></i> </a>
                                                  
									</td>
									
								</tr>
										<?php } ?>
                                           
                                            
                                           
                                        </tbody>
                                    </table>
								<?php } else { echo "No User Found";}  ?>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
<script>
       function CountDown(duration, display) {
            if (!isNaN(duration)) {
                var timer = duration, minutes, seconds;
                
              var interVal=  setInterval(function () {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    $(display).html("<b>" + minutes + "m : " + seconds + "s" + "</b>");
                    if (--timer < 0) {
                        timer = duration;
                       SubmitFunction();
                       $('#display').empty();
                       clearInterval(interVal)
                    }
                    },1000);
            }
        }
        
        function SubmitFunction(){
       $('form').submit();
        
        }
    
         CountDown(300,$('#display'));
</script>