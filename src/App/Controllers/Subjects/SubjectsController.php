<?php

declare(strict_types=1);

namespace App\Controllers\Subjects;

use App\Controllers\Standards\StandardsController;
use App\Services\ProfileService;
use App\Services\StandardService;
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
        private TeacherService $teacher_service,
        private StandardService $standards_service,
    ) {
    }

    public function create()
    {
        $this->validator_service->validate_subject($_POST);
        $this->subject_service->is_subject_added($_POST['sub_code'], $_POST['sub_name']);
        $this->subject_service->create($_POST);
        redirectTo($_SERVER['HTTP_REFERER']);
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

    public function remove_teachers_sub(array $params = [])
    {


        $this->subject_service->remove_teacher_sub((int) $params['tid'], (int) $params['sub_id']);
        redirectTo($_SERVER['HTTP_REFERER']);
    }

    public function remove_std_sub(array $params = [])
    {
        $this->subject_service->remove_std_sub((int)$params['std_id'], (int)$params['sub_id']);
        redirectTo($_SERVER['HTTP_REFERER']);
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

        $stds = $this->standards_service->get_sub_std();
        $stds_sub = $this->standards_service->get_sub_std_id();
        $std_ids = [];
        foreach ($stds_sub as $std) {
            $std_ids[] = $std['standard_id'];
        }
        // dd($std_ids);
        echo $this->view->render(
            "admin/subjects/create.php",
            [
                'teachers' => $teachers,
                'teachers_sub' => $teacher_sub,
                'stds' => $stds,
                'std_ids' => $std_ids
            ]

        );
    }





    public function get_data()
    {
        return $this->subject_service->get_data();
    }

    public function edit_view($params = [])
    {

        // $this->total_subjects();
        // $this->teacher_service->get_teachers();
        // $data = $this->get_data();
        $sub = $this->subject_service->get_subject((int)$params['sub_id']);
        $teachers = $this->teacher_service->get_teachers();
        $teachers_subject = $this->teacher_service->get_teachers_subject((int)$params['sub_id']);
        $teacher_sub = [];

        foreach ($teachers_subject as $t) {
            $teacher_sub[] = $t['id'];
        }
        $filtered_teachers = array_filter($teachers, function ($teacher) use ($teacher_sub) {
            return !in_array($teacher['id'], $teacher_sub);
        });


        $stds = $this->standards_service->get_sub_std();
        $stds_sub = $this->standards_service->get_sub_std_id((int)$params['sub_id']);
        $std_ids = [];

        foreach ($stds_sub as $std) {
            $std_ids[] = $std['id'];
        }


        $filtered_stds = array_filter($stds, function ($std) use ($std_ids) {
            return !in_array($std['id'], $std_ids);
        });
        // dd($stds_sub);
        echo $this->view->render(
            "admin/subjects/edit.php",
            [
                'teachers_subject' => $teachers_subject,
                'teachers' => $filtered_teachers,
                'teachers_sub' => $teacher_sub,
                'stds' => $filtered_stds,
                'standards' => $stds_sub,
                'std_ids' => $std_ids,
                'sub' => $sub
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
        $this->subject_service->is_subject_added(strtoupper($_POST['sub_code']), $_POST['sub_name'], (int) $params['sub_id']);
        $this->subject_service->update($_POST, (int) $params['sub_id']);
        redirectTo($_SERVER['HTTP_REFERER']);
    }
}
