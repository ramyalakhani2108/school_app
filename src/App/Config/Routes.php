<?php

declare(strict_types=1);

namespace App\Config;

use App\Controllers\AboutController;
use App\Controllers\Admin\AdminDashboardController;
use App\Controllers\Admin\ProfileController;
use App\Controllers\AuthController;
use App\Controllers\ErrorController;
use App\Controllers\Standards\StandardsController;
use App\Controllers\Student\CourseController;
use App\Controllers\Student\StudentHomeController;
use App\Controllers\Student\SubjectController;
use App\Controllers\Subjects\SubjectsController;
use App\Controllers\Teacher\TeacherController;
// use App\Controllers\Student\TeacherController;
use App\Middlewares\AuthTokenMiddleware;
use App\Middlewares\GuestOnlyMiddleware;

use Framework\App;

function register_routes(App $app)
{
    $app->get("/register", [AuthController::class, 'register_view'])->add(GuestOnlyMiddleware::class);
    $app->post("/register", [AuthController::class, 'do_reg'])->add(GuestOnlyMiddleware::class);
    $app->get("/login", [AuthController::class, 'login_view'])->add(GuestOnlyMiddleware::class);
    $app->post("/login", [AuthController::class, 'do_login'])->add(GuestOnlyMiddleware::class);
    $app->get("/logout", [AuthController::class, 'logout'])->add(AuthTokenMiddleware::class);
    $app->get("/", [StudentHomeController::class, 'home'])->add(AuthTokenMiddleware::class);
    $app->get("/about", [AboutController::class, 'about_view'])->add(AuthTokenMiddleware::class);
    $app->get("/courses", [SubjectController::class, 'subject_view'])->add(AuthTokenMiddleware::class);
    $app->get("/trainers", [TeacherController::class, 'teacher_view'])->add(AuthTokenMiddleware::class);
    $app->post("/admin/subjects/filtered_by/", [SubjectsController::class, 'filtered_subject'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/subjects/filtered_by/", [SubjectsController::class, 'filtered_subject'])->add(AuthTokenMiddleware::class);
    // $app->get("/admin/subjects/filtered_by/", [SubjectsController::class, 'filtered_subject'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/standards/remove_teachers/{tid}/{std_id}", [StandardsController::class, 'remove_teachers_stds'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/standards/remove_subs/{sub_id}/{std_id}", [StandardsController::class, 'remove_subjects_stds'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/standards/editstandard/{std_id}", [StandardsController::class, 'edit_standard_view'])->add(AuthTokenMiddleware::class);
    $app->post("/admin/standards/editstandard/{std_id}", [StandardsController::class, 'edit'])->add(AuthTokenMiddleware::class);
    $app->delete("/admin/subjects/delete_subjects/{id}", [SubjectsController::class, 'delete'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/subjects/edit_subjects/{sub_id}", [SubjectsController::class, 'edit_view'])->add(AuthTokenMiddleware::class);
    $app->post("/admin/subjects/edit_subjects/{sub_id}", [SubjectsController::class, 'edit'])->add(AuthTokenMiddleware::class);
    $app->post("/admin/subjects/add_teachers", [SubjectsController::class, 'add_teacher_subject'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/subjects/add_teacher/{tid}", [SubjectsController::class, 'add_teacher_subject'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/subjects/remove_teachers/{tid}/{sub_id}", [SubjectsController::class, 'remove_teachers_sub'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/subjects/remove_stds/{std_id}/{sub_id}", [SubjectsController::class, 'remove_std_sub'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/subjects/create_subject", [SubjectsController::class, 'create_subjects_view'])->add(AuthTokenMiddleware::class);
    $app->post("/admin/subjects/create_subject", [SubjectsController::class, 'create'])->add(AuthTokenMiddleware::class);
    $app->delete("/admin/standards/deletestandards", [StandardsController::class, 'delete_standards'])->add(AuthTokenMiddleware::class);
    $app->post("/admin/standards/add_standards", [StandardsController::class, 'add_standards'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/standards/add_standards", [StandardsController::class, 'add_standards_view'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/standards", [StandardsController::class, 'standards_view'])->add(AuthTokenMiddleware::class);
    $app->post("/admin/standards", [StandardsController::class, 'standards_view'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/teachers", [TeacherController::class, 'admin_teacher_view'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/subjects", [SubjectsController::class, 'admin_subjects_view'])->add(AuthTokenMiddleware::class);
    $app->get("/admin/{id}", [ProfileController::class, 'profile_view'])->add(AuthTokenMiddleware::class);
    $app->post("/admin/{id}", [ProfileController::class, 'profile_update'])->add(AuthTokenMiddleware::class);
    $app->get("/admin", [AdminDashboardController::class, 'admin_view'])->add(AuthTokenMiddleware::class);

    $app->set_error_handler([ErrorController::class, 'not_found']);
}
