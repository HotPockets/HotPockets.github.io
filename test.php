<!DOCTYPE HTML>
<html>



<head>
<title> Finder's Page </title>



</head>

<body>
<?php
$pageName = "Found Page";
#include 'includes/pageformat.php';
?>
<div id="bottom">
<?php
require 'connect.php'; # gets db connection
#require( 'includes/helpers.php' ) ; #gets helpers function
?>
<div id="tholder">
<h2 style="background-color:grey; color:white; border-radius: 30px;"> Is what you found here? </h2>
<?php
# Show the records
$query = 'SELECT * FROM users' ;

# Execute the query
$results = pg_query( $dbc , $query ) ;

# Show results
if( $results )
{
  # But...wait until we know the query succeeded before
  # starting the table.
  echo '<TABLE align="center">';
  echo '<TR>';
  echo '<TH>id</TH>';
  echo '<TH>first name</TH>';
  echo '<TH>Last name</TH>';
  echo '<TH>email</TH>';
  echo '<TH>password</TH>';
  echo '</TR>';

  # For each row result, generate a table row
  while ( $row = pg_fetch_array( $results , PGSQL_BOTH ) )
  {
    echo '<TR>' ;
    echo '<TD>' . $row['user_id'] . '</TD>' ;
    echo '<TD>' . $row['first_name'] . '</TD>' ;
	  echo '<TD>' . $row['last_name'] . '</TD>' ;
	  echo '<TD>' . $row['email'] . '</TD>' ;
	  echo '<TD>' . $row['password'] . '</TD>' ;
    echo '</TR>' ;
  }

  # End the table
  echo '</TABLE>';
}
pg_close();
?>


<a href="findform.php"> <h2 style="background-color: grey; color: white; border-radius: 30px;"> Didn't Find An OWNER? <br> Click HERE! </h2> </a>
</div>
</div>






















</body>
</html>
