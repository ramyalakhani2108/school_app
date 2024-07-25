<?php

declare(strict_types=1);

namespace App\Config;

use App\Middlewares\FlashMiddleware;
use App\Middlewares\ValidationExceptionMiddleware;
use App\Middlewares\SessionMiddleware;
use Framework\App;

function register_middlewares(App $app)
{

    $app->add_middlewares(ValidationExceptionMiddleware::class);
    $app->add_middlewares(FlashMiddleware::class);
    $app->add_middlewares(SessionMiddleware::class);
}
