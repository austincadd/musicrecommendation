import mysql.connector

def insert_Album(artist_name, album_name, album_type, release_date):
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

        # Check if the album already exists in the database
        check_query = "SELECT COUNT(*) FROM Albums WHERE Name = %s"
        cursor.execute(check_query, (album_name,))
        album_count = cursor.fetchone()[0]

        if album_count > 0:
            return "Album already exists in the database."
        
        artist_query = "SELECT Artist_ID FROM Artists WHERE Name = %s"
        cursor.execute(artist_query, (artist_name,))
        artist_result = cursor.fetchall()

        if artist_result:
            artist_id = artist_result[0][0]
        else:
            return "Artist not found."
        # Execute an INSERT query to insert the new album
        insert_query = """
            INSERT INTO Albums (Artist_ID, Name, Album_Type, Release_Date) 
            VALUES (%s, %s, %s, %s)
        """
        album_data = (artist_id, album_name, album_type, release_date)
        cursor.execute(insert_query, album_data)

        # Commit the transaction
        connection.commit()
        print("Album inserted successfully!")
        return "Album inserted successfully!"

    except mysql.connector.Error as err:
        # Handle MySQL errors
        print("An error occurred:", err)

    finally:
        # Close the cursor and connection in the finally block
        if 'cursor' in locals() and cursor is not None:
            cursor.close()
            
        if 'connection' in locals() and connection is not None:
            connection.close()