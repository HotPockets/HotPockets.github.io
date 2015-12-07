<?php
include '../../../php/functions.php';
session_start();
$id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null);
if ($id == null){
  echo "User not logged in";
} else {
  if (isset($_POST['subject'])) {
    $subject = $_REQUEST['subject'];
    if (isset($_POST['courseNum'])){
      $courseNum = $_REQUEST['courseNum'];
      if (isset($_POST['name'])){
        $name = $_REQUEST['name'];
        saveCourses($id, $subject, $courseNum, $name);
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
}
?>
