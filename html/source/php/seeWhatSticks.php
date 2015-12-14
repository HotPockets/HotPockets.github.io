<?php
include '../../../php/functions.php';
  if (isset($_POST['transName'])) {
    $transName = $_REQUEST['transName'];
        seeWhatSticks($transName);
  } else {
    echo '0';
  }
?>
