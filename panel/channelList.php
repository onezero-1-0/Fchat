<?php 
session_start();

//functions

function getChannels(){
        $url = 'http://localhost/api/getChannel.php?username='.$_SESSION['nickname'];
        $channels = file_get_contents($url);
        return json_decode($channels, true);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60">
    <link rel="stylesheet" href="/static/style.css">
</head>

<body style="background-color: transparent;">

    <div class="channel_container">
    <?php
    $channels = getChannels();
        
    foreach ($channels as $channel) {
        echo '<a target="_top" href="/index.php?action=channel&cFID='. $channel .'"><div class="channel">'. $channel .'</div></a>';
    }
    ?>
    </div>

</body>
<?php ?>