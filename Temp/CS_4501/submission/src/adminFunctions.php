

<?php
session_start();
if(!isset($_SESSION['security'])){
    header('Location: admin.php');
}


//php mailer stuff
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
$mail->Username = "CS4501.fall15@gmail.com"; // email username
$mail->Password = "UVACSROCKS"; // email password

// "REMOVE"
// "EMAIL"
// "DELETE"
// "SUBMITTER"
// "SIMILAR"
// "OPEN"
$ticket_id= $_SESSION['ticket'];
$db = new mysqli('localhost', 'root', '', 'tickets');

if(isset($_POST['TOGGLE'])){
$admin_email=$_SESSION['admin_email'];

//get ticket requester's email address
$query = "SELECT status, sender_email, subject FROM tickets WHERE ticket_id='$ticket_id'";
$results = $db->query($query);
$row = $results->fetch_array();

if($row['status']==open){
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

header('Location: admin_ticket.php');
}

if(isset($_POST['ASSIGN'])){
  $admin_id=$_SESSION['admin_id'];
  $admin_name=$_SESSION['admin_name'];
  $query = "SELECT admin_id FROM tickets WHERE ticket_id='$ticket_id'";
  $results = $db->query($query);
  $row = $results->fetch_array();

  if($row['admin_id']=='0'){
  $query = "UPDATE tickets SET admin_id='$admin_id', tech='$admin_name' WHERE ticket_id='$ticket_id'";
  $db->query($query);
  $query = "UPDATE connection SET admin_id='$admin_id' WHERE ticket_id='$ticket_id'";
  $db->query($query);

  }
  header('Location: admin_ticket.php');
}

if(isset($_POST['DELETE'])){
  $query = "DELETE FROM tickets WHERE ticket_id='$ticket_id'";
  $db->query($query);
  $query = "DELETE FROM connection WHERE ticket_id='$ticket_id'";
  $db->query($query);
  header('Location: admin_ticket.php');

}

if(isset($_POST['OPEN'])){
  header('Location: admin_ticket.php');
}

if(isset($_POST['REMOVE'])){
$admin_id= $_SESSION['admin_id'];
$query = "SELECT admin_id FROM connection WHERE ticket_id='$ticket_id'";
$results = $db->query($query);
$row = $results->fetch_array();

//if admin is on this ticket, remove admin
if($row['admin_id']==$admin_id){
$query = "UPDATE tickets SET admin_id = '0', tech =' ' WHERE ticket_id='$ticket_id'";
$db->query($query);
$query = "UPDATE connection SET admin_id = '0' WHERE ticket_id='$ticket_id'";
$db->query($query);
}

header('Location: admin_ticket.php');

}


if(isset($_POST['EMAIL'])){
    if(isset($_POST['subject'])&&isset($_POST['text'])){
      $admin_email=$_SESSION['admin_email'];


      //get email of person who made request
      $query = "SELECT status, sender_email, subject FROM tickets WHERE ticket_id='$ticket_id'";
      $results = $db->query($query);
      $row = $results->fetch_array();


      $sender = strip_tags("$admin_email"); //email of sender
      $receiver = strip_tags($row["sender_email"]); //person receiving
      $subj = strip_tags($_POST['subject']);
      $msg = strip_tags($_POST['text']);

      $mail->addAddress($receiver);
      $mail->SetFrom($sender);
      $mail->Subject = "$subj";
      $mail->Body = "$msg";

      //send mail
      $mail->send();
      header('Location: admin_ticket.php');
    }
    else{

//query for email information
?>
<table>
<form action= "adminFunctions.php"
      method= "POST">
  <b>Subject</b>
  <br />
  <tr><input type = "text" name = "subject" size = "50" maxlength= "50"></tr>
  <br /><br />
  <b>Text</b>
  <br />
  <tr><textarea class="FormElement" name="text" id="term" cols="50" rows="5"></textarea></tr>
  <br /><br />
<tr><input type = "submit" name = "EMAIL" value = "Send Email"><tr>
  <br />
</table>
<?php
}
}

?>
