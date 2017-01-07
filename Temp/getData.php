<?php
   // CS 4501
   // Simple script to retrieve some data from the server
      //$fname = $_POST["file"];
      $data = file_get_contents("./file1.txt");
      echo "$data";
?>
