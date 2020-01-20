<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Reseller Mantra Admin Board</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	 <link rel="stylesheet" href="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/dropify/dist/css/dropify.min.css">
    <!-- chartist CSS -->
    <link href="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">
    <link href="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <link href="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/css-chart/css-chart.css" rel="stylesheet">
    <!-- Vector CSS -->
    <link href="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
	    <!-- Dropzone css -->
    <link href="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/dropzone-master/dist/dropzone.css" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <link href="<?php echo $this->request->getAttribute("webroot"); ?>css/style.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="<?php echo $this->request->getAttribute("webroot"); ?>css/colors/blue.css" id="theme" rel="stylesheet">
        <link href="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
	  <link rel="stylesheet" href="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/html5-editor/bootstrap-wysihtml5.css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon --><b>
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                             
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text --><span>
                         <!-- dark Logo text -->
                       
                         <!-- Light Logo text -->    
                         <img src="<?php echo $this->request->getAttribute("webroot"); ?>image/logo-text.jpeg" class="light-logo" alt="homepage" /></span> </a>
               
			   </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item hidden-sm-down search-box"> <a class="nav-link hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search & enter"> <a class="srh-btn"><i class="ti-close"></i></a> </form>
                        </li>
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown mega-dropdown"> <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="mdi mdi-view-grid"></i></a>
                            <div class="dropdown-menu scale-up-left">
                                <ul class="mega-dropdown-menu row">
                                    <li class="col-lg-3 col-xlg-2 m-b-30">
                                        <h4 class="m-b-20">CAROUSEL</h4>
                                        <!-- CAROUSEL -->
                                        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                            <div class="carousel-inner" role="listbox">
                                                <div class="carousel-item active">
                                                    <div class="container"> <img class="d-block img-fluid" src="../assets/images/big/img1.jpg" alt="First slide"></div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="container"><img class="d-block img-fluid" src="../assets/images/big/img2.jpg" alt="Second slide"></div>
                                                </div>
                                                <div class="carousel-item">
                                                    <div class="container"><img class="d-block img-fluid" src="../assets/images/big/img3.jpg" alt="Third slide"></div>
                                                </div>
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
                                            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
                                        </div>
                                        <!-- End CAROUSEL -->
                                    </li>
                                    <li class="col-lg-3 m-b-30">
                                        <h4 class="m-b-20">ACCORDION</h4>
                                        <!-- Accordian -->
                                        <div id="accordion" class="nav-accordion" role="tablist" aria-multiselectable="true">
                                            <div class="card">
                                                <div class="card-header" role="tab" id="headingOne">
                                                    <h5 class="mb-0">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                  Collapsible Group Item #1
                                                </a>
                                              </h5> </div>
                                                <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                                    <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high. </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" role="tab" id="headingTwo">
                                                    <h5 class="mb-0">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                  Collapsible Group Item #2
                                                </a>
                                              </h5> </div>
                                                <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                    <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" role="tab" id="headingThree">
                                                    <h5 class="mb-0">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                  Collapsible Group Item #3
                                                </a>
                                              </h5> </div>
                                                <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                                                    <div class="card-body"> Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-3  m-b-30">
                                        <h4 class="m-b-20">CONTACT US</h4>
                                        <!-- Contact -->
                                        <form>
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="exampleInputname1" placeholder="Enter Name"> </div>
                                            <div class="form-group">
                                                <input type="email" class="form-control" placeholder="Enter email"> </div>
                                            <div class="form-group">
                                                <textarea class="form-control" id="exampleTextarea" rows="3" placeholder="Message"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-info">Submit</button>
                                        </form>
                                    </li>
                                    <li class="col-lg-3 col-xlg-4 m-b-30">
                                        <h4 class="m-b-20">List style</h4>
                                        <!-- List style -->
                                        <ul class="list-style-none">
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> You can give link</a></li>
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Give link</a></li>
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another Give link</a></li>
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Forth link</a></li>
                                            <li><a href="javascript:void(0)"><i class="fa fa-check text-success"></i> Another fifth link</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                    </ul>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>  
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="btn btn-danger btn-circle"><i class="fa fa-link"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Luanch Admin</h5> <span class="mail-desc">Just see the my new admin!</span> <span class="time">9:30 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="btn btn-success btn-circle"><i class="ti-calendar"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Event today</h5> <span class="mail-desc">Just a reminder that you have event</span> <span class="time">9:10 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="btn btn-info btn-circle"><i class="ti-settings"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Settings</h5> <span class="mail-desc">You can customize this template as you want</span> <span class="time">9:08 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="btn btn-primary btn-circle"><i class="ti-user"></i></div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Comment -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Messages -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-email"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu mailbox dropdown-menu-right scale-up" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title">You have 4 new messages</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/1.jpg" alt="user" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:30 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/2.jpg" alt="user" class="img-circle"> <span class="profile-status busy pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Sonu Nigam</h5> <span class="mail-desc">I've sung a song! See you at</span> <span class="time">9:10 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/3.jpg" alt="user" class="img-circle"> <span class="profile-status away pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Arijit Sinh</h5> <span class="mail-desc">I am a singer!</span> <span class="time">9:08 AM</span> </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="user-img"> <img src="../assets/images/users/4.jpg" alt="user" class="img-circle"> <span class="profile-status offline pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5>Pavan kumar</h5> <span class="mail-desc">Just see the my admin!</span> <span class="time">9:02 AM</span> </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>See all e-Mails</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- End Messages -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="../assets/images/users/1.jpg" alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                <ul class="dropdown-user">
                                    <li>
                                        <div class="dw-user-box">
                                            <div class="u-img"><img src="../assets/images/users/1.jpg" alt="user"></div>
                                            <div class="u-text">
                                                <h4>Steave Jobs</h4>
                                                <p class="text-muted">varun@gmail.com</p><a href="profile.html" class="btn btn-rounded btn-danger btn-sm">View Profile</a></div>
                                        </div>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-user"></i> My Profile</a></li>
                                    <li><a href="#"><i class="ti-wallet"></i> My Balance</a></li>
                                    <li><a href="#"><i class="ti-email"></i> Inbox</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="ti-settings"></i> Account Setting</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- Language -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-us"></i></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up"> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-in"></i> India</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-fr"></i> French</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-cn"></i> China</a> <a class="dropdown-item" href="#"><i class="flag-icon flag-icon-de"></i> Dutch</a> </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
         <?php echo $this->element('sidebar');?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
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
                        <h3 class="text-themecolor m-b-0 m-t-0">Catelog</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Catelog List</a></li>
                            <li class="breadcrumb-item active">Add Catelog</li>
                        </ol>
                    </div>
                   
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
				<form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
               <div class="row">
			    
            <div class="col-md-7">
              <div class="card">
                <div class="card-header">
                  <strong>Catelog Upload</strong>
                  
                </div>
                <div class="card-body">
                 
                    <div class="form-group row">
					 <label class="col-md-3 form-control-label" for="text-input">Select Seller</label>
					  <div class="col-md-9 autocomplete">
                       
                         <select id="seller_name" name="seller_id"  class="select2 seller_name form-control" style="width: 100%">
                                    <option>Select Seller</option>
									<?php foreach($userdata as $user){ ?>   
                                    <option seller_name="<?php echo $user['display_name']; ?>" value="<?php echo $user['id']; ?>"><?php echo $user['display_name'].","."S".$user['id']; ?></option>
									<?php } ?>   
                                </select>
                      </div>
                    
                    </div>
					 <div class="form-group row seller_detail" style="display:none;">
					   <div class="col-md-6">Seller Name : <span id="seller_label"></span>      </div>
					   
					   <div class="col-md-6">Total Catelog : <span id="seller_catelog"></span></div>
					 </div>
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="text-input">Percantage </label>
                      <div class="col-md-9">
                        <input type="hidden" id="seller_address_id" maxlength="2" name="seller_address_id" class="form-control" placeholder=""> 
                        <input type="text" id="percantage_value" maxlength="2" name="percantage_value" class="form-control" placeholder="Percantage Value"> 
                    
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="email-input">Catelog Images</label>
                      <div class="col-md-9">

						  <input type="file" id="catelog_upload" name="pic">
						  <input type="hidden" id="offer_id" name="offer_id">
                     
                      </div>
                    </div>
					  <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="email-input">Guarantee Image</label>
                      <div class="col-md-9">

						  <input type="file" id="img_guarantee" name="img_guarantee">
						 
                      </div>
                    </div>
					 <div class="form-group">
											
											<div class="input-group">
												<select   id="img_height"  name="img_height" required class="form-control select">
													<option value="">Select Image Style</option>
													<?php foreach($widthstyle as $style){  $style_id=$style['comment']; ?>
											             
													<option value="<?php echo $style_id;?>"><?php echo $style['style_name']; ?></option>
													<?php } ?>
												
												</select>
											</div>
										</div>   
					 <!--div class="form-group row">
                      <label class="col-md-3 form-control-label" for="email-input">Image Width</label>
                      <div class="col-md-9">

						  <input type="text" class="form-control" name="img_width">
						     
                      </div>
                    </div>
					<div class="form-group row">
                      <label class="col-md-3 form-control-label" for="email-input">Image Height</label>
                      <div class="col-md-9">

						  <input type="text" class="form-control" name="img_height">
						  
                      </div>
                    </div!-->
					 <!--div class="form-group row">
                      <label class="col-md-3 form-control-label" for="email-input">Image Type</label>
                      <div class="col-md-9">

						 <select name="imag_type" class="form-control"> 
						   <option value="Portrat">Portrat</option>
						   <option value="Landscape">Landscape</option>
						</select>
                      </div>
                    </div!-->
						<?php if(count($offerlist)>0){ ?>
					<div class="form-group">
						<div class="input-group">
												<select   id="offer_list" class="form-control">
													<option value="">Select Offer </option>
													<?php foreach($offerlist as $return){  ?>
											             
													<option value="<?php echo $return['id'];?>"><?php echo $return['title']; ?></option>
													<?php } ?>
												
												</select>
											</div>
					</div> 
					 <div class="form-group row">
                     
                      <div class="col-md-12">
					    <p id="offer_value"> </p>
                       <textarea  style="max-height:50px;" id="offer_desc"  name="offer_desc" rows="9" class="form-control" placeholder="Short Description.."></textarea>
						 <input type="file"  style="display:none;" id="offer_upload"  name="offer_image">
					 </div>
                    </div>
					<?php } ?>
					 <!--div class="form-group row">
                      <label class="col-md-3 form-control-label" for="email-input">Offer Images</label>
                      <div class="col-md-9">

						 
                     
                      </div>
                    </div!-->
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Catelog Name (EN)</label>
                      <div class="col-md-9">
                        <input type="text" id="name_en" maxlength="40"  required name="name_en"  class="form-control" placeholder="Catelog Name">
                       <small>Maxlegth For catelog name is 40</small>
                      </div>
                    </div>
					  <!--div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Catelog Name (Hindi)</label>
                      <div class="col-md-9">
                        <input type="text" id="password-input" name="name_hn" class="form-control" placeholder="Catelog Name Hindi">
                       
                      </div>
                    </div!-->
                   
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="textarea-input">Short Description</label>
                      <div class="col-md-9">
					   
                        <textarea id="textarea-input" style="max-height: 100px;"  name="description" rows="9" class="textarea_editor_short form-control" placeholder="Short Description.."></textarea>
                      </div>
                    </div>
					<div class="form-group row">
                      <label class="col-md-3 form-control-label" for="textarea-input">Sharing  Description</label>
                      <div class="col-md-9">
					   
                        <textarea id="sharing_description" style="max-height: 100px;"  name="sharing_description" rows="9" class="form-control" placeholder="Sharing Short Description.."></textarea>
                      </div>
                    </div>
					<div>
					<hr/>   
					  Dynamic Fields 
					 <div class="form-group">
											
											<div class="input-group">
												<select   id="style_list"  name="style_id" required class="form-control select">
													<option value="">Select Attribute Style</option>
													<?php foreach($att_style as $style){  $style_id=$style['id']; ?>
											             
													<option value="<?php echo $style_id;?>"><?php echo $style['style_name']; ?></option>
													<?php } ?>
												
												</select>
											</div>
										</div>   
                                  
					</div>
					<?php if(!empty($attribute_column)):?>
					   <div class="apand_div" style="display:none;">
					    <div class="form-group row">
							<div class="form-group col-md-11 row dynamic_div" id="dynamic_div">
							   <div class="col-sm-6">
							     <select name="selectstyle[]" class="attr_select form-control" style="width: 100%">
											 
									</select>
							   </div>
							   <div class="col-sm-6">
							     <input type="text"  name="selectvalue[]" class="form-control selectvalue" placeholder="Attribute Value">
						   
							   </div>
							</div>
							
							 
							 <div class="col-md-1">
							   <i class="fa fa-plus add_style" aria-hidden="true"></i>

							 </div>
							
						</div>
						
						
						</div>
					<?php endif;?>
						<hr/>   
						
					 <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Price by Suppiler</label>
                      <div class="col-md-9">
                        <input type="number" id="primary_price" required  name="primary_price" class="form-control" placeholder="Price by Suppiler">
                       
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Price Added</label>
                      <div class="col-md-9">
                        <input type="number" id="price_added"  name="price_added" value='0' class="form-control" placeholder="Price Added">
                       
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Final Price</label>
                      <div class="col-md-9">
                        Rs <span id="final_price"> </span>
						<input type="hidden" id="selling_price" name="selling_price"/>
                      </div>
                    </div>
                     <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Shipping Charges</label>
                      <div class="col-md-9">
                        <input type="Number" id="shipping_charges" value='0'    name="shipping_charges" class="form-control" placeholder="Shipping Value">
                       
                      </div>
                    </div>
                      <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">Youtube Video Link</label>
                      <div class="col-md-9">
                        <input type="text" id="password-input" name="youtube_link" class="form-control" placeholder="Youtube Video Link">
                       
                      </div>
                    </div>
                 
                  
                   
                    <div class="form-group row">
                     
                      <div class="col-md-9">
                        <label class="radio-inline" for="inline-radio1">
                          <input style="display:inherit;opacity:100;position: static;" type="checkbox" id="inline-radio1" name="return_applicable" checked value="option1"> Return Applicable
                       
					   </label>
                        <label class="radio-inline" for="inline-radio2">
                          <input style="display:inherit;opacity:100;position: static;" type="checkbox" id="cod_select" name="cod" checked value="option2"> COD
                        </label>
						<label class="radio-inline" for="inline-radio2">
                          <input style="display:inherit;opacity:100;position: static;" type="checkbox" id="inline-radio2" name="top_catelog" value="option2"> Top Catelog
                        </label>
                       
                      </div>
                    </div>
					
					<?php if(count($codrule)>0){ ?>
					<div class="form-group">
						<div class="input-group">
												<select   id="cod_policy" class="form-control">
													<option value="">Select Cod Policy</option>
													<?php foreach($codrule as $return){  ?>
											             
													<option value="<?php echo $return['id'];?>"><?php echo $return['policy_name']; ?></option>
													<?php } ?>
												
												</select>
											</div>
					</div> 
					 <div class="form-group row">
                     
                      <div class="col-md-12">
                       <textarea  style="max-height:50px;" id="cod_rule"  name="cod_rule" rows="9" class="form-control" placeholder="Short Description.."></textarea>
                      </div>
                    </div>
					<?php } ?>
					<?php if(count($returnpolicylist)>0){ ?>
					<div class="form-group">
						<div class="input-group">
												<select   id="return_policy" class="form-control">
													<option value="">Select Return Policy</option>
													<?php foreach($returnpolicylist as $return){  ?>
											             
													<option value="<?php echo $return['id'];?>"><?php echo $return['policy_name']; ?></option>
													<?php } ?>
												
												</select>
											</div>
					</div>  
					 <div class="form-group row">
                   
                      <div class="col-md-12">
                       <textarea id="return_rule" onChange="ShareMsg()" style="" name="return_rule" rows="9" class="form-control" placeholder="Short Description.."></textarea>
                      </div>
                    </div>
					<?php } ?>
					
					
					
                  
                   
                   
             
                </div>
                <div class="card-footer">
				<input type="submit" class="btn btn-sm btn-primary catelog_save" value="save"/>
                
                  <button type="reset" class="btn btn-sm btn-danger"><i class="fa fa-ban"></i> Reset</button>
                </div>
				
              </div>

          
            </div>
            <div class="col-md-5">
				<div class="card">
					<div class="widget-box widget-color-blue2">
						<div class="widget-header">
							<h4 class="widget-title lighter smaller">Categories </h4>
							<small id="category_missed_label" style="color:red;display:none;">Select Atleast One category</small>
						</div>
						<div class="widget-body">
							<div class="widget-main padding-8">
								<!-- <?php pr($root_category);?> -->
								<ul id="tree" class="tree tree-unselectable" role="tree">
									<?php foreach($root_category as $category):
										$children_count = $category['children_count'];
										$category_parent_id = $category['parent_id'];
										$category_id = $category['id'];
										$name = $category['name'];
										$is_active = $category['is_active'];
										
									?>
									<?php if($children_count>0):?>
									<li class="tree-branch" role="treeitem" aria-expanded="false">
										<i class="icon-caret ace-icon tree-plus tree-children" data-element-id="<?php echo $category_id?>"></i>
										<div class="tree-branch-header">
											<span class="tree-branch-name">
											<input type="checkbox" name="category_node[]" class="category_x_box" value="<?php echo $category_id?>">
											<span class="tree-label node-link" data-element-id="<?php echo $category_id?>"><?php echo $name?></span></span>
										</div>
										<ul class="tree-branch-children" role="group"></ul>
										<div class="tree-loader hidden" role="alert">
											<div class="tree-loading"><i class="ace-icon fa fa-refresh fa-spin blue"></i></div>
										</div>
									</li>
									<?php else:?>
									<li class="tree-item" role="treeitem"><span class="tree-item-name">
										<input type="checkbox" name="category_node[]" class="category_x_box" value="<?php echo $category_id?>">
										<span class="tree-label node-link" data-element-id="<?php echo $category_id?>"><?php echo $name?></span></span></li>
									<?php endif;?>
									<?php endforeach;?>
								</ul>
							</div>
						</div>
					</div>
				</div>	
              <div class="card catelog_image" style="display:none;">
                <div class="card-header">
                  <strong>Catelog Image</strong>
				     
                </div>
                <div class="card-body">
                 <img id="catelog_image" style="max-width:80%;display:none;" src="#" alt="your image" />
                  
                </div>
            
              </div>
			  <div class="card offer_image" style="display:none;">
                <div class="card-header">
                  <strong>Offer Image</strong>
				     
                </div>
                <div class="card-body">
                 <img id="offer_image" style="max-width:80%;display:none;" src="#" alt="your image" />
                  
                </div>
            
              </div>
			   <div class="card">
                <div class="card-header">
                   <h2>Stock Maintain</h2>
				    <select   id="size_list"  name="size_id" required class="form-control select">
						<option value="">Select Size Style</option>
						<?php foreach($size_style as $style){  $style_id=$style['id']; ?>
						<option value="<?php echo $style_id;?>"><?php echo $style['style_name']; ?></option>
													<?php } ?>
												
					</select>
                </div>
                <div class="card-body" id="size_card">
				  
                </div>
				<div style="margin:2%;">
				<div class="form-group"
                                        <label for="exampleInputuname2">Mode Style</label>
                                        <div class="input-group">
                                            <select   id="mode_style"  name="mode_id" required class="form-control select required">
													<option value="">Select Mode Style</option>
													<?php foreach($mode_style as $m){  $mode_id=$m['id']; ?>
											             
													<option value="<?php echo $mode_id;?>"><?php echo $m['mode_name']; ?></option>
													<?php } ?>
												
											</select>
                                        </div>
                  </div>
				 <div class="card-body mode_detail"  id="mode_detail" style="display:none;">
						<div class="form-group">
                                        <label for="exampleInputuname2">Package Length</label>
                                        <div class="input-group">
                                            <input type="text" id="packageLength" name="packageLength" placeholder="Package Length" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                        </div>
						<div class="form-group">
                                        <label for="exampleInputuname2">Package Width</label>
                                        <div class="input-group">
                                            <input type="text" id="packageWidth" name="packageWidth" placeholder="Package Width" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                            </div>
							<div class="form-group">
                                        <label for="exampleInputuname2">Package Height</label>
                                        <div class="input-group">
                                            <input type="text" id="packageHeight" name="packageHeight" placeholder="Package Height" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                            </div>
							<div class="form-group">
                                        <label for="exampleInputuname2">Package Weight</label>
                                        <div class="input-group">
                                            <input type="text" id="packageWeight" name="packageWeight" placeholder="Package Weight" class="required-entry form-control"/>
                                            <div class="input-group-addon"></div>
                                        </div>
                            </div>
                </div>
				  </div>
                  <div class="form-group row">
                      <label class="col-md-3 form-control-label" for="password-input">  Max Earning</label>
                      <div class="col-md-9"> 
                        <input type="Number" required  maxlength="2" name="max_ratio" class="form-control" placeholder="Max Earning">
                       
                      </div>
                    </div>
              </div>
              <div class="card">
                <div class="card-header">
                  <strong>Description</strong>
                  For Whatapp Share
				   <p  id="generate_text" class="btn btn-primary" style="float:right;">Generate Share Text</p>
                </div>
                <div class="card-body">
				
                    <textarea name="share_text" id="share_text" required class=" form-control" rows="15" placeholder="Enter text ..."></textarea>
				   
                </div>
             
              </div>

            

             
            </div>
			
            <!--/.col-->
          </div>
		  </form>
          <!--/.row-->
               
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script>

