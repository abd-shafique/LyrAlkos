# LyrAlkos

LyrAlkos is a Python project that enables users to explore the sentiment and themes of their favorite songs. Using the Genius API, LyrAlkos can retrieve the lyrics of any song given the song's name and artist's name. After retrieving the lyrics, LyrAlkos uses the OpenAI API to analyze the lyrics and generate a description of the song's meaning, themes, tone, and whether or not the song is happy or sad.

## Getting Started

To get started with LyrAlkos, you need to have the following:

- A Genius API token: You can get one by signing up on the Genius API website.
- An OpenAI API key: You can get one by signing up on the OpenAI API website.
- Python 3: You can download it from the official website.

After obtaining the necessary credentials and installing Python 3, you can clone the repository by running the following command in your terminal:

```
git clone https://github.com/<username>/LyrAlkos.git
```

Then, navigate to the project directory by running the following command:

```
cd LyrAlkos
```

Create a new file named config.py in the root directory of the project, and add the following lines of code:

```
GENIUS_ACCESS_TOKEN = "your-genius-access-token"
OPENAI_API_KEY = "your-openai-api-key"
```

Install the project dependencies by running the following command:

```
pip install -r requirements.txt
```

You're now ready to use LyrAlkos.

## Usage

To use LyrAlkos, run the main.py file from your terminal:

```
python lyralkos.py
```

You will be prompted to enter the name of the song and the name of the artist. After entering the necessary information, LyrAlkos will retrieve the lyrics of the song and generate a description of the song's meaning, themes, tone, and whether or not the song is happy or sad.

## Contributing

If you want to contribute to LyrAlkos, feel free to fork the repository and make a pull request. You can also open an issue if you find a bug or have a feature request.