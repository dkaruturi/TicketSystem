<html>
<body>
<?php
//annoying notices
error_reporting(E_ERROR | E_WARNING | E_PARSE);

//open and read quizzes.txt
$filename = "quizzes.txt";
$fp = fopen($filename, "r");
$content = fread($fp, filesize($filename));
$lines = explode("\n", $content);
$quiz_index= $_COOKIE["quiz_index"];
$size = count($lines)-1;


//clear current
file_put_contents($filename, "",LOCK_EX);

//build default and remove taken quiz

for ($x = 0; $x < $size; $x++) {

if($x!=$quiz_index){
  $new_line= explode("#", $lines[$x]);
  $new_string = "{$new_line[0]}#{$new_line[1]}#0#0#0";
  file_put_contents($filename,$new_string,FILE_APPEND| LOCK_EX);
  file_put_contents($filename, "\n",FILE_APPEND| LOCK_EX);
}

}

fclose($fp);


  ?>
</body>
</html>
