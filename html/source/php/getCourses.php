<?php
include '../../../php/functions.php';
console_log("Starting to get courses.");
if (isset($_POST['option'])) {
  $subject = $_REQUEST['option'];
  $courseList = getCourses($subject);
  console_log("courses: " . $courseList);
  echo $courseList;
} else {
  console_log("option did not get posted");
}


?>
