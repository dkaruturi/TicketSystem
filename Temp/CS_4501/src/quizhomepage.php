<html>
<body>
<?php
session_start();
echo "Welcome to the Quiz Homepage: ";

//set username
if(isset($_SESSION["username"])){
  $username = $_SESSION["username"];
}
else{
  $username= $_COOKIE["current_user"];
  $_SESSION["username"]=$username;
}
echo $username;

//Let user change user or take quiz
?>
<form action = "quiz.php"
    method = "POST">
    <br />
<input type = "submit" name= "TakeQuiz" value = "Take Quiz">
</form>
<form action = "start.php"
    method = "POST">
    <br />
<input type = "submit" name= "change_user" value = "Change User">
</form>
</body>
</html>
