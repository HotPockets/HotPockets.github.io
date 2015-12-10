<!DOCTYPE HTML>
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/css" href="index.xml"?>
<!-- Bootstrap -->
<!-- Link to Jquery -->
<script src="./distrib/js/jquery-1.11.3.js"></script>
<!-- Links to jsPDF -->
<script type="text/javascript" src="distrib/js/jsPDF/jspdf.js"></script>
<script type="text/javascript" src="distrib/js/jsPDF/libs/Deflate/adler32cs.js"></script>
<script type="text/javascript" src="distrib/js/jsPDF/libs/FileSaver.js/FileSaver.js"></script>
<script type="text/javascript" src="distrib/js/jsPDF/libs/Blob.js/BlobBuilder.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="./distrib/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="./distrib/css/bootstrap-theme.min.css">
<!-- Custom styles for this template -->
<link href="./distrib/css/theme.css" rel="stylesheet">
<link rel="shortcut icon" type="image/ico" href="distrib/img/icon.png" />
<script src="./distrib/js/functions.js"></script>
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
          <h3>Chose up to three majors and/or minors to see degree progress</h3>
          <div class="col-sm-4">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#major1">Major</a></li>
              <li><a data-toggle="tab" href="#minor1">Minor</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="major1">
              <form class="form-horizontal" id="majorSelectForm1">
                <select name="formMajor1" style="width: 100%;" id="major1Select">
                <option value="none">Select a Major</option>
                  <?php
                    getMajor();
                  ?>
                </select>
            </form>
          </div>
          <div class="tab-pane" id="minor1">
            <form class="form-horizontal" id="minorSelectForm1">
              <select name="formMinor1" style="width: 100%;" id="minor1Select">
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
          <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#major2">Major</a></li>
            <li><a data-toggle="tab" href="#minor2">Minor</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="major2">
            <form class="form-horizontal" id="majorSelectForm2">
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
            <select name="formMinor2" style="width: 100%;" id="minor2Select">
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
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#major3">Major</a></li>
          <li><a data-toggle="tab" href="#minor3">Minor</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="major3">
          <form class="form-horizontal" id="majorSelectForm3">
            <select name="formMajor3" style="width: 100%;" id="major3Select">
            <option value="none">Select a Major</option>
              <?php
                getMajor();
              ?>
            </select>
        </form>
      </div>
      <div class="tab-pane" id="minor3">
        <form class="form-horizontal" id="minorSelectForm3">
          <select name="formMinor3" style="width: 100%;" id="minor3Select">
          <option value="none">Select a Minor</option>
            <?php
              getMinor();
            ?>
          </select>
      </form>
    </div>
    </div>
    </div>
    <button class="btn btn-lg btn-danger" id="evalButton">Evaluate Selections</button>
  </div>

  <script>
  $("document").ready(function() {
    var major1 = null;
    var major2 = null;
    var major3 = null;

    //Evaluate Selections
    $("#evalButton").click(function(){
      //Check first major selection
      if ($("#major1Select").val() !== "none"){
        console.log($("#major1Select").val());
        major1 = new Major($("#major1Select").val());
      } else if ($("#minor1Select").val() !== "none"){
        console.log($("#minor1Select").val());
        major1 = new Major($("#minor1Select").val());
        major1.setMinor();
      } else {
        console.log("Nothing selected for Major/Minor 1");
      }

      //Check second major selection
      if ($("#major2Select").val() !== "none"){
        console.log($("#major2Select").val());
        major2 = new Major($("#major2Select").val());
      } else if ($("#minor2Select").val() !== "none"){
        console.log($("#minor2Select").val());
        major2 = new Major($("#minor2Select").val());
        major2.setMinor();
      } else {
        console.log("Nothing selected for Major/Minor 2");
      }

      //Check third major selection
      if ($("#major3Select").val() !== "none"){
        console.log($("#major3Select").val());
        major3 = new Major($("#major3Select").val());
      } else if ($("#minor3Select").val() !== "none"){
        console.log($("#minor3Select").val());
        major3 = new Major($("#minor3Select").val());
        major3.setMinor();
      } else {
        console.log("Nothing selected for Major/Minor 3");
      }

      //Start building the majors
      

/*
            console.log("About to save " + sub + " " + num + ".");
            //Post the course
            $.ajax({
                 url: 'source/php/saveSelectedCourses.php',
                 type: 'POST',
                 data: {subject : sub,
                        courseNum : num,
                        name: transName},
                 success: function(data) {
                     console.log(data);
                     console.log("Saved " + sub + " " + num + ".");
                 },
                 error: function (xhr, ajaxOptions, thrownError) {
                   console.log(xhr.status);
                   console.log(xhr.responseText);
                   console.log(thrownError);
               }
             });
             */
    });

  });
  </script>

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
