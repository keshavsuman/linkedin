<div class="content">
<div class="row match-height">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip">Add News</h4>
        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
      </div>
      <div class="card-body collapse in">
        <div class="card-block">

          <div class="card-text">
            <p>Add News here.</p>
          </div>
          <form class="form" action="<?php echo base_url('admin/addnews');?>"  method="POST">
            <div class="form-body">

              <div class="form-group">
                <label for="issueinput1">Add Image</label>
                <input type="file" id="issueinput1" class="form-control" name="newsimage" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="News Title">
              </div>

              <div class="form-group">
                <label for="issueinput1">News Title</label>
                <input type="text" id="issueinput1" class="form-control" placeholder="News title" name="newstitle" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="News Title">
              </div>
              
              <input type="hidden" id="issueinput2" class="form-control" placeholder="opened by" name="openedby"  value="<?php echo $this->session->name;?>" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="Opened By">
              <div class="row">
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
              </div>

              <div class="form-group">
                <label for="issueinput8">News</label>
                <textarea id="issueinput8" rows="5" class="form-control" name="newscontent" placeholder="news" data-toggle="tooltip" data-trigger="hover" data-placement="top" data-title="news"></textarea>
              </div>

            </div>

            <div class="form-actions">
              <button type="button" class="btn btn-warning mr-1">
                <i class="icon-cross2"></i> Cancel
              </button>
              <button type="submit" class="btn btn-primary">
                <i class="icon-check2"></i> Save
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip">Remove News</h4>
        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
      </div>
      <div class="card-body collapse in">
        <div class="card-block">

          <div class="card-text">
            <p>You can remove News here</p>
          </div>
          <?php foreach($news as $n):?>
          <div class="card-text">
            <p><?php echo $n->news_title;?></p> <button type="button" name="button">Remove</button>
          </div>
        <?php endforeach;?>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
