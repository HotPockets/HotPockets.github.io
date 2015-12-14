<?php
include '../../../php/functions.php';
if (isset($_POST['id'])) {
  $transName = $_REQUEST['id'];
  if (isset($_POST['transName'])) {
    $transName = $_REQUEST['transName'];
    somethingElse($user_id, $transName);
  } else {
    echo 'transName';
  }
    } else {
    echo 'id';
  }


?>
