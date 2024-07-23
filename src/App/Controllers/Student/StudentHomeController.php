<?php

declare(strict_types=1);

namespace App\Controllers\Student;

use Framework\TemplateEngine;

class StudentHomeController
{
    public function __construct(
        private TemplateEngine $view
    ) {
    }

    public function home()
    {
        echo $this->view->render("student/index.php");
    }
}
