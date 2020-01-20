<!-- main menu-->
<div data-scroll-to-active="true" class="main-menu menu-fixed menu-light menu-accordion menu-shadow">
  <!-- main menu header-->
  <div class="main-menu-header">
    <input type="text" placeholder="Search" class="menu-search form-control round" />
  </div>
   <div class="main-menu-content">
    <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
      <li class=" nav-item"><a href="<?php echo base_url('admin/');?>"><i class="icon-home3"></i><span data-i18n="nav.dash.main" class="menu-title">Dashboard</span></a></li>
      <li class=" nav-item"><a href="<?php echo base_url('admin/showrequests');?>"><i class="icon-stack-2"></i><span data-i18n="nav.page_layouts.main" class="menu-title">Accept Requests</span></a>
      <li class=" nav-item"><a href="<?php echo base_url('admin/removeaccepted');?>"><i class="icon-stack-2"></i><span data-i18n="nav.page_layouts.main" class="menu-title">Remove Accepted post</span></a>
      <!-- <li class=" nav-item"><a href="<?php //echo base_url('admin/imagecrousel');?>"><i class="icon-image"></i><span data-i18n="nav.page_layouts.main" class="menu-title">Image Crousel</span></a> -->
      <li class=" nav-item"><a href="<?php echo base_url('admin/news');?>"><i class="icon-paper"></i><span data-i18n="nav.icons.main" class="menu-title">News</span></a></li>
      <li class=" nav-item"><a href="<?php echo base_url('admin/searchuser');?>"><i class="icon-search"></i><span data-i18n="nav.icons.main" class="menu-title">Search User</span></a></li>
      <li class=" nav-item"><a href="<?php echo base_url('admin/addadmin');?>"><i class="icon-eye6"></i><span data-i18n="nav.icons.main" class="menu-title">Add Admin</span></a></li>
    </ul>
  </div>
</div>
<!-- / main menu-->
