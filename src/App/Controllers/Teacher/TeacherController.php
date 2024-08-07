<?php

declare(strict_types=1);

namespace App\Controllers\Teacher;

use App\Services\StandardService;
use App\Services\SubjectService;
use App\Services\TeacherService;
use App\Services\ValidatorService;
use Framework\TemplateEngine;

class TeacherController
{
    public function __construct(
        private TemplateEngine $view,
        private TeacherService $teacher_service,
        private SubjectService $subject_service,
        private StandardService $standards_service,
        private ValidatorService $validator_service
    ) {
    }

    public function teacher_view()
    {
        echo $this->view->render("teacher/show_teachers.php");
    }

    public function admin_teacher_view()
    {
        //SELECT `staff`.`id` AS `staff_ids`, `staff`.`name` as `staff_names`, ( SELECT COUNT(`teachers_std`.`standard_id`) FROM `teachers_std` WHERE `teachers_std`.`teacher_id` = `staff`.`id` ) AS `total_standards`, ( SELECT COUNT(`teacher_subjects`.`subject_id`) FROM `teacher_subjects` WHERE `teacher_subjects`.`teacher_id`=`staff`.`id` ) AS `total_subjects` FROM `staff` WHERE `staff`.`role_id`=2;
        $filtered_teacher = [];
        $subjects = $this->subject_service->get_std_sub();
        foreach ($subjects as $subject) {
            $subject_names[] = $subject['name'];
        }
        $teachers = $this->teacher_service->get_teachers();
        $teacher_names = [];
        foreach ($teachers as $teacher) {
            $teacher_names[] = $teacher['name'];
        }
        $standards = $this->standards_service->get_standard();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (array_key_exists('teacher_names', $_POST)) {
                $params = $_POST['teacher_names'];
                $names = [];
                foreach ($params as $param) {
                    $names[] = urldecode($param);
                }
                $filtered_teacher[] = $this->standards_service->filtered_standards($names, 'staff');
            }

            if (array_key_exists('subjects_name', $_POST)) {
                $params = $_POST['subjects_name'];

                $names = [];
                foreach ($params as $param) {
                    $names[] = urldecode($param);
                }
                $filtered_teacher[] = $this->standards_service->filtered_standards($names, 'subjects');
            }
        }
        if (isset($_GET['s'])) {
            $search = urldecode(htmlspecialchars(trim($_GET['s'])));
            $filtered_teacher[] = array_merge($filtered_teacher, $this->teacher_service->get_search_results($search));
        }
        $standard_names = [];
        foreach ($standards as $standard) {
            $standard_names[] = $standard['name'];
        }

        $search = 0;
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['s'])) {
            $search = urldecode(htmlspecialchars(trim($_GET['s'])));
            $filtered_teacher[] = array_merge($filtered_teacher, $this->subject_service->get_search_results($search));
        } else if (
            $_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['sort']) && isset($_GET['order'])
        ) {
            $filtered_teacher[] = $this->standards_service->get_standards_data(order_by: $_GET['sort'], order: $_GET['order']);
        } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $filtered_teacher[] = $this->teacher_service->get_teachers_data();
        }
        echo $this->view->render(
            "/admin/teachers/list.php",
            [
                // 'standards' => $standards,
                // 'filtered_standard' => $filtered_standards,
                'teachers' => $teacher_names,
                'subjects' => $subject_names,
                'standards' => $standard_names
            ]
        );
    }
}
