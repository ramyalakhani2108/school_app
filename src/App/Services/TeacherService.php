<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Database;
use Framework\Rules\{DateRule, RequiredRule, EmailRule, NameRule, PassRule, PhoneRule};
use Framework\Rules\Subject_rules\ClassNameRule;
use Framework\Rules\Subject_rules\SubjectCodeRule;
use Framework\Rules\Subject_rules\SubjectNameRule;
use Framework\Rules\Subject_rules\SubjectTeacherNameRule;
use Framework\Validator;

class TeacherService
{


    public function __construct(private Database $db)
    {
    }

    public function total_teachers()
    {
        $query = "SELECT COUNT(*) FROM `staffs` WHERE `role_id`=:rid";
        return (($this->db->query($query, ['rid' => 2])->find())['COUNT(*)']);
    }

    public function get_teachers_subject()
    {
        $query = "SELECT `id` FROM `subjects`";
        $last_sub_id = $this->db->query($query)->find_all();
        $last_sub_id = end($last_sub_id)['id'];

        $query = "SELECT `teacher_id` FROM `teacher_subjects` WHERE  `subject_id`=:sid ";

        return $this->db->query($query, [
            'sid' => $last_sub_id
        ])->find_all();
    }

    public function get_teachers(int $id = 0)
    {
        if ($id == 0) {
            $query = "SELECT `id`,`name`,`email` FROM  `staff` WHERE `role_id`=:rid";
            return ($this->db->query(
                $query,
                [
                    'rid' => 2
                ]
            )->find_all());
        } else {
            $query = "SELECT `id` FROM `teacher_subjects` WHERE `subject_id`=`:sid`";
        }
    }
}
