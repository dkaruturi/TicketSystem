<?php
   // CS 4501
   // Simple script to retrieve a random word from the database in XML
   // format and return it to the requestor.  You may want to use this
   // or something like it for Assignment 4.  Don't forget to change the
   // DB info in your version.
   $passlist = file("password.php");
   $passwd = rtrim($passlist[1]);
   $passwd = preg_replace('/#/','',$passwd);
   $db = new mysqli('localhost', 'soffa', "$passwd", 'soffa');
   if ($db->connect_error):
      die ("Could not connect to db " . $db->connect_error);
   endif;

   $query = "select word from Words order by rand() limit 1";
   $result = $db->query($query);
   $rows = $result->num_rows;
   if ($rows >= 1):
      header('Content-type: text/xml');
      echo "<?xml version='1.0' encoding='utf-8'?>";
      echo "<Word>";
      $row = $result->fetch_array();
      $ans = $row["word"];
      echo "<value>$ans</value>";
      echo "</Word>";
   else:
      die ("DB Error");
   endif;
?>