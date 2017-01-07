<html>
<?php
if(isset($_POST['Forget'])){



  //open and read users.txt
  $filename = "users.txt";
  $fp = fopen($filename, "r");
  $content = fread($fp, filesize($filename));
  $lines = explode("\n", $content);
  $size = count($lines)-1;
  $username = $_POST['username'];
  $password = $_POST['password'];
  $match=false;

  //clear current
  file_put_contents($filename, "",LOCK_EX);

  //rewrite users.txt but with the new updated password
  for ($x = 0; $x < $size; $x++) {
    $temp_array= explode("#", $lines[$x]);
    $current_username = $temp_array[0];

  if($username==$current_username){
    $match = true;
    $new_string = "{$username}#{$password}";
    file_put_contents($filename,$new_string,FILE_APPEND| LOCK_EX);
    file_put_contents($filename, "\n",FILE_APPEND| LOCK_EX);
  }
  else{
    file_put_contents($filename,$lines[$x],FILE_APPEND| LOCK_EX);
    file_put_contents($filename, "\n",FILE_APPEND| LOCK_EX);
  }
  }

  fclose($fp);

//if the user was found and the password was updated, notify the user
  if($match==true){
    echo "You successfully changed your password <br />";
  ?>
  <form action = "start.php"
      method = "POST">
      <br />
      <input type = "submit" name="Back to Start" value = "Go Back">
      <br /> <br />
      </form>
<?php
  }
  else{ //if the user is not found, the user is notified and nothing is changed
    echo "That user does not exist, you should register a new user <br />"
?>
<form action = "start.php"
    method = "POST">
    <br />
    <input type = "submit" name="Back to Start" value = "Go Back">
    <br /> <br />
    </form>
  <?php
  }
  //clicking button will take them back to the login page
  exit;
}

//form to choose new password and enter old username
?>

  <form action = "forget.php"
      method = "POST">
  <b> Choose New Password</b>
  <br /> <br />
  <b>username</b>
  <br /><br />
  <input type = "text" name = "username" size = "30" maxlength= "30">
  <br /><br />
  <b>new password</b>
  <br /> <br />
  <input type = "text" name = "password" size = "30" maxlength= "30">
  <br /><br />
  <input type = "submit" name="Forget" value = "Change Password">
  <br /> <br />
  </form>


  </html>
