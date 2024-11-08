<?php

declare(strict_types=1);

use App\Http\Api\Auth\AuthAction;
use App\Http\Api\ExceptionAction;
use App\Http\Api\HelloWorldAction;
use App\Http\Api\Login\Action\LoginAction;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\SessionStartMiddleware;
use Route\Route;

Route::addRoute('GET', '/hello', [
    'Filter' => [],
    'Action' => new HelloWorldAction()
]);

Route::addRoute('POST', '/login', [
    'Filter' => [new SessionStartMiddleware()],
    'Action' => new LoginAction()
]);

Route::addRoute('GET', '/auth', [
    'Filter' => [new SessionStartMiddleware(), new AuthMiddleware()],
    'Action' => new AuthAction()
]);


Route::addRoute('GET', '/500', [
    'Filter' => [],
    'Action' => new ExceptionAction()
]);