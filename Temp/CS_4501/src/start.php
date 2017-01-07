<html>
<?php


//uncomment this to test quiz removal and reset to default
//include 'reset.php';
session_start();


//at midnight reset quiz data and remove taken quiz
$timestamp = strtotime('today midnight');
$current = strtotime('now');
if($timestamp==$current){
  include 'reset.php';
}


//ignore annoying notices
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//clear cookie if change user is hit and send back to start
if(isset($_POST["change_user"])){
setcookie("current_user", "", time()-3600);
header('Location: start.php');
}

//skip to quiz homepage if remembered
if(isset($_COOKIE["current_user"])&&!isset($_POST["change_user"])){
  $_SESSION["username"]= $_COOKIE["current_user"];
  header('Location: quizhomepage.php');
}

//login page with all buttons
 ?>
<head>
      <title> Login Page </title>
</head>
<body>
<form action = "login.php"
    method = "POST">
<b> username</b>
<input type = "text" name = "username" size = "30" maxlength= "30">
<br /><br />
<b> password</b>
<input type = "text" name = "password" size = "30" maxlength= "30">
<br /><br />
<?php echo "remember me"; ?>
  <input type="radio" name="rememberme"
  value="true">
<br /> <br />
<input type = "submit" value = "Submit">
<br />
</form>
<form action = "register.php"
    method = "POST">
      <input type = "submit" name= "RegisterUser" value = "Register User">
</form>
<form action = "forget.php"
    method = "POST">
      <input type = "submit" name= "ForgetPass" value = "Forgot Password">
</form>
</body>
</html>
