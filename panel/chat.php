<?php 
//functions
if(!$redis->hexists("channel:". $_SESSION['cFID'] .":users", $_SESSION['nickname'])){
    header("Location: /index.php?action=kicked");
}

function getMessages(){
        $url = 'http://localhost/api/getChat.php?cFID='.$_SESSION['cFID'];
        $messages = file_get_contents($url);
        return json_decode($messages, true);;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="3">
    <link rel="stylesheet" href="/static/style.css">
</head>

<body style="background-color: black;">

    <div class="chat_container">
        <div class="message_container">
        <?php
        $messages = getMessages();
        
        foreach ($messages as $msgArray) {
            $msg = json_decode($msgArray, true);
            echo '<div class="author">'. $msg['author'] .'</div>';
            echo '<div class="message glow" style="--color: '. $msg['color'] .';">'. $msg['message'] .'</div>';
        }
        ?>
        </div>
    </div>

</body>
<?php ?>
<!-- 
$latest_message = end($messages);
        $last_message_file = "last_message.txt";

        // Read last stored message
        if (file_exists($last_message_file)) {
            $last_message = file_get_contents($last_message_file);
        } else {
            $last_message = "";
        }

        // If the last message is the same, exit (prevents unnecessary reloading)
        if ($last_message == $latest_message) {
            exit;
        }

        // Update the stored message
        file_put_contents($last_message_file, $latest_message); -->