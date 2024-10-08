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

class StandardService
{


    public function __construct(private Database $db) {}

    public function total_standards()
    {
        $query = "SELECT COUNT(*) FROM `standards`";
        return (($this->db->query($query)->find())['COUNT(*)']);
    }


    public function filtered_standards(array $names, string $table_name, string $searched = '', string $order_by = "id", string $order = "ASC")
    {
        if ($order_by == "id") {
            $order_by = " ORDER BY `std`.`id`  ";
        } else if ($order_by == "students") {
            $order_by = " ORDER BY `subjects_count`  ";
        } else if ($order_by == "teachers") {
            $order_by = " ORDER BY `teacher_count`  ";
        } else if ($order_by == "name") {
            $order_by = " ORDER BY `std`.`name`  ";
        } else {
            $order_by = " ORDER BY `std`.`id`  ";
        }

        $names = implode("','", $names);
        $searched = "%{$searched}%";
        $query = "
    SELECT
        std.id AS standards_id,
        std.name AS standards_name,
        GROUP_CONCAT(
            DISTINCT teachers_std.teacher_id SEPARATOR ','
        ) AS teacher_name,
        GROUP_CONCAT(
            DISTINCT staff.name SEPARATOR ','
        ) AS staff_name,
        GROUP_CONCAT(
            DISTINCT subjects.name SEPARATOR ','
        ) AS subjects_name,
        (
            SELECT
                COUNT(sub.subject_id)
            FROM
                std_sub AS sub
            WHERE
                sub.standard_id = std.id
        ) AS subjects_count,
        (
            SELECT
                COUNT(
                    DISTINCT teachers_std.teacher_id
                )
            FROM
                teachers_std
            WHERE
                teachers_std.standard_id = std.id
        ) AS teacher_count,
        (
            SELECT
                COUNT(student.id)
            FROM
                student
            WHERE
                student.standard_id = std.id
        ) AS student_count
    FROM
        standards AS std
    LEFT JOIN std_sub ON std.id = std_sub.standard_id
    LEFT JOIN subjects ON std_sub.subject_id = subjects.id
    LEFT JOIN teachers_std ON teachers_std.standard_id = std.id
    LEFT JOIN staff ON staff.id = teachers_std.teacher_id
    WHERE
        std.id IN (
            SELECT
                std1.id
            FROM
                standards AS std1
            LEFT JOIN teachers_std AS ts1
                ON std1.id = ts1.standard_id
            LEFT JOIN $table_name as s1
                ON ts1.teacher_id = s1.id
            WHERE
                s1.name = 'Emily Davis'
        ) AND std.id IN (
            SELECT
                std2.id
            FROM
                standards AS std2
            LEFT JOIN teachers_std AS ts2
                ON std2.id = ts2.standard_id
            LEFT JOIN $table_name AS s2
                ON ts2.teacher_id = s2.id
            WHERE
                s2.name LIKE :searched
        )
    GROUP BY
        std.id,
        std.name
   
        $order_by $order
;";
        // dd($query);
        return $this->db->query($query, ['searched' => $searched])->find_all();
    }
    public function get_standard(int $id = 0)
    {
        if ($id == 0) {

            $query = "SELECT `id`,`name` FROM `standards`";
            return $this->db->query($query)->find_all();
        } else {
            $query = "SELECT `id`,`name` FROM `standards` WHERE `id`=:id";
            return $this->db->query($query, ['id' => $id])->find();
        }
    }

    public function get_standards(int $id = 0, array $ignore = [])
    {
        $ids = [];
        $where = "";
        if (!empty($ignore)) {
            foreach ($ignore as $ig) {
                foreach ($ig as $i) {
                    $ids[] = $i['id'];
                }
            }
            $ids = implode(",", $ids);
            $where = " WHERE  id NOT IN ($ids)";
        } else {
            $where = "";
        }

        $params = [];
        if ($id != 0) {
            $query = "SELECT DISTINCT `std`.`id`, `std`.`name` FROM `standards` as `std` LEFT JOIN `std_sub` ON `std`.`id` = `std_sub`.`standard_id` WHERE `std_sub`.`subject_id`=:sid";
            $params['sid'] = $id;
        } else {
            $query = "SELECT `id`,`name` FROM `standards`" . $where;
        }
        return $this->db->query($query, $params)->find_all();
    }

    public function delete_standards($selected_standards)
    {
        foreach ($_POST['selected_ids'] as $stds) {
            $selected_standards[] = (int) $stds;
        }
        // dd($selected_standards);
        try {
            $this->db->beginTransaction();

            $selected_standards = implode(",", $selected_standards);
            // dd($selected_standards);
            $query = "DELETE FROM `standards` WHERE `name` IN ($selected_standards)";
            $this->db->query($query);
            $this->db->endTransaction();
        } catch (Exception $e) {
            $this->db->cancelTransaction();
        }
    }

