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

class StandardService
{


    public function __construct(private Database $db)
    {
    }

    public function total_standards()
    {
        $query = "SELECT COUNT(*) FROM `standards`";
        return (($this->db->query($query)->find())['COUNT(*)']);
    }

    public function get_standards_data(int $id = 0)
    {


        if ($id != 0) {
            $query = "";
        } else {
            $query = "SELECT `std`.id AS `standards_id`, `std`.`name` AS `standards_name`, (SELECT COUNT(`sub`.`subject_id`) FROM `std_sub` AS `sub` WHERE `sub`.`standard_id` = `std`.`id`) AS `subjects_count`, (SELECT COUNT(`teachers_std`.`teacher_id`) FROM `teachers_std` JOIN `std_sub` ON `std_sub`.`standard_id` = `teachers_std`.`standard_id` WHERE `std_sub`.`standard_id` = `std`.`id`) AS `teacher_count`, (SELECT COUNT(`student`.`id`) FROM `student` JOIN `standards` ON `standards`.`id` = `student`.`standard_id` WHERE `student`.`standard_id` = `std`.`id` ) as `student_count` FROM `standards` AS `std` LEFT JOIN `std_sub` ON `std`.`id` = `std_sub`.`standard_id` GROUP BY `std`.`id`, `std`.`name`;";
        }
        // dd($query);
        if ($id != 0) {
            $params = [
                'name' => $id
            ];
        } else {
            $params = [];
        }
        return ($this->db->query($query, $params)->find_all());
    }
}
