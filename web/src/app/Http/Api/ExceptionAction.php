<?php

declare(strict_types=1);

namespace App\Http\Api;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ExceptionAction implements MiddlewareInterface
{
    /**
     * @throws Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        trigger_error('This is an error', E_USER_ERROR);
    }

    public function aaa(string $a): string
    {
        return $a;
    }
}
