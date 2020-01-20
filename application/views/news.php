<section class="news-container">
    <div class="news-first-column">
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
        <p class="lead text-lg-center font-weight-normal"> <i class="icon-whatshot"></i>   Hot Headlines</p>
      </div>
      <ul class="nav navbar">
        <?php foreach($allnews as $n): ?>
          <li class="nav-item"><a href="<?php echo base_url('home/news/'.$n->news_id);?>" class="nav-link"><i class="icon-eye2"></i> <?php echo $n->news_title; ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="news-second-column">
        <h1 class="display-4 text-lg-center"><?php echo $news->news_title; ?></h1>
        <div class="date font-weight-bold">00-00-0000,Thrusday 0:00 PM</div>
        <p><?php echo $news->news_content; ?></p>
    </div>
</section>
