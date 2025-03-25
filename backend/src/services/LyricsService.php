<?php

namespace LyrAlkos\Services;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class LyricsService
{
    private Client $client;
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->client = new Client();
        $this->logger = $logger;
    }

    public function getLyrics(string $title, string $artist): ?string
    {
        try {
            $response = $this->client->get(sprintf(
                'https://api.lyrics.ovh/v1/%s/%s',
                urlencode($artist),
                urlencode($title)
            ));

            $data = json_decode($response->getBody()->getContents(), true);
            if (isset($data['lyrics'])) {
                return $this->formatLyrics($data['lyrics']);
            }
        } catch (\Exception $e) {
            $this->logger->error('Failed to fetch lyrics', [
                'error' => $e->getMessage(),
                'title' => $title,
                'artist' => $artist
            ]);
        }

        return null;
    }

    private function formatLyrics(string $lyrics): string
    {
        $lyrics = str_replace("\r\n", "\n", $lyrics);
        $lines = explode("\n", $lyrics);
        $lines = array_map('trim', $lines);

        $formattedLines = [];
        $previousLineEmpty = false;

        foreach ($lines as $line) {
            $isEmpty = empty(trim($line));

            if ($isEmpty) {
                if (!$previousLineEmpty) {
                    $formattedLines[] = '';
                }
            } else {
                $formattedLines[] = $line;
            }

            $previousLineEmpty = $isEmpty;
        }

        while (!empty($formattedLines) && empty(trim(end($formattedLines)))) {
            array_pop($formattedLines);
        }

        return implode("\n", $formattedLines);
    }
}
