<?php

declare(strict_types=1);

namespace App\Middlewares;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\JWTException;
use Framework\Exceptions\ValidationException;

class JWTGuardMiddleware implements MiddlewareInterface
{

    public function process(callable $next)
    {
        if (!array_key_exists('token', $_COOKIE)) {

            throw new JWTException(['email' => ['login first']]);
        }
        $next();
    }
}
