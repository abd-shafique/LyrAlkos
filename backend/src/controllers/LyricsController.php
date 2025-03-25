<?php

namespace LyrAlkos\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use LyrAlkos\Services\LyricsService;
use LyrAlkos\Services\AnalysisService;

class LyricsController
{
    private LyricsService $lyricsService;
    private AnalysisService $analysisService;

    public function __construct(
        LyricsService $lyricsService,
        AnalysisService $analysisService
    ) {
        $this->lyricsService = $lyricsService;
        $this->analysisService = $analysisService;
    }

    public function analyze(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        if (!isset($data['title']) || !isset($data['artist'])) {
            $response->getBody()->write(json_encode([
                'error' => 'Missing title or artist parameter'
            ]));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        try {
            $lyrics = $this->lyricsService->getLyrics($data['title'], $data['artist']);
            if (!$lyrics) {
                throw new \Exception('Lyrics not found');
            }

            $analysis = $this->analysisService->analyze($data['title'], $data['artist'], $lyrics);
            if (!$analysis) {
                throw new \Exception('Failed to analyze lyrics');
            }

            $response->getBody()->write(json_encode([
                'title' => $data['title'],
                'artist' => $data['artist'],
                'lyrics' => $lyrics,
                'analysis' => $analysis
            ]));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode([
                'error' => $e->getMessage()
            ]));
            return $response->withStatus(500)->withHeader('Content-Type', 'application/json');
        }
    }
}
