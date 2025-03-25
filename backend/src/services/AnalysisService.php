<?php

namespace LyrAlkos\Services;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class AnalysisService
{
    private Client $client;
    private LoggerInterface $logger;
    private string $apiKey;

    public function __construct(LoggerInterface $logger, string $apiKey)
    {
        $this->client = new Client();
        $this->logger = $logger;
        $this->apiKey = $apiKey;
    }

    public function analyze(string $title, string $artist, string $lyrics): ?string
    {
        try {
            $prompt = $this->createPrompt($title, $artist, $lyrics);
            $response = $this->client->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash-lite:generateContent',
                [
                    'query' => ['key' => $this->apiKey],
                    'json' => [
                        'contents' => [
                            [
                                'parts' => [
                                    ['text' => $prompt]
                                ]
                            ]
                        ]
                    ]
                ]
            );

            $data = json_decode($response->getBody()->getContents(), true);
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
        } catch (\Exception $e) {
            $this->logger->error('Failed to analyze lyrics', [
                'error' => $e->getMessage(),
                'title' => $title,
                'artist' => $artist
            ]);
            return null;
        }
    }

    private function createPrompt(string $title, string $artist, string $lyrics): string
    {
        return "Analyze the song '$title' by '$artist' and provide the analysis in markdown format with the following sections:

                # Song Analysis: $title by $artist

                ## Theme & Meaning
                [Provide the main themes and meaning of the song]

                ## Mood & Tone
                [Describe the overall mood and tone]

                ## Key Elements
                - [List key musical or lyrical elements]
                - [Include notable metaphors or symbols]
                - [Mention any significant patterns]

                ## Emotional Impact
                [Describe the emotional impact and how the song achieves it]

                ## Cultural Context
                [If relevant, include any cultural or historical context]

                Here are the lyrics to analyze:

                $lyrics";
    }
}
