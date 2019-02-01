<?php

use Insidestyles\SwooleBridge\Adapter\Kernel\Psr15SymfonyKernel;
use Insidestyles\SwooleBridge\Adapter\SymfonyAdapter;
use Insidestyles\SwooleBridge\Builder\RequestBuilderFactory;
use Insidestyles\SwooleBridge\Emiter\SwooleResponseEmitter;
use Insidestyles\SwooleBridge\Handler;
use Psr\Log\NullLogger;
use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// The check is to ensure we don't use .env in production
if (!isset($_ENV['APP_ENV'])) {
    if (!class_exists(Dotenv::class)) {
        throw new \RuntimeException('APP_ENV environment variable is not defined. You need to define environment variables for configuration or add "symfony/dotenv" as a Composer dependency to load variables from a .env file.');
    }
    (new Dotenv())->load(__DIR__ . '/../.env');
}

$env = $_ENV['APP_ENV'] ?? 'dev';
$debug = (bool)$_ENV['APP_DEBUG'] ?? ('prod' !== $env);

if ($debug) {
    umask(0000);

    Debug::enable();
}

$kernel = new Kernel($env, $debug);
$psr15Kernel = new Psr15SymfonyKernel($kernel);
$responseEmitter = new SwooleResponseEmitter();
$requestBuilderFactory = new RequestBuilderFactory();
$adapter = new SymfonyAdapter($responseEmitter, $psr15Kernel, $requestBuilderFactory);
$logger = new NullLogger();
$handler = new Handler($adapter, $logger);

$http = new \Swoole\Http\Server("0.0.0.0", 9501);
$http->on('request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) use ($handler, $debug) {
    $handler->handle($request, $response);
});

$http->start();


