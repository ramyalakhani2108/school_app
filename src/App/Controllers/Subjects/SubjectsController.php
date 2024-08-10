<?php

declare(strict_types=1);

namespace App\Controllers\Subjects;

use App\Controllers\Standards\StandardsController;
use App\Services\ProfileService;
use App\Services\StandardService;
use App\Services\SubjectService;
use App\Services\TeacherService;
use App\Services\UserService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;

class SubjectsController
{
    private array $last_sub_id = [];
    public function __construct(
        private TemplateEngine $view,
        private ProfileService $profile_service,
        private UserService $user_service,
        private SubjectService $subject_service,
        private ValidatorService $validator_service,
        private TeacherService $teacher_service,
        private StandardService $standards_service,
    ) {}
    public function get_standards() {}

    public function get_search_results(array $search) {}

    public  function filtered_subject(array $params = [])
    {




        $filtered_subject = [];
        $teachers = $this->teacher_service->get_teachers();
        $teacher_names = [];
        foreach ($teachers as $teacher) {
            $teacher_names[] = $teacher['name'];
        }
        if (array_key_exists('teacher_names', $_POST)) {
            $params = $_POST['teacher_names'];

            // dd($standards);
            $names = [];
            foreach ($params as $param) {
                $names[] = urldecode($param);
            }
            $filtered_subject[] = $this->subject_service->filtered_subject($names, 'staff');
        }
        $standards = $this->standards_service->get_standard();


        $standard_names = [];
        foreach ($standards as $standard) {
            $standard_names[] = $standard['name'];
        }
        if (array_key_exists('standards_name', $_POST)) {
            $params = $_POST['standards_name'];

            $names = [];
            foreach ($params as $param) {
                $names[] = urldecode($param);
            }


            $filtered_subject[] = $this->subject_service->filtered_subject($names, 'standards');
        }
        if (isset($_GET['s'])) {
            $search = urldecode(htmlspecialchars(trim($_GET['s'])));
            $filtered_subject[] = array_merge($filtered_subject, $this->subject_service->get_search_results($search));
        }

        $filtered_subjects = [];
        foreach ($filtered_subject as $subjects) {

            $filtered_subjects = array_merge($filtered_subjects, $subjects);
        }

        echo $this->view->render(
            "admin/subjects/filtered_subject.php",
            [
                'filtered_subjects' => $filtered_subjects,
                'teachers' => $teacher_names,
                'standards' => $standard_names
            ]
        );
    }
    public function create()
    {

        $this->validator_service->validate_subject($_POST);
        $this->user_service->is_record_added('subjects', 'code', $_POST['sub_code'], field: 'sub_code');
        $this->user_service->is_record_added('subjects', 'name', $_POST['sub_name'], field: 'sub_name');
        $this->subject_service->create($_POST);
        redirectTo($_SERVER['HTTP_REFERER']);
    }

