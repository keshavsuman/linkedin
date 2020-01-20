<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Home  |  AcroLinkedin</title>
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/header-footer.css');?>">
  <!-- <link rel="stylesheet" href="<?php// echo base_url('assets/css/all.css')?>"> -->
  <link rel="stylesheet" href="<?php echo base_url('assets/fonts/icomoon.css')?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/home.css');?>">
</head>
<body>
  <!-- header starts-->
  <div class="header-container">
    <nav class="navbar navbar-expand-sm">
      <img src="<?php echo base_url('assets/images/logo/aitr_logo_it_white.png');?>" alt="Logo" class="img-logo">
      <form class="form-inline  pl-2"  method="post">
      <input type="text" name="" placeholder="Search here" class="form-control">
      <input type="submit" value="Search" class="btn btn-secondary">
      </form>
      <div class="menu">
        <img src="<?php echo base_url('assets/images/portrait/small/avatar-s-1.png');?>" alt="avatar">
      </div>
      <ul class="navbar-nav nav-pills">
        <li class="nav-item header-nav">
            <i class="icon-home3"></i>
            <a href="<?php echo base_url();?>" class="nav-link">Home</a>
        </li>
        <li class="nav-item header-nav">
          <i class="icon-timeline"></i>
          <a href="<?php echo base_url('home/underconstruction');?>" class="nav-link">My Network</a>
        </li>
        <li class="nav-item header-nav">
          <i class="icon-bubbles"></i>
          <a href="<?php echo base_url('home/underconstruction');?>" class="nav-link">Messaging</a>
        </li>
        <li class="nav-item header-nav">
          <i class="icon-bell2"></i>
          <a href="<?php echo base_url('home/underconstruction');?>" class="nav-link">Notification</a>
        </li>
        <li class="nav-item header-nav header-dropdown">
          <i class="icon-user"></i>
          <a href="" class="nav-link">Me 	&nbsp;<span style="font-size:0.7em;">&#9660;</span></a>
          <ul class="dropdown-list">
            <li><a href="<?php echo base_url('home/profile');?>"> <i class="icon-eye"></i>  My Profile</a></li>
            <li><a href="<?php echo base_url('home/underconstruction');?>"><i class="icon-timeline"></i>  Network</a></li>
            <li><a href="<?php echo base_url('home/underconstruction');?>"><i class="icon-bubbles"></i>  Messaging</a></li>
            <li><a href="<?php echo base_url('home/underconstruction');?>"><i class="icon-bell2"></i>  Notification</a></li>
            <li class="logout"><a href="<?php echo base_url('home/logout');?>" ><i class="icon-lock"></i>  Logout</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </div>
