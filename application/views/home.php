<?php
 if (!$this->session->is_login)
      redirect(base_url());
?>
<!-- <img src="<?php //echo base_url('assets/images/background-light.png');?>"  class="col-lg-12" alt=""> -->
<?php //echo anchor("home/logout","logout"); ?>
<section class="section-container">
      <div class="first-column">
          <img src="<?php echo base_url('assets/images/background.png');?>" alt="background-image" class="background-image">
          <img src="<?php echo base_url('UPLOAD/profilepic/default.jpg');?>" alt="Profile_pic" class="profile-image">
          <h5><?php echo $userdetail->Name?></h5>
          <p><?php echo $userdetail->institute;?></p>
      </div>
      <div class="second-column">
        <?php echo $error; ?>
        <?php echo form_open_multipart('uploads/uploads');?>
          <div class="uploads">
            <i class="icon-camera"></i>
            <input type="text" placeholder="Post Something">
          </div>
          <input type="submit" class="upload-button" value="Upload">
        <input type="file" name="userfile" style="display:none;">
        <input type="submit" value="upload" class="btn btn-light"/>
        </form>
        <?php foreach($data as $d): ?>
          <div class="post">
            <div class="post-user-detail">
              <div class="profilepic-container">
                <img src="<?php echo base_url('UPLOAD/profilepic/default.jpg');?>" alt="background-image" class="profilepic">
              </div>
              <div class="username-enrollemnt-container">
                <h5><?php echo $d->Name;?></h5>
                <h6><?php echo $d->Enrollment;?></h6>
              </div>
            </div>
            <p class="small"><?php echo $d->description; ?></p>
          <img src="<?php echo base_url('UPLOAD/'.$d->fileaddress);?>" alt="background-image" class="post-pic img-thumbnail">
          <div class="row">
            <div class="col-lg-12">
              <a href="<?php echo base_url('Home/like/'.$d->upload_id);?>" class="like"><i class="icon-thumbs-o-up"></i> Like <?php echo $d->likes; ?></a>
              <!-- <a href="<?php //echo base_url('Home/dislike/'.$d->upload_id);?>" class=""><i class=""></i> Dislike <?php// echo $d->dislikes; ?></a> -->
              <a href="<?php //echo base_url('Home/share');?>" class="share"><i class="icon-share2"></i>  Share <?php //echo $d->share; ?></a>
            </div>
          </div>
        </div>
      <?php endforeach ?>
      </div>
      <div class="third-column">
        <div id="demo" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ul class="carousel-indicators">
              <li data-target="#demo" data-slide-to="0" class="active"></li>
              <li data-target="#demo" data-slide-to="1"></li>
              <li data-target="#demo" data-slide-to="2"></li>
            </ul>
              <!-- The slideshow -->
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img src="<?php echo base_url('assets/images/background.png');?>">
              </div>
              <div class="carousel-item">
                <img src="<?php echo base_url('assets/images/background-light.png');?>">
              </div>
              <div class="carousel-item">
                <img src="<?php echo base_url('assets/images/background.png');?>">
              </div>
            </div>

            <!-- Left and right controls -->
            <a class="carousel-control-prev" href="#demo" data-slide="prev">
              <span class="carousel-control-prev-icon"></span>
            </a>
            <a class="carousel-control-next" href="#demo" data-slide="next">
              <span class="carousel-control-next-icon"></span>
            </a>
          </div>
        <!-- <img src="<?php //echo base_url('assets/images/background.png');?>" alt="background-image" class="background-image"> -->
        <div class="mt-1">
          <p class="lead text-lg-center font-weight-normal"> <i class="icon-whatshot"></i> &nbsp;&nbsp;Hot Headlines</p>
        </div>
        <ul class="nav navbar">
          <?php foreach($news as $n): ?>
            <li class="nav-item"><a href="<?php echo base_url('home/news/'.$n->news_id);?>" class="nav-link"> <i class="icon-eye3"></i> <?php echo $n->news_title; ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
</section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url('assets/js/homeFunction.js'); ?>">
    </script>
</body>
</html>
