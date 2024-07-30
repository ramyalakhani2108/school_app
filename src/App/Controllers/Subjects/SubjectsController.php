<?php

declare(strict_types=1);

namespace App\Controllers\Subjects;

use App\Services\ProfileService;
use App\Services\SubjectService;
use App\Services\TeacherService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;

class SubjectsController
{
    private array $last_sub_id = [];
    public function __construct(
        private TemplateEngine $view,
        private ProfileService $profile_service,
        private SubjectService $subject_service,
        private ValidatorService $validator_service,
        private TeacherService $teacher_service
    ) {
    }



    public function admin_subjects_view()
    {
        // $this->total_subjects();
        $data = $this->get_data();

        echo $this->view->render(
            "admin/subjects/list.php",
            [
                'subjects' => $data
            ]
        );
    }

    public function total_subjects(int $class = 0)
    {

        $this->view->addGlobal('total_subjects', $this->subject_service->total_subjects($class));
    }

    public function create_subjects_view()
    {
        $this->total_subjects();
        $this->teacher_service->get_teachers();
        $data = $this->get_data();
        $teachers = $this->teacher_service->get_teachers();
        $teachers_subject = $this->teacher_service->get_teachers_subject();
        $teacher_sub = [];
        foreach ($teachers_subject as $t) {
            $teacher_sub[] = $t['teacher_id'];
        }
        echo $this->view->render(
            "admin/subjects/create.php",
            [
                'teachers' => $teachers,
                'teachers_sub' => $teacher_sub
            ]

        );
    }

    public function create()
    {

        $data = $this->get_data();
        $this->validator_service->validate_subject($_POST);

        $this->subject_service->is_subject_added(strtoupper($_POST['sub_code']), $_POST['sub_name']);
        $sub_id = $this->subject_service->add_subject($_POST);
        // dd((int)$sub_id);


        redirectTo($_SERVER['HTTP_REFERER']);
    }


    public function add_teacher_subject(array $params = [])
    {

        if (empty($params)) {
            $this->subject_service->add_teacher_subject(data: $_POST['selected_ids']);
        } else {
            $this->subject_service->add_teacher_subject((int) $params['tid']);
            // adding teacher for particular subject
        }
        redirectTo($_SERVER['HTTP_REFERER']);
    }
    public function remove_teachers(array $params = [])
    {

        if (empty($params)) {
            $this->subject_service->remove_teacher_subject(data: $_POST['selected_ids']);
        } else {
            $this->subject_service->remove_teacher_subject((int) $params['tid']);
            // adding teacher for particular subject
        }
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
        // $this->subject_service->is_subject_added(strtoupper($_POST['sub_code']), $_POST['sub_name'], (int) $params['id']);
        $this->subject_service->update($_POST, (int) $params['id']);
        redirectTo($_SERVER['HTTP_REFERER']);
    }
}
