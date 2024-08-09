<?php

declare(strict_types=1);

namespace App\Controllers\Teacher;

use App\Services\StandardService;
use App\Services\SubjectService;
use App\Services\TeacherService;
use App\Services\UserService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;

class TeacherController
{
    public function __construct(
        private TemplateEngine $view,
        private TeacherService $teacher_service,
        private SubjectService $subject_service,
        private StandardService $standards_service,
        private ValidatorService $validator_service,
        private UserService $user_service
    ) {
    }

    public function teacher_view()
    {
        echo $this->view->render("teacher/show_teachers.php");
    }

    public function edit_teacher(array $params = [])
    {
        // dd($params);
        $teachers = $this->teacher_service->get_teachers((int) $params['tid']);

        $teachers_std = $this->teacher_service->get_std_teacher((int) $params['tid']);
        $stds = $this->standards_service->get_sub_std();

        $std_ids = [];

        foreach ($teachers_std as $std) {
            $std_ids[] = $std['id'];
        }


        $filtered_stds = array_filter($stds, function ($std) use ($std_ids) {
            return !in_array($std['id'], $std_ids);
        });;

        $teachers_subs = $this->teacher_service->get_sub_teacher((int) $params['tid']);
        $subs = $this->subject_service->get_std_sub();
        $std_ids = [];
        if (!empty($teachers_subs)) {
            foreach ($teachers_subs as $std) {

                $std_ids[] = $std['id'];
            }
        }
        $filtered_subs = array_filter($subs, function ($std) use ($std_ids) {
            return !in_array($std['id'], $std_ids);
        });
        echo $this->view->render(
            '/admin/teachers/edit.php',
            [
                'teachers' => $teachers,
                'teacher_stds' => $filtered_stds,
                'subs' => $filtered_subs
            ]
        );
    }

    public function update_teacher(array $params = [])
    {
        $this->validator_service->validate_teacher($_POST);
        $this->user_service->is_record_added('staff', 'email', $_POST['email'], ' id!=' . $_POST['tid']);
        $this->teacher_service->update($_POST);
    }

    public function admin_teacher_view()
    {

        if (array_key_exists('_METHOD', $_POST) && $_POST['_METHOD'] == 'DELETE') {
            if (!empty($_POST['selected_ids'])) {
                $ids = [];
                foreach ($_POST['selected_ids'] as $id) {
                    $ids[] = (int) $id;
                }
                $id = implode(",", $ids);
                $this->user_service->delete_record('staff', " `id` IN  ($id)");
                redirectTo($_SERVER['HTTP_REFERER']);
            }
        }


        //SELECT `staff`.`id` AS `staff_ids`, `staff`.`name` as `staff_names`, ( SELECT COUNT(`teachers_std`.`standard_id`) FROM `teachers_std` WHERE `teachers_std`.`teacher_id` = `staff`.`id` ) AS `total_standards`, ( SELECT COUNT(`teacher_subjects`.`subject_id`) FROM `teacher_subjects` WHERE `teacher_subjects`.`teacher_id`=`staff`.`id` ) AS `total_subjects` FROM `staff` WHERE `staff`.`role_id`=2;
        $subject_names = [];
        $subjects = $this->subject_service->get_std_sub();



        foreach ($subjects as $subject) {
            $subject_names[] = $subject['name'];
        }
        $standard_names = [];
        $standards = $this->standards_service->get_sub_std();



        foreach ($standards as $standard) {
            $standard_names[] = $standard['name'];
        }

        $filtered_teacher = [];
        // $teachers = $this->teacher_service->get_teachers();
        // $teacher_names = [];
        // foreach ($teachers as $teacher) {
        //     $teacher_names[] = $teacher['name'];
        // }
        $order_by = "id";
        $order = "ASC";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (array_key_exists('order_by', $_POST)) {
                $order_by = $_POST['order_by'];
                $order = $_POST['order'];
            }
            if (array_key_exists('standards_name', $_POST)) {
                $params = $_POST['standards_name'];
                $names = [];

                foreach ($params as $param) {
                    $names[] = urldecode($param);
                }
                if ($_POST['s']) {;
                    // dd($_POST['_search_input_']);
                    $filtered_teacher[] = $this->teacher_service->filtered_teacher($names, 'standards', $_POST['s'], $order_by, $order);
                } else {
                    // dd($_POST);


                    $filtered_teacher[] = $this->teacher_service->filtered_teacher($names, 'standards', order_by: $order_by, order: $order);
                }
            }




            if (array_key_exists('subject_names', $_POST)) {
                $params = $_POST['subject_names'];
                $names = [];
                foreach ($params as $param) {
                    $names[] = urldecode($param);
                }

                if ($_POST['s'] ?? '') {

                    $filtered_teacher[] = $this->teacher_service->filtered_teacher($names, 'subjects', $_POST['s'], order_by: $order_by, order: $order);
                } else {

                    $filtered_teacher[] = $this->teacher_service->filtered_teacher($names, 'subjects', order_by: $order_by, order: $order);
                }
            }

            if (array_key_exists('s', $_POST) && empty($_POST['subject_names']) && empty($_POST['standards_name'])) {

                if ($_POST['s']) {
                    $search = urldecode(htmlspecialchars(trim($_POST['s'])));
                    // dd("hi");
                    $filtered_teacher[] = array_merge($filtered_teacher, $this->teacher_service->get_search_results($search, order_by: $order_by, order: $order));
                }
            }
        }
        if (empty(($_POST['s'])) && empty($_POST['_search_input_']) && empty($_POST['subject_names']) && empty($_POST['standards_name'])) {
            // dd($_POST);

            $filtered_teacher[] = $this->teacher_service->get_teacher_data(order_by: $order_by, order: $order);
        }
        $search = 0;
        // if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['s'])) {
        //     $search = urldecode(htmlspecialchars(trim($_GET['s'])));
        //     $filtered_standard[] = array_merge($filtered_standard, $this->subject_service->get_search_results($search));
        // } else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['sort']) && isset($_GET['order'])) {
        //     $filtered_standard[] = $this->standards_service->get_standards_data(order_by: $_GET['sort'], order: $_GET['order']);
        //     // dd($filtered_standard);
        //} else
        // if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        //     $filtered_standard[] = $this->standards_service->get_standards_data();
        // }




        // dd($_SERVER['REQUEST_METHOD']);
        $filtered_teachers = [];

        foreach ($filtered_teacher as $teacher) {
            $filtered_teachers = array_merge($filtered_teachers, $teacher);
        }
        // dd($filtered_standards);

        // dd($filtered_teachers);

        echo $this->view->render(
            "/admin/teachers/list.php",
            [
                // 'standards' => $standards,
                'filtered_teachers' => $filtered_teachers,
                // 'teachers' => $teacher_names,
                'subjects' => $subject_names,
                'standards' => $standard_names
            ]
        );
    }
}
