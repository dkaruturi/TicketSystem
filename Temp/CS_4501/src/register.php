<html>

<?php

//check to see if they clicked Register
if(isset($_POST['Register'])){

  $filename = "users.txt";
  $fp = fopen($filename, "r");

  //parse file
  $content = fread($fp, filesize($filename));
  $lines = explode("\n", $content);
  fclose($fp);
  $match = false;
  $new_user =$_POST['new_username'];
  $new_pass = $_POST['new_password'];

  //loop through users.txt and make sure there isn't a match
  foreach($lines as $val) {
    $temp_array=explode("#", $val);
    if($temp_array[0]==$new_user){
      $match=true;
    }
  }

//if match happens, send back to login
if($match){
  echo "You failed registration because $new_user already exists! Try again <br />";
  ?>
  <form action = "start.php"
      method = "POST">
      <br />
      <input type = "submit" name="Go Back" value = "Go Back">
      <br />
      </form>
<?php
//otherwise append new info to users.txt
}
else{
  $new_string = "{$new_user}#$new_pass";
  file_put_contents($filename, $new_string,FILE_APPEND| LOCK_EX);
  file_put_contents($filename, "\n",FILE_APPEND| LOCK_EX);
  echo "You have sucessfully registered $new_user";
  //take their credentials with this form
  ?>
  <form action = "start.php"
      method = "POST">
      <br />
      <input type = "submit" name="Go Back" value = "Go Back">
      <br />
      </form>
  <?php
  //header('Location: start.php');
}
exit;
}

?>
<form action = "register.php"
    method = "POST">
<b> username</b>
<input type = "text" name = "new_username" size = "30" maxlength= "30">
<br /><br />
<b> password</b>
<input type = "text" name = "new_password" size = "30" maxlength= "30">
<br /><br />
<input type = "submit" name="Register" value = "Register">
<br /> <br />
</form>


</html>
