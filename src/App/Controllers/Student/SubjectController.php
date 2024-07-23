<?php

declare(strict_types=1);

namespace App\Controllers\Student;

use Framework\TemplateEngine;

class SubjectController
{
    public function __construct(
        private TemplateEngine $view
    ) {
    }

    public function subject_view()
    {
        echo $this->view->render("subjects/show_subjects.php");
    }
}
