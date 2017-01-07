<html>
<?php
session_start();
include 'adminClass.php';
//retrieve username and password and check if they in the database
if(isset($_POST['validate'])){

  $username=$_POST["username"];
  $password = $_POST["password"];
  $db = new mysqli('localhost', 'root', '', 'tickets');
  $query= "SELECT user_info, admin_id FROM admin WHERE username = '$username'";
  $results = $db->query($query);
  $row = $results->fetch_assoc();
  $admin_id=$row['admin_id'];
  if(password_verify($password, unserialize($row['user_info'])->password)){
    $_SESSION['admin_id']=$admin_id;
    $_SESSION['admin_name']=unserialize($row['user_info'])->name;
    $_SESSION['admin_email']=unserialize($row['user_info'])->email;

    $_SESSION['security']=true;
    header("Location: admin_ticket.php");
    exit;
  }
}
?>
<body>
<form action = "admin.php"
    method = "POST">
<b>username</b>
<input type = "text" name = "username" size = "30" maxlength= "50">
<br /><br />
<b>password</b>
<input type = "password" name = "password" size = "50" maxlength= "50">
<br /><br />
<input type = "submit" name="validate" value = "Submit">
<br />
</form>
<form action = "forget.php"
    method = "POST">
      <input type = "submit" name= "Forgotten" value = "Forgot Password">
</form>
<form action = "start.php"
    method = "POST">
      <input type = "submit" name= "Back" value = "Back">
</form>
</body>
</html>
