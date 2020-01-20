<div class="content">
  <div class="row match-height">
    <div class="col-md-12">
      <div class="card">
  <div class="card-header">
    <h4 class="card-title" id="basic-layout-tooltip">Accept Post</h4>
    <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
  </div>
  <div class="card-body collapse in">
    <div class="card-block">
      <div class="card-text">
        <p><?php echo $descrip; ?></p>
      </div>
      <?php
      foreach($result as $r):
      ?>
    <div class="col-lg-12 request">
        <div class="detail col-lg-8">
            <h4><?php echo $r['Name'];?></h4>
            <h4><?php echo $r['Enrollment']; ?></h4>
            <img src="<?php echo base_url('UPLOAD/profilepic/0.jpg');?>" alt="profile_pic">
          </div>
        <img src="<?php echo base_url('UPLOAD/'.$r['fileaddress']);?>" alt="Post_Picture" class="col-lg-8 img-thumbnail post-img">
        <div class="col-lg-12">
        <?php
          echo anchor(base_url('admin/accept/'.$r['upload_id']),'Accept',array('class' => 'btn btn-primary col-lg-3', ));
          echo anchor(base_url('admin/reject/'.$r['upload_id']),'Reject',array('class' => 'btn btn-danger col-lg-3', ));
          ?>
        </div>
      </div>
    <?php endforeach;?>
    </div>
  </div>
</div>
  </div>
    </div>
  </div>
</div>
