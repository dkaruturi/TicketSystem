<?php
include 'adminClass.php';

$username=$_REQUEST["username"];
$email = $_REQUEST["email"];

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
    $url = "http://localhost/TicketingSystem/src/resetPassword.php/?id="."$id";
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
    $mail->Username = "testingemail354@gmail.com"; // email username
    $mail->Password = "TicketingSystem"; // email password

    //info for mail
    $sender = strip_tags("testingemail354@gmail.com");
    $receiver = strip_tags($email);
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
    echo "success";
  }
  else{ //if the user is not found, the user is notified and is sent back to the login page
    echo "That was invalid username/email entry. Please try again or contact a System Administrator";

}
?>
