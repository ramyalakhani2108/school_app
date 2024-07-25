<?php

declare(strict_types=1);

use App\Config\Paths;
use App\Services\{ProfileService, SubjectService, UserService, ValidatorService};

use Framework\Container;
use Framework\Database;
use Framework\TemplateEngine;

return [
    TemplateEngine::class => function () {
        return new TemplateEngine(Paths::VIEW);
    },
    ValidatorService::class => function () {
        return new ValidatorService();
    },
    Database::class => function () {
        return
            new Database($_ENV['DB_DRIVER'], [
                'host' => $_ENV['DB_HOST'],
                'port' => $_ENV['DB_PORT'],
                'dbname' => $_ENV['DB_NAME']
            ], $_ENV['DB_USER'], $_ENV['DB_PASS']);
    },
    UserService::class => function (Container $container) {
        $db = $container->get(Database::class);

        return new UserService($db);
    }, ProfileService::class => function (Container $container) {
        $db = $container->get(Database::class);
        return new ProfileService($db);
    }, SubjectService::class => function (Container $container) {
        $db = $container->get(Database::class);
        return new SubjectService($db);
    }
];
