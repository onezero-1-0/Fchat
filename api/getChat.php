<?php 
include("../redis.php");


$cFID = isset($_GET['cFID']) ? htmlspecialchars($_GET['cFID'], ENT_QUOTES, 'UTF-8') : "MAJOR";

function getMessages() {
    global $redis;
    global $cFID;
    $messages = $redis->lrange("channel:$cFID:chats", 0, -1);
    return $messages;
}

header('Content-Type: application/json');


echo json_encode(getMessages());

?>