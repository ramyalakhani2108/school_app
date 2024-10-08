<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Firebase\JWT\JWT;
use Framework\Database;
use Framework\Exceptions\ValidationException;

class UserService
{
    public function __construct(private Database $db) {}

    public function check_role(string $id) {}

    public function is_record_added($table, $column, $value, $condition = null, $field = "email")
    {

        // for checking the duplicate records 

        $query = " SELECT COUNT(*) FROM `$table` WHERE `$column` = :value " . (($condition != null) ? " AND " . $condition :  "");
        // dd($query);
        $columns = $this->db->query($query, ['value' => $value])->fetchColumn();

        if ($columns > 0) {
            // dd("hi");
            throw new ValidationException(["$field" => ["$table is already added"]]);
        }
        return true;
    }
    public function delete_record(string $table, string $condition)
    {
        $query = "DELETE FROM $table WHERE $condition";
        try {
            $this->db->beginTransaction();
            $this->db->query($query);
            $this->db->endTransaction();
        } catch (Exception $e) {
            $this->db->cancelTransaction();
            dd($e->getMessage());
            throw new ValidationException(['email' => 'can\'t delete ']);
        }
    }


    public function login(array $data)
    {

        // header("Content-Type: application/json");
        $input = json_decode(file_get_contents('php://input'), true);
        // dd($data);
        $query = "SELECT `user_id`,`email`,`password`,`rel_type` FROM `users` WHERE `email`=:email";

        $user = $this->db->query($query, [
            'email' => $data['email']
        ])->find();

        // $passwordsMatch = password_verify($data['password'], $user['user_pass'] ?? '');
        // dd([$user['password'], $data['password']]);
        if (!password_verify($data['password'], $user['password'])) {
            throw new ValidationException(['password' => ['Invalid Cradentials']]);
        } else if (!$user) {
            throw new ValidationException(['password' => ['Invalid user']]);
        }
        session_regenerate_id();
        $_SESSION['user_id'] = $user['user_id'];
        if (!array_key_exists('token', $_COOKIE)) {
            $this->set_token($_SESSION['user_id']);
        }
        return $user;
    }
    public function set_token(int $id)
    {
        $query = "SELECT `rel_id`,`rel_type`,`email`FROM `users` WHERE `user_id` = :uid";
        $user = $this->db->query($query, [
            'uid' => $id
        ])->find();

        if ($user) {
            $key = "testtoken";
            $token = JWT::encode(
                [
                    'iat' => time(),
                    'nbf' => time(),
                    'exp' => time() + 3600,
                    'data' => [
                        'user_id' => $id,
                        'user_rel_id' => $user['rel_id'],
                        'user_rel_type' => $user['rel_type'],
                        'email' => $user['email'],
                        'expire' => time() + 3600
                    ]
                ],
                $key,
                'HS256'
            );
            // dd($token);
            $this->db->query(
                "UPDATE `users` SET `token`= :newtoken WHERE `user_id`=:id;",
                [
                    'newtoken' => $token,
                    'id' => $_SESSION['user_id']
                ]

            );
            setcookie("token", $token, time() + 3600);
        }
    }

    public function register(array $data)
    {

        $formattedDate = "{$data['dob']} 00:00:00";

        $hashed_password = password_hash($data['password'], PASSWORD_BCRYPT);

        $query = "INSERT INTO `student` SET `first_name`=:fn,`last_name`=:ln,`email`=:eml,`dob`=:dob,`gender`=:gen,`address`=:add,`phone`=:phn,`password`=:pwd";
        $this->db->query(
            $query,
            [
                'fn' => $data['first_name'],
                'ln' => $data['last_name'],
                'eml' => $data['email'],
                'dob' => $formattedDate,
                'gen' => $data['gender'],
                'add' => $data['address'],
                'phn' => $data['phone'],
                'pwd' => $hashed_password
            ]
        );
        session_regenerate_id();
        $_SESSION['user_id'] = $this->db->id();
        $this->set_token((int)$_SESSION['user_id']);
        $this->update_token($data['email']);
    }

    public function update_token(string $email)
    {

        $query = "UPDATE `users` SET `token`=:token WHERE `email`=:eml";
        $this->db->query($query, [
            'token' => $_COOKIE['token'],
            'eml' => $email
        ]);
    }
    public function logout()
    {
        unset($_SESSION['user_id']);
        // unset($_COOKIE['token']);
        setcookie("token", "/", time() - 3600);
        setcookie("PHPSESSID", "/", time() - 3600);
    }

    public function get_user(int $id)
    {
        $query = "SELECT * FROM `users` WHERE `id`=:id";
        return $this->db->query($query, [
            'id' => $id
        ])->find();
    }
}
