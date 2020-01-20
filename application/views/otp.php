<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
  <head>
    <title>Enter OTP - Acrolinkedin</title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/ico/favicon.ico'); ?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/images/ico/favicon-32.png'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/icomoon.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/flag-icon-css/css/flag-icon.min.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/vendors/css/extensions/pace.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-extended.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/app.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/colors.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/core/menu/menu-types/vertical-menu.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/core/menu/menu-types/vertical-overlay-menu.css'); ?>">
    <link rel="stylesheet" type="text/css" href="../../assets/css/style.css">
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
            <div class="card-header no-border pb-0">
                <div class="card-title text-xs-center">
                    <img src="<?php echo base_url('assets/images/logo/aitr_logo_it.png'); ?>" alt="branding logo">
                </div>
                <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span>We have sent you an OTP for your Registration.</span></h6>
            </div>
            <div class="card-body collapse in">
                <div class="card-block">
                    <form class="form-horizontal" action="otpconfirmation" method="post" novalidate>
                        <fieldset class="form-group position-relative has-icon-left">
                            <input type="text" class="form-control form-control-lg input-lg" id="user-email" placeholder="OTP" required>
                            <div class="form-control-position">
                                <i class="icon-key2"></i>
                            </div>
                        </fieldset>
                        <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="icon-lock4"></i>  Enter OTP</button>
                    </form>
                </div>
            </div>
            <!-- <div class="card-footer no-border">
                <p class="float-sm-left text-xs-center"><a href="login-simple.html" class="card-link">Login</a></p>
                <p class="float-sm-right text-xs-center">New to Robust ? <a href="register-simple.html" class="card-link">Create Account</a></p>
            </div> -->
        </div>
    </div>
</section>

        </div>
      </div>
    </div>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <!-- BEGIN VENDOR JS-->
    <script src="<?php echo base_url('assets/js/core/libraries/jquery.min.js" type="text/javascript'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/js/ui/tether.min.js" type="text/javascript'); ?>"></script>
    <script src="<?php echo base_url('assets/js/core/libraries/bootstrap.min.js" type="text/javascript'); ?>"></script>
    <script src="<?php echo base_url('assets/vendors/js/ui/perfect-scrollbar.jquery.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/vendors/js/ui/unison.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/vendors/js/ui/blockUI.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/vendors/js/ui/jquery.matchHeight-min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/vendors/js/ui/screenfull.min.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/vendors/js/extensions/pace.min.js'); ?>" type="text/javascript"></script>

    <script src="<?php echo base_url('assets/js/core/app-menu.js'); ?>" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/js/core/app.js'); ?>" type="text/javascript"></script>
  </body>
</html>
