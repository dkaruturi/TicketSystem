<?php
// print_r($_SESSION);
session_start();

//remove validation if the user logged in
if(isset($_POST['LOGOUT'])){
unset($_SESSION['security']);
header('Location: admin.php');
}
//make sure user logged in
if(!isset($_SESSION['security'])){
    header('Location: admin.php');
}
$admin_id=$_SESSION['admin_id'];

//keep track of last query
if(isset($_SESSION['previous_query'])){
  $previous=$_SESSION['previous_query'];

}
//ALL_TICKETS,SORT,SELECTED_TICKET,MY_TICKETS,LOGOUT,UNASSIGNED_TICKET

?>

<table border ='1'>
<tr>
<th>Ticket Number</th>
<th>Received</th>
<th>Sender Name</th>
<th>Sender Email</th>
<th>Subject</th>
<?php
if(isset($_POST['SELECTED_TICKET'])&&isset($_POST['ticket'])){
echo '<th>Body</th>';
}
 ?>
<th>Tech</th>
<th>Status</th>
<th>Select</th>
</tr>

<?php

//display all open tickets in html table
$db = new mysqli('localhost', 'root', '', 'tickets');

//view all tickets
if(isset($_POST['ALL_TICKETS'])){
  $query= "SELECT * FROM tickets";
  $_SESSION['previous_query']= $query;
}

//find the tickets associated with the admin through the connection table
elseif(isset($_POST['MY_TICKETS'])){
    $query= "SELECT ticket_id FROM connection WHERE admin_id='$admin_id'";
    $results =  $db->query($query);
    if($results->num_rows>0){
    for($ctr=1; $ctr<=$results->num_rows; $ctr++){
      $array = $results->fetch_array();
      $ticket_id[$ctr]=$array['ticket_id'];
          }
        $ids = join("','",$ticket_id);

  $query= "SELECT * FROM tickets WHERE  ticket_id IN ('$ids')";
  $_SESSION['previous_query']= "SELECT * FROM tickets WHERE  admin_id='$admin_id'";
}

  }
  //handles unassigned tickets
  elseif(isset($_POST['UNASSIGNED_TICKET'])){
    $query= "SELECT * FROM tickets WHERE admin_id='0'";
    $_SESSION['previous_query']= $query;

}
//finds all tickets from same submitter
elseif(isset($_POST['SUBMITTER'])&&isset($_SESSION['ticket'])){
  $selected=$_SESSION['ticket'];
  $query = "SELECT sender_name FROM tickets WHERE ticket_id='$selected'";
  $results = $db->query($query);
  $row = $results->fetch_array();
  $sender_name=$row['sender_name'];
  $query= "SELECT * FROM tickets WHERE sender_name='$sender_name'";
  $_SESSION['previous_query']= $query;
}

//finds selected ticket
  elseif(isset($_POST['SELECTED_TICKET'])&&isset($_POST['ticket'])){
    $ticket_id=$_POST['ticket'];
    $query= "SELECT * FROM tickets WHERE ticket_id='$ticket_id'";
    $_SESSION['previous_query']= $query;

  }

//finds ticket if one ticket
  elseif(isset($_POST['SIMILAR'])&&isset($_SESSION['ticket'])){

    //get subject for ticket and put it in an array for regex form
    $ticket_id=$_SESSION['ticket'];
    $query= "SELECT subject FROM tickets WHERE ticket_id='$ticket_id'";
    $results =  $db->query($query);
    $array = $results->fetch_array();
    $subject=explode(" ",$array['subject']);
    foreach ($subject as $key => $value) {
      //add all ticket ids that match all each word of the ticket in question
      //only add if there is a match
       $sql[] = "subject LIKE '%".$value."%'";
    }

    //find all tickets that match this
    $query = 'SELECT * FROM tickets WHERE '.implode(" OR ", $sql);

  }
else{
    //view open tickets
    $query= "SELECT * FROM tickets WHERE status='open'";
    $_SESSION['previous_query']= $query;
  }

  //sorts tickets
  if(isset($_POST['SORT'])){
    if(isset($_POST['filter'])){
      $filter = $_POST['filter'];
      $query=$previous." ORDER BY $filter ASC";
    }
    else{
      $query=$previous;
    }

    $_SESSION['previous_query']=$previous;

}
$results =  $db->query($query);

