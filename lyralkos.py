import lyricsgenius
import config

def get_lyrics(title, artist, token):
    genius = lyricsgenius.Genius(token)

    search_query = f"{title} {artist}"
    search_results = genius.search_song(search_query)

    if search_results is None:
        return None
    
    return search_results.lyrics

def main():
    song_name = input("Enter the name of the song: ")
    artist_name = input("Enter the name of the artist: ")

    lyrics = get_lyrics(song_name, artist_name, config.GENIUS_ACCESS_TOKEN)
    
    if lyrics is None:
        print(f"Error: {song_name} performed by {artist_name} was not found.")
    else:
        print(lyrics)

if __name__ == '__main__':
    main()
