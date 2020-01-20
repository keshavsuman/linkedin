 <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="login-register login-sidebar"  style="background-image:url(<?php echo $this->request->getAttribute("webroot"); ?>image/login-register.jpg);">
  <div class="login-box card">
    <div class="card-body">
	   
		<?php  echo $this->Form->create('Login',['class' => 'form-horizontal form-material','id'=>'loginform']); ?>	 
       <h3>Reseller Mantra</h3>
        <!--a href="javascript:void(0)" class="text-center db"><img src="<?php echo $this->request->getAttribute("webroot"); ?>image/logo.jpeg" alt="Home" />
		</a!-->  
        
        <div class="form-group m-t-40">
          <div class="col-xs-12">
            <input class="form-control"  name="username"  type="text" required="" placeholder="Username">
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-12">
            <input class="form-control"  name="password"  type="password" required="" placeholder="Password">
          </div>
        </div>
		  <div class="form-group">
          <div class="col-xs-12">
		  <select class="form-control" name="user_role">
		    <option value='-1'>Select Role</option>
		    <option value='reseller'>Reseller</option>
		    <option value="supplier">Supplier</option>
		    <option value="staff">Staff</option>
		  </select>
           
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            <p style="color:red;">    <?= $this->Flash->render() ?></p>
            <!--a href="javascript:void(0)" id="to-recover" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> Forgot pwd?</a!--> 
			</div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
		  <?= $this->Flash->render() ?>
            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
          </div>
        </div>
      
        <!--div class="form-group m-b-0">
          <div class="col-sm-12 text-center">
            <p>Don't have an account? <a href="register2.html" class="text-primary m-l-5"><b>Sign Up</b></a></p>
          </div>
        </div!-->
    <?= $this->Form->end() ?>
      <form class="form-horizontal" id="recoverform" action="index.html">
        <div class="form-group ">
          <div class="col-xs-12">
            <h3>Recover Password</h3>
            <p class="text-muted">Enter your Email and instructions will be sent to you! </p>
          </div>
        </div>
        <div class="form-group ">
          <div class="col-xs-12">
            <input class="form-control" type="text" required="" placeholder="Email">
          </div>
        </div>
        <div class="form-group text-center m-t-20">
          <div class="col-xs-12">
            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Reset</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->