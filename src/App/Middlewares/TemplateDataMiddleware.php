<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Services\ClassService;
use App\Services\StudentService;
use App\Services\SubjectService;
use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;

class TemplateDataMiddleware implements MiddlewareInterface
{
    public function __construct(
        private TemplateEngine $view,
        private SubjectService $subject_service,
        private ClassService $class_service,
        private StudentService $student_service
    ) {
    }
    public function process(callable $next)
    {
        $this->view->addGlobal('total_subjects', $this->subject_service->total_subjects());
        $this->view->addGlobal('total_class', $this->class_service->total_classes());
        $this->view->addGlobal('total_students', $this->student_service->total_students());
        $this->view->addGlobal('title', "Expense tracking app");
        $next();
    }
}
