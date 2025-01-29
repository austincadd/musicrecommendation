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
if(isset($_POST['searchText'])) {
    $searchText = $_POST['searchText'];

    // Perform a SELECT query to search for tracks matching the search text
    $query = "SELECT * FROM tracks WHERE Name LIKE '%$searchText%'";
    $result = mysqli_query($connection, $query);

    if(mysqli_num_rows($result) > 0) {
        echo "<ul>";
        while($row = mysqli_fetch_assoc($result)) {
            echo "<li>" . $row['Name'] . "</li>";
        }
        echo "</ul>";
    } else {
        echo "No matching tracks found";
    }
}
?>