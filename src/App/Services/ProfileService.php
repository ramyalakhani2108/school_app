<?php

declare(strict_types=1);

namespace App\Services;

use App\Config\Paths;
use Framework\Database;
use Framework\Exceptions\ValidationException;

class ProfileService
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


    function phoneNumberExists($phone, $userId)
    {
        $query = "SELECT COUNT(*) FROM staff WHERE phone = :phone AND user_id != :user_id";

        $result = $this->db->query($query, [
            'phone' => $phone, 'user_id' => $userId
        ])->fetchColumn();
        if ($result > 0) {
            throw new ValidationException(['phone' => 'The number is already added']);
            // return true;
        } else {
            return false;
        }
    }
    public function update(array $data)
    {

        $user_old_data = $this->get_user_profile($_SESSION['user_id']);

        if ($data['password'] != '') {
            if ($data['confirm_password'] != '') {
                if ($data['password'] != $data['confirm_password']) {
                    throw new ValidationException(['confirm_password' => 'Password and confirm password should match']);
                } else {
                    $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
                }
            }
        } else {
            $data['password'] = $user_old_data['password'];
        }

        // Prepare data for update
        $params = [
            'nm' => $data['name'],
            'eml' => $data['email'],
            'phn' => $data['phone'],
            'dept' => $data['department'],
            'pwd' => $data['password'],
            'uid' => $_SESSION['user_id']
        ];





        if ($_FILES && $_FILES['profile']['name'] != '') {
            $this->validate_file($_FILES['profile']);

            $fileExt = pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION);
            $newFileName = bin2hex(random_bytes(16)) . "." . $fileExt;
            $uploadPath = Paths::STORAGE_UPLOADS . "/" . $newFileName;

            if (!move_uploaded_file($_FILES['profile']['tmp_name'], $uploadPath)) {
                throw new ValidationException([
                    'profile' => ['Failed to upload file']
                ]);
            }

            $where = ", `profile` = :pf, `storage_filename` = :stgfn";
            $params['pf'] = $_FILES['profile']['name'];
            $params['stgfn'] = $newFileName;
        } else {
            $where = '';
        }
        if (!$this->phoneNumberExists($data['phone'], $_SESSION['user_id'])) {

            unset($params['phn']);
        } else {
            $where .= ',`phone` = :phn ';
        }
        if ($data['password'] == $user_old_data['password']) {
            unset($params['pwd']);
        } else {
            $where .= ', `password`=:pwd';
        }


        // Perform the update query

        $query = "UPDATE `staff` SET `name` = :nm, `department` = :dept,`email` = :eml" . $where . " WHERE `user_id` = :uid";
        $this->db->query($query, $params);

        if ($newFileName != '') {
            unlink(Paths::STORAGE_UPLOADS . "/" . $user_old_data['storage_filename']);
        }
        //from rowcount
    }

    public function validate_file(?array $file)
    {

        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            throw new ValidationException([
                'profile' => ['Faild to upload file']
            ]);
        }

        $maxFileSizeMB = 8 * 1024 * 1024;

        if ($file['size'] > $maxFileSizeMB) {
            throw new ValidationException([
                'profile' => ['File should be lesser than ' . ($maxFileSizeMB / 1024) / 1024 . 'MB']
            ]);
        }

        $originalFileName = $file['name'];

        if (!preg_match('#^[A-Za-z0-9\s\(\)._-]+#', $originalFileName)) {
            throw new ValidationException([
                'profile' => ['Invalid file name']
            ]);
        }

        $clientMimeType = $file['type'];
        $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf'];

        if (!in_array($clientMimeType, $allowedMimeTypes)) {
            throw new ValidationException([
                'profile' => ['Invalid file type']
            ]);
        }
    }
    public function delete(int $id)
    {
        $query = "DELETE FROM transactions WHERE tran_id=:id AND user_id=:user_id";
        $this->db->query($query, [
            'id' => $id,
            'user_id' => $_SESSION['user_id'],
        ]);
    }

    public function getTransactions(int $id)
    {
        $query = "SELECT SUM(tran_amount) as total_transaction FROM transactions WHERE user_id = :uid";
        $total_amt = $this->db->query($query, [
            'uid' => $id
        ])->find();
        return $total_amt;
    }
}
