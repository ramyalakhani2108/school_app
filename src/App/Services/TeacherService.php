<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Framework\Database;
use Framework\Exceptions\ValidationException;
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

    public function update(array $data)
    {
        try {
            $this->db->beginTransaction();
            $fields = [];
            $selected_ids = [];
            foreach ($data as $k => $v) {
                if ($k == 'selected_standards' || $k == 'selected_subjects') {
                    ${"$k"} = [];

                    foreach ($data[$k] as $value) {
                        ${"$k"}[] = (int) $value;
                    }
                    dd($selected_subjects);
                    continue;
                }
                $fields[] = "`$k`=:$v";
            }
            dd(implode(",", $fields));

            $query = "UPDATE `staff` SET `name`";
            $this->db->endTransaction();
        } catch (Exception $e) {
            $this->db->cancelTransaction();
            dd($e->getMessage());
            throw new ValidationException(['name' => ['couldn\'t update the records']]);
        }
    }

    public function get_teachers_data(
        string|int $name = 0,
        string $order_by = "id",
        $order = "ASC"
    ) {
        if ($order_by == "id") {
            $order_by = " ORDER BY `staff`.`id`  ";
        } else if ($order_by == "standards") {
            $order_by = " ORDER BY `total_standards`  ";
        } else if ($order_by == "subjects") {
            $order_by = " ORDER BY `total_subjects`  ";
        } else if ($order_by == "name") {
            $order_by = " ORDER BY `staff`.`name`  ";
        } else if ($order_by == "email") {
            $order_by = " ORDER BY `staff`.`email`  ";
        } else if ($order_by == "status") {
            $order_by = " ORDER BY `staff`.`status`  ";
        } else if ($order_by == "dept") {
            $order_by = " ORDER BY `staff`.`department`  ";
        } else if ($order_by == "phone") {
            $order_by = " ORDER BY `staff`.`phone`  ";
        } else if ($order_by == "dob") {
            $order_by = " ORDER BY `staff`.`dob`  ";
        } else if ($order_by == "gender") {
            $order_by = " ORDER BY `staff`.`gender`  ";
        } else {
            $order_by = " ORDER BY `staff`.`id`  ";
        }

        if ($name != 0) {
            $query = "SELECT
    `std`.id AS `standards_id`,
    `std`.`name` AS `standards_name`,
 `staff`.`email` AS `staff_emails`,
    `staff`.`phone` AS `staff_phones`,
    `staff`.`storage_filename` AS `staff_profile`,
    `staff`.`dob` AS `staff_dobs`,
    `staff`.`status` AS `staff_status`,
    `staff`.`gender` AS `staff_gender`,
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
     `staff`.`email` AS `staff_emails`,
    `staff`.`phone` AS `staff_phones`,
    `staff`.`storage_filename` AS `staff_profile`,
    `staff`.`dob` AS `staff_dobs`,
    `staff`.`status` AS `staff_status`,
    `staff`.`gender` AS `staff_gender`,
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
        // dd($query);
        // dd($this->db->query($query)->find_all());
    }

    public function filtered_teacher(array $names, string $table_name, string $searched = '', string $order_by = "id", string $order = "ASC")
    {

        $names = implode("','", $names);
        // dd($searched);
        $params = [];
        if ($searched != '') {
            $search_query = "AND (
	`staff`.`name` IN (SELECT `staff`.`name` FROM `staff` WHERE `staff`.`name` LIKE :searched)
    OR 
	`subjects`.`name` IN (SELECT `subjects`.`name` FROM `subjects` WHERE `subjects`.`name` LIKE :searched)
	OR 
	`standards`.`name` IN (SELECT `standards`.`name` FROm `standards` WHERE `standards`.`name` LIKE :searched)
    )";
            $searched = "%{$searched}%";
            $params['searched'] = $searched;
        } else {
            $search_query = "";
        }

        $query
            = "SELECT
    `staff`.`id` AS `staff_ids`,
    `staff`.`name` AS `staff_names`,
     `staff`.`email` AS `staff_emails`,
    `staff`.`phone` AS `staff_phones`,
    `staff`.`storage_filename` AS `staff_profile`,
    `staff`.`dob` AS `staff_dobs`,
    `staff`.`status` AS `staff_status`,
    `staff`.`gender` AS `staff_gender`,
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
    `$table_name`.`name` IN ('$names')

    $search_query
GROUP BY 
    `teacher_subjects`.`id`;
";
        // dd($query);
        return ($this->db->query($query, $params)->find_all());
    }
    public function get_search_results(string|int $search, string $order_by = "id", string $order = "ASC")
    {
        if ($order_by == "id") {
            $order_by = " ORDER BY `staff`.`id`  ";
        } else if ($order_by == "standards") {
            $order_by = " ORDER BY `total_standards`  ";
        } else if ($order_by == "subjects") {
            $order_by = " ORDER BY `total_subjects`  ";
        } else if ($order_by == "name") {
            $order_by = " ORDER BY `staff`.`name`  ";
        } else if ($order_by == "email") {
            $order_by = " ORDER BY `staff`.`email`  ";
        } else if ($order_by == "status") {
            $order_by = " ORDER BY `staff`.`status`  ";
        } else if ($order_by == "dept") {
            $order_by = " ORDER BY `staff`.`department`  ";
        } else if ($order_by == "phone") {
            $order_by = " ORDER BY `staff`.`phone`  ";
        } else if ($order_by == "dob") {
            $order_by = " ORDER BY `staff`.`dob`  ";
        } else if ($order_by == "gender") {
            $order_by = " ORDER BY `staff`.`gender`  ";
        } else {
            $order_by = " ORDER BY `staff`.`id`  ";
        }

        $search = "%{$search}%";

        $query = "SELECT
    `staff`.`id` AS `staff_ids`,
    `staff`.`name` AS `staff_names`,
    `staff`.`email` AS `staff_emails`,
    `staff`.`phone` AS `staff_phones`,
    `staff`.`storage_filename` AS `staff_profile`,
    `staff`.`dob` AS `staff_dobs`,
    `staff`.`status` AS `staff_status`,
    `staff`.`gender` AS `staff_gender`,
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
LEFT JOIN `teacher_subjects` ON `teacher_subjects`.`teacher_id` = `staff`.`id`
LEFT JOIN `subjects` ON `teacher_subjects`.`subject_id` = `subjects`.`id`
LEFT JOIN `std_sub` ON `std_sub`.`subject_id` = `subjects`.`id`
LEFT JOIN `standards` ON `standards`.`id` = `std_sub`.`standard_id`
WHERE
    `staff`.`role_id` = 2
	AND 
	(
    	`staff`.`name` LIKE :searched
        OR 
        `standards`.`name` LIKE :searched
        OR 
        `subjects`.`name` LIKE :searched
    )
GROUP BY
    `staff`.`id`
    $order_by $order
    ";
        // dd($query);
        return ($this->db->query($query, ['searched' => $search])->find_all());
    }
    public function total_teachers()
    {
        $query = "SELECT COUNT(*) FROM `staffs` WHERE `role_id`=:rid";
        return (($this->db->query($query, ['rid' => 2])->find())['COUNT(*)']);
    }

    public function get_std_teacher(int $id = 0)
    {
        if ($id != 0) {
            $query = "SELECT
    `standards`.`name` ,`standards`.`id`
FROM
    `standards`
JOIN `teachers_std` ON `teachers_std`.`standard_id` = `standards`.`id`
WHERE
    `teachers_std`.`teacher_id` = :tid;";

            return $this->db->query($query, ['tid' => $id])->find_all();
        }
    }
    public function get_sub_teacher(int $id = 0)
    {
        if ($id != 0) {
            $query = "SELECT
    `subjects`.`name` ,`subjects`.`id`
FROM
    `subjects`
JOIN `teacher_subjects` ON `teacher_subjects`.`subject_id` = `subjects`.`id`
WHERE
    `teacher_subjects`.`teacher_id` = :tid;";

            return $this->db->query($query, ['tid' => $id])->find_all();
        }
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

    public function get_teacher_data(string|int $name = 0, string $order_by = "id", $order = "ASC")
    {

        if ($order_by == "id") {
            $order_by = " ORDER BY `staff`.`id`  ";
        } else if ($order_by == "standards") {
            $order_by = " ORDER BY `total_standards`  ";
        } else if ($order_by == "subjects") {
            $order_by = " ORDER BY `total_subjects`  ";
        } else if ($order_by == "name") {
            $order_by = " ORDER BY `staff`.`name`  ";
        } else if ($order_by == "email") {
            $order_by = " ORDER BY `staff`.`email`  ";
        } else if ($order_by == "status") {
            $order_by = " ORDER BY `staff`.`status`  ";
        } else if ($order_by == "dept") {
            $order_by = " ORDER BY `staff`.`department`  ";
        } else if ($order_by == "phone") {
            $order_by = " ORDER BY `staff`.`phone`  ";
        } else if ($order_by == "dob") {
            $order_by = " ORDER BY `staff`.`dob`  ";
        } else if ($order_by == "gender") {
            $order_by = " ORDER BY `staff`.`gender`  ";
        } else {
            $order_by = " ORDER BY `staff`.`id`  ";
        }


        $query = "
        SELECT
    `staff`.`id` AS `staff_ids`,
    `staff`.`name` AS `staff_names`,
     `staff`.`email` AS `staff_emails`,
    `staff`.`phone` AS `staff_phones`,
    `staff`.`storage_filename` AS `staff_profile`,
    `staff`.`dob` AS `staff_dobs`,
    `staff`.`status` AS `staff_status`,
    `staff`.`gender` AS `staff_gender`,
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
LEFT JOIN `teacher_subjects` ON `teacher_subjects`.`teacher_id` = `staff`.`id`
LEFT JOIN `subjects` ON `teacher_subjects`.`subject_id` = `subjects`.`id`
LEFT JOIN `std_sub` ON `std_sub`.`subject_id` = `subjects`.`id`
LEFT JOIN `standards` ON `standards`.`id` = `std_sub`.`standard_id`
WHERE
    `staff`.`role_id` = 2
GROUP BY
    `staff`.`id`
$order_by $order
        ";

        return $this->db->query($query)->find_all();
    }
    public function get_teachers(int $id = 0)
    {
        $params = [
            'rid' => 2
        ];
        if ($id == 0) {
            $query = "SELECT `id`,`name` FROM  `staff` WHERE `role_id`=:rid";
        } else {
            $query = "SELECT * FROM `staff` WHERE `role_id`=:rid AND `id`=:id";
            $params['id'] = $id;
        }
        return ($this->db->query(
            $query,
            $params
        )->find_all());
    }
}