    public function get_sub_std_id(int $id = 0)
    {
        $query = "SELECT `id` FROM `subjects`";
        $last_sub_id = $this->db->query($query)->find_all();
        $last_sub_id = end($last_sub_id)['id'];

        $query = "SELECT DISTINCT `std`.`id`, `std`.`name` FROM `standards` as `std` LEFT JOIN `std_sub` ON `std`.`id` = `std_sub`.`standard_id` WHERE `std_sub`.`subject_id`=:sid";

        $params = [];
        if ($id != 0) {
            $params =
                [
                    'sid' => $id
                ];
        } else {
            $params = [
                'sid' => $last_sub_id
            ];
        }
        return ($this->db->query(
            $query,
            $params
        )->find_all());
    }
    public function get_standard_sub()
    {

        $query = "SELECT `id`,`name`,`code` FROM `subjects`";
        return $this->db->query($query)->find_all();
    }
    public function get_standard_subjects(int $id = 0)
    {

        //getting subjects as per standard
        $query = "SELECT `id` FROM `standards`";
        $last_std_id = $this->db->query($query)->find_all();
        $last_std_id = end($last_std_id)['id'];
        $query = "SELECT DISTINCT `sub`.`id`, `sub`.`name`,`sub`.`code` FROM `subjects` as `sub` LEFT JOIN `std_sub` ON `sub`.`id` = `std_sub`.`subject_id` WHERE `std_sub`.`standard_id`=:sid";

        $params = [];
        if ($id != 0) {
            $params =
                [
                    'sid' => $id
                ];
        } else {
            $params = [
                'sid' => $last_std_id
            ];
        }
        return ($this->db->query(
            $query,
            $params
        )->find_all());
    }
    public function get_search_results(string|int $search, string $order_by = "id", string $order = "ASC")
    {
        if ($order_by == "id") {
            $order_by = " ORDER BY `std`.`id`  ";
        } else if ($order_by == "students") {
            $order_by = " ORDER BY `subjects_count`  ";
        } else if ($order_by == "teachers") {
            $order_by = " ORDER BY `teacher_count`  ";
        } else if ($order_by == "name") {
            $order_by = " ORDER BY `std`.`name`  ";
        } else {
            $order_by = " ORDER BY `std`.`id`  ";
        }

        $query = "SELECT
    `std`.id AS `standards_id`,
    `std`.`name` AS `standards_name`,
  	GROUP_CONCAT(`teachers_std`.`teacher_id` SEPARATOR ',')as `teacher_ids`,
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
WHERE 
	`subjects`.`name` LIKE '%$search%'
    OR
    `std`.`name`  LIKE '%$search%'
    OR 
    `staff`.`name` LIKE '%$search%'
GROUP BY
    `std`.`id`,
    `std`.`name`
$order_by $order    
    ;

";
        return ($this->db->query($query)->find_all());
    }
    public function get_standards_data(string|int $search = 0, string $order_by = "id", $order = "ASC")
    {

        if ($order_by == "id") {
            $order_by = " ORDER BY `std`.`id`  ";
        } else if ($order_by == "students") {
            $order_by = " ORDER BY `subjects_count`  ";
        } else if ($order_by == "teachers") {
            $order_by = " ORDER BY `teacher_count`  ";
        } else if ($order_by == "name") {
            $order_by = " ORDER BY `std`.`name`  ";
        } else {
            $order_by = " ORDER BY `std`.`id`  ";
        }


        if ($search != 0) {
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
WHERE `std`.`name` LIKE '%$search%'
OR `staff`.`name` LIKE '%$search%'
OR `subjects`.`name` LIKE '%$search%'

GROUP BY
    `std`.`id`,
    `std`.`name`
  " . $order_by . $order . "  
    ;";
        } else {
            $query = "SELECT `std`.id AS `standards_id`, `std`.`name` AS `standards_name`, ( SELECT COUNT(`sub`.`subject_id`) FROM `std_sub` AS `sub` WHERE `sub`.`standard_id` = `std`.`id` ) AS `subjects_count`, ( SELECT COUNT(`teachers_std`.`teacher_id`) FROM `teachers_std` WHERE `teachers_std`.`standard_id` = `std`.`id` ) AS `teacher_count`, ( SELECT COUNT(`student`.`id`) FROM `student` JOIN `standards` ON `standards`.`id` = `student`.`standard_id` WHERE `student`.`standard_id` = `std`.`id` ) AS `student_count` FROM `standards` AS `std` LEFT JOIN `std_sub` ON `std`.`id` = `std_sub`.`standard_id` GROUP BY `std`.`id`, `std`.`name` " . $order_by . $order . "  
   
    ;";
        }
        // dd($query);
        return ($this->db->query($query)->find_all());
    }


