from dotenv import load_dotenv
import os
from addArtist import insert_Artist
from addAlbum import insert_Album
from addTrack import insert_Track
import base64
import requests
from requests import post, get
import json



load_dotenv()

clientID = os.getenv("CLIENT_ID")
clientSecret = os.getenv("CLIENT_SECRET")


def get_token():
    auth_string = str(clientID) + ':' + str(clientSecret)
    auth_bytes = auth_string.encode("utf-8")
    auth_base64 = str(base64.b64encode(auth_bytes), "utf-8")
    
    url = "https://accounts.spotify.com/api/token"
    headers = {
        "Authorization" : "Basic " + auth_base64,
        "Content-Type" : "application/x-www-form-urlencoded"
    }
    data = {"grant_type" : "client_credentials"}
    result = post(url, headers = headers, data=data)
    json_result = json.loads(result.content)
    token = json_result["access_token"]
    return token

def get_auth_header(token):
    return {"Authorization": "Bearer " + token}

def search_for_artist(token, artist_name):
    url = "http://api.spotify.com/v1/search"
    headers = get_auth_header(token)
    query = f"q={artist_name}&type=artist&limit=1"

    query_url = url + "?" + query
    result = get(query_url, headers=headers)
    json_result = json.loads(result.content)["artists"]["items"]
    if len(json_result) == 0:
        print("NO artists with this name exists...")
        return None
    
    return json_result[0]

def get_songs_by_artist(token, artist_id):
    url = f"http://api.spotify.com/v1/artists/{artist_id}/top-tracks?country=US"
    headers = get_auth_header(token)
    result = get(url, headers=headers)
    json_result = json.loads(result.content)["tracks"]
    return json_result

def get_artist_name(token, artist_id):
    url = f"https://api.spotify.com/v1/artists/{artist_id}"
    headers = get_auth_header(token)
    response = requests.get(url, headers=headers)
    artist_info = response.json()
    artist_name = artist_info.get('name')
    return artist_name

def get_artist_albums(token, artist_id):
    url = f"https://api.spotify.com/v1/artists/{artist_id}/albums"
    headers = get_auth_header(token)
    response = requests.get(url, headers=headers)
    data = response.json()
    albums = data.get('items', [])
    return albums

def get_album_id(token, album_name, artist_name):
    query = f"album:{album_name} artist:{artist_name}"
    url = "https://api.spotify.com/v1/search"
    headers = get_auth_header(token)
    params = {
        'q': query,
        'type': 'album'
        
    }
    response = requests.get(url, params=params, headers=headers)
    data = response.json()
    if data['albums']['items']:
            album_id = data['albums']['items'][0]['id']
            return album_id
    else:
        
        return None
    

def get_album_info(token, album_id):
    url = f"https://api.spotify.com/v1/albums/{album_id}"
    headers = get_auth_header(token)
    response = requests.get(url, headers=headers)
    album_info = response.json()
    album_type = album_info.get('album_type')
    release_date = album_info.get('release_date')
    return release_date, album_type

def get_track_genres(token, track_id):
    url = f"https://api.spotify.com/v1/tracks/{track_id}"
    headers = get_auth_header(token)
    response = requests.get(url, headers=headers)
    data = response.json()
    genres = data.get('genres', [])
    return genres

def get_album_tracks(token, album_id):
    url = f"https://api.spotify.com/v1/albums/{album_id}/tracks"
    headers = get_auth_header(token)
    response = requests.get(url, headers=headers)
    data = response.json()
    tracks = data.get('items', [])
    return tracks 

def get_album_tracksINFO(token, album_id):
    url = f"https://api.spotify.com/v1/albums/{album_id}/tracks"
    headers = get_auth_header(token)
    response = requests.get(url, headers=headers)
    data = response.json()
    tracks = data.get('items', [])

    track_details = []
    for track in tracks:
        
        track_name = track['name']
        duration_ms = track['duration_ms']
         
        track_details.append((track_name, duration_ms))

    return track_details

def get_duration(token, album_id, tracks_name):
    url = f"https://api.spotify.com/v1/albums/{album_id}/tracks"
    headers = get_auth_header(token)
    response = requests.get(url, headers=headers)
    data = response.json()
    tracks = data.get('items', [])

    track_details = []
    for track in tracks:
        if(track['name'] == tracks_name):
            duration_ms = track['duration_ms']
            track_details.append((tracks_name, duration_ms))
    return track_details
    
def get_track_duration(token, track_name, album_name):
     # Construct the query to search for the track
    query = f"track:{track_name} album:{album_name}"
    url = "https://api.spotify.com/v1/search"
    headers = get_auth_header(token)
    params = {
        'q': query,
        'type': 'track'
    }
    response = requests.get(url, headers=headers, params=params)
    data = response.json()

    # Check if any tracks were found
    if 'tracks' in data and 'items' in data['tracks'] and data['tracks']['items']:
        # Extract the duration of the first track found
        track_info = data['tracks']['items'][0]
        duration_ms = track_info['duration_ms']
        return duration_ms
    else:
        return 0

def get_track_id(token, track_name, album_name, artist_id):
    query = f"track:{track_name} album:{album_name} artist:{artist_id}"
    headers = get_auth_header(token)
    # Spotify search endpoint URL
    url = "https://api.spotify.com/v1/search"
    params = {
        'q': query,
        'type': 'track'
        
    }
    response = requests.get(url, params=params, headers=headers)
    data = response.json()
    if data['tracks']['items']:
            track_id = data['tracks']['items'][0]['id']
            return track_id
    else:
        
        return None
    
