<?php   $login_role=($Auth->user('login_role'));
?>
<aside class="left-sidebar"> 
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile" style="background: url(<?php echo $this->request->getAttribute("webroot"); ?>assets/images/background/user-info.jpg) no-repeat;">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="<?php echo $this->request->getAttribute("webroot"); ?>assets/images/users/profile.png" alt="user" /> </div>
                    <!-- User profile text-->
                    <div class="profile-text"> <a href="#" class="dropdown-toggle u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><?php echo $Auth->user('fullname'); ?></a>
                        <div class="dropdown-menu animated flipInY"> 
						<a href="#" class="dropdown-item"><i class="ti-user"></i> My Profile <?php echo $login_role; ?></a>
						
                            
							
						   <div class="dropdown-divider"></div> <a href="<?php echo $this->Url->Build(['controller'=>'Users','action'=>'logout'])?>" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a> </div>
                    </div>
                </div>   
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                       
                        <li> <a class="waves-effect waves-dark"  href="<?php echo $this->Url->Build(['controller'=>'Users','action'=>'dashboard'])?>" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard </span></a>
                          
                        </li>
						<?php if($login_role==1){ ?>
						<li> <a class="waves-effect waves-dark" href="<?php echo $this->Url->Build(['controller'=>'category','action'=>'add'])?>" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Manage Category </span></a>
                          
                        </li> <?php  } if($login_role!=2){?>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-laptop-windows"></i><span class="hide-menu">Manage Catelog</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'Catelog','action'=>'index'])?>"> Catelog List</a></li>
								<?php if($login_role==1 || $login_role==4){ ?>
								<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'Catelog','action'=>'add'])?>">Add Catelog</a></li>
								<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'Catelog','action'=>'uploadedcatelog'])?>">Uploaded Catelog</a></li>
								
								<?php } else { if($login_role==3){?>
								<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'Catelog','action'=>'upload'])?>">Upload Catelog</a></li>
								
								<?php }} ?>
                            </ul>
                        </li>
						<?php }  else {?>
						 
						<?php } ?>
						<?php if($login_role==1){ ?>
						 <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-bullseye"></i><span class="hide-menu">Manage User</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'users','action'=>'userlist',2])?>">Reseller</a></li>
                                <li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'users','action'=>'userlist',3])?>">Supplier</a></li>
                               
                            </ul>
                        </li>
						<li> <a class="waves-effect waves-dark"  href="<?php echo $this->Url->Build(['controller'=>'coupon','action'=>'index'])?>" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Manage Coupon </span></a>
                          
                        </li>
						

						<?php } ?>
						 <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-cart"></i><span class="hide-menu">Manage Sale</span></a>
                            <ul aria-expanded="false" class="collapse">
							  
								<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'order','action'=>'index'])?>">Order List</a></li>
								<?php if($login_role==3){ ?>
								<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'order','action'=>'mainfest'])?>">MainFest</a></li>
								<?php } ?>
								<?php if($login_role==1){ ?>
								<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'order','action'=>'d5order'])?>">D+5 Order</a></li>
								<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'order','action'=>'d5order2'])?>">D+5 Order 2</a></li>
                                <li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'order','action'=>'rto'])?>">RTO Order</a></li>
								
								<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'order','action'=>'weiver'])?>">Weiver</a></li>
								<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'order','action'=>'penlty'])?>">Penlty</a></li>
								<?php  } if($login_role==1){?>
								  <li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'order','action'=>'trascation'])?>">Order Trascation</a></li>
								  <li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'order','action'=>'rbycustomer'])?>">Return By Customer</a></li>
								
								<?php } else { if($login_role==3){?>
								<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'order','action'=>'rbycustomer'])?>">Return By Customer</a></li>
								<?php } ?>
								 <li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'order','action'=>'trascation'])?>">Order Payment</a></li>
								
									<?php } if($login_role==1){ ?>
							   <li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'order','action'=>'report'])?>">Payment Report</a></li>
								<?php } ?>
							   <li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'order','action'=>'payoff'])?>">Payoff</a></li>
                              
                               
                            </ul>
                        </li>
						<?php if($login_role==3){ ?>
						<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'users','action'=>'warehouse'])?>"><i class="mdi mdi-table"></i>Warehouse Address</a></li>  
						<?php } ?>
						<?php if($login_role==1){ ?>
						<li> <a class="waves-effect waves-dark"  href="<?php echo $this->Url->Build(['controller'=>'Users','action'=>'sendpush'])?>" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Send Push </span></a>
                          
                        </li>
						
						 <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-laptop-windows"></i><span class="hide-menu">Manage Attribute</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'attribute','action'=>'attributestyle'])?>"> Attribute Style</a></li>
                              
                                <li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'attribute','action'=>'add-attribute'])?>"> Attribute Value</a></li>
                                <li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'attribute','action'=>'sizestyle'])?>">Size Style</a></li>
                                <li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'attribute','action'=>'add-option'])?>">Add Size option</a></li>
                               
                            </ul>
                        </li>
                       
                      
                      
                        <li class="nav-devider"></li>
						
                        <li class="nav-small-cap">Setting</li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-table"></i><span class="hide-menu">App Setting</span></a>
                            <ul aria-expanded="false" class="collapse">
                               
                                <li><a href="<?php echo $this->Url->Build(['controller'=>'setting','action'=>'collectionlist'])?>">Searh Page </a></li>
                                <li><a href="<?php echo $this->Url->Build(['controller'=>'setting','action'=>'homepage'])?>">Home Page Setup </a></li>
                                <li><a href="<?php echo $this->Url->Build(['controller'=>'setting','action'=>'categoryorder'])?>">Category Ording </a></li>
                                <!--li><a href="<?php echo $this->Url->Build(['controller'=>'setting','action'=>'adssetup'])?>">Ads setup </a></li!-->
                                <li><a href="<?php echo $this->Url->Build(['controller'=>'setting','action'=>'modelist'])?>">Courier  setup </a></li>
								  <li><a href="<?php echo $this->Url->Build(['controller'=>'setting','action'=>'tutorial'])?>">Tutorials</a></li>
								  <li><a href="<?php echo $this->Url->Build(['controller'=>'setting','action'=>'policylist'])?>">Policy</a></li>
                             

                            </ul>
                        </li>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-table"></i><span class="hide-menu">Mange offer</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="<?php echo $this->Url->Build(['controller'=>'setting','action'=>'offerlist'])?>">Offer List</a></li>
                                <li><a href="<?php echo $this->Url->Build(['controller'=>'setting','action'=>'addoffer'])?>">Add New Offer</a></li>   

                            </ul>
                        </li>
						<?php } ?>
						<?php if($login_role==2 || $login_role==3){ ?>
							<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'Pages','action'=>'notification'])?>"><i class="mdi mdi-table"></i>Notification</a></li>
							<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'Pages','action'=>'offer'])?>"><i class="mdi mdi-table"></i>Offer</a></li>
							<li> <a class="nav-link" href="<?php echo $this->Url->Build(['controller'=>'Users','action'=>'logout'])?>"><i class="mdi mdi-power"></i>Logout</a></li>
								
						<?php } ?>
							
                       
                       
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
            <div class="sidebar-footer">
<!--a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
              <a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a!-->
                <!-- item--><a href="<?php echo $this->Url->Build(['controller'=>'Users','action'=>'logout'])?>" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a> </div>
            <!-- End Bottom points-->
        </aside>