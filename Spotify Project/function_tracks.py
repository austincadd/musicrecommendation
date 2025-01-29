#!C:/Users/austi/AppData/Local/Programs/Python/Python312/python.exe

import cgi



form = cgi.FieldStorage()
album_name = form.getvalue("album_name")
artist_name = form.getvalue("artist_name")
'''
selected_albums = form.getvalue("SELECTED_ALBUMS", "")
'''

print("Content-Type:text/html")
print("Location: tracks.php?result={},{}".format(album_name,artist_name))
print()