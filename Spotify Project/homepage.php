<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MoodMix - User Homepage</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 50px 20px;
        }
        h1 {
            font-size: 36px;
            margin-bottom: 20px;
            color: #007bff;
            text-shadow: 2px 2px 2px rgba(0, 0, 0, 0.1); /* Add subtle text shadow */
        }
        .options-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 40px;
        }
        .option-box {
            flex: 1;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 30px;
            margin: 0 10px 20px;
            font-size: 18px;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .option-box:hover {
            transform: translateY(-5px); /* Add hover effect */
        }
        .option-box a {
            text-decoration: none;
            color: #333;
        }
        .option-box h3 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .option-box p {
            margin-bottom: 0;
        }
        .option-box button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .option-box button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <?php
    // Check if the username is provided in the POST or GET data
    if(isset($_POST['username'])) {
        $username = $_POST['username'];
        echo "<h1>Welcome back, $username!</h1>";
    } elseif(isset($_GET['name'])) {
        $username = $_GET['name'];
        echo "<h1>Welcome back, $username!</h1>";
    } elseif(isset($_GET['result'])) {
        $username = $_GET['result'];
        echo "<h1>Welcome, $username!</h1>";
    }
    ?>

    <div class="options-container">
        <div class="option-box">
            <h3>View/Edit Playlists</h3>
            <p>Manage your playlists easily</p>
            <form method="post" action="view_playlists.php">
                <input type="hidden" name="username" value="<?php echo $username; ?>">
                <button type="submit">Go</button>
            </form>
        </div>

        <div class="option-box">
            <h3>Find Artist Discography</h3>
            <p>Explore the discographies of your favorite artists</p>
            <form action="function_calls.py" method="post">
                <input type="text" name="id" placeholder="Enter Artist Name">
                <button type="submit" name="button1">Go</button>   
            </form>
        </div>

        <div class="option-box">
            <h3>Recommend Music by Artist</h3>
            <p>Discover new music recommendations</p>
            <form action="recommend_calls.py" method="post">
                <input type="text" name="id" placeholder="Enter Artist Name">
                <button type="submit" name="button2">Go</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