def get_artist_genre(token, artist_id):
    url = f"https://api.spotify.com/v1/artists/{artist_id}"
    headers = get_auth_header(token)
    try:
        response = requests.get(url, headers=headers)
        if response.status_code == 200:
            artist_info = response.json()
            genres = artist_info.get('genres', [])
            genres_string = '. '.join(genres)
            return genres_string
        else:
            print(f"Error: {response.status_code} - {response.text}")
            return None
    except requests.exceptions.RequestException as e:
        print(f"Error: {e}")
        return None
    
def get_album_for_track(token, artist_id, track_name):
    url = f"https://api.spotify.com/v1/artists/{artist_id}/albums"
    headers = get_auth_header(token)
    response = requests.get(url, headers=headers)
    data = response.json()
    for album in data['items']:
        album_id = album['id']
        album_tracks_url = f"https://api.spotify.com/v1/albums/{album_id}/tracks"
        album_tracks_response = requests.get(album_tracks_url, headers=headers)
        album_tracks_data = album_tracks_response.json()
        for track in album_tracks_data['items']:
            if track['name'] == track_name:
               
                return album['name']
    
    
    
def get_related_artists(token, artist_id):
    url = f"https://api.spotify.com/v1/artists/{artist_id}/related-artists"
    headers = get_auth_header(token)
    response = requests.get(url, headers=headers)
    data = response.json()
    related_artists = [artist['name'] for artist in data['artists']]
    return related_artists
    

def print_artist_info(artist_name):
    token = get_token()
    result = search_for_artist(token, artist_name)
    artist_id = result["id"]
    artist_name = get_artist_name(token, artist_id)
    genre = get_artist_genre(token, artist_id)
    
    return artist_name, genre

def print_related_artists(artist_name):
    token = get_token()
    result = search_for_artist(token, artist_name)
    artist_id = result["id"]
    related_artists = get_related_artists(token, artist_id)
    return related_artists

def get_artist_id(artist_name):
    token = get_token()
    result = search_for_artist(token, artist_name)
    artist_id = result["id"]
    return artist_id

def artist_info_helper(artist_name):
    token = get_token()
    artist_id = get_artist_id(artist_name)
    albums = get_artist_albums(token, artist_id)
    album_names =[]
    for album in albums:
        album_id = get_album_id(token, album['name'], artist_name)
        release_date, album_type = get_album_info(token, album_id)
        album_info = f"{album['name']}/{release_date}/{album_type}/"
        album_names.append(album_info)
    return album_names


def get_track_info(album_name, artist_name):
    token = get_token()
    artist_id = get_artist_id(artist_name)
    album_id = get_album_id(token, album_name, artist_name,)
    tracks = get_album_tracks(token, album_id)
    track_list = []
    for track in tracks:
        track_list.append(track['name'] + "/")
    
    return track_list

def insert_track_info(album_name,  artist_name, track_name):
    token = get_token()
    artist_id = get_artist_id(artist_name)
    genres = get_artist_genre(token, artist_id)

    result = insert_Artist(artist_name, genres)
    
    album_id = get_album_id(token, album_name, artist_name)
    release_date, album_type = get_album_info(token, album_id)
    result1 = insert_Album(artist_name, album_name, album_type, release_date)
    
    album_tracks = get_album_tracksINFO(token, album_id)
    duration_ms = get_track_duration(token, track_name, album_name)
    insert_Track(album_name, track_name,duration_ms, genres)
            
    return result + result1

def insert_track_No_album(track_name, artist_name):
    token = get_token()
    artist_id = get_artist_id(artist_name)
    genres = get_artist_genre(token, artist_id)

    result = insert_Artist(artist_name, genres)
    album_name = get_album_for_track(token,artist_id, track_name)
    album_id = get_album_id(token, album_name, artist_name)
    release_date, album_type = get_album_info(token, album_id)
    result1 = insert_Album(artist_name, album_name, album_type, release_date)
    album_tracks = get_album_tracksINFO(token, album_id)
    duration_ms = get_track_duration(token, track_name, album_name)
    insert_Track(album_name, track_name,duration_ms, genres)
            
    return result1

def get_artist_tracks(artist_name):
    token = get_token()
    result = search_for_artist(token, artist_name)
    artist_id = result["id"]
    songs = get_songs_by_artist(token, artist_id)
    song_list = []
    for idx, song in enumerate(songs):
        song_list.append((f"{song['name']}"))
    return song_list

'''
    track_id = get_track_id(token, track_name, album_name, artist_id)
    token = get_token()
    #var = input("Enter an artist name: ")
    result = search_for_artist(token, artist_name)
    artist_id = result["id"]
    artist_name = get_artist_name(token, artist_id)
    songs = get_songs_by_artist(token, artist_id)
    genre = get_artist_genre(token, artist_id)
    albums = get_artist_albums(token, artist_id)

    for album in albums:
            print(album['name'])
    


    album_name = input("Which Album do you want to see the tracks from: ")
    album_id = get_album_id(token, artist_id, album_name)
    release_date, album_type = get_album_info(token, album_id)
    album_tracks = get_album_tracksINFO(token, album_id)


    for track_name, duration_ms in album_tracks:
            insert_Track(album_name, track_name,duration_ms, genre)
            print("Track Name:", track_name)
            print("Duration (ms):", duration_ms)
            print("Genre:", genre)
            print()


    tracks = get_album_tracks(token, album_id)
    for track in tracks:
        print(track['name'])
        
        
    print(release_date)
    print(album_type)
    #insert_Artist(artist_name, genre)
    #insert_Track(album_name, track_name,duration_ms,genres)
    #insert_Album(artist_name, album_name, album_type, release_date)
    print(f"Genre of Artist is: {genre}")

    
    for idx, song in enumerate(songs):
        print(f"{idx + 1}. {song['name']}")
'''
