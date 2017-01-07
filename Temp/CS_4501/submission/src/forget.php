<html>
<?php
session_start();
include 'adminClass.php';
//enter once user is queried for info
if(isset($_POST['Forget'])){

//grab/set user info
$username=$_POST["username"];
$email = $_POST["emailaddress"];

//connect to database and retreive important info
$db = new mysqli('localhost', 'root', '', 'tickets');
$query= "SELECT username, user_info FROM admin WHERE username = '$username'";
$results = $db->query($query);
$row = $results->fetch_assoc();
$adminObject = unserialize($row['user_info']);
//check if their username is in the database and if it matches the email on file
  if($row['username']==$username && $adminObject->email==$email){

    //generate link and store id in database
    $id = uniqid();
    $db->query("UPDATE admin
SET f_id='$id'
WHERE username='$username'");
    $url = "http://localhost/emaildata/resetPassword.php/?id="."$id";
    $body= "<a href=".$url.">Reset Password</a>";
    $message = "<tr><td><strong>URL To Change Password:</strong> </td><td>" . $url . "</td></tr>";


    //php mailer stuff
    $mailpath = '/Applications/XAMPP/xamppfiles/PHPMailer';

    // Add the new path items to the previous PHP path
    $path = get_include_path();
    set_include_path($path . PATH_SEPARATOR . $mailpath);
    require 'PHPMailerAutoload.php';

    $mail = new PHPMailer();

    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "tls"; // sets tls authentication
    $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server; or your email service
    $mail->Port = 587; // set the SMTP port for GMAIL server; or your email server port
    $mail->Username = "CS4501.fall15@gmail.com"; // email username
    $mail->Password = "UVACSROCKS"; // email password

    //info for mail
    $sender = strip_tags("CS4501.fall15@gmail.com");
    $receiver = strip_tags($_POST["emailaddress"]);
    $subj = strip_tags("Forgotten Password Reset");
    $msg = strip_tags($message);

    // Put information into the message
    $mail->addAddress($receiver);
    $mail->SetFrom($sender);
    $mail->Subject = "$subj";
    $mail->Body = "$msg";
    $mail->IsHTML(true);
    // echo 'Everything ok so far' . var_dump($mail);
    $mail->send();
    echo "A link to reset your password has been sent to the associated email address";
    ?>
    <form action = "start.php"
        method = "POST">
        <br />
        <input type = "submit" name="Back to Start" value = "Go to Homepage">
        <br /> <br />
        </form>

    <?php

  }
  else{ //if the user is not found, the user is notified and is sent back to the login page
    echo "That was invalid username/email entry. Please try again or contact a System Administrator <br />"
?>
<form action = "start.php"
    method = "POST">
    <br />
    <input type = "submit" name="Back to Start" value = "Go to Homepage">
    <br /> <br />
    </form>
  <?php
  }
  exit;
}
//form to enter username and email
?>

<table>
  <form action = "forget.php"
      method = "POST">
  <b> Choose New Password</b>
  <br /> <br />
  <b>username</b>
  <br />
  <input type = "text" name = "username" size = "30" maxlength= "50">
  <br />  <br />
  <b>email address</b>
  <br />
  <input type = "email" name = "emailaddress" size = "30" maxlength= "50">
  <br />  <br />
  <input type = "submit" name="Forget" value = "Send Reset Email">
  <br />
  </form>
</table>


  </html>
