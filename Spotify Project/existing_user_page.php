<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Existing User Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .container {
            width: 500px; /* Increase width of container */
            padding: 20px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        label {
            font-weight: bold;
            font-size: 18px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Existing User Login</h2>

    <form method="post">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>

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

        // SQL query to select user with the given name and password
        $sql = "SELECT * FROM Users WHERE Name = '$name' AND Password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User is validated, redirect to a new blank page
            $new_user_name = $name;
            header("Location: homepage.php?name=" . urlencode($new_user_name));
            exit;
        } else {
            // Invalid credentials, set error message
            $error_message = "Error: Invalid username or password. Please try again.";
        }
    }

    // Display error message if present
    if (!empty($error_message)) {
        echo "<p class='error'>$error_message</p>";
    }

    // Close the database connection
    $conn->close();
    ?>
</div>

</body>
</html>