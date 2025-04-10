<?php
include("redis.php");

session_start();
$privilege = $_SESSION['privilage'] ?? 4;
$superUser = false;
$admin = false;
$moderator = false;
$symbol = $_SESSION['symbol'];

switch($privilege){
    case 1:
        $superUser = true;
        break;
    case 2:
        $admin = true;
        break;
    case 3:
        $moderator = true;
        break;
    default:
        null;
}

if(!isset($_SESSION['nickname']) || !$_SESSION['color']){
    header("Location: login.php");
}



$action = isset($_GET['action']) ? htmlspecialchars($_GET['action'], ENT_QUOTES, 'UTF-8') : 'home';
$action = preg_replace('/[^a-zA-Z0-9_]/', '', $action);

if($action == "home"){
    $_SESSION['cFID'] = "MAJOR";
}else{
    $channelFID = isset($_GET['cFID']) ? htmlspecialchars($_GET['cFID'], ENT_QUOTES, 'UTF-8') : $_SESSION['cFID'];
    $_SESSION['cFID'] = preg_replace('/[^a-zA-Z0-9_]/', '', $channelFID);
}

// update user activity

switch($action){
    case 'kicked':
        include("panel/kicke.php");
        break;
    case 'userslist':
        include("panel/userslist.php");
        break;
    case 'chatbox':
        include("panel/chatbox.php");
        break;
    case 'chat':
        include("panel/chat.php");
        break;
    case 'channel':
        include("panel/channel.php");
        break;
    case 'channellist':
        include("panel/channelList.php");
        break;
    default:
        include("panel/home.php");
        break;

}

    
    
