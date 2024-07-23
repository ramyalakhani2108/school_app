<?php

declare(strict_types=1);

use App\Config\Paths;
use Dotenv\Dotenv;
use Framework\App;

use function App\Config\register_middlewares;
use function App\Config\register_routes;

require __DIR__ . "/../../vendor/autoload.php";




$dotenv = Dotenv::createImmutable(Paths::ROOT);
$dotenv->load(); //loading all the environment variables defined in .env file at the root directory of the project
$app = new App(Paths::SOURCE . "App/container-definitions.php");


register_routes($app);
register_middlewares($app);

return $app;
