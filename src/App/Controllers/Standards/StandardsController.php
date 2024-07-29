<?php

declare(strict_types=1);

namespace App\Controllers\Standards;

use App\Services\StandardService;
use App\Services\UserService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;


class StandardsController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validator_service,
        private StandardService $standards_service
    ) {
    }

    public function standards_view()
    {

        $standards = $this->standards_service->get_standards_data();
        echo $this->view->render(
            "/admin/standards/list.php",
            [
                'standards' => $standards
            ]
        );
    }

    public function edit_standard_view(array $params)
    {

        $standard = $this->standards_service->get_standards_data((int) $params['std_id']);
        echo $this->view->render(
            "/admin/standards/edit.php",
            [
                'standard' => $standard
            ]
        );
    }

    public function delete_standards()
    {
        dd($_POST);
    }
}
