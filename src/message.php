<?php
    require_once "vendor/autoload.php";
    use Twilio\Rest\Client;
    $AccountSid = "";
    $AuthToken = "";
    $client = new Client($AccountSid, $AuthToken);
    $from = "";
    $to =$_REQUEST['phoneNumber'];
    $user =$_REQUEST['name'];
    $body = $_REQUEST['text'];
    $people = array(
        "$to" => "$user",
    );
    foreach ($people as $number => $name) {

        $sms = $client->account->messages->create(
            $number,
            array(
                'from' => "$from",
                'body' => "$body"
            )
        );
        echo "<script type='text/javascript'>alert('Sent message to $name');</script>";
    }
    ?>
