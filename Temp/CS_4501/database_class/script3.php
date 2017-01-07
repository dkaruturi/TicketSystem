<html>

<?php
  $db = new mysqli('localhost', 'root', '', 'tickets');
  $FName = $_POST["firstname"];
  $LName = $_POST["lastname"];
  $query = "SELECT * FROM Students WHERE FName = '$FName' AND LName = '$LName'";
  $results = $db->query($query);
  //print_r($results);
  $count=$results->num_rows;
  if($count!=0){
    echo "This name is already in the table!<br/>";

  }
  else{
    echo "Name was inserted!";
    $query2 = "INSERT INTO Students
    (LName, FName) VALUES ('$LName', '$FName')";
    $db->query($query2);
  }
  echo "<br />";

  $query3 = "SELECT * FROM Students";
  $results = $db->query($query3);
  for($ctr=1; $ctr<=$results->num_rows; $ctr++){
    $array = $results->fetch_array();
    echo $array['Student_id']." ".$array['LName']." ".$array['FName'];
    echo "<br />";
  }
  ?>
</html>
