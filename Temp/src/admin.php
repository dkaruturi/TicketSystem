<html>
<?php
session_start();
include 'adminClass.php';
if(isset($_POST['logout'])){
  unset($_SESSION['security']);
  header('Location: admin.php');
}
//retrieve username and password and check if they in the database
if(isset($_POST['validate'])&&!empty($_POST["username"])&&!empty($_POST["password"])){

  $username=$_POST["username"];
  $password = $_POST["password"];
  $db = new mysqli('localhost', 'root', '', 'tickets');
  $query= "SELECT user_info, admin_id, type FROM admin WHERE username = '$username'";
  $results = $db->query($query);
  $row = $results->fetch_assoc();
  $admin_id=$row['admin_id'];
  if(password_verify($password, unserialize($row['user_info'])->password)){

    $_SESSION['security']=true;

//checks user type and redirects them to the correct page
    if($row['type']=="admin"){
      $_SESSION['admin_id']=$admin_id;
      $_SESSION['admin_name']=unserialize($row['user_info'])->name;
      $_SESSION['admin_email']=unserialize($row['user_info'])->email;

      header("Location: admin_ticket.php");
      exit;

    }
    else{
      header("Location: start.php");
    }

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
</body>
</html>
