<?php
if (isset($_GET["songName"]) && isset($_GET["artistName"])) {
    $songName = $_GET["songName"];
    $artistName = $_GET["artistName"];
    
    // Replace with the actual path to your Python executable and script
    $pythonScript = "C:/Users/austi/AppData/Local/Programs/Python/Python312/python.exe";
    $pythonCommand = "-c \"import main; print(main.insert_track_No_album('$songName', '$artistName'))\"";
    
    // Execute the Python script and capture the output
    $output = shell_exec("$pythonScript $pythonCommand 2>&1");
    
    // Output the result
    echo $output;
} else {
    echo "Invalid request.";
}
header("Location: homepage.php");

?>