<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

include("redis.php");

session_start(); // Start the session

$priv = $_SESSION['privilage'];


//functions
//derect system message
function deleteChannelIfEmpty($redis, $channelID) {
    $channelUsersKey = "channel:$channelID:users";
    
    // Check if the hash has any users
    if ($redis->hlen($channelUsersKey) === 0) {
        // Delete all keys related to the channel
        $redis->del($channelUsersKey); // remove users hash

        // Optional: delete other related channel data
        $redis->del("channel:$channelID");
        $redis->del("channel:$channelID:chats");

        return true; // Channel deleted
    }

    return false; // Channel still has users
}

function systemmsg($message="SYTEM - What happend IDK!"){
    global $redis;

    $entry = json_encode([
        "author" => "system",
        "message" => $message,
        "color" => "#00fff3"
    ]) . "\n";

    $redis->rpush("channel:MAJOR:chats",$entry);
}
function removeUserFromChannel($redis,$cFID, $username){
    $redis->hdel("channel:$cFID:users", $username);
    $redis->sRem("user:$username:channels",$cFID);
}

function removeUserFromRedis($redis, $username,$user=true) {
    // Key for the user's main data
    $userHashKey = "user:$username";

    // Get the list of channels the user is part of (from the user's channel set)
    $channelsKey = "user:$username:channels";
    $channels = $redis->smembers($channelsKey);

    // Start a Redis transaction
    $redis->multi();

    // 1. Delete the user's data from the main hash
    if($user){
        $redis->del($userHashKey);
    }
    
    // 2. Remove the user from each channel's user set
    foreach ($channels as $channel) {
        $channelUsersKey = "channel:$channel:users";
        $redis->hdel($channelUsersKey, $username); // Using HDEL to delete the user from the channel hash
        deleteChannelIfEmpty($redis, $channel);

    }

    // 3. Remove the user from the channels set
    $redis->del($channelsKey);

    // Execute all commands in the transaction
    $redis->exec();

    echo "User $username has been logged out and removed from Redis.\n";
}

function kick($redis,$nickname,$cFID) {
    if($cFID == "MAJOR"){
        $redis->hset("user:$nickname", "status", "kicked");
        removeUserFromRedis($redis, $nickname,false);
        return;
    }
    removeUserFromChannel($redis, $cFID, $nickname);

}


//code

// Check if the user is logged in
if (!isset($_SESSION['nickname'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Process actions based on provided GET parameters
$username = $_GET['username'] ?? null;
$cFID = $_GET['cFID'] ?? null;
$action = $_GET['action'] ?? null;

if ($username && $cFID) {
    $priv = $redis->hGet("channel:$cFID:users", $_SESSION['nickname']);
    // User management action
    if ($action == "leave") {
        // Remove the user from a specific channel
        removeUserFromChannel($redis, $cFID, $username);
        deleteChannelIfEmpty($redis, $cFID);
        header("Location: index.php");
        exit();
    }elseif ($priv > 0 && $priv < 4) {
        // User has sufficient privileges to kick
        kick($redis, $username, $cFID);
        header("Location: index.php?action=userslist");
    }
    header("Location: index.php?action=userslist");

} else {
    // Logout process: remove user from Redis and clear session
    removeUserFromRedis($redis, $_SESSION['nickname']);
    session_unset(); // Clear all session variables
    session_destroy(); // Destroy the session on the server
    session_regenerate_id(true); // Regenerate session ID for security
    header("Location: login.php");
    exit();
}
?>
