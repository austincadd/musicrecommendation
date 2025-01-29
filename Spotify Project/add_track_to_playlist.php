<?php
$servername = "localhost";
$username = "root";
$password = "Mezcal";
$database = "MoodMix";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}


    $trackId = $_POST['trackId']; 
    $playlistId = $_POST['playlistId']; 
    
    $query = "INSERT INTO playlist_tracks (Playlist_ID, Track_ID) VALUES ('$playlistId', '$trackId')";
    $result = mysqli_query($connection, $query);

    if($result) {
        echo "Track added to playlist successfully!";
    } else {
        echo "Error: " . mysqli_error($connection);
    }

mysqli_close($connection);
?>