    public function admin_subjects_view()
    {
        // $this->total_subjects();
        // dd($_POST);
        $standard_names = [];
        $standards = $this->standards_service->get_sub_std();
        // dd($standards);


        foreach ($standards as $standard) {
            $standard_names[] = $standard['name'];
        }

        $filtered_subject = [];
        $teachers = $this->teacher_service->get_teachers();
        $teacher_names = [];
        foreach ($teachers as $teacher) {
            $teacher_names[] = $teacher['name'];
        }
        $order_by = "id";
        $order = "ASC";
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (array_key_exists('order_by', $_POST)) {
                $order_by = $_POST['order_by'];
                $order = $_POST['order'];
            }
            if (array_key_exists('teacher_names', $_POST)) {
                $params = $_POST['teacher_names'];
                $names = [];

                foreach ($params as $param) {
                    $names[] = urldecode($param);
                }
                if ($_POST['s']) {;
                    $filtered_subject[] = $this->subject_service->filtered_subject($names, 'staff', $_POST['s']);
                } else {


                    $filtered_subject[] = $this->subject_service->filtered_subject($names, 'staff');
                }
            }



            if (array_key_exists(
                'standards_name',
                $_POST
            )) {
                $params = $_POST['standards_name'];

                $names = [];
                foreach ($params as $param) {
                    $names[] = urldecode($param);
                }

                if ($_POST['s'] ?? '') {

                    // dd($_POST);

                    $filtered_subject[] = $this->subject_service->filtered_subject($names, 'standards', $_POST['s']);
                } else {
                    $filtered_subject[] = $this->subject_service->filtered_subject($names, 'standards');
                }
            }

            if (array_key_exists('s', $_POST) && empty($_POST['standards_name']) && empty($_POST['teacher_names'])) {

                if ($_POST['s']) {

                    $search = urldecode(htmlspecialchars(trim($_POST['s'])));

                    $filtered_subject[] = array_merge($filtered_subject, $this->subject_service->get_search_results($search));
                }
            }
        }
        if (
            empty(($_POST['s'])) && empty($_POST['_search_input_']) && empty($_POST['standards_name']) && empty($_POST['teacher_names'])
        ) {

            $filtered_subject[] = $this->subject_service->get_data();
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





        $filtered_subjects = [];

        foreach ($filtered_subject as $subject) {
            $filtered_subjects = array_merge($filtered_subjects, $subject);
        }
        // dd($filtered_standards);

        // dd($filtered_subjects);

        // dd($filtered_subject);
        echo $this->view->render(
            "admin/subjects/list.php",
            [
                'filtered_subjects' => $filtered_subjects,
                'teachers' => $teacher_names,
                'standards' => $standard_names
            ]
        );
        // echo $this->view->render(
        //     "admin/subjects/list.php",
        //     [
        //         'subjects' => $data,
        //         'teachers' => $teacher_names,
        //         'standards' => $standard_names
        //     ]
        // );
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
        if (!empty($teachers_subject)) {
            foreach ($teachers_subject as $t) {
                $teacher_sub[] = $t['teacher_id'];
            }
        }
        $stds = $this->standards_service->get_sub_std();
        $stds_sub = $this->standards_service->get_sub_std_id();
        $std_ids = [];
        if (!empty($stds_sub)) {
            foreach ($stds_sub as $std) {
                $std_ids[] = $std['id'];
            }
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
        $teachers_subject = $this->teacher_service->get_teachers(sid: (int)$params['sub_id']);
        // dd($teachers_subject);
        $teacher_sub = [];
        foreach ($teachers_subject as $t) {
            $teacher_sub[] = $t['id'];
        }
        $filtered_teachers = array_filter($teachers, function ($teacher) use ($teacher_sub) {
            return !in_array($teacher['id'], $teacher_sub);
        });


        $stds_sub = $this->standards_service->get_sub_std_id((int)$params['sub_id']);
        // dd($stds_sub);
        $stds = $this->standards_service->get_sub_std();

        $std_ids = [];

        foreach ($stds_sub as $std) {
            $std_ids[] = $std['id'];
        }


        $filtered_stds = array_filter($stds, function ($std) use ($std_ids) {
            return !in_array($std['id'], $std_ids);
        });;
        echo $this->view->render(
            "admin/subjects/edit.php",
            [
                'teachers_subject' => $teachers_subject,
                'teachers' => $filtered_teachers,
                'teachers_sub' => $teacher_sub,
                'stds' => $filtered_stds,
                'standards' => $stds_sub,
                'std_ids' => $std_ids,
                'sub' => $sub,
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
        // $this->subject_service->is_subject_added(strtoupper($_POST['sub_code']), $_POST['sub_name'], (int) $params['sub_id']);
        $this->user_service->is_record_added('subjects', 'code', $_POST['sub_code'], '`id`!=' . (int) $params['sub_id'], 'sub_code');
        $this->user_service->is_record_added('subjects', 'name', $_POST['sub_name'], '`id`!=' . (int) $params['sub_id'], 'sub_name');
        $this->subject_service->update($_POST, (int) $params['sub_id']);
        redirectTo($_SERVER['HTTP_REFERER']);
    }
}
