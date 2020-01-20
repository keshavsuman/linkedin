<?php if(count($data)==0): ?>
<div class="content">
<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip">Search User</h4>
        <!-- <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a> -->
      </div>
      <div class="card-body collapse in">
        <div class="card-block">

          <div class="card-text">
            <p>You can search any user here by his name or by using Enrollment number</p>
          </div>

          <form class="form" action="<?php echo base_url('admin/search'); ?>" method="post">
            <div class="form-body">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="issueinput1">User Name</label>
                  <input type="text" id="issueinput1" class="form-control" placeholder="User Name" name="name" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Username">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="issueinput2">Enrollment</label>
                  <input type="text" id="issueinput2" class="form-control" placeholder="Enrollment" name="enroll" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Enrollment">
                </div>
              </div>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn btn-warning mr-1">
                <i class="icon-Search"></i> Search
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<?php else:?>
  <div class="content">
  <div class="row match-height">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title" id="basic-layout-tooltip">Search User</h4>
          <!-- <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a> -->
        </div>
        <div class="card-body collapse in">
          <div class="card-block">

            <div class="card-text">
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <?php foreach($data as $d):?>
              <p><?php echo $d['Name']; ?></p>
              <p><?php echo $d['Enrollment']; ?></p>
              <p><?php echo $d['Class']; ?></p>
              <p><?php echo $d['Branch']; ?></p>
              <p><?php echo $d['Year']; ?></p>
              <p><?php echo $d['email']; ?></p>
              <p><?php echo $d['institute']; ?></p>
              <p><?php echo $d['profilepic']; ?></p>
              <?php endforeach;?>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
<?php endif;?>
