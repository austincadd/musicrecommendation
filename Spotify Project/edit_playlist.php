<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Track to Playlist</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<?php
$playlist_id = $_GET['playlist_id'];
?>
<h1>Add Track to Playlist</h1>

<input type="text" id="searchInput" placeholder="Search tracks...">
<div id="searchResults"></div>


<form id="addTrackForm">
    <input type="hidden" id="playlistId" name="playlistId" value="<?php echo $playlist_id; ?>">
    <input type="hidden" id="trackId" name="trackId" value="">
    <input type="submit" value="Add Track to Playlist">
</form>

<script>
$(document).ready(function(){
    $('#searchInput').on('input', function(){
        performSearch($(this).val());
    });

    $('#searchInput').on('keydown', function(event){
        if(event.keyCode === 13) { 
            performSearch($(this).val());
        }
    });

    function performSearch(searchText) {
        if(searchText.length > 0) {
            $.ajax({
                url: 'search.php',
                method: 'POST',
                data: { searchText: searchText },
                success: function(response){
                    $('#searchResults').html(response);
                }
            });
        } else {
            $('#searchResults').html('');
        }
    }

    $('#addTrackForm').submit(function(e) {
        e.preventDefault(); 
        var trackId = $('#trackId').val();
        var playlistId = $('#playlistId').val();

        $.ajax({
            url: 'add_track_to_playlist.php',
            method: 'POST',
            data: {
                trackId: trackId,
                playlistId: playlistId
            },
            success: function(response){
                alert(response); 
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); 
            }
        });
    });
});
</script>

</body>
</html>
