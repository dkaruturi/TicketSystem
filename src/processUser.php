<?php
session_start();
$button=$_REQUEST['q'];
$db = new mysqli('localhost', 'root', '', 'tickets');

if($button=="viewticket"){
$user_name = $_SESSION['user_name'];
$query = "SELECT ticket_id, received, subject, status FROM tickets WHERE sender_name = '$user_name'";
$results = $db->query($query);
for($ctr=1; $ctr<=$results->num_rows; $ctr++){
  $array=$results->fetch_array();
  echo '["'.implode('","', array_unique($array)).'"];';
}
}
if($button=="viewalltickets"){
$user_name = $_SESSION['user_name'];
$query = "SELECT ticket_id, received, sender_name, sender_email, subject, tech, status, sender_phonenum FROM tickets";
$results = $db->query($query);
for($ctr=1; $ctr<=$results->num_rows; $ctr++){
  $array=$results->fetch_array();
  echo '["'.implode('","', array_unique($array)).'"];';
}
echo "***";
$query = "SELECT body FROM tickets";
$results = $db->query($query);
for($ctr=1; $ctr<=$results->num_rows; $ctr++){
  $array=$results->fetch_array();
  echo '["'.implode('","', array_unique($array)).'"];';
}
}

if($button=="createticket"){
  include "ticket.php";
}

if($button=="textmessage"){
  include "message.php";
}

if($button =="passwordchange"){
include "changePassword.php";
}

if($button=="logout"){
  unset($_SESSION['security']);
}

if($button=='toggle'){
$_SESSION['TOGGLE']='true';
include 'selectedFunctions.php';
}

if($button=='assignself'){
$_SESSION['ASSIGN']=true;
include 'selectedFunctions.php';
}

if($button=='deleteTicket'){
$_SESSION['DELETE']=true;
include 'selectedFunctions.php';
}

if($button=="emailsubmitter"){
  $_SESSION['EMAIL']=true;
  include 'selectedFunctions.php';

}

if($button=="forgotpassword"){
  include "forget.php";
}

if($button=='registeruser'){
  include 'register.php';
}




?>
