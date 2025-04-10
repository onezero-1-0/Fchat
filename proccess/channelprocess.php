<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("../redis.php");

session_start();
//function
function creat_channel($cName,$cType,$cFID){
    global $redis;
    $channelData = [
        "name" => $cName,
        "type" => $cType,
        "description" => "Talk about anything here"
    ];
    $redis->hMSet("channel:$cFID", $channelData);

}
function join_channel($cFID,$username,$privilage){
    global $redis;
    if(!$redis->exists("channel:$cFID")){
        header("Location: /panel/joinChannel.php?error=channelNotFound");
        exit;
    }
    if(!$redis->hexists("channel:$cFID:users", $username)){
        $redis->hSet("channel:$cFID:users", $username, $privilage);
        $redis->sAdd("user:$username:channels", $cFID);
    }
    
}


if(!isset($_SESSION['nickname']) || !$_SESSION['color']){
    header("Location: login.php");
}


$action = isset($_POST['action']) ? htmlspecialchars($_POST['action'], ENT_QUOTES, 'UTF-8') : null;
$action = preg_replace('/[^a-zA-Z0-9_]/', '', $action);

$channel_fid = isset($_POST['channel_FID']) ? htmlspecialchars($_POST['channel_FID'], ENT_QUOTES, 'UTF-8') : null;


if($action == null || ($action !="creat" && $action != "join")){
    header("Location: /index.php");
    exit;
}

$cName = $_POST['channel_name'];
$cType = $_POST['channel_type'];
$cFID = ($channel_fid != null) ? $channel_fid : $cName[0] . uniqid();
$username = $_SESSION['nickname'];
$privilage = 4;

if($action == 'creat'){
    creat_channel($cName,$cType,$cFID);
    $privilage = 2;
}

join_channel($cFID,$username,$privilage);
header("Location: /index.php?action=channel&cFID=" . $cFID);

?>