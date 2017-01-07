<html>
<body>

  <?php
if(isset($_SESSION["username"])){
  $username = $_SESSION["username"];
}
else{
  $username= $_COOKIE["current_user"];
}
  //echo "$username <br />";


  //if cookie isn't set, make a cookie for them
  if (!isset($_COOKIE[$username])){
    setcookie($username,"templogin", strtotime("tomorrow") );

    }
    else{
      //otherwise they already have so send them back to start
      echo "You have already taken your quiz today, come back tomorrow.";

?>
<form action = "start.php"
    method = "POST">
    <br />
    <?php
     ?>
<input type = "submit" name = "Back" value = "Back">
</form>
<?php
exit;
    }

  //setup the whole quiz

  //openfile
  $filename = "quizzes.txt";
  $fp = fopen($filename, "r");

  //parse file
  $content = fread($fp, filesize($filename));
  $lines = explode("\n", $content);
  fclose($fp);

  //size of quizzes.txt
  $count = (int)count($lines) -2;

  //quiz index is set, use the cookie value; otherwise, choose it and make a cookie
  if(!isset($_COOKIE["quiz_index"])){
  $quiz_index=mt_rand(0,$count);
  setcookie("quiz_index", $quiz_index, strtotime('tomorrow'));
}
  else{
    $quiz_index= $_COOKIE["quiz_index"];
  }


  //open, read, parse chosen quiz, and close
  $quiz_chosen=explode("#", $lines[$quiz_index]);
  $quiz_name= $quiz_chosen[0];
  $quiz_count= $quiz_chosen[1];
  $fq = fopen($quiz_name, "r");
  $quiz_content = fread($fq, filesize($quiz_name));
  $quiz_lines = explode("\n", $quiz_content);
  fclose($fq);

  //create a hastable of question to answer and a set of questions
  for ($x = 0; $x < $quiz_count; $x++) {
  $temp_array = explode("#", $quiz_lines[$x]);
  $temp_answers = explode(":", $temp_array[1]);
  $quiz_questions[$x] = $temp_array[0];
  $quiz_correct[$x]=$temp_array[2];
  $quiz_answers[$x]=$temp_answers;

  }

//set all the session variables needed by quiz.php and potentially other files
  $_SESSION["quiz_questions"]= $quiz_questions;
  $_SESSION["quiz_answers"] = $quiz_answers;
  $_SESSION["quiz_correct"] = $quiz_correct;
  $_SESSION["question_count"]=0;
  $_SESSION["quiz_count"]=$quiz_count;
  $_SESSION["correct_count"]=0;
  $_SESSION["check"] =true;
  $_SESSION["quiz_index"]= $quiz_index;
  $_SESSION["quizzes_count"]=$count;

?>


<?php
?>
</body>
</html>
