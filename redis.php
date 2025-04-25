<?php


error_reporting(E_ALL);        // Report all types of errors
ini_set('display_errors', 1);  // Enable error display


// Connect to Redis
$redis = new Redis();
$redis->connect('127.0.0.1', 6379); // Default Redis host and port

// Test connection
if (!$redis->ping()) {
    echo "❌ Redis connection failed!";
}
?>
