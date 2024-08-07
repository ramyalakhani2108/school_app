<?php

declare(strict_types=1);

namespace App\Controllers\Standards;

use App\Services\StandardService;
use App\Services\SubjectService;
use App\Services\TeacherService;
use App\Services\UserService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;


class StandardsController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validator_service,
        private StandardService $standards_service,
        private TeacherService $teacher_service,
        private SubjectService $subject_service
    ) {
    }

    public function remove_teachers_stds(array $params = [])
    {

        $this->standards_service->remove_teachers_stds((int) $params['tid'], (int) $params['std_id']);
        redirectTo($_SERVER['HTTP_REFERER']);
    }
    public function remove_subjects_stds(array $params = [])
    {
        $this->standards_service->remove_subjects_stds((int)$params['sub_id'], (int)$params['std_id']);
        redirectTo($_SERVER['HTTP_REFERER']);
    }
    public function standards_view()
    {

        $subject_names = [];
        $subjects = $this->subject_service->get_std_sub();



        foreach ($subjects as $subject) {
            $subject_names[] = $subject['name'];
        }
        $filtered_standard = [];
        $teachers = $this->teacher_service->get_teachers();
        $teacher_names = [];
        foreach ($teachers as $teacher) {
            $teacher_names[] = $teacher['name'];
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (array_key_exists('teacher_names', $_POST)) {
                $params = $_POST['teacher_names'];
                $names = [];
                foreach ($params as $param) {
                    $names[] = urldecode($param);
                }
                $filtered_standard[] = $this->standards_service->filtered_standards($names, 'staff');
            }

            if (array_key_exists('subjects_name', $_POST)) {
                $params = $_POST['subjects_name'];

                $names = [];
                foreach ($params as $param) {
                    $names[] = urldecode($param);
                }
                $filtered_standard[] = $this->standards_service->filtered_standards($names, 'subjects');
            }
        }


        $search = 0;
        // if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['s'])) {
        //     $search = urldecode(htmlspecialchars(trim($_GET['s'])));
        //     $filtered_standard[] = array_merge($filtered_standard, $this->subject_service->get_search_results($search));
        // } else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['sort']) && isset($_GET['order'])) {
        //     $filtered_standard[] = $this->standards_service->get_standards_data(order_by: $_GET['sort'], order: $_GET['order']);
        //     // dd($filtered_standard);
        //} else
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $filtered_standard[] = $this->standards_service->get_standards_data();
        }



        $filtered_standards = [];

        foreach ($filtered_standard as $standard) {

            $filtered_standards = array_merge($filtered_standards, $standard);
        }




        echo $this->view->render(
            "/admin/standards/list.php",
            [
                // 'standards' => $standards,
                'filtered_standard' => $filtered_standards,
                'teachers' => $teacher_names,
                'subjects' => $subject_names
            ]
        );
    }

    public function edit_standard_view(array $params)
    {
        $teachers = $this->teacher_service->get_teachers();
        $teachers_standard = $this->teacher_service->get_teachers_std((int)$params['std_id']);
        $teacher_sub = [];

        foreach ($teachers_standard as $t) {
            $teacher_sub[] = $t['id'];
        }
        // dd($teachers);
        $filtered_teachers = array_filter($teachers, function ($teacher) use ($teacher_sub) {
            return !in_array($teacher['id'], $teacher_sub);
        });





        $subs = $this->standards_service->get_standard_sub();
        $stds_sub = $this->standards_service->get_standard_subjects((int)$params['std_id']);
        $sub_ids = [];

        foreach ($stds_sub as $std) {
            $sub_ids[] = $std['id'];
        }


        $filtered_subs = array_filter($subs, function ($std) use ($sub_ids) {
            return !in_array($std['id'], $sub_ids);
        });
        $std = $this->standards_service->get_standard((int)$params['std_id']);

        echo $this->view->render(
            "admin/standards/edit.php",
            [
                'std' => $std,
                'teachers_standard' => $teachers_standard,
                'teachers' => $filtered_teachers,
                'teachers_sub' => $teacher_sub,
                'subs' => $filtered_subs,
                'subjects' => $stds_sub,
                'sub_ids' => $sub_ids,
            ]

        );
    }
    public function add_standards_view()
    {
        $this->teacher_service->get_teachers();

        $teachers = $this->teacher_service->get_teachers();
        $teachers_subject = $this->teacher_service->get_teachers_subject();
        $teacher_sub = [];
        if (!empty($teachers_subject)) {
            foreach ($teachers_subject as $t) {
                $teacher_sub[] = $t['teacher_id'];
            }
        }
        $subs = $this->subject_service->get_std_sub();
        $stds_sub = $this->standards_service->get_sub_std_id();
        $std_ids = [];
        if (!empty($stds_sub)) {
            foreach ($stds_sub as $std) {

                $std_ids[] = $std['id'];
            }
        }
        echo $this->view->render(
            "/admin/standards/create.php",
            [
                'teachers' => $teachers,
                'teachers_sub' => $teacher_sub,
                'subs' => $subs,
                'std_ids' => $std_ids
            ]
        );
    }

    public function add_standards()
    {
        $this->validator_service->validate_standards($_POST);
        $this->standards_service->add_standards($_POST);
        redirectTo($_SERVER['HTTP_REFERER']);
    }
    public function delete_standards()
    {
        $selected_standards = [];

        $this->standards_service->delete_standards($selected_standards);
        redirectTo($_SERVER['HTTP_REFERER']);
    }

    public function edit(array $params = [])
    {

        $this->standards_service->is_std_added($_POST['std_name'], (int) $params['std_id']);
        $this->standards_service->update($_POST, (int) $params['std_id']);
        redirectTo($_SERVER['HTTP_REFERER']);
    }
}
