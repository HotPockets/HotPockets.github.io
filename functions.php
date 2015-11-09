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
########################################################################################################################
function getSubjects($currSubject){
  global $dbc;
  console_log("Getting Subjects");
  $query = "SELECT * FROM subject_dcc";

  console_log($query);
  $results = pg_query($dbc, $query);
  check_results($results);

  while($row = pg_fetch_array($results, NULL, PGSQL_ASSOC)){
    $subject = (isset($row['subject']) ? $row['subject'] : null);
    echo '<option value="' . $subject . '" ';
    if($subject==$currSubject) echo 'selected="selected"';
    echo '>' . $subject . '</option>';
  }
}
########################################################################################################################
function getCourses($subject){
  global $dbc;
  console_log("Getting Courses for " . $subject);
  $query = "SELECT course_num, course_title FROM dcc WHERE subject = '$subject';";

  console_log($query);
  $results = pg_query($dbc, $query);
  check_results($results);

  while($row = pg_fetch_array($results, NULL, PGSQL_ASSOC)){
    $course_num = (isset($row['course_num']) ? $row['course_num'] : null);
    console_log("Course Num: " . $course_num);
    $course_title = (isset($row['course_title']) ? $row['course_title'] : null);
    console_log("Course Title: " . $course_title);
    echo '<option value="' . $course_num . '">' . $course_num . ' - ' . $course_title . '</option>';
  }
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
  } else {
    console_log("Query Returned Results");
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
?>
