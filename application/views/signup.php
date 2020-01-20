<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Sign up - Acrolinkedin </title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/ico/favicon.ico');?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/images/ico/favicon-32.png');?>">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css');?>">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/icomoon.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/flag-icon-css/css/flag-icon.min.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendors/css/extensions/pace.css');?>">
    <!-- END VENDOR CSS-->
    <!-- BEGIN Cohort CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-extended.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/app.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/colors.css');?>">
    <!-- END Cohort CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/core/menu/menu-types/vertical-menu.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/core/menu/menu-types/vertical-overlay-menu.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/pages/login-register.css');?>">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/style.css');?>">
    <!-- END Custom CSS-->
  </head>
<body data-open="click" data-menu="vertical-menu" data-col="1-column" class="vertical-layout vertical-menu 1-column  blank-page blank-page">
  <!-- ////////////////////////////////////////////////////////////////////////////-->
  <div class="app-content content container-fluid">
    <div class="content-wrapper">
      <div class="content-header row">
      </div>
      <div class="content-body"><section class="flexbox-container">
  <div class="col-md-4 offset-md-4 col-xs-10 offset-xs-1 box-shadow-2 p-0">
  <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
    <div class="card-header no-border">
      <div class="card-title text-xs-center">
        <img src="<?php echo base_url('assets/images/logo/aitr_logo_it.png');?>" alt="branding logo" style="width:100%;">
      </div>
      <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>Create Account</span></h6>
    </div>
    <div class="card-body collapse in">
      <div class="card-block">
        <form class="form-horizontal form-simple" action="registeruser" method="post" novalidate>
          <fieldset class="form-group position-relative has-icon-left mb-1">
            <input type="text" class="form-control form-control-lg input-lg" id="user-name" name="name" placeholder="User Name">
            <div class="form-control-position">
                <i class="icon-head"></i>
            </div>
          </fieldset>
          <fieldset class="form-group position-relative has-icon-left mb-1">
            <input type="text" class="form-control form-control-lg input-lg" id="user-name" name="enroll" placeholder="Enrollment number">
            <div class="form-control-position">
                <i class="icon-head"></i>
            </div>
          </fieldset>
          <fieldset class="form-group position-relative has-icon-left mb-1">
            <input type="email" class="form-control form-control-lg input-lg" id="user-email" name="email" placeholder="Your Email Address" required>
            <div class="form-control-position">
                <i class="icon-mail6"></i>
            </div>
          </fieldset>
          <fieldset class="form-group position-relative has-icon-left mb-1">
            <input type="password" class="form-control form-control-lg input-lg" id="user-password" name="pass" placeholder="Enter Password" required>
            <div class="form-control-position">
                <i class="icon-key3"></i>
            </div>
          </fieldset>
          <fieldset class="form-group position-relative has-icon-left mb-1">
            <input type="password" class="form-control form-control-lg input-lg" id="user-name" name="confpass" placeholder="Confirm password">
            <div class="form-control-position">
                <i class="icon-key3"></i>
            </div>
          </fieldset>
          <fieldset class="form-group position-relative has-icon-left mb-1">
            <input type="text" class="form-control form-control-lg input-lg" id="user-name"  name ="class" placeholder="Enter class">
            <div class="form-control-position">
                <i class="icon-head"></i>
            </div>
          </fieldset>
          <fieldset class="form-group position-relative has-icon-left mb-1">
            <input type="text" class="form-control form-control-lg input-lg" id="user-name"  name ="branch" placeholder="Enter Your Branch ">
            <div class="form-control-position">
                <i class="icon-head"></i>
            </div>
          </fieldset>
          <fieldset class="form-group position-relative has-icon-left mb-1">
            <input type="text" class="form-control form-control-lg input-lg" id="user-name"  name ="institute" placeholder="Enter Institute Name">
            <div class="form-control-position">
                <i class="icon-head"></i>
            </div>
          </fieldset>
          <fieldset class="form-group position-relative has-icon-left mb-1">
            <input type="text" class="form-control form-control-lg input-lg" id="user-name"  name ="year" placeholder="Enter Year of admission">
            <div class="form-control-position">
                <i class="icon-head"></i>
            </div>
          </fieldset>
          <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="icon-unlock2"></i> Register</button>
        </form>
      </div>
      <p class="text-xs-center">Already have an account ? <a href="login-simple.html" class="card-link">Login</a></p>
    </div>
  </div>
</div>
</section>
      </div>
    </div>
  </div>
  <script src="<?php echo base_url('assets/js/core/libraries/jquery.min.js');?>" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/vendors/js/ui/tether.min.js');?>" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/js/core/libraries/bootstrap.min.js');?>" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/vendors/js/ui/perfect-scrollbar.jquery.min.js');?>" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/vendors/js/ui/unison.min.js');?>" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/vendors/js/ui/blockUI.min.js');?>" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/vendors/js/ui/jquery.matchHeight-min.js');?>" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/vendors/js/ui/screenfull.min.js');?>" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/vendors/js/extensions/pace.min.js');?>" type="text/javascript"></script>
  <!-- BEGIN VENDOR JS-->
  <!-- BEGIN PAGE VENDOR JS-->
  <!-- END PAGE VENDOR JS-->
  <!-- BEGIN Cohort JS-->
  <script src="<?php echo base_url('assets/js/core/app-menu.js');?>" type="text/javascript"></script>
  <script src="<?php echo base_url('assets/js/core/app.js');?>" type="text/javascript"></script>
  <!-- END Cohort JS-->
  <!-- BEGIN PAGE LEVEL JS-->
  <!-- END PAGE LEVEL JS-->
</body>
</html>
