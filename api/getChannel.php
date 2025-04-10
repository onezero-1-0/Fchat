<?php
include("../redis.php");


$username = isset($_GET['username']) ? htmlspecialchars($_GET['username'], ENT_QUOTES, 'UTF-8') : "MAJOR";

function getChannels() {
    global $redis;
    global $username;
    $channels = $redis->sMembers("user:$username:channels");
    return $channels;
}

header('Content-Type: application/json');


echo json_encode(getChannels());
?>