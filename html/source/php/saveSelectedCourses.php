<?php
include '../../../php/functions.php';
console_log("Starting to save courses.");
if (isset($_POST['subject'])) {
  $subject = $_REQUEST['subject'];
  if (isset($_POST['courseNum'])){
    $courseNum = $_REQUEST['courseNum'];
    if (isset($_POST['name'])){
      $name = $_REQUEST['name'];
      saveCourse($subject, $courseNum, $name);
      echo "1";
    } else {
      echo "0";
    }
  } else {
    echo "0";
  }
} else {
  echo "0";
}


?>
