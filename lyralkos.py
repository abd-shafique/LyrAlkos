import lyricsgenius
import config
from openai import OpenAI

client = OpenAI(api_key=config.OPENAI_API_KEY)


def get_lyrics(title, artist, token):
    genius = lyricsgenius.Genius(token)

    search_query = f"{title} {artist}"
    search_results = genius.search_song(search_query)

    if search_results is None:
        return None

    return search_results.lyrics


def analyze_lyrics(title, artist, lyrics):

    prompt = (
        f"Explain the meaning of this song. \n"
        f"Include themes, tone, and whether or not the song is happy or sad. \n"
        f"The song is {title} by {artist}: \n"
        f"{lyrics}\n"
    )

    response = client.completions.create(
        model="gpt-3.5-turbo-1106",
        prompt=prompt,
        max_tokens=1000,
        temperature=1,
        top_p=1,
        frequency_penalty=0,
        presence_penalty=0,
    )

    return response.choices[0].text


def main():
    song_name = input("Enter the name of the song: ")
    artist_name = input("Enter the name of the artist: ")

    lyrics = get_lyrics(song_name, artist_name, config.GENIUS_ACCESS_TOKEN)

    if lyrics is None:
        print(f"Error: {song_name} performed by {artist_name} was not found.")
    else:
        print(analyze_lyrics(song_name, artist_name, lyrics))


if __name__ == "__main__":
    main()
