<?php
require( 'connect.php' );
########################################################################################################################
# Validates the login
function validate($prname = '', $prpass = '')
{
    global $dbc;
  if(empty($prname)){
    return -1 ;
  }
	if(empty($prpass)){
    return -1 ;
  }


    # Make the query
    $query = "SELECT login('$prname', '$prpass')" ;

    # Execute the query
    $results = pg_query( $dbc, $query ) ;
    check_results($results);

    # If we get no rows, the login failed
    if (pg_num_rows( $results ) == 0 ){
      return -1 ;
    }


    # We have at least one row, so get the first one and return it
    $row = pg_fetch_array($results, NULL, PGSQL_ASSOC) ;
    echo "ROW: " . $row;

    $pid = (isset($row['login']) ? $row['login'] : null);

    if($pid == null){
      echo "The pid is null";
    }

    echo "Found PID: " . $pid;
    return intval($pid) ;
}
###############################################################################################
function sign_up($email = '', $password = '', $fname = '', $lname = ''){
  global $dbc;
if(empty($email)){
  return -1 ;
}
if(empty($password)){
  return -1 ;
}
if(empty($fname)){
  return -1 ;
}
if(empty($lname)){
  return -1 ;
}


  # Make the query
  $query = "SELECT sign_up('$fname', '$lname', '$email', '$password')" ;

  # Execute the query
  $results = pg_query( $dbc, $query ) ;
  check_results($results);

  # If we get no rows, the login failed
  if (pg_num_rows( $results ) == 0 ){
    return -1 ;
  }


  # We have at least one row, so get the first one and return it
  $row = pg_fetch_array($results, NULL, PGSQL_ASSOC) ;
  echo "ROW: " . $row;

  $pid = 1;

  if($pid == null){
    echo "The pid is null";
  }

  echo "Found PID: " . $pid;
  return intval($pid) ;
}
########################################################################################################################
function getSubjects(){
  global $dbc;
  console_log("Getting Subjects");
  $query = "SELECT * FROM subject_dcc";
  #log_file($query);
  console_log($query);
  $results = pg_query($dbc, $query);
  check_results($results);

  while($row = pg_fetch_array($results, NULL, PGSQL_ASSOC)){
    $subject = (isset($row['subject']) ? $row['subject'] : null);
    echo '<option value="' . $subject . '" ';
    echo '>' . $subject . '</option>';
  }
}
########################################################################################################################
function getCourses($subject){
  global $dbc;
  #console_log("Getting Courses for " . $subject);
  $query = "SELECT course_num, course_title FROM dcc WHERE subject = '$subject';";

  #console_log($query);
  $results = pg_query($dbc, $query);
  check_results($results);

  $list = "";
  while($row = pg_fetch_array($results, NULL, PGSQL_ASSOC)){
    $course_num = (isset($row['course_num']) ? $row['course_num'] : null);
    #console_log("Course Num: " . $course_num);
    $course_title = (isset($row['course_title']) ? $row['course_title'] : null);
    #console_log("Course Title: " . $course_title);
    $list = $list . '<option value="' . $course_num . '">' . $course_num . ' - ' . $course_title . '</option>';
  }
  return $list;
}
########################################################################################################################
function saveCourses($user_id, $subject, $course_num, $name){
  global $dbc;
  $date = date("Y-m-d");
  $query = "SELECT distinct transfer_id
            FROM transfer
            where d_subject = '" . $subject . "'
              and d_course_num = '" . $course_num . "';";
  $results = pg_query($dbc, $query);
  check_results($results);

  while($row = pg_fetch_array($results, NULL, PGSQL_ASSOC)){
    $transfer_id = (isset($row['transfer_id']) ? $row['transfer_id'] : null);

    $query2 = "INSERT INTO transcript (user_id,transfer_id,creatation_date, name)
              VALUES ('$user_id','$transfer_id','$date','$name');";
    $results2 = pg_query($dbc, $query2);
    check_results($results2);
  }
}
########################################################################################################################
function getMajor($currMajor){
  global $dbc;
  #console_log("Getting Majors");
  $query = "SELECT distinct major_name FROM major";

  #console_log($query);
  $results = pg_query($dbc, $query);
  check_results($results);

  while($row = pg_fetch_array($results, NULL, PGSQL_ASSOC)){
    $major_name = (isset($row['major_name']) ? $row['major_name'] : null);
    echo '<option value="' . $major_name . '" ';
    if($major_name==$currMajor) echo 'selected="selected"';
    echo '>' . $major_name . '</option>';
  }
}
########################################################################################################################
function getMinor($currMinor){
  global $dbc;
  #console_log("Getting Minors");
  $query = "SELECT distinct minor_name FROM minor";

  #console_log($query);
  $results = pg_query($dbc, $query);
  check_results($results);

  while($row = pg_fetch_array($results, NULL, PGSQL_ASSOC)){
    $minor_name = (isset($row['minor_name']) ? $row['minor_name'] : null);
    echo '<option value="' . $minor_name . '" ';
    if($minor_name==$currMinor) echo 'selected="selected"';
    echo '>' . $minor_name . '</option>';
  }
}########################################################################################################################
function checkMajor($name, $major_name){
  global $dbc;
  session_start();
  $user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null);
  #console_log("Finding what is in the major if anything is in the major");
  $query = "SELECT distinct m.course_title, m.course_num, m.subject, m.credits
            FROM marist m, majors ma, transcript tc, transfer t
            WHERE tc.name = '$name'
              and tc.user_id = $user_id
              and ma.major_name = '$major_name'
              and tc.transfer_id = t.transfer_id
              and t.m_course_num = m.course_num
              and t.m_subject = m.subject
              and m.course_num = ma.course_num
              and m.subject = ma.subject;";
  #console_log($query);
  $results = pg_query($dbc,$query);
  check_results($results);
}
########################################################################################################################
function checkMinor($name, $minor_name){
  global $dbc;
  session_start();
  $user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null);
  #console_log("Finding what is in the minor if anything is in the major");
  $query = "SELECT distinct m.course_title, m.course_num, m.subject, m.credits
            FROM marist m, minors mi, transcript tc, transfer t
            WHERE tc.name = '$name'
              and tc.user_id = $user_id
              and mi.minor_name = '$minor_name'
              and tc.transfer_id = t.transfer_id
              and t.m_course_num = m.course_num
              and t.m_subject = m.subject
              and m.course_num = mi.course_num
              and m.subject = mi.subject;";
  #console_log($query);
  $results = pg_query($dbc,$query);
  check_results($results);
}
########################################################################################################################
function profileList(){
  global $dbc;
  session_start();
  $user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null);

  $query = "SELECT DISTINCT t.name, t.creatation_date
            FROM transcript t, users u
            WHERE t.user_id = u.user_id
              and u.user_id = $user_id
            ORDER BY t.creatation_date;";
  $results = pg_query($dbc, $query);
  check_results($results);
}
########################################################################################################################
function transcriptSelect($name){
  global $dbc;
  session_start();
  $user_id = (isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null);

  $query = "SELECT m.subject, m.course_num, m.course_title, m.credits, sum(m.credits) as total_credits
            FROM marist m, transfer t, transcript tr, users u
            WHERE u.user_id = $user_id
              and tr.user_id = u.user_id
              and tr.name = '$name'
              and tr.transfer_id = t.transfer_id
              and t.m_subject = m.subject
              and t.m_course_num = m.course_num
            group by m.subject, m.course_num;";
  $results = pg_query($dbc,$query);
  check_results($results);
}
########################################################################################################################
function logOut(){
// remove all session variables
session_unset();

// destroy the session
session_destroy();

header( "Location: index.html" ) ;

exit();
}
########################################################################################################################
# Checks the query results as a debugging aid
function check_results($results) {
  global $dbc;

  if($results != true) {
    console_log("No Results from Query." . pg_last_error($dbc));
    return false;
  } else {
    console_log("Query Returned Results");
    return true;
  }
}
########################################################################################################################
# Loads a specified or default URL.
function load( $page = 'login.php', $pid = -1 )
{
  # Begin URL with protocol, domain, and current directory.
  $url = 'http://' . $_SERVER[ 'HTTP_HOST' ] . dirname( $_SERVER[ 'PHP_SELF' ] ) ;

  # Remove trailing slashes then append page name to URL and the print id.
  $url = rtrim( $url, '/\\' ) ;
  $url .= '/' . $page;

  # Execute redirect then quit.
  $_SESSION['user_id'] = $pid;
  header( "Location: $url" ) ;

  exit() ;
}
########################################################################################################################
# Used to print out to the Javascript Console
function console_log($data) {
  echo '<script>';
  echo 'console.log(' . json_encode( $data ) . ')';
  echo '</script>';
}
########################################################################################################################
#function log_file($data){
#  $fileName = '/home/user/phpLog.txt';
#  if (!file_exists($fileName)){
#    echo "Cannot find file.";
#  } else {
#    $myFile = fopen($fileName, 'w') or die('failed to open file');
#    fwrite($myFile, $data . '\n');
#    fclose($myFile);
#  }
#}


?>
