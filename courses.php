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
            <img src="./distrib/img/seal.jpg" alt="MaristLogo" style="width:180px;height:150px;">
          </a>
          <h2><img src="./distrib/img/logo.png" alt="Marist" style="width:400px;height:80px;"></h2>
        </div>
        <nav class="navbar navbar-inverse" style="border-radius:0px;">
          <div class="btns">
            <a href="index.html" class="btn btn-lg btn-lg active" type="button">Home</a>
            <a href="profile.php" class="btn btn-lg active" type="button">Profile</a>
            <a href="courses.html" class="btn btn-lg active" type="button">Course List</a>
            <a href="contact.html" class="btn btn-lg active" type="button">Contact</a>
            <a href="help.html" class="btn btn-lg active" type="button">Help</a>
          </div>
        </nav>
<div class="landing">
  <br><br>
<div class="col-sm-3">
  <br><br><br>
  <form class="form-horizontal" method="post">
    <label for='formSubject'>Select the subject</label><br>
    <select name="formSubject" onchange='this.form.submit()'
    value="<?php if(isset($_POST['formSubject'])) echo $_POST['formSubject']; ?>">
    <option value="none">--------</option>
      <?php
      require( '../php/connect.php' );
      require( '../php/functions.php' );
      session_start();
      getSubjects();
      ?>
    </select>
    <noscript><input type="submit" value="Submit"></noscript>
</form>
<form class="form-horizontal">
    <br><br>
    <label for='formCourses[]'>Select the Courses</label><br>
<select multiple="multiple" name="formCourses[]">
    <?php
    if (isset($_POST['formSubject'])) {
      console_log("Selected Subject: " . $_POST['formSubject']);
    }
    ?>
    <option value="Accounting">Accounting</option>
    <option value="Anthropology">Anthropology</option>
    <option value="Arabic">Arabic</option>
    <option value="Art">Art</option>
    <option value="Art Studio - Ldm">Art Studio - Ldm</option>
    <option value="Athletic Training">Athletic Training</option>
  </select>
</form>
</div>

<div class="col-sm-3">
  <br><br><br><br><br>
    <a href="" class="btn btn-lg btn-danger">Add Course(s)</a>
    <br><br><br>
    <a href="" class="btn btn-lg btn-danger">Remove Course(s)</a>
</div>

<div class="col-sm-3">
</div>

<div class="col-sm-5">
<H1>Transfer Courses</H1>
<form class="form-horizontal">
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
</form>
</div>

</div>
        <div class="footer">
          <p>Copyright&#169 Team Hot Pockets 2015</p>
        </div>
  </div>


</div>
</html>
