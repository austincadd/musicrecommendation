import mysql.connector

def insert_Artist(artist_name, genre):
    try:
        connection = mysql.connector.connect(
            host="localhost",
            user="root",
            passwd="Mezcal",
            database="MoodMix"
        )

        cursor = connection.cursor()

        # Check if the artist already exists in the database
        check_query = "SELECT COUNT(*) FROM Artists WHERE Name = %s"
        cursor.execute(check_query, (artist_name,))
        artist_count = cursor.fetchone()[0]

        if artist_count > 0:
            return "Artist already exists in the database."

        insert_query = "INSERT INTO Artists (Name, Genre) VALUES (%s, %s)"
        cursor.execute(insert_query, (artist_name, genre))

        connection.commit()
        return "Data inserted successfully!"

    except mysql.connector.Error as err:
        # Handle MySQL errors
        print("An error occurred:", err)

    finally:
        # Close the cursor and connection in the finally block
        if 'cursor' in locals() and cursor is not None:
            cursor.close()
        if 'connection' in locals() and connection is not None:
            connection.close()