</script>

 <script>
    jQuery(document).ready(function() {
	  
	   <!-- alert(3); -->
		  $('#generate_text').click(function() {
				var c_name=$.trim($('#name_en').val());
				
				 var short_desc=$.trim($('#sharing_description').val());
				
				var shipping_charges=$.trim($('#shipping_charges').val());
				var final_price=$.trim($('#final_price').html());
			
				var share_text='';
				var size_text='';
			  if(c_name)
			  share_text +="*"+c_name+"*\n";
			  if(short_desc)
			  share_text +="\n"+short_desc+"\n";
			 $('.attr_select').each(function(){
			     var selected_item=$.trim($('option:selected', this).attr('data'));
				 var n_val=$.trim($(this).closest('div').next().find('input').val());
				 if(selected_item && n_val)
				 share_text +="\n*"+selected_item+"* : "+n_val+"\n";
			   });
			  if(shipping_charges)
				  {
					if(shipping_charges==0)
					{
					  var ship_text="*Free Shipping*";
					}
					else
					{
					   var ship_text=shipping_charges+" Rs. extra \n";
					}
					 share_text +="\n*Shipping* : "+ship_text+"\n";
				  }
				  if($("#cod_select").prop("checked") == true){
				    var c_text="Yes";
				  }
				  else
				  {
				     var c_text="No";
				  }
				  if(c_text)
				  share_text +="\n*COD Available*: "+c_text+"\n";
			   $("#share_text").val(share_text);     
			 });
		 // For select 2
        $(".select2").select2();
		  $('#seller_name').change(function() {
			  var id=$(this).val();
			  
        $.ajax({
            url: '<?php echo $this->url->Build(['controller'=>'users','action'=>'sellerdetail'])?>',
            dataType: 'json',
            type: 'GET',
            // This is query string i.e. country_id=123
            data: {id :id},
            success: function(data) {  
					
				 $('.seller_detail').show();
				  $('#seller_label').html(data.seller_name);
				  $('#seller_address_id').val(data.seller_address_id);
				  $('#percantage_value').val(data.per_value);
					 $('#seller_catelog').html(data.total_catelog);
				 
				 
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
	 $('#mode_style').change(function() {
			  var id=$(this).val();
			  
        $.ajax({
            url: '<?php echo $this->url->Build(['controller'=>'setting','action'=>'modedetail'])?>',
            dataType: 'json',
            type: 'POST',
            // This is query string i.e. country_id=123
            data: {id :id},
            success: function(data) {  
					
				 $('.mode_detail').show();
				  <!-- $('#seller_label').html(data.seller_name); -->
				  $('#packageLength').val(data.packageLength);
				  $('#packageWidth').val(data.packageWidth);
				  $('#packageHeight').val(data.packageHeight);
				  $('#packageWeight').val(data.packageWeight);
					 <!-- $('#seller_catelog').html(data.total_catelog); -->
				 
				 
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
	  $('#cod_policy').change(function() {
			  var id=$(this).val();
			  
        $.ajax({
            url: '<?php echo $this->url->Build(['controller'=>'setting','action'=>'policydetail'])?>',
            dataType: 'json',
            type: 'POST',
            // This is query string i.e. country_id=123
            data: {id :id},
            success: function(data) {  
					<!-- alert(data.content); -->
				 <!-- $('.seller_detail').show(); -->
				  <!-- $('#seller_label').html(data.seller_name); -->
				  $('#cod_rule').val(data.content);
				  
					 <!-- $('#seller_catelog').html(data.total_catelog); -->
				 
				 
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
	 $('#return_policy').change(function() {
			  var id=$(this).val();
			  
        $.ajax({
            url: '<?php echo $this->url->Build(['controller'=>'setting','action'=>'policydetail'])?>',
            dataType: 'json',
            type: 'POST',
            // This is query string i.e. country_id=123
            data: {id :id},
            success: function(data) {  
					<!-- alert(data.content); -->
				 <!-- $('.seller_detail').show(); -->
				  <!-- $('#seller_label').html(data.seller_name); -->
				  $('#return_rule').val(data.content);
				  
					 <!-- $('#seller_catelog').html(data.total_catelog); -->
				 
				 
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
	 $('#offer_list').change(function() {
			  var id=$(this).val();
			  
        $.ajax({
            url: '<?php echo $this->url->Build(['controller'=>'setting','action'=>'offerdetail'])?>',
            dataType: 'json',
            type: 'POST',
            // This is query string i.e. country_id=123
            data: {id :id},
            success: function(data) {  
					<!-- alert(data.content); -->
				 <!-- $('.seller_detail').show(); -->
				  <!-- $('#seller_label').html(data.seller_name); -->
				  <!-- alert(data.id); -->
				  $('#offer_id').val(data.id);
				  if(data.offer_type=="per")
				  var off_text=data.offer_value +" Percantage off";
				  else
				   var off_text=data.offer_value +" Rs off";
				   <!-- alert(off_text); -->
				  $('#offer_value').html(off_text);
				  $('#offer_desc').val(data.content);
				  if(data.pic)
				  {
				  $('.offer_image').show();
			$('#offer_image').show();
			
		  $('#offer_image').attr('src', data.pic);
		  }
				  
					 <!-- $('#seller_catelog').html(data.total_catelog); -->
				 
				 
               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
    });
	
	$('.catelog_save').click(function() {
	   $(".catelog_save").prop("disabled",false);
	    var sum = 0;
    $(".stock_qty").each(function() {
      var num = parseInt($(this).val(), 10);
      sum += (num || 0);
    });
	  
		
	   if ($(".category_x_box:checkbox:checked").length > 0)
		{
			if(sum<=0)
			{
			  $("html, body").animate({ scrollTop: 0 }, "slow");
			  alert('Fill Stock Maintain');
			  return false;
			}
		 
			$('#category_missed_label').hide();
		}
		else
		{
		   // none is checked
		   $("html, body").animate({ scrollTop: 0 }, "slow");
		   $('#category_missed_label').show();
		   return false;
		}
	});
	 $('.add_style').click(function() {
	   $("#dynamic_div").clone().appendTo(".apand_div");
	 });
	
	function readURL(input) {

	  if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$('.catelog_image').show();
			$('#catelog_image').show();
		  $('#catelog_image').attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	  }
	}
	 function offerreadURL(input) {

	  if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$('.offer_image').show();
			$('#offer_image').show();
		  $('#offer_image').attr('src', e.target.result);
		}

		reader.readAsDataURL(input.files[0]);
	  }
	}
	$('#style_list').change(function() {
		// $(this).val() will work here
		var style_id=$(this).val();
		$.ajax({
            url: '<?php echo $this->url->Build(['controller'=>'catelog','action'=>'attrlist'])?>',
            dataType: 'json',
            type: 'GET',
            // This is query string i.e. country_id=123
            data: {style_id :style_id},
            success: function(data) { 
				$(".apand_div").show();   
				$(".attr_select").empty(); //To reset cities
				$(".attr_select").append("<option>--Select--</option>");
				
				$(data).each(function(i) { //to list cities
					<!-- $(".attr_select").append("<option"+ data[i].attribute_code +">"+data[i].frontend_label+"</option>"); -->
					$(".attr_select").append("<option  data='"+ data[i].frontend_label +"' value='"+ data[i].attribute_code +"'>"+ data[i].frontend_label +"</option>");
				});
			 },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
	});
	$('#size_list').change(function() {
		// $(this).val() will work here
		var style_id=$(this).val();
		$.ajax({
            url: '<?php echo $this->url->Build(['controller'=>'catelog','action'=>'sizelist'])?>',
            dataType: 'json',
            type: 'GET',
            // This is query string i.e. country_id=123
            data: {style_id :style_id},
            success: function(data) {
				$("#size_card").html("");
				
				$(data).each(function(i) { //to list cities
					<!-- $(".attr_select").append("<option"+ data[i].attribute_code +">"+data[i].frontend_label+"</option>"); -->
					<!-- $(".attr_select").append("<option  value='"+ data[i].attribute_code +"'>"+ data[i].frontend_label +"</option>"); -->
					$("#size_card").append("<div class='form-group row' style='margin-bottom:5px;'><label class='col-md-2 form-control-label stock_label'>"+ data[i].frontend_label +"</label><div class='col-md-8'><input type='hidden' id='password-input' name='stock_type[]' value='"+ data[i].attribute_code +"' class='form-control' placeholder='Catelog Name'><input type='Number' id='password-input' name='stock_qty[]' class='form-control stock_qty' placeholder='Quantity'></div></div>");
				});
			 },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(errorThrown);
            }
        });
	});

	$("#catelog_upload").change(function() {
	  readURL(this);
	});
	$("#offer_upload").change(function() {
	  offerreadURL(this);
	});
	$("#primary_price").keyup(function(){
      var primary_value=$('#primary_price').val();
      var price_added=$('#price_added').val();
	  var final_value=parseInt(primary_value, 10) + parseInt(price_added, 10);
	  $('#final_price').html(final_value);
	  $('#selling_price').val(final_value);
});
$("#price_added").keyup(function(){
    var primary_value=$('#primary_price').val();
      var price_added=$('#price_added').val();
	  var final_value=parseInt(primary_value, 10) + parseInt(price_added, 10);
	  $('#final_price').html(final_value);
	  $('#selling_price').val(final_value);
});
	});
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('click','.node-link',function(){
			cat_id = $(this).attr('data-element-id');
			$('li').removeClass('tree-selected');
			$(this).closest('li').addClass('tree-selected');

			if($(this).hasClass('x_tree_selected') == false){
				$('span').removeClass('x_tree_selected');
				$(this).addClass('x_tree_selected');
			}
			var csrfToken = <?= json_encode($this->request->getParam('_csrfToken')) ?>;
			$.ajax({
				headers: {
			        'X-CSRF-Token': csrfToken
			    },
				url:"<?php echo $this->Url->build(['controller'=>'category','action'=>'getCategoryData'])?>",
				type:'post',
				data:{'cat_id':cat_id},
				success:function(res){
					category = JSON.parse(res);
					$("#name").val(category.name);
					$("#is_active").val(category.is_active);
					$("#category_id").val(category.id);
					console.log(category.name);
				}
			});
		});
		$(document).on('click','.tree-children',function(){
			cat_id = $(this).attr('data-element-id');
			element = $(this);
			x_tree_expended = true;
			if($(this).hasClass('x_tree_expended') == true){
				x_tree_expended = false;
			}
			if($(this).hasClass('x_tree_expended') == false){
				$(this).addClass('x_tree_expended');
			}
			
			console.log(x_tree_expended);
			if(x_tree_expended == true){
				$(element).siblings('.tree-loader').removeClass('hidden');
				var csrfToken = <?php echo json_encode($this->request->getParam('_csrfToken')) ?>;

				$.ajax({
					headers: {
				        'X-CSRF-Token': csrfToken
				    },
					url:"<?php echo $this->url->Build(['controller'=>'product','action'=>'subCategoryTree'])?>",
					type:'post',
					data:{'cat_id':cat_id},
					success:function(res){
						$(element).siblings('ul').html(res);
						$(element).siblings('.tree-loader').addClass('hidden');
					}
				});
			}
		});
	});
</script>

			   
				</div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> © 2019 Reseller Mantra </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->

    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>js/jquery.slimscroll.js"></script>
    <!--Wave Effects -->
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--stickey kit -->
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>js/custom.min.js"></script>
	  <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- Treeview Plugin JavaScript -->
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/bootstrap-treeview-master/dist/bootstrap-treeview.min.js"></script>
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/bootstrap-treeview-master/dist/bootstrap-treeview-init.js"></script>
  
    <!-- Vector map JavaScript -->
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/vectormap/jquery-jvectormap-us-aea-en.js"></script>
     <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/select2/dist/js/select2.full.min.js" type="text/javascript"></script>
       <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/dropify/dist/js/dropify.min.js"></script>
	     <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/html5-editor/wysihtml5-0.3.0.js"></script>
	     <script src="<?php echo $this->request->getAttribute("webroot"); ?>assets/plugins/html5-editor/bootstrap-wysihtml5.js"></script>
    <script>
    $(document).ready(function() {
        // Basic
        $('.dropify').dropify();
		  $('.textarea_editor').wysihtml5();
		  $('.textarea_editor_short').wysihtml5();


        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        });

        // Used events
        var drEvent = $('#input-file-events').dropify();

        drEvent.on('dropify.beforeClear', function(event, element) {
            return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
        });

        drEvent.on('dropify.afterClear', function(event, element) {
            alert('File deleted');
        });

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors');
        });

        var drDestroy = $('#input-file-to-destroy').dropify();
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault();
            if (drDestroy.isDropified()) {
                drDestroy.destroy();
            } else {
                drDestroy.init();
            }
        })
    });
    </script>
</body>

</html>