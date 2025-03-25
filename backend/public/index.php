<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use LyrAlkos\Controllers\LyricsController;
use LyrAlkos\Services\LyricsService;
use LyrAlkos\Services\AnalysisService;
use Psr\Log\LoggerInterface;

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$container = new Container();

$container->set(LoggerInterface::class, function () {
    $logger = new Logger('lyralkos');
    $logger->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::DEBUG));
    return $logger;
});

$container->set(LyricsService::class, function (Container $c) {
    return new LyricsService($c->get(LoggerInterface::class));
});

$container->set(AnalysisService::class, function (Container $c) {
    return new AnalysisService(
        $c->get(LoggerInterface::class),
        $_ENV['GEMINI_API_KEY']
    );
});

$container->set(LyricsController::class, function (Container $c) {
    return new LyricsController(
        $c->get(LyricsService::class),
        $c->get(AnalysisService::class)
    );
});

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addBodyParsingMiddleware();
$app->addErrorMiddleware(true, true, true);

$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->post('/analyze', [LyricsController::class, 'analyze']);

$app->run();
