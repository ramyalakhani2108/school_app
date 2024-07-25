<?php

declare(strict_types=1);

namespace App\Services;

use App\Config\Paths;
use Exception;
use Framework\Database;
use Framework\Exceptions\ValidationException;

class SubjectService
{
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

    public function total_subjects(int $class = 0)
    {
        if ($class != 0) {
            $where = " WHERE `sc.classroom_id`= :cid";
        } else {
            $where = '';
        }
        $query = "SELECT DISTINCT COUNT(s.id) AS total_subjects FROM subjects s JOIN subject_classroom sc ON s.id = sc.subject_id " . $where;
        if ($class != 0) {
            $params = [
                'cid' => $class
            ];
        } else {
            $params = [];
        }

        return $this->db->query($query, $params)->fetchColumn();
    }


    public function get_data()
    {
        $query = "SELECT s.id AS subject_id, s.name AS subject_name, s.code AS subject_code, GROUP_CONCAT(DISTINCT sc.classroom_id ORDER BY sc.classroom_id) AS classroom_ids, GROUP_CONCAT(DISTINCT c.name ORDER BY sc.classroom_id) AS classroom_names, GROUP_CONCAT(DISTINCT CONCAT(t.first_name, ':', c.name) ORDER BY sc.classroom_id, t.first_name SEPARATOR ', ') AS teacher_names FROM subjects s JOIN subject_classroom sc ON s.id = sc.subject_id JOIN classroom c ON c.id = sc.classroom_id LEFT JOIN teachers t ON sc.teacher_id = t.id GROUP BY s.id, s.name, s.code ORDER BY s.id;


";
        return $this->db->query($query)->find_all();
    }

    public function is_subject_added(string $subject_code, string $subject_name)
    {

        $subject_code = strtoupper(trim($subject_code));
        $query = "SELECT * FROM `subjects` WHERE `code`=:code OR `name`=:name";
        $sub = $this->db->query(
            $query,
            [
                'code' => $subject_code,
                'name' => $subject_name
            ]
        )->find();
        if ($sub) {
            if (strtoupper($sub['code']) == $subject_code) {
                throw new ValidationException(['sub_code' => ['subject is already registered']]);
            }
            if ($subject_name == $sub['name']) {
                throw new ValidationException(['sub_name' => ['subject is already registered']]);
            }
        }
    }

    // public function is_class_available(array $classes)
    // {
    //     $placeholdersC = rtrim(str_repeat('?,', count($classes)), ',');
    //     $query = "SELECT * FROM `classroom` WHERE `id` IN ($placeholdersC)";
    //     $class_ids =
    //         $this->db->query(
    //             $query,
    //             $classes
    //         )->find_all();
    //     dd($class_ids);
    // }


    public function add_subject(array $data)
    {

        try {
            $this->db->beginTransaction();


            $query = "INSERT INTO `subjects` SET `name`=:name, `code`=:code";
            $this->db->query(
                $query,
                [
                    'name' => $data['sub_name'],
                    'code' => $data['sub_code']
                ]
            );

            $subject_id = $this->db->id();

            $class_names = explode(',', $data['class_names']);
            $placeholdersC = rtrim(str_repeat('?,', count($class_names)), ',');
            $query = "SELECT id FROM `classroom` WHERE `name` IN ($placeholdersC)";
            $class_ids =
                $this->db->query(
                    $query,
                    $class_names
                )->find_all();

            if (count($class_ids) < count($class_names)) {
                throw new ValidationException(['class_names' => ['not all classes are available']]);
            }


            $teacher_names = explode(',', $data['teacher_names']);
            $placeholdersT = rtrim(str_repeat('?,', count($teacher_names)), ',');
            $query = "SELECT id FROM `teachers` WHERE `first_name` IN ($placeholdersT)";
            $teacher_ids = $this->db->query(
                $query,
                $teacher_names
            )->find_all();
            if (count($teacher_ids) < count($teacher_names)) {
                throw new ValidationException(['teacher_names' => ['Not all the teachers are available.']]);
            }
            // dd([$teacher_ids, $class_ids]);

            $insertQuery = "INSERT INTO `subject_classroom` (`subject_id`, `classroom_id`, `teacher_id`, `created_at`) VALUES ";
            $values = [];

            foreach ($class_ids as $class) {
                foreach ($teacher_ids as $teacher) {
                    $values[] = "($subject_id, {$class['id']}, {$teacher['id']}, NOW())";
                }
            }

            $insertQuery .= implode(', ', $values);
            $this->db->query($insertQuery);




            $this->db->endTransaction();
        } catch (ValidationException $e) {

            $_SESSION['errors'] = $e->errors;
            $excludedKeys = ['password', 'confirmPassowrd'];

            $oldFormData = $_POST;
            $formattedFormData = array_diff_key($oldFormData, array_flip($excludedKeys));


            $_SESSION['oldFormData'] = $formattedFormData;

            $referer = $_SERVER['HTTP_REFERER'];
            //$_SERVER['HTTP_REFERER'] it is a special value available after the form submission stores the url after submission
            redirectTo("{$referer}");
        }
    }
}
