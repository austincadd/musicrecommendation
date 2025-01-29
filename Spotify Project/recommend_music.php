<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Track List</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .song-container {
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .artist-header {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 24px;
            color: #333;
        }
        .song-list {
            list-style-type: none;
            padding-left: 0;
        }
        .song-item {
            margin-bottom: 5px;
            cursor: pointer; /* Add pointer cursor to indicate clickable */
            font-size: 18px;
            color: #666;
            transition: color 0.3s;
        }
        .song-item:hover {
            text-decoration: underline; /* Add underline on hover to indicate clickable */
            color: #007bff;
        }
    </style>
</head>
<body>
    <div align="center">
        <?php
        if (isset($_GET['result'])) {
            $result = $_GET['result'];
            
            $output = shell_exec("C:/Users/austi/AppData/Local/Programs/Python/Python312/python.exe -c \"import main; print(main.print_related_artists('$result'))\" 2>&1");
            
            $s1 = ['[', ']', "'"];
            $r1 = ['', '', ''];
            $artists = str_replace($s1, $r1, $output);
            $related_artists = explode(",", $artists, 5);
            
            foreach($related_artists as $related_artist){
                echo "<div class='song-container'>";
                echo "<h2 class='artist-header'>$related_artist</h2>";
                
                $output2 = shell_exec("C:/Users/austi/AppData/Local/Programs/Python/Python312/python.exe -c \"import main; print(main.get_artist_tracks('$related_artist'))\" 2>&1");
                
                $s2 = ['[', ']', "'"];
                $r2 = ['', '', ''];
                $songs = str_replace($s1, $r1, $output2);
                $top_songs = explode(",", $songs); 
                
                echo "<ul class='song-list'>";
                foreach($top_songs as $top_song){
                    // Escape single quotes in song name for JavaScript
                    $escaped_song_name = addslashes($top_song);
                    $escaped_artist_name = addslashes($related_artist);
                    echo "<li class='song-item' onclick=\"playSong('$escaped_song_name', '$escaped_artist_name')\">$top_song</li>";
                }
                echo "</ul>";
                
                echo "</div>"; // Close song-container
            }
        }
        ?>
    </div>

    <script>
    function playSong(songName, artistName) {
        // Construct the URL with query parameters
        header("Location: homepage.php");

        var url = 'execute_python_script.php?songName=' + encodeURIComponent(songName) + '&artistName=' + encodeURIComponent(artistName);
        
        // Redirect to the PHP script
        window.location.href = url;
    }
</script>
</body>
</html>
