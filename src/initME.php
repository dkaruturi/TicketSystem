<?php
//give access to adminClass
include 'adminClass.php';

//connect to database, PLEASE ENTER YOUR OWN INFORMATION
		$db = new mysqli('localhost', 'root', '', 'tickets');
		if ($db->connect_error):
			die ("Could not connect to db: " . $db->connect_error);
		endif;

//clear previous tables
		$db->query("drop table tickets");
    $db->query("drop table admin");


//create new ones
		$result = $db->query("create table tickets (ticket_id int primary key not null auto_increment, received varchar(255) not null, sender_name varchar(255) not null, sender_email varchar(255), subject varchar(255), body varchar(255), tech varchar(255), status varchar(255), admin_id varchar(255), sender_phonenum varchar(255))") or die ("Invalid: " . $db->error);
    $result = $db->query("create table admin (admin_id int primary key not null auto_increment, username varchar(255), user_info varchar(255), f_id varchar(255), type varchar(255))") or die ("Invalid: " . $db->error);


//parse admin txt file
$filename = "admin.txt";
$fp = fopen($filename, "r");
$content = fread($fp, filesize($filename));
$lines = explode("\n", $content);
fclose($fp);
$size = count($lines)-1;

for($i=0; $i<$size; $i+=1){
	$new_line= explode("#", $lines[$i]);

	//set variables
	$name= $new_line[3];
	$password= $new_line[0];
	$email= $new_line[1];
	$username = $new_line[2];
	$typ = $new_line[4];

	//store user info in object
  $admin = new admin($name,$password,"",$email);
	$admin->password= $admin->hashit();
  $user_info = serialize($admin);

	$j=$i+1;
  $db->query("INSERT INTO admin (admin_id, username, user_info, type) VALUES ('$j','$username','$user_info','$typ')");
}


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

	//set variables
	$ticket_id=$new_line[0];
	$received=$new_line[1];
	$sender_name=$new_line[2];
	$sender_email=$new_line[3];
	$subject=$new_line[4];
	$tech=$new_line[5];
	$body=$new_line[6];
	$status=$new_line[7];
	$admin_id=$new_line[8];
	$sender_phonenum = $new_line[9];

	//insert ticket into database
	$ticket_query = "INSERT INTO tickets
	  (ticket_id, received, sender_name, sender_email, subject, body, tech, status, admin_id, sender_phonenum) VALUES ('$ticket_id','$received','$sender_name','$sender_email','$subject','$body','$tech','$status','$admin_id', '$sender_phonenum')";
		$db->query($ticket_query);

}
//go to login page
header('Location: admin.php')
?>
