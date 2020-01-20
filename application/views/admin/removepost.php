<div class="content">
<div class="row match-height">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title" id="basic-layout-tooltip">Remove Accepted Post</h4>
        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
      </div>
      <div class="card-body collapse in">
        <div class="card-block">

          <div class="card-text">
            <p>You can remove the post accepted by you here</p>
          </div>
          <?php foreach($result as $r): ?>
            <div class="col-lg-12 removerequest">
              <div class="row">
                <div class="detail col-lg-4 my-3">
                  <img src="<?php
                  if(strlen($r['profilepic'])>0)
                  {

                    echo base_url('UPLOAD/profilepic/'.$r['profilepic']);
                  }
                  else{
                    echo base_url('UPLOAD/profilepic/0.jpg');
                  }
                  ?>" alt="profile_pic">
                    <h4><?php echo $r['Name'];?></h4>
                    <h4><?php echo $r['Enrollment']; ?></h4>
                </div>
                <div class="col-lg-3">
                  <img src="<?php echo base_url('UPLOAD/'.$r['fileaddress']);?>" alt="Post_Picture" class=" img-thumbnail ">
                </div>
                <div class="col-lg-3 my-3 ml-3">
                  <?php
                    echo anchor(base_url('admin/removepost/'.$r['upload_id']),'Remove',array('class' => 'btn btn-danger btn-block'));
                    ?>
                </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
