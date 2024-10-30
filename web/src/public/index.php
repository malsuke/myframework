<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

ob_start();

use App\Http\Middleware\SessionStartMiddleware;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Relay\Relay;
use Route\Route;

$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
$serverRequest = $creator->fromGlobals();

require_once __DIR__ . '/../route/web.php';

$queue = Route::findAndRoute($serverRequest, null);

$relay = new Relay($queue);
$response = $relay->handle($serverRequest);

// エラーがあればログに出力
if (ob_get_length() > 0) {
    error_log((string)ob_get_contents());
}
ob_end_clean();

$emitter = new SapiEmitter();
$emitter->emit($response);
