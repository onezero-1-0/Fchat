<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/style.css">
    <style>
        body {
            background-color: black; /* Dark background */
            color: #fff; /* Light text color for contrast */
            font-family: 'Courier New', Courier, monospace; /* Monospaced font for a "terminal" feel */
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .chatbox {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full screen height */
        }

        .msg_send_form {
            width: 100%;
            padding: 15px;
            display: flex;
            flex-direction: column;
        }

        .form_item_box {
            position: relative;
            width: 100%;
        }

        #usermessage {
            width: 100%; /* Make the input take most of the space */
            padding: 12px;
            background-color: #333; /* Darker input background */
            border: none;
            border-radius: 5px;
            color: #fff; /* Light text color */
            font-size: 16px;
            box-sizing: border-box; /* Ensure padding is included in width */
        }

        #usermessage:focus {
            outline: none;
            background-color: #444; /* Lighter background on focus */
        }

        .send_button {
            position: absolute;
            right: 0%;
            top: 50%;
            transform: translateY(-50%); /* Center vertically */
            background-color: #999; /* Bright green button color */
            color: #121212; /* Dark text on button */
            border: none;
            padding: 10px 15px;
            font-size: 17px;
            cursor: pointer;
            transition: background-color 0.3s ease; /* Smooth transition on hover */
        }

        .send_button:hover {
            background-color: #111; /* Darker green on hover */
            color: white;
        }

        .send_button:active {
            background-color: #333; /* Even darker green when clicked */
        }
    </style>
</head>
<body>

    <div class="chatbox">
        <form action="/api/sendChat.php" method="POST" class="msg_send_form">

            <div class="form_item_box">
                <input type="text" name="message" id="usermessage" placeholder="Enter Message" required>
                <input type="submit" class="send_button" value="➤">
            </div>

        </form>
    </div>

</body>
<?php ?>