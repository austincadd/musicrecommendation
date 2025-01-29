import mysql.connector

def insert_Track(album_name, name, duration, genre):
    try:
        # Establish a connection to the MySQL server
        connection = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="Mezcal",
            database="MoodMix"
        )

        # Create a cursor object
        cursor = connection.cursor()

        # Check if the track already exists in the database
        check_query = "SELECT COUNT(*) FROM Tracks WHERE Name = %s"
        cursor.execute(check_query, (name,))
        track_count = cursor.fetchone()[0]

        if track_count > 0:
            return "Track already exists in the database."

        # First, retrieve the album ID based on the album name
        query = "SELECT Album_ID FROM Albums WHERE Name = %s"
        cursor.execute(query, (album_name,))
        album_id_result = cursor.fetchall()

        if album_id_result:
            album_id = album_id_result[0][0]

            # Execute an INSERT query to insert the new track
            insert_query = """
                INSERT INTO Tracks (Album_ID, Name, Duration, Genre) 
                VALUES (%s, %s, %s, %s)
            """
            track_data = (album_id, name, duration, genre)
            cursor.execute(insert_query, track_data)

            # Commit the transaction
            connection.commit()
            return "Track inserted successfully!"
        else:
            return "Album not found."

    except mysql.connector.Error as err:
        # Handle MySQL errors
        print("An error occurred:", err)

    finally:
        # Close the cursor and connection in the finally block
        if 'cursor' in locals() and cursor is not None:
            cursor.close()
        if 'connection' in locals() and connection is not None:
            connection.close()