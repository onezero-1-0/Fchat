<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
include("../redis.php");

//List OF Functions
function sanitize($string){
    if(empty(trim($string))){
        return uniqid() . "fucker";
    }
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
function privilage($adminpass){
    $url = "http://localhost/api/getPrivilage.php"; // call API

    $data = http_build_query(array(
        "adminpass" => $adminpass
    ));

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // Sending JSON data

    $response = curl_exec($ch);
    curl_close($ch);
    
    $responseData = json_decode($response, true);

    return isset($responseData['privilege']) ? (int) $responseData['privilege'] : 4;

}
function RandomColor() {
    // Make sure each color component is at least 80 (to avoid dark colors)
    $r = rand(80, 255);
    $g = rand(80, 255);
    $b = rand(80, 255);

    return sprintf('#%02X%02X%02X', $r, $g, $b);
}

//END List OF Functions

session_start([
    'cookie_lifetime' => 600,
    'cookie_httponly' => true, 
    'cookie_secure' => true, 
]);

if(isset($_SESSION['nickname']) && $_SESSION['color']){
    header("Location: /index.php");
}

if ($_SERVER["REQUEST_METHOD"] != "POST"){
    echo "This is not your fault";
    header("Location: ../login.php");
}

// login details
$nickname = $_POST['nickname'];
$adminpassword = $_POST['admin'] ?? "none";
$color = isset($_POST['color_random']) ? RandomColor() : $_POST['color'];

//remove html chracter
$nickname = sanitize($nickname);
$adminpassword = sanitize($adminpassword);
$color = sanitize($color);

if($adminpassword != "none"){
    $privilageLevel = privilage($adminpassword);
}else{
    $privilageLevel = 4; //default user privilage
}

//generate symbol
switch($privilageLevel){
    case 1:
        $symbol = " **";
        break;
    case 2:
        $symbol = " *";
        break;
    case 3:
        $symbol = " /*";
        break;
    default:
        $symbol = null;
}


//set session variables
$_SESSION['nickname'] = $nickname;
$_SESSION['color'] = $color;
$_SESSION['privilage'] = $privilageLevel; //set user prvilage
if($symbol != null){
    $_SESSION['symbol'] = $symbol;
}
$_SESSION['cFID'] = "MAJOR";

// save user details for update userlist, now we use txt file but after used memory databse
$entry = json_encode([
    "username" => $nickname,
    "color" => $color,
    "priv" => $privilageLevel, //this is for only show others to his privilage
    "status" => 'ok',
]) . "\n";


$redis->hMSet("user:$nickname", [
    "color" => $color,
    "priv" => $privilageLevel,
    "status" => 'ok',
    "last_seen" => time()
]);


$channelFID = "MAJOR";
$channelKey = "channel:$channelFID";

// Check if the channel already exists
if (!$redis->exists($channelKey)) {
    $channelData = [
        "name" => "Magor Channel",
        "type" => "Public",
        "description" => "Talk about anything here"
    ];
    $redis->hMSet($channelKey, $channelData);
}


$redis->hSet("channel:$channelFID:users", $nickname, $privilageLevel);
$redis->sAdd("user:$nickname:channels", $channelFID);

header("Location: /index.php");









// $userFile = "users.txt";

// if(isset($_SESSION['nickname']) && $_SESSION['color']){
//     header("Location: ../index.php");
// }

// function isColorNearBlack($hexColor) {
//     // Remove the hash (#) if it's present
//     $hexColor = ltrim($hexColor, '#');

//     // Check if the hex color is valid (6 characters)
//     if (strlen($hexColor) !== 6) {
//         return false; // Invalid color
//     }

//     // Convert hex to RGB
//     $r = hexdec(substr($hexColor, 0, 2));
//     $g = hexdec(substr($hexColor, 2, 2));
//     $b = hexdec(substr($hexColor, 4, 2));

//     // Define a threshold (e.g., 50)
//     $threshold = 50;

//     // Check if the RGB values are all below the threshold
//     return ($r < $threshold && $g < $threshold && $b < $threshold);
// }



// if ($_SERVER["REQUEST_METHOD"] == "POST"){

//     $nickname = $_POST['nickname'];
//     $adminpassword = $_POST['admin'] ?? "none";
//     $color = $_POST['color'];

//     function sanitizeNickname($input, $type) {

//         if($type == "name") {
//             return preg_match('/[;\'"\\/]/', $input) != 1;
//         }elseif($type == "color"){
//             return preg_match('/^#[A-Fa-f0-9]{6}$/', $input) === 1;
//         }
        
//     }
// }

// if(!sanitizeNickname($nickname,"name") || strlen($nickname) > 15 || empty($nickname)){

//     $nickname = "fucker";

// }else{
//     $nickname = trim($nickname);
// }

// if(!sanitizeNickname($color,"color") || isColorNearBlack($color)){

//     $color = "#585858";

// }else{
//     $color = $color;
// }

// if(sanitizeNickname($adminpassword,"name")){

//     $_SESSION['admin'] = password_hash($adminpassword, PASSWORD_DEFAULT);

// }



// // Generate a unique ID for the user
// $userId = uniqid(); // Generates a unique ID based on the current time in microseconds


// $_SESSION['nickname'] = $nickname;
// $_SESSION['color'] = $color;
// $_SESSION['id'] = $userId;

// #$_SESSION['ACTIVE'] = time();

// $entry = json_encode([
//     "id" => $userId,
//     "username" => $nickname,
//     "color" => $color,
//     "admin" => password_hash($adminpassword, PASSWORD_DEFAULT),
//     "status" => "ok"
// ]) . "\n";


// file_put_contents($userFile, $entry, FILE_APPEND);

// header("Location: ../index.php");


