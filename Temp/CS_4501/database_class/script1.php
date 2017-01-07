<!DOCTYPE html>
<html>
	<head>
		<title>Students Script 1</title>
	</head>
	<body>
		<?php
		$db = new mysqli('localhost', 'root', '', 'Students');
		if ($db->connect_error):
			die ("Could not connect to db: " . $db->connect_error);
		endif;

		$db->query("drop table Students");

		$result = $db->query("create table Students (Student_id int primary key not null auto_increment, LName char(30) not null, FName char(30) not null)") or die ("Invalid: " . $db->error);
		echo "Database created";
      ?>
      <a href="script2.php">Continue to form</a>
	</body>
</html>
