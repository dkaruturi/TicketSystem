<?php
include 'adminClass.php';

  $db = new mysqli('localhost', 'root', '', 'tickets');
  $admin = new admin($_REQUEST['new_name'],$_REQUEST['new_password'],"",$_REQUEST['new_email']);
  $admin->password= $admin->hashit();
  $user_info = serialize($admin);
  $un = $_REQUEST['new_username'];
  echo $un;
  $typ="regular";


    $db->query("INSERT INTO admin (username, user_info, type) VALUES ('$un','$user_info','$typ')");
    echo "success";
    //echo "user already exists";

 ?>
