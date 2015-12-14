<?php
include '../../../php/functions.php';
if (isset($_POST['option'])) {
  $email = $_REQUEST['option'];
  $evalList = userTranscript($email);
  echo $evalList;
} else {
  console_log("option did not get posted");
}


?>
