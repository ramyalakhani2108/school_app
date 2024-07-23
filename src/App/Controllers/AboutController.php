<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\UserService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;


class AboutController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validator_service,
        private UserService $user_service
    ) {
    }

    public function about_view()
    {
        echo $this->view->render("about.php");
    }
}
