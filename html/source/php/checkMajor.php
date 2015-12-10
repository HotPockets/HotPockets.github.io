<?php
include '../../../php/functions.php';
if (isset($_POST['majorName'])) {
  $majorName = $_REQUEST['majorName'];
  if (isset($_POST['transName'])) {
    $transName = $_REQUEST['transName'];
    if (isset($_POST['type'])) {
      $type = $_REQUEST['type'];

      if ($type == "major") {
        checkMajor($transName, $majorName);
      } else {
        checkMinor($transName, $majorName);
      }
      
    } else {
      echo '0';
    }
  } else {
    echo '0';
  }
} else {
  echo '0';
}


?>
