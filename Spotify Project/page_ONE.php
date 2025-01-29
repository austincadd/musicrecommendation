<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        label {
            font-size: 16px;
        }
        input[type="radio"] {
            margin-right: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>MoodMix</h2>

    <!-- Form to select existing or new user -->
    <form method="post">
        <label>Lets Get Set Up</label><br>
        <input type="radio" id="existing" name="user_type" value="existing">
        <label for="existing">Existing User</label><br>
        <input type="radio" id="new" name="user_type" value="new">
        <label for="new">New User</label><br><br>
        <input type="submit" value="Go">
    </form>

    <?php
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the selected user type
        $user_type = $_POST['user_type'];

        // If user selects 'Existing User', redirect to existing user page
        if ($user_type === "existing") {
            header("Location: existing_user_page.php");
            exit;
        }
        // If user selects 'New User', redirect to new user page
        elseif ($user_type === "new") {
            header("Location: new_user_page.php");
            exit;
        }
    }
    ?>

</div>

</body>
</html>