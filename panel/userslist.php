<?php

include(__DIR__ ."/../redis.php");

$redis->hset("user:".$_SESSION['nickname'], "last_seen", time());

$cFID = $_SESSION['cFID'];
//functions
function getUsers()
    {
        global $cFID;
        $url = "http://localhost/api/getUsers.php?cFID=$cFID";
        $users = file_get_contents($url);
        return json_decode($users, true);
    }

$privilege = $redis->hGet("channel:$cFID:users", $_SESSION['nickname']);
switch($privilege){
    case 2:
        $admin = true;
        break;
    case 3:
        $moderator = true;
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
    <meta http-equiv="refresh" content="10">
    <link rel="stylesheet" href="/static/style.css">
</head>

<body style="background-color: rgb(0, 23, 35);">
    <div class="containet">
        <div class="staff">
            <label class="h3_head magerfont">SYSTEM USERS</label>
            <?php
            $users = getUsers();
            $userList = [];
            foreach ($users as $key => $value) {

                if(!isset($value)){
                    continue;
                }
                if($value == 1){
                    $staff = $key." **";
                }elseif($value == 2){
                    $staff = $key." *";
                }elseif($value == 3){
                    $staff = $key." /*";
                }else{
                    $userList[] = $key;
                    continue;
                }
                echo "<span>". $staff ."</span>";

            }
            ?>
        </div>
        <div class="users">
            <?php
            echo '<label class="h3_head magerfont">USERS - '. count($userList) .'</label>';
            foreach ($userList as $user) {
                echo "<div class='row'><span>". $user ."</span>";
                if($superUser || $admin || $moderator){
                    echo "<a class='none' href='logout.php?username=$user&cFID=$cFID'>🔚</a>";
                }
                echo "</div>";
            } ?>
        </div>
    </div>
</body>
<?php ?>


