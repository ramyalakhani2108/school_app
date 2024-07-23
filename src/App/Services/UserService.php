<?php

declare(strict_types=1);

namespace App\Services;

use Exception;
use Firebase\JWT\JWT;
use Framework\Database;
use Framework\Exceptions\UserException;
use Framework\Exceptions\ValidationException;

class UserService
{
    public function __construct(private Database $db)
    {
    }

    public function check_role(string $id)
    {
    }

    public function is_email_taken_profile(string $email, int $id)
    {
        $query = "SELECT COUNT(*) FROM `staff` WHERE `email`=:email AND `user_id`!=:id";
        $emailCount = $this->db->query($query, [
            'email' => $email,
            'id' => $id
        ])->count();

        $query = "SELECT `email` FROM `staff` WHERE `email`=:email";
        $emailFind = $this->db->query($query, [
            'email' => $email
        ])->find();


        if ($emailCount > 0) {
            if ($email !== $emailFind['email']) {
                throw new ValidationException(['email' => 'Email Taken']);
            }
        }
    }
    public function is_email_taken(string $email)
    {
        $query = "SELECT COUNT(*) FROM users WHERE email=:email";
        $emailCount = $this->db->query($query, [
            'email' => $email
        ])->count();

        if ($emailCount > 0) {
            throw new ValidationException(['registered_user' => 'Email Taken']);
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
        $this->set_token($_SESSION['user_id']);
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
    }

    public function get_user()
    {
    }
}
