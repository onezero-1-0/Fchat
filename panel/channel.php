<?php 
$cFID = $_SESSION['cFID'];

//functions
function getChannel($cFID){
    $url = 'http://localhost/api/getChannel.php?'.$cFID;
    $channel_details = file_get_contents($url);
    return json_decode($channel_details, true);
}
$username = $_SESSION['nickname'];

if(!$redis->hExists("channel:$cFID:users", $username)){
    header("Location: /index.php");
}

$privilege = $redis->hGet("channel:$cFID:users", $username);
$channel_name = $redis->hGet("channel:$cFID", "name");

switch($privilege){
    case 2:
        $admin = true;
        $symbol = " *";
        break;
    case 3:
        $moderator = true;
        $symbol = " /*";
        break;
    default:
        null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fchat-start</title>
    <link rel="stylesheet" href="/static/style.css">
</head>

<body>
    <div class="container">

        <div class="left_panel">
            <div class="name h2_head">
                <?php echo $channel_name; ?>
            </div>
            <div class="name h3_head">
                <?php echo $cFID; ?>
            </div>
            <div class="name h2_head">
                <?php echo $_SESSION['nickname'] . $symbol; ?>
            </div>
            <div class="privilages">
                <label class="h3_head magerfont">CHANNEL Privilage</label>
                <br>
                <li>
                    <?php
                        if($superUser){
                            echo "SUPER USER<br>you have all permisions you can kick users delete privet or public channels and do system tasks.";
                        }elseif($admin){
                            echo "ADMIN<br>you have all permisions in this channel you can kick users and delete this channel";
                        }elseif($moderator){
                            echo "MODERATOR<br>you have mid permisions you can kick users in this channel";
                        }else{
                            echo "USER<br>you have minimum permisions you can send message and read";
                        }
                    ?>
                </li>
                <br>
                <br>
                
            </div>
            <br>

            <div class="column click">
                <a href="logout.php?action=leave&username=<?php echo $_SESSION['nickname']. "&cFID=" .$_SESSION['cFID'] ?>" style="text-decoration: none; color: inherit;">
                ❌ LEAVE
                </a>
            </div>

            <div class="column click logout">
                <a href="index.php" style="text-decoration: none; color: inherit;">
                    Back TO MAJOR CHAT
                </a>
            </div>
        </div>

        <div class="middle_panel">
            <div class="chat_panel">
                <?php echo '<iframe src="/index.php?action=chat" frameborder="0"></iframe>'; ?>
            </div>
            <div class="chat_box_panel">
                <iframe src="/index.php?action=chatbox" frameborder="0"></iframe>
            </div>
        </div>

        <div class="right_panel">
            <iframe src="/index.php?action=userslist" frameborder="0" style="height: 100vh;width: 20vw;"></iframe>
        </div> 
    </div>
</body>

</html>


<?php ?>
