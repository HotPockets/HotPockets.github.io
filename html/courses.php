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
  <br><br>
<div class="col-sm-3">
  <br><br><br>
  <form class="form-horizontal" method="post" id="subjectSelectForm">
    <label for='formSubject'>Select the subject</label><br>
    <select name="formSubject" id="subjectSelect">
    <option value="none">--------</option>
      <?php
      require( '../php/connect.php' );
      require( '../php/functions.php' );
      session_start();
      getSubjects();
      ?>
    </select>
    <noscript><input type="submit" name="selectedSubject" id="selectedSubject" value="Submit"></noscript>
</form>
<form class="form-horizontal">
    <br><br>
    <label for='formCourses[]'>Select the Courses</label><br>
<select multiple id="coursesSelectBox" name="formCourses[]">

  </select>
</form>
</div>

<div class="col-sm-3">
  <br><br><br><br><br>
    <button class="btn btn-lg btn-danger" onclick="updateCourses(document.getElementById('coursesSelectBox'), document.getElementById('coursesOutputBox'));">Add Course(s)</button>
    <br><br><br>
    <button class="btn btn-lg btn-danger" onclick="removeSelectedOptions(document.getElementById('coursesOutputBox'));">Remove Course(s)</button>
</div>

<div class="col-sm-3">
</div>

<div class="col-sm-5">
<H1>Transfer Courses</H1>
<form class="form-horizontal">
  <select multiple="multiple" id="coursesOutputBox" name="outCourses[]">

  </select>
  <!--
  <table class="table table-striped table-bordered">
  <tr>
    <th>Course Number</th>
    <th>Subject</th>
    <th>Course Name</th>
  </tr>
  <tr>
    <td>3333</td>
    <td>Sex Studies</td>
    <td>Boneritis</td>
  </tr>
  <tr>
    <td>6969</td>
    <td>Sex Studies</td>
    <td>Sexxy time</td>
  </tr>
  <tr>
    <td>3333</td>
    <td>Sex Studies</td>
    <td>Boneritis</td>
  </tr>
  <tr>
    <td>6969</td>
    <td>Sex Studies</td>
    <td>Sexxy time</td>
  </tr>
  </table>
  -->

</form>
<script>populateList(document.getElementById('coursesOutputBox'), outputList);

$("document").ready(function() {
  //Populate courses
  //When the dropdown changes
  $("#subjectSelect").change(function(){
    //Get the selected value
     var selectedValue = this.value;
     console.log("Selected " + selectedValue);
     //Post it to the file getCourses.php
    $.ajax({
         url: '../php/getCourses.php',
         type: 'POST',
         data: {option : selectedValue},
         success: function() {
             console.log("Data sent!");
         },
         error: function (xhr, ajaxOptions, thrownError) {
           console.log(xhr.status);
           console.log(xhr.responseText);
           console.log(thrownError);
       }
     });
  });

});
/*
var doc = new jsPDF();

doc.setTextColor(100);
doc.setFont("helvetica");
doc.setFontType("bold");
doc.setFontSize(36);
doc.setTextColor(255, 0, 0);
doc.text(65, 30, 'Marist College');
doc.setFontSize(28);
doc.setTextColor(0, 0, 0);
doc.text(38, 40, 'Unofficial Transfer Evaluation');

doc.save('Test.pdf');
*/
</script>
</div>

</div>
        <div class="footer">
          <p>Copyright&#169 Team Hot Pockets 2015</p>
        </div>
  </div>


</div>
</html>
