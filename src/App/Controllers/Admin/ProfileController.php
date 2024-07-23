<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Services\ProfileService;
use App\Services\UserService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;

class ProfileController
{
    public function __construct(
        private TemplateEngine $view,
        private ProfileService $profile_service,
        public ValidatorService $validator_service,
        public UserService $user_service
    ) {
    }

    public function profile_view(array $params = [])
    {

        $profile = $this->profile_service->get_user_profile((int)$params['id']);
        // dd($profile);
        if (!$profile) {
            redirectTo("/");
        }
        echo $this->view->render(
            "admin/profile.php",
            [
                'profile' => $profile
            ]
        );
    }
    public function profile_update()
    {

        $this->validator_service->validate_profile($_POST);
        $this->user_service->is_email_taken_profile($_POST['email'], $_SESSION['user_id']);
        $this->profile_service->update($_POST);
        redirectTo($_SERVER['HTTP_REFERER']);
    }
}
