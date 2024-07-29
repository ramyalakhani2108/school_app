<?php

declare(strict_types=1);

namespace App\Middlewares;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\SessionExceptions;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
     
        if (session_status() === PHP_SESSION_ACTIVE) {

            throw new SessionExceptions("Session already active");
        }

        if (headers_sent($filename, $line)) {
            throw new SessionExceptions("Headers already sent.Consider enabling output buffering. Data Outputed from {$filename} - line: {$line}");
        }

        session_set_cookie_params([
            'secure' => $_ENV['APP_ENV'] === "production",
            'httponly' => true,
            'samesite' => 'lax'
        ]);
        session_start();

        $next();
        session_write_close();
    }
}
