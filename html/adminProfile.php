<!DOCTYPE HTML>
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/css" href="index.xml"?>
<!-- Bootstrap -->
<!-- Link to Jquery -->
<script src="./distrib/js/jquery-1.11.3.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="./distrib/css/bootstrap.min.css">
<!-- Links to jsPDF -->
<script type="text/javascript" src="distrib/js/jsPDF/jspdf.js"></script>
<script type="text/javascript" src="distrib/js/jsPDF/libs/Deflate/adler32cs.js"></script>
<script type="text/javascript" src="distrib/js/jsPDF/libs/FileSaver.js/FileSaver.js"></script>
<script type="text/javascript" src="distrib/js/jsPDF/libs/Blob.js/BlobBuilder.js"></script>
<!-- Optional theme -->
<link rel="stylesheet" href="./distrib/css/bootstrap-theme.min.css">
<!-- Custom styles for this template -->
<link href="./distrib/css/theme.css" rel="stylesheet">
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
          <br>
          <?php
          require( '../php/connect.php' );
          require( '../php/functions.php' );
          session_start();
          if(intval($_SESSION['user_id']) == "" || intval($_SESSION['user_id']) < 0){
            load("login.php", -1);
          } else {
            console_log("Logged in with PID " . $_SESSION['user_id']);
          }
          getName();
          console_log('<h1>Welcome ' . $_SESSION['first_name'] .'!</h1>');
          echo '<h1>Welcome ' . $_SESSION['first_name'] .'!</h1>';
          ?>
          <br><br>
          <div class="holder">
            <div class="row">
              <div class="col-md-6 col-md-offset-3">
                <br>
                <h3>Saved Evaluations From All User</h3>
              </div>
            </div>
              <div class="row">
                <div class="col-md-8 col-md-offset-2">
                  <form class="form-horizontal input-lg" method="post">
                  <select style="width: 100%; color:black;" id="adminProfileList" name="selectedSave">
                    <option value='none'>Please select an evaluation</option>
                    <?php
                    adminProfileList();
                    ?>
                  </select>
                  <!-- <a href="courses.php" class="btn btn-lg btn-danger" style="margin-top: 6px">Create Evaluation</a> -->
                  </form>
                  <br>
                  <form class="form-horizontal input-lg" method="post">
                  <select style="width: 100%; color:black;" id="evalList" name="selectedEval">

                  </select>
                </form>
                  <?php
                    if (isset($_POST['evaluate'])) {
                      $name = isset($_POST['selectedSave']) ? $_POST['selectedSave'] : false;
                      if ($name && $name != 'none'){
                        $_SESSION['evalName'] = $name;
                          load("evaluation.php", $_SESSION['user_id']);
                      } else {
                        echo 'Please select a saved evaluation from the box.';
                      }
                    }
                    if (isset($_POST['logout'])) {
                      logOut();
                    }
                  ?>
                  <button class="btn btn-lg btn-danger" type="submit" id="evaluate" name="evaluate">Evaluate Selection</button>
              </div>
          </div>
          <form class="form-horizontal" method="post">
            <input class="btn btn-lg btn-danger" type="submit" name="logout" value="Log Out">
          </form>

        </div>
      </div>

      <script>
      var user_id = -1;
      var evalName = "";

      $("document").ready(function() {
      //createPDF(new jsPDF());
        //Populate courses
        //When the dropdown changes
        $("#adminProfileList").change(function(){
          //Get the selected value
           var selectedValue = this.value;
           user_id = selectedValue;
           console.log("Selected " + selectedValue);
           //Post it to the file adminGetEvals.php
          $.ajax({
               url: 'source/php/adminGetEvals.php',
               type: 'POST',
               data: {option : selectedValue},
               success: function(data) {
                   console.log("Data sent! Option: " + selectedValue + " Data: " + data);
                   $("#evalList").html(data);
               },
               error: function (xhr, ajaxOptions, thrownError) {
                 console.log(xhr.status);
                 console.log(xhr.responseText);
                 console.log(thrownError);
             }
           });
        });

        $("#evaluate").click(function(){
          makeMajor();
        });

      });

      function makeMajor(){
        var majorWhatSticks = new Major("No Major");
        evalName = $("#evalList option:selected").text();
        console.log(evalName);
        console.log("ID: " + user_id);
            $.ajax({
                 url: 'source/php/somethingElse.php',
                 type: 'POST',
                 data: {id : user_id,
                        transName : evalName},
                 success: function(data) {
                     console.log(data);
                     if (data === "failed"){

                     } else {
                       console.log("Data: " + data);
                      handleData(data, majorWhatSticks);
                      var majorArr = [];
                      majorArr.push(majorWhatSticks);
                      createPDF(new jsPDF(), majorArr, evalName);
                     }
                 },
                 error: function (xhr, ajaxOptions, thrownError) {
                   console.log(xhr.status);
                   console.log(xhr.responseText);
                   console.log(thrownError);
               }
             });


      }

      function handleData(data, major){
        var str = "" + data;
        var arr = str.split(",");
        console.log("data " + str);
        var subject = "";
        var courseNum = "";
        var courseTitle = "";
        var credits = 0;
        arr.pop(); //Remove last element which is garbage
        console.log(arr.length);

        for (var i = 0; i < arr.length; i++){
            courseTitle = arr[i];
            i++;
            courseNum = arr[i];
            i++;
            subject = arr[i];
            i++;
            credits = parseInt(arr[i]);

            course = new TransferCourse(subject, courseNum, courseTitle);
            course.setCredits(credits);
            major.addCourse(course);
        }
      }
      </script>

              <div class="footer">
                <br><br><br>
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
