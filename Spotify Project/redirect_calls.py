#!C:/Users/austi/AppData/Local/Programs/Python/Python312/python.exe


import cgi
import mysql.connector

connection = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="Mezcal",
    database="MoodMix"
)
cursor = connection.cursor()

# Retrieve user_id based on the username
form = cgi.FieldStorage()
username = form.getvalue("username")

query = "SELECT USER_ID FROM users WHERE name = %s"
cursor.execute(query, (username,))
user_id_result = cursor.fetchall()
if user_id_result:
    user_id = user_id_result[0][0]

    # Insert playlist into the database
    playlist_name = form.getvalue("playlist_name")
    insert_query = "INSERT INTO playlists (USER_ID, Name) VALUES (%s, %s)"
    playlist_data = (user_id, playlist_name)
    cursor.execute(insert_query, playlist_data)
    connection.commit()

print("Content-Type:text/html")
print("Location: homepage.php?result={}".format(username))
print()
print("<html>")
print("<head>")
print("<title>Redirecting...</title>")
print("</head>")
print("<body>")
print("<h1>Playlist created successfully!</h1>")
print("</body>")
print("</html>")