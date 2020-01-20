
 <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0"> Add <?php echo $user_type; ?></h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Add User</li>
                        </ol>
                    </div>
                   
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
				<?php echo $this->Form->create('User', array('url' => array('action' => 'addsupplier'), 'enctype' => 'multipart/form-data')) ?>
				
				<input type="hidden" name="customer_id" value="<?php echo $user['id']; ?>"/>
			
				
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                 <b> Add <?php echo $user_type; ?> </b>
								 
									  <p>Name: <input type="text" name="fullname" class="form-control"/></p>
									  <p>Display Name: <input type="text" name="display_name" class="form-control" required/></p>
									  <p>Mobile: <input type="text" name="mobile" maxlength="12" id="mobile" class="form-control"/></p>
									  <p>Alternative Mobile: <input type="text" name=" alternative_mobile" class="form-control"/></p>
									  <p>Email: <input type="text" name="email" class="form-control"/></p>
									  <p>City: <input type="text" name="city" class="form-control"/></p>
									
									 
									 
									 <p>
									  Supplier Pic
									
									   <input type="file" name="supplier_pic" class="form-control"/>
									</p>
									  
								
                            </div>
                        </div>
                        
                       
                    </div>
					 <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                  Bank Detail
								   
									<p>Account Holder Name:  <input type="text" name="account_holder_name" class="form-control"/></p>
									<p>Account Number:  <input type="text" name="account_number" class="form-control"/></p>
									<p>Bank Name:  <input type="text" name="bank_name" class="form-control"/></p>
									<p>IFSC:  <input type="text" name="ifsc_code" class="form-control"/></p>
									<p>Branch Address:  <input type="text" name="bank_address" class="form-control"/></p>
									<p>Branch City:  <input type="text" name="bank_city" class="form-control"/></p>
								
									
									
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
				
				 <div class="row">
                    <div class="col-md-6">
                         <div class="card">
                            <div class="card-body">
                                  Gst Detail 
								 
									 
									  <p>Gst Number:  <input type="text" name="gst_number" class="form-control"/></p>
								
									
									  <p>
									    Gst Doc
									   <input type="file" name="gst_doc" class="form-control"/></p>
								
									  </p>
									  <p> 
									   Pan card
									   <input type="file" name="pan_doc" class="form-control"/></p>
								
									  </p>
									  
                            </div>
                        </div>
                        
                       
                    </div>
					 <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                  Address Detail
								 
								<textarea class="form-control" name="address" rows="3" placeholder="Address"><?php echo $ue['address']; ?></textarea>
								<textarea class="form-control" name="address2" rows="3" placeholder="Address 2"><?php echo $ue['address2']; ?></textarea>
									<p>
									Address Proff
									
									   <input type="file" name="address_prof" class="form-control"/>
									</p>
								
								 <p>Earning Percentage :<input required type="text" name="per_value" class="form-control" value='<?php echo $user['per_value']; ?>'/> </p>
									<p>Delay/Reject/Cancel Penalty For order : 
									<input  required type="Number" maxlength="3" name="delay_penalty" class="form-control" value='<?php echo $user['delay_penalty']; ?>'/> </p>
									 <!--p>
									 Promoted Supplier
									 <?php  $promoted_supllier=$ue['promoted_supllier']; ?>
									   <select required class="form-control" name="promoted_supllier">
									   <option>Select Supplier Promotoion</option>
									   <option value="y" <?php if($promoted_supllier=="y") echo "selected";?>>Yes</option>
									   <option value="n" <?php if($promoted_supllier=="n") echo "selected";?>>No</option>
									   </select>
									 </p!-->
									 <p>Manual Shipping <input type="checkbox" name="manual_ship" id="manual_ship"/></p>
									 <p>Rating <input type="text" maxlength="3" class="form-control" name="user_rating"/></p>
									
									
                            </div>
                        </div>
                        
                       
                    </div>
                </div>
				<?php if($user['latitude'] && $user['longitute']) { ?>
				 <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> App  Map</h4>
								
								<div id="googleMap" style="width:100%;height:250px;"></div>
                                
                            </div>
                        </div>
                    </div>
                </div>
				<?php } ?>
				 <div class="card-footer">
				<input type="submit" class="btn btn-sm btn-primary" value="Create"/>
				<input type="reset" class="btn btn-sm btn-danger" value="Reset"/>
                
                  
                  
                </div>
					
				</form>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
			  <div class="modal" id="RejectModel">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Rejection </span></h4>
          <button type="button" class="close close_pop" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
		<?php echo $this->Form->create('User', array('url' => array('action' => 'updateprofile'), 'enctype' => 'multipart/form-data')) ?>
				
            
			   <div class="form-group row">
					 <label class="col-md-4 form-control-label" for="text-input">Comment For  Rejection</label>
					  <div class="col-md-8 autocomplete">
                        <input type="hidden" name="customer_id" value="<?php echo $user['id']; ?>"/>
                        <input type="hidden" id="reject_type" name="reject_type"/>
						 <textarea class="form-control" name="rejection_comment" rows="3" placeholder="Message"></textarea>
                                           
						</br>
					  </br>
					  <input type="submit" class="btn btn-primary" value="Reject"/>
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
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

 <script>
function myMap() {
	 var latitude='<?php echo $user['latitude']; ?>';
	 var longitute='<?php echo $user['longitute']; ?>';
var mapProp= {
	
  center:new google.maps.LatLng(latitude,longitute),
  zoom:5,
};
var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);
}
</script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEgme0IQxpYJUG43PZO9Dg-G0yWG6ompk&callback=myMap"></script>
<script>
$(document).ready(function(){
	
	var base_url = window.location.origin;
	r_data={};
	 $("input[name='mobile']").on("keyup", function(){
		  var number = $(this).val();
		   if(number.length > 9 && number.length <= 10){
			   $.ajax({
            url: '<?php echo $this->url->Build(['controller'=>'users','action'=>'usercheck'])?>',
            dataType: 'json',
            type: 'GET',
            // This is query string i.e. country_id=123
            data: {number :number},
            success: function(data) {  
				var result = JSON.parse(JSON.stringify(data));
				// var result = JSON.parse(data);
				// alert(result);
				if(result.is_new=="y")
				{
				}
				else
				{
					alert(result.message);
				}
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
		   }
		  
	 });
      $('.approve').click(function() {
			
			var type = $(this).attr("type");
			// alert(type);
			
			var type = $(this).attr("type");
			r_data['type']=type;
			r_data['customer_id']='<?php echo $user['id']; ?>';
			$.ajax({
			type: "POST",
			 url: base_url+"/users/updateprofile",
			data:r_data,
			// return false;
			success: function(data){
				
				    location.reload();
			}
			});
			
	  });
	  $('.reject').click(function() {
			
			var type = $(this).attr("type");
			$("#reject_type").val(type);
			$("#RejectModel").show();
			
	  });
	  $('.close_pop').click(function() {
			
			 $("#RejectModel").hide();
			 // $("#AddCatelog").hide();
			
		});
	    $('.change_status').click(function() {
			
			var status_type = $(this).attr("type");
			// alert(status_type);
			if(status_type=="make_supplier")
			{
				r_data['supplier_status']='y';
			}
			if(status_type=="block_account")
			{
				r_data['user_status']='block';
			}
			if(status_type=="active_account")
			{
				r_data['user_status']='active';
			}
		
			r_data['customer_id']='<?php echo $user['id']; ?>';
			$.ajax({
			type: "POST",
			 url: base_url+"/users/updateprofile",
			data:r_data,
			// return false;
			success: function(data){
				
				    location.reload();
			}
			});
			
	  });
});
</script>