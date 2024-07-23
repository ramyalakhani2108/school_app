<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\UserService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;


class AuthController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validator_service,
        private UserService $user_service
    ) {
    }

    public function register_view()
    {
        echo $this->view->render("register.php");
    }
    public function login_view()
    {
        echo $this->view->render("login.php", []);
    }

    public function do_login(array $data = [])
    {

        $this->validator_service->validate_login($_POST);
        $user = $this->user_service->login($_POST);
        redirectTo($user['rel_type']);
    }

    public function do_reg()
    {
        $this->validator_service->validate_register($_POST);
        $this->user_service->is_email_taken($_POST['email']);

        $this->user_service->register($_POST);
        redirectTo("/");
    }

    public function logout()
    {
        $this->user_service->logout();
        redirectTo("/login");
    }
}
