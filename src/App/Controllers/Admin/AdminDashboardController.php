<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Services\ProfileService;
use Framework\TemplateEngine;

class AdminDashboardController
{
    public function __construct(
        private TemplateEngine $view,
        private ProfileService $profile_service
    ) {
    }

    public function admin_view(array $params = [])
    {
        
        $profile = $this->profile_service->get_user_profile((int)$_SESSION['user_id']);
        // dd($profile);
        if (!$profile) {
            redirectTo("/");
        }
        echo $this->view->render(
            "admin/dashboard.php"

        );
    }
}
