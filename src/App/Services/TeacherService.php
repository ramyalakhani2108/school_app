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


    public function get_teachers_data(
        string|int $name = 0,
        string $order_by = "id",
        $order = "ASC"
    ) {
        if ($order_by == "id") {
            $order_by = " ORDER BY `staff`.`id`  ";
        } else if ($order_by == "students") {
            $order_by = " ORDER BY `subjects_count`  ";
        } else if ($order_by == "teachers") {
            $order_by = " ORDER BY `teacher_count`  ";
        } else if ($order_by == "name") {
            $order_by = " ORDER BY `std`.`name`  ";
        } else {
            $order_by = " ORDER BY `staff`.`id`  ";
        }

        if ($name != 0) {
            $query = "SELECT
    `std`.id AS `standards_id`,
    `std`.`name` AS `standards_name`,
  	GROUP_CONCAT(`teachers_std`.`teacher_id` SEPARATOR ',')as `teacher_name`,
	GROUP_CONCAT(DISTINCT `staff`.`name` SEPARATOR ',' ) as `staff name`,
	GROUP_CONCAT(DISTINCT `subjects`.`name` SEPARATOR ',' ) as `staff name`,

    (
    SELECT
        COUNT(`sub`.`subject_id`)
    FROM
        `std_sub` AS `sub`
    WHERE
        `sub`.`standard_id` = `std`.`id`
) AS `subjects_count`,
(
    SELECT
        COUNT(`teachers_std`.`teacher_id`)
    FROM
        `teachers_std`
    WHERE
        `teachers_std`.`standard_id` = `std`.`id`
) AS `teacher_count`,
(
    SELECT
        COUNT(`student`.`id`)
    FROM
        `student`
    JOIN `standards` ON `standards`.`id` = `student`.`standard_id`
    WHERE
        `student`.`standard_id` = `std`.`id`
) AS `student_count`
	
FROM
    `standards` AS `std`
LEFT JOIN `std_sub` ON `std`.`id` = `std_sub`.`standard_id`
LEFT JOIN `subjects` ON `std_sub`.`subject_id` = `subjects`.`id`
LEFT JOIN `teachers_std` ON `teachers_std`.`standard_id`=`std_sub`.`standard_id`
LEFT JOIN `staff` ON `staff`.`id` = `teachers_std`.`teacher_id`
WHERE `std`.`name` LIKE '%$name%'
OR `staff`.`name` LIKE '%$name%'
OR `subjects`.`name` LIKE '%$name%'

GROUP BY
    `std`.`id`,
    `std`.`name`
  " . $order_by . $order . "  
    ;";
        } else {

            $query = "SELECT
    `staff`.`id` AS `staff_ids`,
    `staff`.`name` AS `staff_names`,
    
    (
    SELECT
        COUNT(`teachers_std`.`standard_id`)
    FROM
        `teachers_std`
    WHERE
        `teachers_std`.`teacher_id` = `staff`.`id`

) AS `total_standards`,
(
    SELECT
        COUNT(`teacher_subjects`.`subject_id`)
    FROM
        `teacher_subjects`
    WHERE
        `teacher_subjects`.`teacher_id` = `staff`.`id`
) AS `total_subjects`
FROM
    `staff`
LEFT JOIN 
	`teacher_subjects` ON `teacher_subjects`.`teacher_id` = `staff`.`id`
LEFT JOIN `subjects` ON `teacher_subjects`.`subject_id`=`subjects`.`id`
LEFT JOIN `std_sub` ON `std_sub`.`subject_id` =`subjects`.`id`
LEFT JOIN `standards` ON `standards`.`id`=`std_sub`.`standard_id`
GROUP BY 
    `teacher_subjects`.`id`" . $order_by . $order . "  
   ;";
        }
        dd($query);
        dd($this->db->query($query)->find_all());
    }

    public function filtered_teacher(array $names, string $table_name)
    {

        $names = implode("','", $names);


        $query
            = "SELECT
    `staff`.`id` AS `staff_ids`,
    `staff`.`name` AS `staff_names`,
    
    (
    SELECT
        COUNT(`teachers_std`.`standard_id`)
    FROM
        `teachers_std`
    WHERE
        `teachers_std`.`teacher_id` = `staff`.`id`

) AS `total_standards`,
(
    SELECT
        COUNT(`teacher_subjects`.`subject_id`)
    FROM
        `teacher_subjects`
    WHERE
        `teacher_subjects`.`teacher_id` = `staff`.`id`
) AS `total_subjects`
FROM
    `staff`
JOIN 
	`teacher_subjects` ON `teacher_subjects`.`teacher_id` = `staff`.`id`
JOIN `subjects` ON `teacher_subjects`.`subject_id`=`subjects`.`id`
JOIN `std_sub` ON `std_sub`.`subject_id` =`subjects`.`id`
JOIN `standards` ON `standards`.`id`=`std_sub`.`standard_id`
WHERE
    `subjects`.`name` IN ('$names')
GROUP BY 
    `teacher_subjects`.`id`;
";
        // dd($query);
        return ($this->db->query($query)->find_all());
    }
    public function get_search_results(string|int $search)
    {

        $query = "SELECT
    `staff`.`id` AS `staff_ids`,
    `staff`.`name` AS `staff_names`,
    
    (
    SELECT
        COUNT(`teachers_std`.`standard_id`)
    FROM
        `teachers_std`
    WHERE
        `teachers_std`.`teacher_id` = `staff`.`id`

) AS `total_standards`,
(
    SELECT
        COUNT(`teacher_subjects`.`subject_id`)
    FROM
        `teacher_subjects`
    WHERE
        `teacher_subjects`.`teacher_id` = `staff`.`id`
) AS `total_subjects`
FROM
    `staff`
JOIN 
	`teacher_subjects` ON `teacher_subjects`.`teacher_id` = `staff`.`id`
JOIN `subjects` ON `teacher_subjects`.`subject_id`=`subjects`.`id`
JOIN `std_sub` ON `std_sub`.`subject_id` =`subjects`.`id`
JOIN `standards` ON `standards`.`id`=`std_sub`.`standard_id`
WHERE 
	`staff`.`name` LIKE '%$search%'
OR 
	`standards`.`name` LIKE '%$search%'
OR 
	`subjects`.`name`LIKE '%$search%';";

        dd($this->db->query($query)->find_all());
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
