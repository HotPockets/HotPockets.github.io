<!DOCTYPE HTML>
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/css" href="index.xml"?>
<!-- Bootstrap -->
<!-- Link to Jquery -->
<script src="./distrib/js/jquery-1.11.3.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="./distrib/css/bootstrap.min.css">
<!-- Optional theme -->
<link rel="stylesheet" href="./distrib/css/bootstrap-theme.min.css">
<!-- Custom styles for this template -->
<link href="./distrib/css/theme.css" rel="stylesheet">

<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>
        Marist College Unofficial Credit Transfer Evaluator
      </title>
  </head>
    <body>
      <div class="page">
        <div class="header">
          <a href="">
            <img src="./distrib/img/seal.jpg" alt="MaristLogo" style="width:150px;height:150px;">
          </a>
          <h2><img src="./distrib/img/logo.png" alt="Marist" style="width:400px;height:80px;"></h2>
        </div>
        <nav class="navbar navbar-inverse" style="border-radius:0px;">
          <div class="btns">
            <a href="index.html" class="btn btn-lg btn-lg active" type="button">Home</a>
            <a href="profile.php" class="btn btn-lg active" type="button">Profile</a>
            <a href="courses.php" class="btn btn-lg active" type="button">Course List</a>
            <a href="contact.html" class="btn btn-lg active" type="button">Contact</a>
            <a href="help.html" class="btn btn-lg active" type="button">Help</a>
          </div>
        </nav>
        <div class="landing">
          <br><br><br><br><br>
          <div class="holder">
            <div class="row">
              <div class="col-sm-1">
              </div>
              <div class="col-sm-5">
                <h2>Login</h2>
                <form class="form-horizontal" method="post">
                  <input type="email" class="form-control" id="InputEmail" name="loginEmail" placeholder="Email">
                  <br>
                  <input type="password" class="form-control" id="InputPassword1" name="loginPassword" placeholder="Password">
                  <br>
                  <input class="btn btn-danger" type="submit" value="Login" name="login">
                </form>
                <?php
                  require( '../php/connect.php' );
                  require( '../php/functions.php' );
                  session_start();
                  if (isset($_POST['login'])) {
                  	$name = $_POST['loginEmail'];
                  	$password = $_POST['loginPassword'];

                    $pid = validate($name, $password);

                    if($pid == -1){
                      echo '<p style=color:red>Login failed please try again.</p>';
                	   } else {
                       if (adminValidate($pid)){
                        console_log("Logging in admin with PID " . $pid);
                        load('adminProfile.php', $pid); 
                       } else {
                        console_log("Logging in with PID " . $pid);
                        load('profile.php', $pid);
                       }
                  	}
                  }
                ?>
              </div>

              <div class="col-sm-5">
                <form class="form-horizontal" method="post">
                  <h2>Sign Up</h2>
                  <input type="first_name" class="form-control" id="Inputfname" name="signUpFirst" placeholder="First Name">
                  <br>
                  <input type="last_name" class="form-control" id="Inputlname" name="signUpLast" placeholder="Last Name">
                  <br>
                  <input type="email" class="form-control" id="InputEmail" name="signUpEmail" placeholder="Email">
                  <br>
                  <input type="password" class="form-control" id="InputPassword1" name="signUpPassword" placeholder="Password">
                  <br>
                  <input type="password" class="form-control" id="InputPassword2" name="signUpConfirmPassword"  placeholder="Retype Password">
                  <br>
                  <input class="btn btn-danger" type="submit" value="Sign Up" name="signUp">
                </form>
                <?php
                  if (isset($_POST['signUp'])) {
                    $fname = $_POST['signUpFirst'];
                    $lname = $_POST['signUpLast'];
                    $password = $_POST['signUpPassword'];
                    $password2 = $_POST['signUpConfirmPassword'];
                    $email = $_POST['signUpEmail'];

                    if($password == $password2){
                      $result = sign_up($email,$password,$fname,$lname);
                      $pid = -1;
                      if($result == 1){
                        $pid = validate($email, $password);
                      }
                      if($pid == -1){
                        echo '<p style=color:red>Login failed please try again.</p>';
                       } else {
                         console_log("Logging in with PID " . $pid);
                        load('profile.php', $pid);
                       }
                      } else {
                      echo '<p style=color:red>Please enter matching passwords.</p>';
                    }
                  }
                ?>
              </div>
            </div>

        </div>
      </div>
              <div class="footer">
                <br><br><br>
                <p>Copyright&#169 Team Hot Pockets 2015</p>
              </div>
        </div>

        <!-- Bootstrap core JavaScript
          ================================================== -->
          <!-- Placed at the end of the document so the pages load faster -->
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
          <script src="distrib/js/bootstrap.min.js"></script>
          <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
          <!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
  </body>
</html>
