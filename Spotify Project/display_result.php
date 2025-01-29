<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Artist Discography</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 40px 20px;
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 10px;
            color: #007bff;
        }
        h3 {
            margin-bottom: 5px;
        }
        .column {
            float: left;
            width: 33.33%;
        }
        .clearfix {
            clear: both;
        }
        p {
            margin: 5px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #ccc;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }
        input[type="text"],
        input[type="submit"] {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    // Check if the artist info is provided
    if (isset($_GET['result'])) {
        // Extract artist info
        $result = $_GET['result'];
        $output = shell_exec("C:/Users/austi/AppData/Local/Programs/Python/Python312/python.exe -c \"import main; print(main.print_artist_info('$result'))\" 2>&1");
        $output2 = shell_exec("C:/Users/austi/AppData/Local/Programs/Python/Python312/python.exe -c \"import main; print(main.get_artist_id('$result'))\" 2>&1");
        $output3 = shell_exec("C:/Users/austi/AppData/Local/Programs/Python/Python312/python.exe -c \"import main; print(main.artist_info_helper('$result'))\" 2>&1");

        $artist_ID = $output2;
        $s1 = ['[', ']', "'", '(', ')', ",'"];
        $r1 = ['', '', '', '', '', '*'];
        $albums = str_replace($s1, $r1, $output3);
        $returned_albums = explode("/,", $albums);

        list($artist_name, $genre) = explode(',', $output, 2);
        $s2 = ['.', '(', "'", ')'];
        $r2 = ['', '', '', ''];
        $name = str_replace($s2, $r2, $artist_name);
        $genre_X = str_replace('.', ',', $genre);
        $genre_Y = str_replace($s2, $r2, $genre_X);
        echo "<h2>$name's Discography</h2><br>";
        echo "<h3>$genre_Y</h3><br>";

        echo "<ul style='line-height: 100%;'>";
        ?>
    </p>

    <div class="column">
        <h3>Album Name</h3>
        <?php
        // Loop through each returned album
        foreach ($returned_albums as $album_info) {
            // Split the string into album name, release date, and album type
            list($album_name, $release_date, $album_type) = explode('/', $album_info);
            // Print album name
            echo "<p>" . htmlspecialchars($album_name) . "</p>";
        }
        ?>
    </div>
    <div class="column">
        <h3>Release Date</h3>
        <?php
        // Loop through each returned album
        foreach ($returned_albums as $album_info) {
            // Split the string into album name, release date, and album type
            list($album_name, $release_date, $album_type) = explode('/', $album_info);
            // Print release date
            echo "<p>" . htmlspecialchars($release_date) . "</p>";
        }
        ?>
    </div>
    <div class="column">
        <h3>Album Type</h3>
        <?php
        // Loop through each returned album
        foreach ($returned_albums as $album_info) {
            // Split the string into album name, release date, and album type
            list($album_name, $release_date, $album_type) = explode('/', $album_info);
            // Print album type
            echo "<p>" . htmlspecialchars($album_type) . "</p>";
        }
        ?>
    </div>

    <div class="clearfix"></div>
    <?php
        echo "</ul>";
    }
    ?>

    <form action="function_tracks.py" method="post">
        <label for="album_name">Enter Album Name:</label>
        <input type="text" id="album_name" name="album_name" required>
        <input type="hidden" name="artist_name" value= "<?php echo $name; ?>">
        <input type="submit" value="Get Tracks">
    </form>
</div>
</body>
</html>
