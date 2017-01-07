<?php
//MAIL STUFF
$mailpath = '/Applications/XAMPP/xamppfiles/PHPMailer';

// Add the new path items to the previous PHP path
$path = get_include_path();
set_include_path($path . PATH_SEPARATOR . $mailpath);
require 'PHPMailerAutoload.php';

// PHPMailer is a class -- we will discuss classes and PHP object-oriented
// programming soon.  However, you should be able to copy / use this
// technique without fully understanding PHP OOP.
$mail = new PHPMailer();

$mail->IsSMTP(); // telling the class to use SMTP
$mail->SMTPAuth = true; // enable SMTP authentication
$mail->SMTPSecure = "tls"; // sets tls authentication
$mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server; or your email service
$mail->Port = 587; // set the SMTP port for GMAIL server; or your email server port
$mail->Username = "testingemail354@gmail.com"; // email username
$mail->Password = "TicketingSystem"; // email password

$ticket_id=$_REQUEST['ticketID'];



//TOGGLE FUNCTION
if(isset($_SESSION['TOGGLE'])&&$_SESSION['TOGGLE']==true){
$admin_email=$_SESSION['admin_email'];
//get ticket requester's email address
$query = "SELECT status, sender_email, subject FROM tickets WHERE ticket_id='$ticket_id'";
$results = $db->query($query);
$row = $results->fetch_array();

if($row['status']=='open'){
$query = "UPDATE tickets SET status='closed' WHERE ticket_id='$ticket_id'";

//set mail stuff specific to this function
$sender = strip_tags("$admin_email"); //email of sender
$receiver = strip_tags($row["sender_email"]); //person receiving
$subj = strip_tags($row["subject"]);
$msg = strip_tags("Thank you for your patience. Your ticket has been resolved now.");

$mail->addAddress($receiver);
$mail->SetFrom($sender);
$mail->Subject = "$subj";
$mail->Body = "$msg";

//send mail
$mail->send();

}
else{
$query = "UPDATE tickets SET status='open' WHERE ticket_id='$ticket_id'";
}
$db->query($query);
$_SESSION['TOGGLE']=false;
}

if(isset($_SESSION['ASSIGN'])&&$_SESSION['ASSIGN']==true){
  $admin_id=$_SESSION['admin_id'];
  $admin_name=$_SESSION['admin_name'];
  $query = "SELECT admin_id FROM tickets WHERE ticket_id='$ticket_id'";
  $results = $db->query($query);
  $row = $results->fetch_array();

  if($row['admin_id']==$_SESSION['admin_id']){
  $query = "UPDATE tickets SET admin_id = '0', tech =' ' WHERE ticket_id='$ticket_id'";
  $db->query($query);
  echo "remove";
  }
  else{
    if($row['admin_id']=='0'){
    $query = "UPDATE tickets SET admin_id='$admin_id', tech='$admin_name' WHERE ticket_id='$ticket_id'";
    $db->query($query);
    echo "added";
    }
  }
$_SESSION['ASSIGN']=false;
}

if(isset($_SESSION['DELETE'])&&$_SESSION['DELETE']==true){
  $query = "DELETE FROM tickets WHERE ticket_id='$ticket_id'";
  $db->query($query);
  $_SESSION['DELETE']=false;
}

if(isset($_SESSION['EMAIL'])&&$_SESSION['EMAIL']==true){
      $admin_email=$_SESSION['admin_email'];


      //get email of person who made request
      $query = "SELECT status, sender_email, subject FROM tickets WHERE ticket_id='$ticket_id'";
      $results = $db->query($query);
      $row = $results->fetch_array();


      $sender = strip_tags("$admin_email"); //email of sender
      $receiver = strip_tags($row["sender_email"]); //person receiving
      $subj = strip_tags($_REQUEST['subject']);
      $msg = strip_tags($_REQUEST['text']);

      $mail->addAddress($receiver);
      $mail->SetFrom($sender);
      $mail->Subject = "$subj";
      $mail->Body = "$msg";
      echo 'Everything ok so far' . var_dump($mail);

      //send mail
      $mail->send();
      if(!$mail->send()){
      echo "failure";
      }
    }



 ?>
