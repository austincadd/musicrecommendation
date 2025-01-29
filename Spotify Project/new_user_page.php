<?php
// Database connection parameters
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

// Initialize variables for error message and redirect URL
$error_message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve input values from the form
    $name = $_POST['name'];
    $password = $_POST['password'];

    // Check if username already exists in the database
    $sql_check_username = "SELECT * FROM Users WHERE Name = '$name'";
    $result_check_username = $conn->query($sql_check_username);

    if ($result_check_username->num_rows > 0) {
        // Username already exists, set error message
        $error_message = "Error: Username already exists. Please choose a different username.";
    } else {
        // Insert new user into the database
        $sql_insert_user = "INSERT INTO Users (Name, Password) VALUES ('$name', '$password')";
        if ($conn->query($sql_insert_user) === TRUE) {
            // New user registered successfully
            $new_user_name = $name;
            header("Location: welcome_new_user.php?name=" . urlencode($new_user_name));
            exit;
        } else {
            // Error occurred while inserting user, set error message
            $error_message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New User Page</title>
</head>
<body>

<h2>New User Registration</h2>

<form method="post">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>
    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Register">
</form>

<?php
// Display error message if present
if (!empty($error_message)) {
    echo "<p>$error_message</p>";
}
?>

</body>
</html>