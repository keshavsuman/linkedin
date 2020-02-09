<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Sign up - Acrolinkedin </title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/ico/favicon.ico');?>">
    <link rel="shortcut icon" type="image/png" href="<?php echo base_url('assets/images/ico/favicon-32.png');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/fonts/icomoon.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap-extended.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/signup.css');?>">
  </head>
  <body style="background-color:#0101">
    <header class="header">
      <img src="<?php echo base_url('assets/images/logo/aitr_logo_it_white.png'); ?>" alt="" class="navbar-brand aitr_logo_it">
      <a href="<?php echo base_url('home/');?>" class="btn btn-outline-primary login">Login</a>
    </header>
    <section>
      <div class="row">
        <div class="col-lg-6">
          <div class="container">
            <h3 class="display-4">Sign up </h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="container">
            <div class="form-container">
              <form class="form" action="<?php echo base_url('signup/registerUser');?>" method="post" role="form">
          <div class="form-group">
            <label for="Full Name">Full Name </label>
            <input type="text" name="name" placeholder="Full Name" class="form-control">
          </div>
          <div class="form-group">
            <label for="Enrollment">Enrollment</label>
            <input type="text" name="enroll" placeholder="Enrollment Number" class="form-control">
          </div>
          <div class="form-group">
            <label for="Email">Email address</label>
            <input type="email" name="email" placeholder="Email Address" class="form-control">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" placeholder="Password" class="form-control">
          </div>
          <div class="form-group">
            <label for="confirm password">Confirm Password</label>
            <input type="password" name="password" placeholder="Confirm Password" class="form-control">
          </div>
          <div class="form-group">
            <label for="Branch">Branch</label>
            <select name="branch" class="custom-select form-control">
              <option selected>Branch</option>
              <option value="IT">IT</option>
              <option value="CS">CS</option>
              <option value="EC">EC</option>
              <option value="ME">ME</option>
              <option value="CE">CE</option>
            </select>
          </div>
          <div class="form-group">
            <label for="class">Class</label>
            <input type="text" name="class" placeholder="Class" class="form-control">
          </div>
          <div class="form-group">
            <label for="Institute">Institute</label>
            <input type="text" name="institute" placeholder="Institute Name" class="form-control" value="Acropolis Institute of Technology and Research">
          </div>
          <div class="form-group">
            <button type="button" name="button" class="btn btn-warning">Cancel</button>
            <input type="submit" value="Next" class="btn btn-primary">
          </div>
        </form>
      </div>

      </div>
    </div>
    </div>
    </section>
    <footer class="footer">
    <p class="lead"> <span class="all_right">All Rights Reserved</span> <span class="developed_by">Developed By Students of IT Department</span></p>
    </footer>
  </body>
</html>
