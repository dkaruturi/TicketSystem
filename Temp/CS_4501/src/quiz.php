<html>
<body>
<?php


session_start();

//annoying notices
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//back button hit of the current user from the summary page: send back to start
$username= $_SESSION["username"];
if(isset($_SESSION["refresh"])){
  if($username == $_SESSION["refresh"]){
session_destroy();
unset($_SESSION["refresh"]);
//exit;
header('Location: start.php');
}
}

//first time process quiz
if(isset($_POST["TakeQuiz"])){
include 'processQuiz.php';
}

//access session variables
$quiz_questions= $_SESSION["quiz_questions"];
$quiz_answers= $_SESSION["quiz_answers"];
$question_count=$_SESSION["question_count"];
$quiz_count=$_SESSION["quiz_count"];
$quiz_correct = $_SESSION["quiz_correct"];

//last question of the quiz
if($question_count==$quiz_count&&$_SESSION["check"]){
  $_SESSION["check"] =false;

  if($_POST['answer']==$quiz_correct[$question_count-1]){

    $_SESSION["correct_count"]= $_SESSION["correct_count"]+1;
    echo "You got the last question correct! <br />";
  }
  else{
    echo "You got the last question wrong! <br />";
    echo "Here is the correct answer: ";
    echo $quiz_answers[$question_count-1][(int)$quiz_correct[$question_count-1]];
  }

}

//button to take user to summary page
if($question_count==$quiz_count){
  ?>
  <form action = "done.php"
        method = "POST">
        <br />
        <input type = "submit" value = "Go to Summary">
  </form>
<?php
exit;
}
?>

<html>

<form action = "quiz.php"
      method = "POST">

<?php

//report whether user got question right
if($question_count>0&&$question_count<$quiz_count){
if($_POST['answer']==$quiz_correct[$question_count-1]){

  $_SESSION["correct_count"]=$_SESSION["correct_count"]+1;
  echo "You got the last question correct! <br />";
}
else{
  echo "You got the last question wrong! <br />";
  echo "Correct Answer: ";
  echo $quiz_answers[$question_count-1][(int)$quiz_correct[$question_count-1]];
}

}
//print questions and take input
echo "<br /><br />";
echo $quiz_questions[$question_count];
?>
<br />

<?php echo $quiz_answers[$question_count][0] ?>
<input type="radio" name="answer"
value="0">
<br />

<?php echo $quiz_answers[$question_count][1] ?>
<input type="radio" name="answer"
value="1">
<br />

<?php echo $quiz_answers[$question_count][2] ?>
<input type="radio" name="answer"
value="2">
<br />

<?php echo $quiz_answers[$question_count][3] ?>
<input type="radio" name="answer"
value="3">
<br />

<?php echo $quiz_answers[$question_count][4] ?>
<input type="radio" name="answer"
value="4">
<br />


<br />
<input type = "submit" value = "Submit">
<br />

<?php
$_SESSION["question_count"]=$question_count+1;
?>

</form>

</html>
</body>
</html>
