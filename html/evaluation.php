<!DOCTYPE HTML>
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/css" href="index.xml"?>
<!-- Bootstrap -->
<!-- Link to Jquery -->
<script src="./distrib/js/jquery-1.11.3.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="./distrib/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="./distrib/css/bootstrap-theme.min.css">
<!-- Custom styles for this template -->
<link href="./distrib/css/theme.css" rel="stylesheet">
<link rel="shortcut icon" type="image/ico" href="distrib/img/icon.png" />
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
            <img src="./distrib/img/seal.jpg" alt="MaristLogo" style="width:150px;height:150px;">
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
          <?php
            require( '../php/connect.php' );
            require( '../php/functions.php' );
            session_start();
            if(intval($_SESSION['user_id']) == "" || intval($_SESSION['user_id']) < 0){
              load("login.php", -1);
            } else {
              console_log("Logged in with PID " . $_SESSION['user_id']);
            }
            console_log($_SESSION['evalName']);
          ?>
          <br>
          <h1>Marist Majors Evaluation</h1>
          <h3>Chose up to three majors to see degree progress</h3>
          <div class="col-sm-4">
            <form class="form-horizontal" id="majorsSelectForm1">
              <h3><b>Select a Major</b></h3>
              <select name="formMajor1" style="width: 100%;" id="major1Select">
              <option value="none">Select a Major</option>
                <?php
                  getMajor();
                ?>
              </select>
          </form>
        </div>
        <div class="col-sm-4">
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#major2">Major</a></li>
            <li><a data-toggle="tab" href="#minor2">Minor</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="major2">
            <form class="form-horizontal" id="majorSelectForm2">
              <h3><b>Select a Major</b></h3>
              <select name="formMajor2" style="width: 100%;" id="major2Select">
              <option value="none">Select a Major</option>
                <?php
                  getMajor();
                ?>
              </select>
          </form>
        </div>
        <div class="tab-pane" id="minor2">
          <form class="form-horizontal" id="minorSelectForm2">
            <h3><b>Select a Minor</b></h3>
            <select name="formMajor2" style="width: 100%;" id="major2Select">
            <option value="none">Select a Minor</option>
              <?php
                getMinor();
              ?>
            </select>
        </form>
      </div>
      </div>
      </div>
      <div class="col-sm-4">
        <form class="form-horizontal" method="post" id="majorSelectForm3">
          <h3><b>Select a Major</b></h3>
          <select name="formMajor3" style="width: 100%;" id="major3Select">
          <option value="none">Select a Major</option>
            <?php
              getSubjects();
            ?>
          </select>
          <br><br>
          <button class="btn btn-lg btn-danger" style="float:right;" id="saveButton">Submit Evaluation</button>
      </form>
    </div>
  </div>

<div class="footer">
  <br><br><br>
  <p>Copyright&#169 Team Hot Pockets 2015</p>
</div>
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
