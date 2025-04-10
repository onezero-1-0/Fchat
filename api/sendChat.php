<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
include("../redis.php");
//functions

function sanitize($string){
    $string = trim($string);
    if(empty($string) || strlen($string) > 300){
        return uniqid() . " fucking...";
    }
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
function urlFilter($message){
    $pattern = "/\b(https?:\/\/|www\.)?([a-zA-Z0-9.-]+\.[a-zA-Z]{2,})(\/[^\s]*)?\b/i";
    $filterd_message = preg_replace($pattern, '<a href="$0" target="_blank" rel="noopener noreferrer">$0</a>', $message);
    return $filterd_message;
}
function mention($msg) {
    return $msg;
}
function iskicked($redis, $username, $cFID) {
    $status = $redis->hget("user:$username","status");
    echo $status;
    if ($status != "ok") {
        return true;
    }
    if(!$redis->hexists("channel:$cFID:users", $username)){
        return true;
    }

    return false;
}


//code
$cFID = $_SESSION['cFID'];


if(iskicked($redis, $_SESSION['nickname'], $cFID)){
    header("Location: /index.php?action=kicked");
    exit;
}

if (isset($_SESSION['nickname']) && isset($_POST['message']) && !empty($_POST['message'])) {
    
    $auther = sanitize($_SESSION['nickname']);
    $message = $_POST['message'];
    $color = $_SESSION['color'];
    $auther = $auther;

    $message = sanitize($message);
    $message = urlFilter($message);
    $message = mention($message);
    $color = sanitize($color);
    
    $entry = json_encode([
        "author" => $auther,
        "message" => $message,
        "color" => $color
    ]);
    
    if(!$redis->hexists("channel:$cFID:users",$auther)){
        ("Location: /index.php?action=chatbox");
        exit;
    }

    $redis->rpush("channel:$cFID:chats",$entry);
    $redis->ltrim("channel:$cFID:chats", -10, -1);
    header("Location: /index.php?action=chatbox");
    exit;
}

?>