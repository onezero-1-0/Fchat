<?php 
include("../redis.php");

$cFID = isset($_GET['cFID']) ? htmlspecialchars($_GET['cFID'], ENT_QUOTES, 'UTF-8') : "MAJOR";

function getUser() {
    global $redis;
    global $cFID;

    $users = $redis->hgetall("channel:$cFID:users");
    return $users;
}

header('Content-Type: application/json');

echo json_encode(getUser());


?>