<!DOCTYPE html>
<html>
<head>
<title>Send Mail Results</title>
</head>
<body>
<?php
include 'adminClass.php';
session_start();


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

  $sender = strip_tags($_SESSION["email"]);
  $subj = strip_tags($_SESSION["subject"]);
  $msg = strip_tags($_SESSION["text"]);

  // Put information into the message

  //add all the admins on the email
  $db = new mysqli('localhost', 'root', '', 'tickets');
  $query3 = "SELECT user_info FROM admin";
  $results = $db->query($query3);

  for($ctr=1; $ctr<=$results->num_rows; $ctr++){
    $array = $results->fetch_array();
    $receiver = strip_tags(unserialize($array["user_info"])->email);
    $mail->addAddress($receiver);
  }

  $mail->AddAddress($sender);
  $mail->SetFrom($sender);
  $mail->Subject = "$subj";
  $mail->Body = "$msg";

  // echo 'Everything ok so far' . var_dump($mail);
  if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
   }
   else {
  echo 'Message has been sent';

  //setup database and variables
    $firstname = $_SESSION["firstname"];
    $lastname = $_SESSION["lastname"];
    $text=$_SESSION['text'];
    $name = $firstname . " " . $lastname;
    $timestamp = date('M d Y h:i A');
    //insert ticket into database
    $insert_query = "INSERT INTO tickets
      (received, sender_name, sender_email, subject, body, status, admin_id) VALUES ('$timestamp','$name','$sender','$subj','$text','open','0')";
     $db->query($insert_query);
     $select_query= "SELECT ticket_id FROM tickets WHERE received='$timestamp' AND sender_name='$name' AND body='$text'";
     $results=$db->query($select_query);
     $row=$results->fetch_array();
     $ticket_id=$row['ticket_id'];
     $insert_query = "INSERT INTO connection (ticket_id, admin_id) VALUES('$ticket_id','0')";
     $db->query($insert_query);

      echo "<form action = 'start.php'  method = 'GET'>
      <br />
            <input type = 'submit' name= 'back' value = 'Back to Homepage'>
      </form>
      ";
    }
?>
</body>
</html>
