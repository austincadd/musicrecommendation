<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if selected tracks are submitted
    if (isset($_POST['Add_to_Playlist'])) {
        // Get the selected tracks
        $selected_tracks = $_POST['Add_to_Playlist'];
        $album_name = $_POST['album_name'];
        $artist_name = $_POST['id'];
        // Process the selected tracks (for demonstration, just echoing here)
        echo "Album Name: " . htmlspecialchars($album_name) . "<br>";
        echo "Artist Name: " . htmlspecialchars($artist_name) . "<br>";
        foreach ($selected_tracks as $track) {
            $outputs = shell_exec("C:/Users/austi/AppData/Local/Programs/Python/Python312/python.exe -c \"import main; print(main.insert_track_info('$album_name', '$artist_name', '$track'))\" 2>&1");
            echo $outputs;
            // Perform any action with the selected tracks, such as saving to a database
            echo "Selected track: " . htmlspecialchars($track) . "<br>";
            // You can perform any other actions here, such as saving to a database
        }
    } else {
        // No tracks selected
        echo "No tracks selected.";
    }
} else {
    // Form not submitted
    echo "Form not submitted.";
}
header("Location: homepage.php");
?>