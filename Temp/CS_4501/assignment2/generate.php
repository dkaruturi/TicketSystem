<html>
<body>
<?php
//annoying notices
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$filename = 'quizzes.txt';
//clear current

//build default and remove taken quiz

for ($x = 0; $x < $size; $x++) {
  $x=$x*2;
  $new_string = "{$x} {$x}";
  file_put_contents($filename,$new_string,FILE_APPEND| LOCK_EX);
  file_put_contents($filename, "\n",FILE_APPEND| LOCK_EX);
}




  ?>
</body>
</html>
