<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .channel_container {
            width: 40vw;
            background-color: none;

            padding: 20px;

            margin: 20vh auto auto auto;
        }
        h1 {
            font-size: 2.8rem;
            text-align: center;
            color: white;
        }
        label {
            font-size: 1.8rem;
            margin-bottom: 8px;
            color: white;
            display: block;
        }
        input {
            font-size: 1.7rem;

            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            box-sizing: border-box; /* Ensures padding is included in width */
        }
        .submit-btn {
            width: 100%;
            padding: 0.7rem;
            background-color: gray;
            color: white;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            border-radius: 4px;
        }
        .submit-btn:hover {
            background-color: #999;
        }
        .back-btn {
            font-size: 1.8rem;
            position: absolute;
            top: 1rem;
            left: 0.5rem;
            padding: 8px 16px;
            background-color: gray;
            color: white;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }
        .back-btn:hover {
            background-color: #999;
        }
    </style>
</head>
<body style="background-color: black;">
    <div class="back-btn"><a href="/index.php">Back To Home</a></div>
    <div class="channel_container">
        <h1>Join a Channel</h1>
        <form action="/proccess/channelprocess.php" method="POST">
            <label for="channel_name">Channel F I D</label>
            <input type="hidden" name="action" value="join">
            <input type="text" name="channel_FID" placeholder="Enter channel FID" required>


            <button type="submit" class="submit-btn">Join Channel</button>
        </form>
    </div>
    
</body>
</html>