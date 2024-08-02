<?php

declare(strict_types=1);

namespace App\Services;

use App\Config\Paths;
use Exception;
use Framework\Database;
use Framework\Exceptions\ValidationException;

class SubjectService
{
    private int $last_sub_id = 0;
    public function __construct(private Database $db)
    {
    }

    public function get_user_profile(int $id)
    {

        $query = "SELECT *,DATE_FORMAT(dob,'%Y-%m-%d') as fomatted_date FROM staff WHERE user_id = :user_id";
        return $this->db->query($query, [
            'user_id' => $_SESSION['user_id']
        ])->find();
    }
    public function filtered_subject(array $names)
    {

        $names = implode("','", $names);

        $query = "SELECT `subjects`.`name` AS `subject_names`,\n"

            . "	`staff`.`name` as `staff_name`,\n"

            . "    `teacher_subjects`.`teacher_id` AS `teacher_ids`,\n"

            . "   GROUP_CONCAT( DISTINCT `standards`.`name` SEPARATOR ',') AS `standards`,\n"

            . "    `subjects`.`id` AS `subject_ids`,\n"

            . "    `subjects`.`code` AS `subject_codes`\n"

            . "FROM\n"

            . "    `subjects`\n"

            . "JOIN `teacher_subjects` ON `teacher_subjects`.`subject_id` = `subjects`.`id`\n"

            . "JOIN `staff` ON `staff`.`id` = `teacher_subjects`.`teacher_id`\n"

            . "JOIN `teachers_std` ON `teachers_std`.`teacher_id` = `staff`.`id`\n"

            . "JOIN `standards` ON `teachers_std`.`standard_id` = `standards`.`id`\n"

            . "WHERE\n"

            . "    `staff`.`name` IN ('$names') "

            . "GROUP BY \n"

            . "	`staff`.`name`;";

        return ($this->db->query($query)->find_all());
    }

