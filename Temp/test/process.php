<?php
   header('Content-type: text/xml');
   $URL = 'data.xml';
   $contents = file_get_contents($URL); 
   echo $contents;
?>