<!DOCTYPE HTML>
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/css" href="index.xml"?>
<!-- Bootstrap -->
<!-- Link to Jquery -->
<script src="./distrib/scripts/jquery-1.11.3.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="./distrib/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="./distrib/css/bootstrap-theme.min.css">
<!-- Custom styles for this template -->
<link href="./distrib/css/theme.css" rel="stylesheet">
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>
        Marist College Unofficial Credit Transfer Evaluator
      </title>
  </head>
    <body>
      <div class="page">
        <div class="header">
          <a href="">
            <img src="./distrib/img/seal.jpg" alt="MaristLogo" style="width:180px;height:150px;">
          </a>
          <h2><img src="./distrib/img/logo.png" alt="Marist" style="width:400px;height:80px;"></h2>
        </div>
        <nav class="navbar navbar-inverse" style="border-radius:0px;">
          <div class="btns">
            <a href="index.html" class="btn btn-lg btn-lg active" type="button">Home</a>
            <a href="profile.php" class="btn btn-lg active" type="button">Profile</a>
            <a href="courses.php" class="btn btn-lg active" type="button">Course List</a>
            <a href="contact.html" class="btn btn-lg active" type="button">Contact</a>
            <a href="help.html" class="btn btn-lg active" type="button">Help</a>
          </div>
        </nav>
        <div class="landing">
          <br><br><br>
          <h1>Course History</h1>
          <br><br>
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <textarea class="form-control" id="course-history" name="course-history"rows="20"></textarea>
            </div>
          </div>
          <br><br>
          <form class="form-horizontal" method="post">
            <a href="courses.html" class="btn btn-lg btn-danger">Input More Courses</a>
            <input class="btn btn-lg btn-danger" type="submit" name="logout" value="Log Out">
          </form>
          <?php
          require( '../php/connect.php' );
          require( '../php/functions.php' );
          session_start();
          if(intval($_SESSION['user_id']) == "" || intval($_SESSION['user_id']) < 0){
            load("login.php", -1);
          } else {
            console_log("Logged in with PID " . $_SESSION['user_id']);
          }
          if (isset($_POST['logout'])) {
            logOut();
          }
          ?>
        </div>

              <div class="footer">
                <p>Copyright&#169 Team Hot Pockets 2015</p>
              </div>
        </div>

        <!-- Bootstrap core JavaScript
          ================================================== -->
          <!-- Placed at the end of the document so the pages load faster -->
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
          <script src="distrib/js/bootstrap.min.js"></script>
          <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
          <!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
  </body>
</html>