<?php
$servername = "localhost";
$username = "root";
$password = "Mezcal";
$database = "MoodMix";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";
if(isset($_POST['username'])) {
    $username = $_POST['username'];
}
$query = "SELECT USER_ID FROM users WHERE name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username); 
$stmt->execute();
$stmt->bind_result($user_id);
$your_id = $user_id;
if ($stmt->fetch()) {
    echo "USER_ID for $username is: $user_id";
}
$stmt->close();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Name"])) {
    $playlist_name = $_POST["Name"];
    $sql = "INSERT INTO playlists (Name, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $playlist_name, $user_id);
    if ($stmt->execute()) {
        // Redirect to refresh the page
        
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

$query1 = "SELECT * FROM playlists WHERE USER_ID = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("i", $user_id);
if ($stmt1->execute()) {
    $result = $stmt1->get_result();

    if (mysqli_num_rows($result) > 0) {
        echo "<div class='container'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $playlist_id = $row['Playlist_ID'];
            $playlist_name = $row['Name'];

            echo "<div class='playlist'>";
            echo "<span class='playlist-name'>$playlist_name</span>";

            echo "<button onclick='redirectToViewPlaylist($playlist_id, \"$your_id\", \"$playlist_id\")'>View</button>";
            echo "<script>
                    function redirectToViewPlaylist(playlist_id, your_id, playlist_id) {
                        var url = 'view_playlist.php?playlist_id=' + playlist_id;
                        url += '&your_id=' + encodeURIComponent(your_id);
                        url += '&playlist_id=' + encodeURIComponent(playlist_id);
                        window.location = url;
                    }
                </script>";

            echo "<button onclick='redirectToEditPlaylist($playlist_id, \"$your_id\", \"$playlist_id\")'>Edit</button>";
            echo "<script>
                    function redirectToEditPlaylist(playlist_id, your_id, playlist_id) {
                        var url = 'edit_playlist.php?playlist_id=' + playlist_id;
                        url += '&your_id=' + encodeURIComponent(your_id);
                        url += '&playlist_id=' + encodeURIComponent(playlist_id);
                        window.location = url;
                    }
                </script>";
            echo "<button onclick='deletePlaylist($playlist_id)'>Delete</button>";
            echo "<input type='text' class='combine-input' placeholder='Combine with...'>";
            echo "<button onclick='combinePlaylists($playlist_id)'>Combine</button>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        // If no playlists found
        echo "<p>No playlists found.</p>";
    }
} else {
    echo "Error: " . $stmt->error;
}
$stmt1->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Music</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 50%;
            margin: 0 auto;
            text-align: center;
        }
        .playlist {
            margin-bottom: 20px;
        }
        .playlist-name {
            font-size: 20px;
            font-weight: bold;
            margin-right: 10px;
        }
        button {
            padding: 8px 16px;
            margin-right: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .combine-input {
            margin-right: 10px;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create New Playlist</h2>
        <form action="redirect_calls.py" method="post">
            <input type="text" placeholder="Playlist Name" name="playlist_name">
            <input type="hidden" name="username" value="<?php echo $username; ?>">
            <input type="submit" value="Create Playlist">
        </form>

        <form action="homepage.php" method="post">
            <input type="hidden" name="name" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
            <input type="submit" value="Homepage">
        </form>
    </div>

    <script>
        function viewPlaylist(id) {
            alert("View Playlist " + id);
        }

        function editPlaylist(id) {
            alert("Edit Playlist " + id);
        }

        function deletePlaylist(id) {
            if (confirm("Are you sure you want to delete this playlist?")) {
                $.ajax({
                    url: 'C:\xampp\htdocs\py_files\delete_playlist.php', 
                    type: 'POST',
                    data: { playlist_id: id }, 
                    success: function(response) {
                        
                        alert(response);
                        
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                        alert("An error occurred while deleting the playlist.");
                    }
                });
            }
        }
    </script>
</body>
</html>

<?php

mysqli_close($conn);
?>
