<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include("redis.php");
//functions
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
function removeUserFromRedis($redis, $username) {
    // Key for the user's main data
    $userHashKey = "user:$username";

    // Get the list of channels the user is part of (from the user's channel set)
    $channelsKey = "user:$username:channels";
    $channels = $redis->smembers($channelsKey);

    // Start a Redis transaction
    $redis->multi();

    // 1. Delete the user's data from the main hash
    $redis->del($userHashKey);
    
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


$threshold = time() - 60;

$allKeys = $redis->keys("user:*"); // Get all keys starting with "user:"
$userKeys = array_filter($allKeys, function($key) {
    // Only keep keys that don’t have extra colons after "user:"
    return substr_count($key, ":") === 1;
});

foreach ($userKeys as $userKey) {
    $lastSeen = $redis->hGet($userKey, "last_seen");
    if ($lastSeen < $threshold) {
        $username = substr($userKey, 5);
        removeUserFromRedis($redis, $username); // Delete inactive user
    }
}
