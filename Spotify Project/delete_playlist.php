<?php

// Check if the playlist ID is provided in the POST data
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["playlist_id"])) {
    
    // Get the playlist ID from the POST data
    $playlist_id = $_POST["playlist_id"];

    // Perform the deletion operation
    // Replace this with your actual database connection and query
    $servername = "localhost";
    $username = "root";
    $password = "Mezcal";
    $database = "MoodMix";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the delete statement
    $query = "DELETE FROM playlists WHERE Playlist_ID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $playlist_id);

    // Execute the delete statement
    if ($stmt->execute()) {
        // Deletion successful
        echo "Playlist deleted successfully.";
    } else {
        // Deletion failed
        echo "Error deleting playlist: " . $conn->error;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
    } else {
    // Playlist ID not provided or invalid request
    echo "Invalid request.";
} 
}
?>