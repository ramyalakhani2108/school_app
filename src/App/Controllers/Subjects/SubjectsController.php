<?php

declare(strict_types=1);

namespace App\Controllers\Subjects;

use App\Services\ProfileService;
use App\Services\SubjectService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;

class SubjectsController
{
    public function __construct(
        private TemplateEngine $view,
        private ProfileService $profile_service,
        private SubjectService $subject_service,
        private ValidatorService $validator_service
    ) {
    }



    public function admin_subjects_view()
    {
        $profile = $this->profile_service->get_user_profile($_SESSION['user_id']);
        $this->total_subjects();
        $data = $this->get_data();
        if (!$profile) {
            redirectTo("/");
        }
        echo $this->view->render(
            "admin/subjects/list.php",
            [
                'profile' => $profile,
                'subject' => $data
            ]
        );
    }

    public function total_subjects(int $class = 0)
    {

        $this->view->addGlobal('total_subjects', $this->subject_service->total_subjects($class));
    }

    public function create_subjects_view()
    {
        $profile = $this->profile_service->get_user_profile($_SESSION['user_id']);
        $this->total_subjects();
        $data = $this->get_data();
        if (!$profile) {
            redirectTo("/");
        }
        echo $this->view->render(
            "admin/subjects/create.php",
            [
                'profile' => $profile,
            ]
        );
    }

    public function create()
    {

        $data = $this->get_data();
        $this->validator_service->validate_subject($_POST);

        $this->subject_service->is_subject_added(strtoupper($_POST['sub_code']), $_POST['sub_name']);
        $this->subject_service->add_subject($_POST);
        redirectTo($_SERVER['HTTP_REFERER']);
    }

    public function get_data()
    {
        return $this->subject_service->get_data();
    }

    public function edit_view($params = [])
    {

        $profile = $this->profile_service->get_user_profile($_SESSION['user_id']);
        $this->total_subjects();


        $subject = $this->subject_service->get_subject((int) $params['id']);

        if (!$profile) {
            redirectTo("/");
        }
        echo $this->view->render(
            "admin/subjects/edit.php",
            [
                'profile' => $profile,
                'subject' => $subject,
            ]
        );
    }

    public function delete($params = [])
    {
     
        $this->subject_service->delete((int) $params['id']);
        redirectTo($_SERVER['HTTP_REFERER']);
    }
    public function edit($params = [])
    {
        $this->subject_service->is_subject_added(strtoupper($_POST['sub_code']), $_POST['sub_name'], (int) $params['id']);
        $this->subject_service->update($_POST, (int) $params['id']);
        redirectTo($_SERVER['HTTP_REFERER']);
    }
}
