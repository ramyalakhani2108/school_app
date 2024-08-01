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

    public function get_teachers_subject(int $sid = 0)
    {
        if ($sid != 0) {

            // SELECT DISTINCT `staff`.`name` FROM `staff` JOIN `teacher_subjects` ON `teacher_subjects`.`teacher_id` = `staff`.`id` WHERE `teacher_subjects`.`subject_id` = 119; //getting teacher name as per std table

            $query = "SELECT DISTINCT `teacher_subjects`.`subject_id`,`staff`.`id`,`staff`.`name`,`staff`.`email` FROM `staff` JOIN `teacher_subjects` ON `teacher_subjects`.`teacher_id` = `staff`.`id` WHERE `teacher_subjects`.`subject_id` = :sid; ";

            return ($this->db->query($query, [
                'sid' => $sid
            ])->find_all());
        }
    }

    public function get_teachers_std(int $stid = 0)
    {
        if ($stid != 0) {

            // SELECT DISTINCT `staff`.`name` FROM `staff` JOIN `teacher_subjects` ON `teacher_subjects`.`teacher_id` = `staff`.`id` WHERE `teacher_subjects`.`subject_id` = 119; //getting teacher name as per std table

            $query = "SELECT DISTINCT
    `teachers_std`.`standard_id`,
    `staff`.`id`,
    `staff`.`name`,
    `staff`.`email`
FROM
    `staff`
JOIN `teachers_std` ON `teachers_std`.`teacher_id` = `staff`.`id`
WHERE
    `teachers_std`.`standard_id` = :stid;";

            return ($this->db->query($query, [
                'stid' => $stid
            ])->find_all());
        }
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
        }
    }
}
