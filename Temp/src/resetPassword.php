<?php
session_start();
include 'adminClass.php';
//set up db and and grab needed info
$db = new mysqli('localhost', 'root', '', 'tickets');


if(isset($_POST['new_password'])){
  //update databse with new password
  $f_id=$_SESSION['f_id'];
  $password = password_hash($_POST['new_password'],PASSWORD_DEFAULT);
  $adminObject= unserialize($_SESSION['user_info']);
  $adminObject->password=$password;
  $adminObject= serialize($adminObject);
  $insert_query = "UPDATE admin SET user_info='$adminObject' WHERE f_id='$f_id'";
  $db->query($insert_query);
  echo "Congrats your password has been updated";
  exit;
}

//verify id matches
$id = $_GET['id'];
$query= "SELECT f_id, user_info FROM admin WHERE f_id = '$id'";
$results = $db->query($query);
$row = $results->fetch_assoc();
$f_id = $row['f_id'];
$_SESSION['f_id']=$f_id;
$adminObject = $row['user_info'];
$_SESSION['user_info']=$adminObject;

if($f_id==$id){
//query for new password

?>
<form action = "resetPassword.php"
      method = "POST">
      <b> Choose a new password <b>
      <br /> <br />
      Password
      <input type = "password" name="new_password" size ="30" maxlength="50">
      <br /> <br />
      <input type= "submit" name="resetPassword" value = "Submit">
      <br />
</form>
<?php
}
else{
echo "This is not a valid link";
}
 ?>
