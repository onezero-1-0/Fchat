<?php ?>
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
                <?php echo $_SESSION['nickname'] . $symbol; ?>
            </div>
            <div class="privilages">
                <label class="h3_head magerfont">SYSTEM Privilage</label>
                <br>
                <li>
                    <?php
                        if($superUser){
                            echo "SUPER USER<br>you have all permisions you can kick users delete privet or public channels and do system tasks.";
                        }elseif($admin){
                            echo "ADMIN<br>you have high permisions you can kick users delete public channels";
                        }elseif($moderator){
                            echo "MODERATOR<br>you have mid permisions you can kick users in public chat and channels";
                        }else{
                            echo "USER<br>you have minimum permisions you can send message and read";
                        }
                    ?>
                </li>
                <br>
                <br>
                <label class="h3_head magerfont">Chanels</label>
                <br>
                <div class="channel_panel">
                    <iframe src="/index.php?action=channellist" frameborder="0"></iframe>
                </div>
                
            </div>
            <br>
            <div class="channel_operations row">
                <a href="/panel/createChannel.php" style="text-decoration: none; color: inherit;">
                    <div class="create_channel click">Create Channel</div>
                </a>
                <a href="/panel/joinChannel.php" style="text-decoration: none; color: inherit;">
                    <div class="join_channel click">Join Channel</div>
                </a>
            </div>
            
            <div class="column click logout">
                <a href="logout.php" style="text-decoration: none; color: inherit;">
                    Log Out
                </a>
            </div>
        </div>

        <div class="middle_panel">
            <div class="chat_panel">
                <iframe src="/index.php?action=chat" frameborder="0"></iframe>
            </div>
            <div class="chat_box_panel">
                <iframe src="/index.php?action=chatbox" frameborder="0"></iframe>
            </div>
        </div>

        <div class="right_panel">
            <iframe src="index.php?action=userslist" frameborder="0" style="height: 100vh;width: 20vw;" loading="lazy"></iframe>
        </div> 
    </div>
</body>

</html>


<?php ?>














<!-- <div class="imojis">
            <div class="smile"><span class="imoji">😀</span> <span class="imoji">😁</span> <span class="imoji">😂</span> <span class="imoji">😊</span> <span class="imoji">🤔</span> <span class="imoji">😐</span> <span class="imoji">😑</span> <span class="imoji">🙄</span> <span class="imoji">😶</span> <span class="imoji">😏</span> </div>
            <div class="hand"><span class="imoji">👋</span> <span class="imoji">🤚</span> <span class="imoji">✋</span> <span class="imoji">👌</span> <span class="imoji">🤏</span> <span class="imoji">✊</span> <span class="imoji">✋</span> <span class="imoji">🤞</span> <span class="imoji">👏</span> <span class="imoji">👍</span></div>
            <div class="hacking"><span class="imoji">🧑‍💻</span> <span class="imoji">🕵️‍♂️</span> <span class="imoji">💣</span> <span class="imoji">🔑</span> <span class="imoji">🔒</span> <span class="imoji">💾</span> <span class="imoji">🛠️</span> <span class="imoji">🕶️</span> <span class="imoji">🛰️</span> <span class="imoji">⚙️</span></div>
        </div> 

<div class="container-chat">

          <div class="yourside">

          <?php //echo '<div class="you" style="background-color: ' . $_SESSION['color'] . ';">' ?>
            </div>
            <?php //echo '<div class="yourname" style="color: ' . $_SESSION['color'] . ';text-shadow: 0 0 5px ' . $_SESSION['color'] . ',0 0 10px ' . $_SESSION['color'] . ', 0 0 15px ' . $_SESSION['color'] . ', 0 0 100px ' . $_SESSION['color'] . ';">' . $_SESSION['nickname'] . '</div>';
            ?>

        </div>
        <div class="yourside-out">

          
        <?php
        // if (isset($_SESSION['admin']) && password_verify($adminKey, $_SESSION['admin'])) {
        //     echo '<div class="admin">you have admin acess</div>';
        // }
        ?>
         Place holde for imoji dont think 
        <div class="logout"><a href="logout.php">LogOut</a></div>

    </div>

    <div class="chatside">

        <iframe src="index.php?action=chat" frameborder="0" style="height: 84vh;"></iframe>

        <hr style="width: 100%;height: 0px;">

        <iframe src="index.php?action=chatbox" frameborder="0" style="height: 10vh;"></iframe>

    </div>

    <iframe src="index.php?action=userslist" frameborder="0" style="height: 100vh;width: 20vw;"></iframe> -->