<?php
require( 'connect.php' );
########################################################################################################################
# Validates the login
function validate($prname = '', $prpass = '')
{
    global $dbc;
    echo "Starting validation";
  if(empty($prname)){
    echo "Name is empty";
    return -1 ;
  }
	if(empty($prpass)){
    echo "Password is empty";
    return -1 ;
  }


    # Make the query
    $query = "SELECT login('$prname', '$prpass')" ;
    echo "Query: " . $query;

    # Execute the query
    $results = pg_query( $dbc, $query ) ;
    check_results($results);

    # If we get no rows, the login failed
    if (pg_num_rows( $results ) == 0 ){
      echo "No Results Found";
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
    echo "New String";
    return intval($pid) ;
}
########################################################################################################################
# Checks the query results as a debugging aid
function check_results($results) {
  global $dbc;

  if($results != true) {
    echo '<p>SQL ERROR = </p>'  ;
  } else {
    echo 'We have RESULTS';
  }
}
########################################################################################################################
# Console.log()
function console_log($data) {
  echo '<script>';
  echo 'console.log(' . json_encode( $data ) . ')';
  echo '</script>';
}
########################################################################################################################
?>
