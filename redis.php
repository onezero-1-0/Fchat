<?php
// Connect to Redis
$redis = new Redis();
$redis->connect('127.0.0.1', 6379); // Default Redis host and port

// Test connection
if (!$redis->ping()) {
    echo "❌ Redis connection failed!";
}
?>