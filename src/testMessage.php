<?php
    require_once "vendor/autoload.php";
    use Twilio\Rest\Client;
    $AccountSid = "AC34d6c80019d335a97418a3b464f73282";
    $AuthToken = "64d7525b224134ea165d3b6d81e8aa68";
    $client = new Client($AccountSid, $AuthToken);
    $people = array(
        "+17577597930" => "Divya Karuturi",
    );
    foreach ($people as $number => $name) {

        $sms = $client->account->messages->create(
            $number,
            array(
                'from' => "+17576902682",
                'body' => "Hey $name, Congratulations, you're hired!~ Twilio Team"
            )
        );
        echo "<script type='text/javascript'>alert('Sent message to $name');</script>";
    }
    ?>
