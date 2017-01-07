<html>
<body>
<?php
session_start();

//if user refreshes, go back to login
 if(isset($_SESSION["refresh"])){
  session_destroy();
 header('Location: start.php');

 }
 
 //this page has been reached once through this page
 $_SESSION["refresh"] = true;
 $username= $_SESSION["username"];
//print summary of quiz results
echo "Quiz Results";
echo '<br />';
echo '<br />';

// echo $_SESSION["correct_count"];
// echo $_SESSION["quiz_count"];
echo "Your Score: ";
echo ($_SESSION["correct_count"]/$_SESSION["quiz_count"])*100;
echo "%";
echo '<br />';

echo "Number of Questions Correct:";
echo $_SESSION["correct_count"];
$filename = "quizzes.txt";
$fp = fopen($filename, "r");
$content = fread($fp, filesize($filename));
$lines = explode("\n", $content);
echo '<br />';

//clear file
file_put_contents('quizzes.txt', "",LOCK_EX);

  //update quiz stats
  for ($x = 0; $x <= $_SESSION["quizzes_count"]; $x++) {
    if($x==$_SESSION["quiz_index"]){

      //parse
      $new_line = explode("#",$lines[$x]);

      //update stats with local info
      $local_incorrect = $_SESSION["quiz_count"]-$_SESSION["correct_count"];

      $new_line[3] = $new_line[3]+$_SESSION["correct_count"];

      $new_line[4] = $new_line[4] +$local_incorrect;

      $new_line[2] = $new_line[2]+1;

      $total = $new_line[4]+$new_line[3];
      echo 'Average score for this quiz: ';
      //print total percentage here
      $final_percentage = ($new_line[3]/$total)*100;
      echo "$final_percentage% <br />";

      //build string
      $new_string = "{$new_line[0]}#{$new_line[1]}#{$new_line[2]}#{$new_line[3]}#{$new_line[4]}";

      //write to file
      file_put_contents($filename,$new_string,FILE_APPEND| LOCK_EX);
      file_put_contents($filename, "\n",FILE_APPEND| LOCK_EX);
    }
    else{
      //write same info back
      file_put_contents($filename, $lines[$x], FILE_APPEND| LOCK_EX);
      file_put_contents($filename, "\n",FILE_APPEND| LOCK_EX);
    }

}

//close file
fclose($fp);

//button to go back to login after quiz is over
 ?>

 <form action = "start.php"
     method = "POST">
 <br />
 <input type = "submit" name= "Done" value = "Done">
 </form>

</body>
</html>
