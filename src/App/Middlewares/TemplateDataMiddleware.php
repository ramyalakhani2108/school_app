<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Services\StandardService;
use App\Services\ProfileService;
use App\Services\StudentService;
use App\Services\SubjectService;
use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class TemplateDataMiddleware implements MiddlewareInterface
{
    public function __construct(
        private TemplateEngine $view,
        private SubjectService $subject_service,
        private StandardService $class_service,
        private StudentService $student_service,
        private ProfileService $profile_service
    ) {
    }
    public function process(callable $next)
    {

        if (array_key_exists('user_id', $_SESSION)) {
            $profile = $this->profile_service->get_user_profile((int) $_SESSION['user_id']);
            $this->view->addGlobal('profile', $profile);
        }
        $this->view->addGlobal('total_subjects', $this->subject_service->total_subjects());
        $this->view->addGlobal('total_standards', $this->class_service->total_standards());
        $this->view->addGlobal('total_students', $this->student_service->total_students());
        $this->view->addGlobal('title', "Expense tracking app");
        $next();
    }
}
