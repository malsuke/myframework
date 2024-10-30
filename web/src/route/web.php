<?php

declare(strict_types=1);

use App\Http\Actions\HelloWorldAction;
use Route\Route;

Route::addRoute('GET', '/hello', [
    'Filter' => [],
    'Action' => new HelloWorldAction()
]);
