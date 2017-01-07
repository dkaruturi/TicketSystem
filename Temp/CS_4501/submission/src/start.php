<html>
<?php


session_start();

//ignore annoying notices
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//validate user input here after entered
//print_r($_SERVER);
if($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_POST['submit_info'])){

  $error="ERROR: ";

  if (empty($_POST["firstname"])) {
      $error .= "First Name is required---";
    }
  else {
      $firstname = trim($_POST["firstname"]);
  }
  if (empty($_POST["lastname"])) {
      $error .= "Last name is required---";
    }
  else {
      $lastname = trim($_POST["lastname"]);
  }

  if (empty($_POST["email"])) {
        $error .= "Email is required---";
    }
  else {
        $email = trim($_POST["email"]);
  }

  if (empty($_POST["subject"])) {
          $error .= "Subject is required---";
    }
  else {
          $subject .= trim($_POST["subject"]);
      }
  if (empty($_POST["text"])) {
              $error .= "Text is required";
        }
  else {
              $text .= trim($_POST["text"]);
          }

  if($error=="ERROR: "){
    $_SESSION['firstname']=$firstname;
    $_SESSION['lastname']=$lastname;
    $_SESSION['email']=$email;
    $_SESSION['subject']=$subject;
    $_SESSION['text']=$text;
    header('Location: ticket.php');
  }
  echo $error;
}



//login page with all buttons
 ?>
<head>
      <title> Ticketing System </title>
</head>
<body>
<form action = "start.php"
    method = "POST">
<br />
<b>First Name </b>
<input type = "text" name = "firstname" size = "30" maxlength= "50">
<br /><br />
<b>Last Name </b>
<input type = "text" name = "lastname" size = "30" maxlength= "50">
<br /><br />
<b>Email</b>
<input type = "text" name = "email" size = "50" maxlength= "50">
<br /><br />
<b>Subject</b>
<input type = "text" name = "subject" size = "50" maxlength= "50">
<br /><br />
<b>Text</b>
<textarea class="FormElement" name="text" id="term" cols="50" rows="5"></textarea>
<br /><br />

<input type = "submit" name = "submit_info" value = "Submit">
<br />
</form>
<form action = "admin.php"
    method = "POST">
      <input type = "submit" name= "admin" value = "Admin Login">
</form>
</body>
</html>
