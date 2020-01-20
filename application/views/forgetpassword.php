<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Linkedin login</title>
  </head>
  <body>
    <div class="row">
    <div class="col-lg-3"></div>
    <form class="col-lg-6" action="<?php echo base_url('home/resetpassword');?>" method="post">
      <h3 class="display-3">Password Reset</h1>
      <div class="form-group">
        <label for="usr">Enrollment number</label>
        <input type="text" class="form-control" id="usr" name="Enrollment" placeholder="Enrolment number">
      </div>
      <div class="form-group">
        <label for="usr">Email</label>
        <input type="text" class="form-control" id="usr" name="email" placeholder="Email ">
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <div class="col-lg-3"></div>
  </div>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</html>
