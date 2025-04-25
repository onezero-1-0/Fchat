<?php

session_start();



if(isset($_SESSION['nickname']) && $_SESSION['color']){
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fchat</title>
    <link rel="stylesheet" href="static/style.css">
</head>
<body style="background-color: black;overflow: auto;">
    <div class="login_container">
    	<span class="h3_head" style="font-family: 'Courier New', Courier, monospace;color: red;text-shadow: 0 0 10px red, 0 0 20px red, 0 0 30px red;">This is for testing purposes and to collect users' experiences. For now, you cannot create private channels, only public channels. The app will only run for a specific period initially, and after that, it will run 24/7 Day.</span>
        <div class="title h1_head">Welcome To FChat</div>

        <div class="login_form" style="height: 29vh;">
            <form action="proccess/loginprocess.php" method="POST">

                <div class="form_item_name">
                    <label>Nickname</label>
                    <input type="text" name="nickname" placeholder="Enter Username" required>
                </div>

                <div class="form_item_color">
                    <label>color</label>
                    <input type="color" name="color">
                    <label>||</label>
                    <label>random</label>
                    <input type="checkbox" name="color_random" checked>
                </div>

                <div class="form_item_submit">
                    <input type="submit" value="Start">
                </div>

                <div style="display: flex; align-items: flex-end; justify-content: center; margin-top: 10rem;">
                    <input type="text" name="admin" placeholder="privilage pass if available" st>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
