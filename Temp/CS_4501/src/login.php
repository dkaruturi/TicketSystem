<html>
<head>
<title>Enter your song </title>
</head>
<body>
<?php

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//openfile
$filename = "users.txt";
$fp = fopen($filename, "r");

//parse file
$content = fread($fp, filesize($filename));
$lines = explode("\n", $content);
fclose($fp);
$i=0;

//grab user info
foreach($lines as $val) {
  $temp_array=explode("#", $val);
   $usernames[$i]= $temp_array[0];
   $hashtable[$temp_array[0]]=$temp_array[1];
  $i=$i+1;
}
$username = $_POST['username'];
$_SESSION["username"] = $username;

$password = $_POST['password'];

//set remember me
if(isset($_POST['rememberme'])){
  $_SESSION["rememberme"] = true;
}
else{
  $_SESSION["rememberme"]= false;
}
$foundUser = false;

//see if the username and password matches
foreach($usernames as $val){
if($val==$username){
  $foundUser=true;

  //matched
  if($hashtable[$username]==$password){
    //set cookie
    if($_SESSION["rememberme"]){
      setcookie("current_user",$username, strtotime("tomorrow"));
    }
    //set session username
    $_SESSION["username"]= $username;
    header('Location: quizhomepage.php');
    exit;
  }
  else{
    //if user is found but the wrong password is chosen
    echo "wrong password <br />";
  }
}
}
//if user is not found notify them
if($foundUser==false){
  echo "this user does not exist <br />";
}
  ?>
</body>
</html>
