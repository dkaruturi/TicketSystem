<?php
include 'adminClass.php';
$username=$_REQUEST["username"];
$password = $_REQUEST["password"];

$db = new mysqli('localhost', 'root', '', 'tickets');
$query= "SELECT username, user_info FROM admin WHERE username = '$username'";
$results = $db->query($query);
$row = $results->fetch_assoc();
$adminObject = unserialize($row['user_info']);
//check if their username is in the database and if it matches the email on file
  if($row['username']==$username &&  $row['username']=['username']){
    $password = password_hash($password,PASSWORD_DEFAULT);
    $adminObject->password=$password;
    $adminObject= serialize($adminObject);
    $insert_query = "UPDATE admin SET user_info='$adminObject' WHERE username='$username'";
    $message= $db->query($insert_query);
    echo "success";
  //  echo "success";
}
else{
  echo "failure";
}
 ?>
