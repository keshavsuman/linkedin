<div class="content">
<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip">Add Admin</h4>
        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
      </div>
      <div class="card-body collapse in">
        <div class="card-block">

          <div class="card-text">
            <p>You can add another admin here.</p>
          </div>

          <form class="form" action="<?php echo base_url('admin/insertadmin'); ?>" method="post">
            <div class="form-body">

              <div class="col-md-4">
                <div class="form-group">
                  <label for="issueinput1">Admin ID</label>
                  <input type="text" id="issueinput1" class="form-control" placeholder="Admin ID" name="admin_id" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Admin ID">
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group">
                  <label for="issueinput2">Password</label>
                  <input type="password" id="issueinput2" class="form-control" placeholder="Password" name="pass" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Password">
                </div>
              </div>

              <!-- <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="issueinput3">Date Opened</label>
                    <input type="date" id="issueinput3" class="form-control" name="dateopened" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date Opened">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="issueinput4">Date End</label>
                    <input type="date" id="issueinput4" class="form-control" name="dateend" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Date End">
                  </div>
                </div>
              </div> -->


              <!-- <div class="form-group">
                <label for="issueinput5">Priority</label>
                <select id="issueinput5" name="priority" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Priority">
                  <option value="low">Low</option>
                  <option value="medium">Medium</option>
                  <option value="high">High</option>
                </select>
              </div> -->

              <!-- <div class="form-group">
                <label for="issueinput6">Status</label>
                <select id="issueinput6" name="status" class="form-control" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Status">
                  <option value="not started">Not Started</option>
                  <option value="started">Started</option>
                  <option value="fixed">Fixed</option>
                </select>
              </div> -->

              <!-- <div class="form-group">
                <label for="issueinput8">News</label>
                <textarea id="issueinput8" rows="5" class="form-control" name="news" placeholder="news" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="news"></textarea>
              </div> -->

            </div>

            <div class="form-actions">
              <button type="button" class="btn btn-warning mr-1">
                <i class="icon-cross2"></i> Cancel
              </button>
              <button type="submit" class="btn btn-primary">
                <i class="icon-check2"></i> Add
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
