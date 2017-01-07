<?php

session_start();
//if no session and no cookie, first time initialize
if (!(isset($_SESSION["views"]))&&!(isset($_COOKIE['count']))){
  $output= "Number of total times the webpage has been visited: 1";
  $cookie = 1;
  setcookie("count",$cookie,time()+600);
 }
 //otherwise, if the cookie is set but no session, increment by 1
else if(!(isset($_SESSION["views"]))&&isset($_COOKIE['count'])){
  $cookie = (int)$_COOKIE['count']+1;
  setcookie("count",$cookie,time()+600);
  $output = "Number of total times the webpage has been visited: ";
  $output .=  $cookie;

}
//if session is going, just keep cookie constant

else{
  $cookie = (int)$_COOKIE['count'];
  setcookie("count",$cookie,time()+600);
  $output = "Number of total times the webpage has been visited: ";
  $output .=  $_COOKIE['count'];
}



//if session is set, set s = Session[views]
if (isset($_SESSION["views"]))
   $s = (int) $_SESSION["views"];
if (!(isset($s))) //if not set initialize to 1
   $s = 1;
else
   $s++; //else increment
$_SESSION["views"] = $s; //set views to value of s
?>
<!DOCTYPE html>
<html>
<head>
   <title>Welcome to the CS 4501 Counter</title>
</head>
<body>
<h3>
<?php
     echo "Welcome to tthe CS 4501 Counter <br/>";
     echo "$output <br/>";
     echo "You have visited $s pages in the current session";

?>
</body>
</html>
