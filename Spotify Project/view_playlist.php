<?php
$servername = "localhost";
$username = "root";
$password = "Mezcal";
$database = "MoodMix";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$error_message = "";
$playlist_id = $_GET['playlist_id'];
$variable2 = $_GET['playlist_id'];

$query = "SELECT User_ID, Name FROM playlists WHERE Playlist_ID = $playlist_id";

$result = mysqli_query($connection, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    
    if ($row) {
        $user_id = $row['User_ID'];
        $name = $row['Name'];
        
        
    } else {
        echo "No playlist found with ID: $playlist_id";
    }
} else {
    echo "Error: " . mysqli_error($connection);
}

mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Playlist</title>
</head>
<body>

<h1>View Playlist</h1>
<?php

    echo "<p>User ID: $user_id</p>";
    echo "<p>Name: $name</p>";


?>

</body>
</html>