//checks if the query succeeds
if($results->num_rows<=0){
  echo "No Results! <br />";
  $query= "SELECT * FROM tickets WHERE status='open'";
  $_SESSION['previous_query']= $query;
  $results =  $db->query($query);

}

//displays table
for($ctr=1; $ctr<=$results->num_rows; $ctr++){
$array = $results->fetch_array();
echo
"<tr>
<th>".$array['ticket_id']."</th>
<th>".$array['received']."</th>
<th>".$array['sender_name']."</th>
<th>".$array['sender_email']."</th>
<th>".$array['subject']."</th>";
if(isset($_POST['SELECTED_TICKET'])&&isset($_POST['ticket'])){
echo "<th>".$array['body']."</th>";
}
echo
"<th>".$array['tech']."</th>
<th>".$array['status']."</th>
<th><input type = 'radio' name = 'ticket' value=".$array['ticket_id']." form='Form1'"." </th>
</tr>";

}

//display radio button for sort
 ?>

 <tr>
 <th><input type = 'radio' name = 'filter' value="ticket_id" form="Form1" </th>
 Sort By
 <th><input type = 'radio' name = 'filter' value="received" form="Form1"</th>
 Sort By
 <th><input type = 'radio' name = 'filter' value="sender_name" form="Form1"</th>
 Sort By
 <th><input type = 'radio' name = 'filter' value="sender_email" form="Form1"</th>
 Sort By
 <th><input type = 'radio' name = 'filter' value="subject" form="Form1"</th>
 Sort By
<th> </th>
<th> </th>
 </tr>

</table>
<?php
//show options for selected ticket
if(isset($_POST['SELECTED_TICKET'])&&isset($_POST['ticket'])){
  $_SESSION['ticket']=$_POST['ticket'];

  ?>
  <form   id = "Form2"
          action ="adminFunctions.php"
          method = "POST">
  <table style="margin:1em auto;">
    <tr>
      <td><input type="submit" name ="TOGGLE" value="Close/Reopen"></td>
      <td><input type="submit" name ="ASSIGN" value="Assign Self"></td>
      <td><input type="submit" name ="REMOVE" value="Remove Self"></td>
      <td><input type="submit" name ="EMAIL" value="Email Submitter"></td>
    </tr>
    <tr>
      <td><input type="submit" name ="DELETE" value="Delete Ticket"></td>
      <td><input type="submit" name ="OPEN" value="View Open Tickets"></td>
    </form>
    <form   id = "Form3"
            action ="admin_ticket.php"
            method = "POST">
      <td><input type="submit" name ="SUBMITTER" value="Tickets From Submitter"></td>
      <td><input type="submit" name ="SIMILAR" value="Find Similar Tickets"></td>
    </form>

    </tr>
  <table>


<?php
exit;
//displays buttons for tickets
}

?>

<form   id = "Form1"
        action ="admin_ticket.php"
        method = "POST">
<table style="margin:1em auto;">
  <tr>
    <?php
    if(isset($_POST['ALL_TICKETS'])){
      echo "<td><input type='submit' name ='OPEN_TICKETS' value='View Open Tickets'></td>";
    }
    else{
      echo "<td><input type='submit' name ='ALL_TICKETS' value='View All Tickets'></td>";
    }
    ?>
     <td><input type="submit" name ="SORT" value="Sort"></td>
     <td><input type="submit" name ="SELECTED_TICKET" value="View Selected Tickets"></td>

  </tr>
  <tr>
    <?php
    if(isset($_POST['MY_TICKETS'])){
      echo "<td><input type='submit' name ='OPEN_TICKETS' value='View Open Tickets'></td>";
    }
    else{
      echo "<td><input type='submit' name ='MY_TICKETS' value='View My Ticket'></td>";
    }
     ?>
    <td><input type="submit" name ="LOGOUT" value="Logout"></td>
    <?php
    if(isset($_POST['UNASSIGNED_TICKET'])){
      echo "<td><input type='submit' name ='OPEN_TICKETS' value='View Open Tickets'></td>";
    }
    else{
      echo "<td><input type='submit' name ='UNASSIGNED_TICKET' value='View Unassigned Tickets'></td>";
    }
     ?>
  </tr>
<table>
</form>
