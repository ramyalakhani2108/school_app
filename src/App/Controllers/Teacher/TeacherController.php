<?php

declare(strict_types=1);

namespace App\Controllers\Teacher;

use Framework\TemplateEngine;

class TeacherController
{
    public function __construct(
        private TemplateEngine $view
    ) {
    }

    public function teacher_view()
    {
        echo $this->view->render("teacher/show_teachers.php");
    }
}