    public function add_standards(array $data)
    {
        try {

            $this->db->beginTransaction();
            $query = "INSERT INTO `standards` SET `name`=:name";
            $this->db->query($query, ['name' => $data['std_name']]);

            $last_std_id = $this->db->id();
            if (!empty($data['selected_teachers'])) {
                $selected_teachers = [];

                foreach ($data['selected_teachers'] as $teacher) {
                    $selected_teachers[] = (int) $teacher;
                }
                $teachers = implode(",", $selected_teachers);
                $query = "INSERT INTO `teachers_std` (`standard_id`,`teacher_id`) SELECT :stid,`id` FROM `staff` WHERE `id` IN ($teachers)";
                $this->db->query(
                    $query,
                    [
                        'stid' => $last_std_id
                    ]
                );
            }

            if (!empty($data['selected_subjects'])) {

                $selected_subjects = [];
                foreach ($data['selected_subjects'] as $sub) {
                    $selected_subjects[] = $sub;
                }
                $subjects = implode(",", $selected_subjects);

                $query = "INSERT INTO `std_sub` (`standard_id`,`subject_id`) SELECT :stdid,`id` FROM `subjects` WHERE `id` IN ($subjects);";
                $this->db->query(
                    $query,

                    [
                        'stdid' => $last_std_id
                    ]
                );
            }
            // dd($data);
            $this->db->endTransaction();
        } catch (Exception $e) {
            $this->db->cancelTransaction();
            dd($e->getMessage());
        }
    }
    public function remove_subjects_stds(int $sub_id = 0, int $std_id = 0, array $data = [])
    {


        try {
            if (!empty($data)) {
                // $teachers = [];
                // foreach ($data as $d) {

                //     $teachers[] = (int) $d;
                // }
                // $teachers = implode(",", $teachers);
                // // dd($teachers);

                // $query = "DELETE FROM  `teacher_subjects` WHERE `teacher_id` IN ($teachers) AND `subject_id`=:subid";
                // // dd($query);
                // $this->db->query(
                //     $query,
                //     [
                //         'subid' => $sub,

                //     ]
                // );
            } else {
                // dd($sub_id);
                $query = "DELETE FROM `std_sub` WHERE `subject_id`=:sid AND `standard_id`=:stid";
                $this->db->query(
                    $query,
                    [
                        'sid' => $sub_id,
                        'stid' => $std_id
                    ]
                );
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            throw new ValidationException(['sub_code' => ['couldn\'t add teachers']]);
        }
    }
    public function is_std_added(string $std_name, int $std_id = 0)
    {

        $subject_code = strtoupper(trim($std_name));

        $params = [
            'name' => $std_name
        ];
        if ($std_id > 0) {

            $where = " AND id!=:id ";
            $params['id'] = $std_id;
        } else {
            $where = " ";
        }
        $query = "SELECT * FROM `standards` WHERE `name`=:name" . $where;
        $std = [];
        $std = $this->db->query(
            $query,
            $params
        )->find();

        if (!empty($std) && $std_id != $std['id']) {
            if (strtoupper($std['name']) == $std_name) {
                throw new ValidationException(['std_name' => ['standard is already registered']]);
            }
        }
    }

    public function update(array $data, int $std_id = 0)
    {
        try {
            $this->db->beginTransaction();

            $query = "UPDATE `standards` SET `name`=:name WHERE `id` = :id";
            $this->db->query($query, [
                'name' => $data['std_name'],
                'id' => $std_id,

            ]);
            $selected_teachers = [];
            if (!empty($data['selected_teachers'])) {
                foreach ($data['selected_teachers'] as $teacher) {
                    $selected_teachers[] = (int) $teacher;
                }
                $selected_teachers = implode(",", $selected_teachers);
                $query = "INSERT INTO `teachers_std` (`standard_id`,`teacher_id`) SELECT :stdid,`id` FROM `staff` WHERE `id` IN ($selected_teachers)";
                $this->db->query($query, ['stdid' => $std_id]);
            }

            $selecte_subjects = [];

            if (!empty($data['selected_subjects'])) {
                foreach ($data['selected_subjects'] as $std) {
                    $selecte_subjects[] = (int) $std;
                }
                $selecte_subjects = implode(",", $selecte_subjects);
                $query = "INSERT INTO `std_sub` (`standard_id`,`subject_id`) SELECT :stdid,`id` FROM `subjects` WHERE `id` IN ($selecte_subjects)";
                $this->db->query($query, ['stdid' => $std_id]);
            }
            $this->db->endTransaction();
        } catch (Exception $e) {
            dd($e->getMessage());
            $this->db->cancelTransaction();
            throw new ValidationException(['std_name' => ['couldn\'t update the records']]);
        }
    }
    public function remove_teachers_stds(int $teacher_id = 0, int $std_id = 0, array $data = [])
    {

        try {
            if (!empty($data)) {
                // $teachers = [];
                // foreach ($data as $d) {

                //     $teachers[] = (int) $d;
                // }
                // $teachers = implode(",", $teachers);
                // // dd($teachers);

                // $query = "DELETE FROM  `teacher_subjects` WHERE `teacher_id` IN ($teachers) AND `subject_id`=:subid";
                // // dd($query);
                // $this->db->query(
                //     $query,
                //     [
                //         'subid' => $sub,

                //     ]
                // );
            } else {


                $query = "DELETE FROM `teachers_std` WHERE `standard_id`=:sid AND `teacher_id`=:tid";
                $this->db->query(
                    $query,
                    [
                        'tid' => $teacher_id,
                        'sid' => $std_id
                    ]
                );
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            throw new ValidationException(['sub_code' => ['couldn\'t add teachers']]);
        }
    }
}