    public function add_teacher_subject(int $teacher_id = 0, array $data = [])
    {

        $query = "SELECT `id` FROM `subjects`";
        $last_sub_id = $this->db->query($query)->find_all();
        $last_sub_id = end($last_sub_id)['id'];
        try {
            if (!empty($data)) {
                $teachers = [];
                foreach ($data as $d) {

                    $teachers[] = (int) $d;
                }
                $teachers = implode(",", $teachers);
                // dd($teachers);

                $query = "INSERT INTO `teacher_subjects` (`subject_id`,`teacher_id`) SELECT :subid,`id` FROM `staff` WHERE `id` IN ($teachers)";
                // dd($query);
                $this->db->query(
                    $query,
                    [
                        'subid' => $last_sub_id,

                    ]
                );
            } else {

                $query = "INSERT INTO `teacher_subjects` SET `subject_id`=:sid, `teacher_id`=:tid";
                $this->db->query(
                    $query,
                    [
                        'tid' => $teacher_id,
                        'sid' => $last_sub_id
                    ]
                );
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            throw new ValidationException(['sub_code' => ['couldn\'t add teachers']]);
        }
    }
    public function add_std_sub(int $std_id = 0, array $data = [])
    {

        $query = "SELECT `id` FROM `subjects`";
        $last_sub_id = $this->db->query($query)->find_all();
        $last_sub_id = end($last_sub_id)['id'];
        try {
            if (!empty($data)) {
                $stds = [];
                foreach ($data as $d) {

                    $stds[] = (int) $d;
                }
                $stds = implode(",", $stds);
                // dd($stds);

                $query = "INSERT INTO `std_sub` (`subject_id`,`standard_id`) SELECT :subid,`id` FROM `standards` WHERE `id` IN ($stds)";
                // dd($query);
                $this->db->query(
                    $query,
                    [
                        'subid' => $last_sub_id,

                    ]
                );
            } else {

                $query = "INSERT INTO `std_sub` SET `subject_id`=:sid, `standard_id`=:stid";
                $this->db->query(
                    $query,
                    [
                        'stid' => $std_id,
                        'sid' => $last_sub_id
                    ]
                );
            }
        } catch (Exception $e) {
            // dd($e->getMessage());
            throw new ValidationException(['sub_code' => ['couldn\'t add teachers']]);
        }
    }

    public function create(array $data)
    {

        try {
            $this->db->beginTransaction();
            $query = "INSERT INTO `subjects` SET `name`=:name,`code`=:code";
            $this->db->query(
                $query,

                [
                    'name' => $data['sub_name'],
                    'code' => strtoupper($data['sub_code'])
                ]
            );

            $last_sub_id = $this->db->id();
            $teachers = [];
            foreach ($data['selected_teachers'] as $d) {

                $teachers[] = (int) $d;
            }
            $teachers = implode(",", $teachers);
            // dd($teachers);

            $query = "INSERT INTO `teacher_subjects` (`subject_id`,`teacher_id`) SELECT :subid,`id` FROM `staff` WHERE `id` IN ($teachers)";

            $this->db->query(
                $query,
                [
                    'subid' => $last_sub_id,

                ]
            );


            $stds = [];
            foreach ($data['selected_standard'] as $d) {

                $stds[] = (int) $d;
            }
            $stds = implode(",", $stds);
            // dd($stds);

            $query = "INSERT INTO `std_sub` (`subject_id`,`standard_id`) SELECT :subid,`id` FROM `standards` WHERE `id` IN ($stds)";
            // dd($query);
            $this->db->query(
                $query,
                [
                    'subid' => $last_sub_id,
                ]
            );

            $this->db->endTransaction();
        } catch (Exception $e) {
            $this->db->cancelTransaction();
            dd($e->getMessage());
        }
    }
    public function remove_teacher_sub(int $teacher_id = 0, int $sub_id = 0, array $data = [])
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

                $query = "DELETE FROM `teacher_subjects` WHERE `subject_id`=:sid AND `teacher_id`=:tid";
                $this->db->query(
                    $query,
                    [
                        'tid' => $teacher_id,
                        'sid' => $sub_id
                    ]
                );
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            throw new ValidationException(['sub_code' => ['couldn\'t add teachers']]);
        }
    }
    public function remove_std_sub(int $std_id = 0, int $sub_id = 0, array $data = [])
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

                $query = "DELETE FROM `std_sub` WHERE `subject_id`=:sid AND `standard_id`=:stid";
                $this->db->query(
                    $query,
                    [
                        'stid' => $std_id,
                        'sid' => $sub_id
                    ]
                );
            }
        } catch (Exception $e) {
            dd($e->getMessage());
            throw new ValidationException(['sub_code' => ['couldn\'t add teachers']]);
        }
    }
    public function total_subjects_per_standard(int $standard = 0)
    {
        if ($standard != 0) {
            $where = " WHERE `sc.standard_id`= :cid";
        } else {
            $where = '';
        }
        $query = "SELECT DISTINCT COUNT(s.id) AS total_subjects FROM subjects s JOIN subject_classroom sc ON s.id = sc.subject_id " . $where;
        if ($standard != 0) {
            $params = [
                'cid' => $standard
            ];
        } else {
            $params = [];
        }

        return $this->db->query($query, $params)->fetchColumn();
    }

    public function total_subjects()
    {
        $query = "SELECT COUNT(*) FROM `subjects`";
        return $this->db->query($query)->find()['COUNT(*)'];
    }

    public function get_subject(int $id)
    {
        $query = "SELECT `id`,`name`,`code` FROM `subjects` WHERE `id`=:id";
        return ($this->db->query($query, [
            'id' => $id
        ])->find());
    }
    public function add_subject(array $data)
    {


        $query = "INSERT INTO `subjects` SET `name`=:name, `code`=:code";
        $this->db->query(
            $query,
            [
                'name' => $data['sub_name'],
                'code' => $data['sub_code']

            ]
        );
    }

    public function update(array $data, int $id)
    {
        try {
            $this->db->beginTransaction();

            $query = "UPDATE `subjects` SET `name`=:name, `code`=:code WHERE `id` = :id";
            $this->db->query($query, [
                'name' => $data['sub_name'],
                'code' => $data['sub_code'],
                'id' => $id,

            ]);
            $selected_teachers = [];
            if (!empty($data['selected_teachers'])) {
                foreach ($data['selected_teachers'] as $teacher) {
                    $selected_teachers[] = (int) $teacher;
                }
                $selected_teachers = implode(",", $selected_teachers);
                $query = "INSERT INTO `teacher_subjects` (`subject_id`,`teacher_id`) SELECT :subid,`id` FROM `staff` WHERE `id` IN ($selected_teachers)";
                $this->db->query($query, ['subid' => $id]);
            }

            $selected_standards = [];

            if (!empty($data['selected_standards'])) {
                foreach ($data['selected_standards'] as $std) {
                    $selected_standards[] = (int) $std;
                }
                $selected_standards = implode(",", $selected_standards);
                $query = "INSERT INTO `std_sub` (`subject_id`,`standard_id`) SELECT :subid,`id` FROM `standards` WHERE `id` IN ($selected_standards)";
                $this->db->query($query, ['subid' => $id]);
                $this->db->endTransaction();
            }
        } catch (Exception $e) {
            $this->db->cancelTransaction();
            throw new ValidationException(['sub_code' => ['couldn\'t update the records']]);
        }
    }


    public function delete(int $id)
    {

        try {

            $this->db->beginTransaction();
            $query = "DELETE FROM `subjects` WHERE `id`=:id";
            $this->db->query($query, ['id' => $id]);
            $this->db->endTransaction();
        } catch (Exception $e) {
            $this->db->cancelTransaction();
            dd($e->getMessage());
        }
    }
    public function get_std_sub()
    {
        $query = "SELECT `id`,`name`,`code` FROM `subjects`";
        return $this->db->query($query)->find_all();
    }
    public function get_data()
    {
        $query = "SELECT
    `sub`.`name` AS `subject_name`,
    `sub`.`id` AS `subject_id`,
    `sub`.`code` AS `subject_code`,
    (
    SELECT
        COUNT(`teacher_subjects`.`teacher_id`)
    FROM
        `teacher_subjects`
    WHERE
        `teacher_subjects`.`subject_id` = `sub`.`id`
) AS `teacher_count`,
(
    SELECT
        COUNT(`std_sub`.`standard_id`)
    FROM
        `std_sub`
    WHERE
        `std_sub`.`subject_id` = `sub`.`id`
) AS `standards_count`
FROM
    `subjects` AS `sub`
GROUP BY
    `sub`.`id`;
        
        
        ";
        // dd($query);
        return (
            $this->db->query($query)->find_all()
        );
    }

    public function is_subject_added(string $subject_code, string $subject_name, int $sub_id = 0)
    {

        $subject_code = strtoupper(trim($subject_code));

        $params = [

            'code' => $subject_code,
            'name' => $subject_name

        ];
        if ($sub_id > 0) {

            $where = " AND id!=:id ";
            $params['id'] = $sub_id;
        } else {
            $where = " ";
        }
        $query = "SELECT * FROM `subjects` WHERE `code`=:code OR `name`=:name" . $where;
        $sub = [];
        $sub = $this->db->query(
            $query,
            $params
        )->find();

        if (!empty($sub) && $sub_id != $sub['id']) {
            if (strtoupper($sub['code']) == $subject_code) {
                throw new ValidationException(['sub_code' => ['subject is already registered']]);
            }
            if ($subject_name == $sub['name']) {
                throw new ValidationException(['sub_name' => ['subject is already registered']]);
            }
        }
        // }

        // public function is_class_available(array $standardes)
        // {
        //     $placeholdersC = rtrim(str_repeat('?,', count($standardes)), ',');
        //     $query = "SELECT * FROM `classroom` WHERE `id` IN ($placeholdersC)";
        //     $standard_ids =
        //         $this->db->query(
        //             $query,
        //             $standardes
        //         )->find_all();
        //     dd($standard_ids);
        // }


        // public function add_subject(array $data)
        // {

        //     try {
        //         $this->db->beginTransaction();


        //         $query = "INSERT INTO `subjects` SET `name`=:name, `code`=:code";
        //         $this->db->query(
        //             $query,
        //             [
        //                 'name' => $data['sub_name'],
        //                 'code' => $data['sub_code']
        //             ]
        //         );

        //         $subject_id = $this->db->id();

        //         $standard_names = explode(',', $data['class_names']);
        //         $placeholdersC = rtrim(str_repeat('?,', count($standard_names)), ',');
        //         $query = "SELECT id FROM `standards` WHERE `name` IN ($placeholdersC)";
        //         $standard_ids =
        //             $this->db->query(
        //                 $query,
        //                 $standard_names
        //             )->find_all();

        //         if (count($standard_ids) < count($standard_names)) {
        //             throw new ValidationException(['standard_names' => ['not all standards are available']]);
        //         }


        //         $teacher_names = explode(',', $data['teacher_names']);
        //         $placeholdersT = rtrim(str_repeat('?,', count($teacher_names)), ',');
        //         $query = "SELECT id FROM `teachers` WHERE `first_name` IN ($placeholdersT)";
        //         $teacher_ids = $this->db->query(
        //             $query,
        //             $teacher_names
        //         )->find_all();
        //         if (count($teacher_ids) < count($teacher_names)) {
        //             throw new ValidationException(['teacher_names' => ['Not all the teachers are available.']]);
        //         }
        //         // dd([$teacher_ids, $standard_ids]);

        //         $insertQuery = "INSERT INTO `subject_classroom` (`subject_id`, `standard_id`, `teacher_id`, `created_at`) VALUES ";
        //         $values = [];

        //         foreach ($standard_ids as $standard) {
        //             foreach ($teacher_ids as $teacher) {
        //                 $values[] = "($subject_id, {$standard['id']}, {$teacher['id']}, NOW())";
        //             }
        //         }

        //         $insertQuery .= implode(', ', $values);
        //         $this->db->query($insertQuery);




        //         $this->db->endTransaction();
        //     } catch (ValidationException $e) {
        //         $this->db->cancelTransaction();
        //         $_SESSION['errors'] = $e->errors;
        //         $excludedKeys = ['password', 'confirmPassowrd'];

        //         $oldFormData = $_POST;
        //         $formattedFormData = array_diff_key($oldFormData, array_flip($excludedKeys));


        //         $_SESSION['oldFormData'] = $formattedFormData;

        //         $referer = $_SERVER['HTTP_REFERER'];
        //         //$_SERVER['HTTP_REFERER'] it is a special value available after the form submission stores the url after submission
        //         redirectTo("{$referer}");
        //     }
        // }


    }
}
