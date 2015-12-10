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
  <br>
  <h1>Generate Transfer Evaluations!</h1>
  <br><br>
<div class="col-sm-4">
  <form class="form-horizontal" method="post" id="subjectSelectForm">
    <h3><b>Select the subject</b></h3>
    <select name="formSubject" style="width: 100%;" id="subjectSelect">
    <option value="none">Select a Subject</option>
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
    <b><h3  align='center' for='formCourses[]'>Select the Courses</label></b></h3>
<select style="width: 100%;" multiple id="coursesSelectBox" name="formCourses[]">

  </select>
</form>
</div>

<div class="col-sm-3">
  <br><br><br><br><br>
    <button class="btn btn-lg btn-danger" style="width: 80%" onclick="updateCourses($('#subjectSelect option:selected').text(), document.getElementById('coursesSelectBox'), document.getElementById('coursesOutputBox'));">Add Course(s)</button>
    <br><br><br>
    <button class="btn btn-lg btn-danger" style="width: 80%;" onclick="removeSelectedOptions(document.getElementById('coursesOutputBox'));">Remove Course(s)</button>
</div>

<div class="col-sm-3">
</div>

<div class="col-sm-5">
<h2><b>Transfer Courses</b></h2>
<form class="form-horizontal input-lg">
  <select style="width: 100%;" multiple="multiple" id="coursesOutputBox" name="outCourses[]">

  </select>
</form>
<br><br><br><br>
<input type="eval_name" id="eval_name" name="eval_name" style="float:left;" placeholder="Evaluation Name">
<button class="btn btn-lg btn-danger" id="saveButton">Submit Evaluation</button>
<script>populateList(document.getElementById('coursesOutputBox'), outputList);

$("document").ready(function() {
//createPDF(new jsPDF());
  //Populate courses
  //When the dropdown changes
  $("#subjectSelect").change(function(){
    //Get the selected value
     var selectedValue = this.value;
     console.log("Selected " + selectedValue);
     //Post it to the file getCourses.php
    $.ajax({
         url: 'source/php/getCourses.php',
         type: 'POST',
         data: {option : selectedValue},
         success: function(data) {
             console.log("Data sent!");
             $("#coursesSelectBox").html(data);
         },
         error: function (xhr, ajaxOptions, thrownError) {
           console.log(xhr.status);
           console.log(xhr.responseText);
           console.log(thrownError);
       }
     });
  });

  //Save courses
  $("#saveButton").click(function(){
    //TODO Check to see if entered name already exists
    var transName = $('#eval_name').val();
    if (transName.length < 1){
      alert("Please enter an Evaluation Name.");
    } else {
      //Loop through and save each course
      for (var i = 0; i < list.length; i++){
        var sub = list[i].subject;
        var num = list[i].courseNum;

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
      }
  }
  });

});
</script>
</div>

</div>
        <div class="footer">
          <br><br><br>
          <p>Copyright&#169 Team Hot Pockets 2015</p>
        </div>
  </div>


</div>
</html>
