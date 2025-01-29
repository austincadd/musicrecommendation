<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome New User</title>
</head>
<body>

<?php
// Check if the name parameter is provided in the URL
if(isset($_GET['name'])) {
    // Get the name of the new user from the URL parameter
    $new_user_name = $_GET['name'];
    // Display the welcome message
    echo "<h2>Welcome, $new_user_name!</h2>";
} else {
    // If name parameter is not provided, display a generic message
    echo "<h2>Welcome New User!</h2>";
}
?>

<p>You have successfully created an account. Make sure to save your credentials.</p>
<form action="homepage.php" method="get">
    <input type="hidden" name="name" value="<?php echo isset($_GET['name']) ? $_GET['name'] : ''; ?>">
    <button type="submit">Homepage</button>
</form>
</body>
</html>
