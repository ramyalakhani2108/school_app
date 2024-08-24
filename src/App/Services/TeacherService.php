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


    public function __construct(private Database $db) {}

    public function  remove_subs_teacher(int $sub_id, int $tid)
    {

        $query = "UPDATE `teacher_subjects` SET `status`='0' WHERE `subject_id`=:subid AND `teacher_id`=:tid";
        // dd($query);
        $this->db->query(
            $query,
            [
                'subid' => $sub_id,
                'tid' => $tid
            ]
        );
    }
    public function  remove_stds_teacher(int $std_id, int $tid)
    {

        $query = "UPDATE `teachers_std` SET `status`='0' WHERE `standard_id`=:std_id AND `teacher_id`=:tid";
        // dd($query);
        $this->db->query(
            $query,
            [
                'std_id' => $std_id,
                'tid' => $tid
            ]
        );
    }
    public function update(array $data)
    {
        try {
            $this->db->beginTransaction();
            $fields = [];
            $params = [];
            foreach ($data as $k => $v) {


                if ($k == 'selected_standards' || $k == 'selected_subjects') {
                    ${"$k"} = [];

                    foreach ($data[$k] as $value) {
                        ${"$k"}[] = (int) $value;
                    }
                    ${"$k"} = implode(",", ${"$k"});
                    // $fields[] = "`$k`" . " IN (" . ${"$k"} . ")";

                    continue;
                }
                $params[$k] = $v;
                if ($k == 'tid') {
                    continue;
                }
                $fields[] = "`$k`=:$k";
            }
            $fields = (implode(",", $fields));
            $params['gender'] = strtoupper($params['gender'][0]);

            $query = "UPDATE `staff` SET " . $fields . " WHERE `id`=:tid";
            $this->db->query($query, $params);

            if (array_key_exists('selected_standards', $data)) {
                // dd($selected_standards);
                $query = "INSERT INTO `teachers_std` (`teacher_id`,`standard_id`) SELECT :tid,`id`FROM `standards` WHERE `id` IN ($selected_standards) ";
                // dd($query);
                $this->db->query($query, ['tid' => (int)$data['tid']]);
            }
            if (array_key_exists('selected_subjects', $data)) {
                $query = "INSERT INTO `teacher_subjects` (`teacher_id`,`subject_id`) SELECT :tid,`id` FROM `subjects` WHERE `id` IN ($selected_subjects)";
                $this->db->query($query, ['tid' => (int)$data['tid']]);
            }
            $this->db->endTransaction();
        } catch (Exception $e) {
            $this->db->cancelTransaction();
            // dd($e->getMessage());
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

    public function get_teacher_subs(int $tid)
    {
        $query = "SELECT `std`.`id`,`std`.`name`
FROM `standards` as `std`
JOIN `teachers_std`
ON `teachers_std`.`standard_id`=`std`.`id`
WHERE `teachers_std`.`teacher_id`=:tid AND `status`=1;";
        return $this->db->query($query, ['tid' => $tid])->find_all();
    }
    public function filtered_teacher(array $names=[], string $table_name, string $searched = '', string $order_by = "id", string $order = "ASC",$limit=10,$offset=0)
    {
        $names = implode("','", $names);
        // dd($names);
        // dd($names);
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

        
        $role_where = "     AND 
    `staff`.`role_id` NOT IN ('1')";
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
LEFT JOIN 
	`teacher_subjects` ON `teacher_subjects`.`teacher_id` = `staff`.`id`
LEFT JOIN `subjects` ON `teacher_subjects`.`subject_id`=`subjects`.`id`
LEFT JOIN `std_sub` ON `std_sub`.`subject_id` =`subjects`.`id`
LEFT JOIN `standards` ON `standards`.`id`=`std_sub`.`standard_id`
WHERE".
    
    (($names == '1' || $names == '0' || $names = '1\',\'2')?
             " `$table_name`.`status` IN ('$names') "
        
        :
    "         `$table_name`.`name` IN ('$names') ")
    
."
    $search_query

   $role_where 
GROUP BY 
    ".
    (($names == '1' || $names == '0' || $names = '1\',\'2')?
        "`staff`.`id`;"
        :
        "`teacher_subjects`.`id`;"
    )."
";
// dd($query);
        $result = $this->db->query($query,$params)->find_all();
       $count = count($result);
       $query .= " LIMIT $limit OFFSET $offset;";
              $result = $this->db->query($query,$params)->find_all();
return([$result, $count]);
    }
    public function get_search_results(string|int $search, string $order_by = "id", string $order = "ASC",$limit=8,$offset=0)
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
    $params= ['searched' => $searched];
               $result = $this->db->query($query,$params)->find_all();
       $count = count($result);
       $query .= " LIMIT $limit OFFSET $offset;";
              $result = $this->db->query($query,$params)->find_all();
return([$result, $count]);
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
    `teachers_std`.`teacher_id` = :tid AND `teachers_std`.`status`=1";

            return $this->db->query($query, ['tid' => $id])->find_all();
        }
    }
    public function get_sub_teacher(int $id = 0)
    {
        if ($id != 0) {
            $query = "SELECT DISTINCT
    `subjects`.`name` ,`subjects`.`id`
FROM
    `subjects`
JOIN `teacher_subjects` ON `teacher_subjects`.`subject_id` = `subjects`.`id`
WHERE
    `teacher_subjects`.`teacher_id` = :tid AND `teacher_subjects`.`status`=1";
            // dd($query);
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

    public function get_teacher_data(string|int $name = 0, string $order_by = "id", $order = "ASC",$limit = 10,$offset=0)
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
        $params =[];
        $result = $this->db->query($query,$params)->find_all();
       $count = count($result);
       $query .= " LIMIT $limit OFFSET $offset;";
              $result = $this->db->query($query,$params)->find_all();
return([$result, $count]);
    }
    public function get_teachers(int $id = 0, int $sid = 0)
    {
        $params = [
            'rid' => 2
        ];

        if ($id != 0) {
            $query = "SELECT * FROM `staff` WHERE `role_id` = :rid AND `id` = :id";
            $params['id'] = $id;
        } else if ($sid != 0) {

            $query = "
            SELECT DISTINCT 
                `teacher_subjects`.`subject_id`,
                `staff`.`id`,
                `staff`.`name`,
                `staff`.`email`
            FROM 
                `staff`
            JOIN 
                `teacher_subjects` ON `teacher_subjects`.`teacher_id` = `staff`.`id`
            WHERE 
                `teacher_subjects`.`subject_id` = :sid 
                AND `staff`.`role_id` = :rid
        ";
            $params['sid'] = $sid;
        } else {
            $query = "SELECT `id`, `name`,`email` FROM `staff` WHERE `role_id` = :rid";
        }

        return ($this->db->query($query, $params)->find_all());
    }
}
