<!DOCTYPE html>
<html>
	<head>
		<title>Initialize Database and Tables</title>
	</head>
	<body>
		<?php

//give access to adminClass
include 'adminClass.php';

//connect to database
		$db = new mysqli('localhost', 'root', '', 'tickets');
		if ($db->connect_error):
			die ("Could not connect to db: " . $db->connect_error);
		endif;

//clear previous tables
		$db->query("drop table tickets");
    $db->query("drop table admin");
		$db->query("drop table connection");


//create new ones
		$result = $db->query("create table tickets (ticket_id int primary key not null auto_increment, received varchar(255) not null, sender_name varchar(255) not null, sender_email varchar(255), subject varchar(255), body varchar(255), tech varchar(255), status varchar(255), admin_id varchar(255))") or die ("Invalid: " . $db->error);
    echo "created tickets table <br />";
    $result = $db->query("create table admin (admin_id int primary key not null auto_increment, username varchar(255), user_info varchar(255), f_id varchar(255))") or die ("Invalid: " . $db->error);
    echo "created admin table <br />";
		$result = $db->query("create table connection (connection_id int primary key not null auto_increment, ticket_id varchar(255), admin_id varchar(255))") or die ("Invalid: " . $db->error);
		echo "created connection table <br />";

//generate passwords for admins
$password1 = "password";
$password2 = "Dick";
$password3=  "Kane";
$password4 = "Barabara";
$password5 = "Cagney";
$password6 = "Lucy";
$password7 = "Virus";
$password=array($password1,$password2,$password3,$password4,$password5,$password6,$password7);

//emails for admins
$email1="dsk5df354@gmail.com";
$email2="dsk5df354+Dick@gmail.com";
$email3="dsk5df354+Kane@gmail.com";
$email4="dsk5df354+Barabara@gmail.com";
$email5="dsk5df354+Cagney@gmail.com";
$email6="dsk5df354+Lucy@gmail.com";
$email7="dsk5df354+Virus@gmail.com";
$email=array($email1,$email2,$email3,$email4,$email5,$email6,$email7);

//usernames for admins
$username1 = "Divya354";
$username2 = "Dick354";
$username3 = "Kane354";
$username4 = "Barabara354";
$username5 = "Cagney354";
$username6 = "Lucy354";
$username7 = "Virus354";
$username = array($username1,$username2,$username3,$username4,$username5,$username6, $username7);

//names for admins
$name1 = "Divya";
$name2 = "Dick";
$name3 = "Kane";
$name4 = "Barabara";
$name5 = "Cagney";
$name6 = "Lucy";
$name7 = "Virus";
$name = array($name1,$name2,$name3,$name4,$name5,$name6,$name7);

//make objects and insert them into the database
for($i=0; $i<7; $i+=1){
	//npfe
  $admin = new admin($name[$i],$password[$i],"",$email[$i]);
	$admin->password= $admin->hashit();
  $user_info = serialize($admin);
  $un = $username[$i];
  $db->query("INSERT INTO admin (admin_id, username, user_info) VALUES ('$i','$un','$user_info')");
}

//fields for dummy ticket
// date_default_timezone_set('America/New_York');
// $timestamp = date('M d Y h:i A');
// $name = "Divya Karuturi";
// $sender= "dsk5df354@gmail.com";
// $subj= "dsk5df354@gmail.com";
// $text= "dummy ticket";

//parse txt file
$filename = "ticket.txt";
$fp = fopen($filename, "r");
$content = fread($fp, filesize($filename));
$lines = explode("\n", $content);
fclose($fp);
$size = count($lines)-1;

//INSERT TICKETS
for ($x = 0; $x < $size; $x++) {
	$new_line= explode("#", $lines[$x]);
	$ticket_id=$new_line[0];
	$received=$new_line[1];
	$sender_name=$new_line[2];
	$sender_email=$new_line[3];
	$subject=$new_line[4];
	$tech=$new_line[5];
	$body=$new_line[6];
	$status=$new_line[7];
	$admin_id=$new_line[8];
	//query database
	$ticket_query = "INSERT INTO tickets
	  (ticket_id, received, sender_name, sender_email, subject, body, tech, status, admin_id) VALUES ('$ticket_id','$received','$sender_name','$sender_email','$subject','$body','$tech','$status','$admin_id')";
		$db->query($ticket_query);
		$connection_query = "INSERT INTO connection
			(ticket_id, admin_id) VALUES ($ticket_id,$admin_id)";
		$db->query($connection_query);

}

      ?>
      <br />
      <a href="start.php">Continue to form</a>
	</body>
</html>
