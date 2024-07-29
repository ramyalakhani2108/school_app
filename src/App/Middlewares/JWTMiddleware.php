<?php

declare(strict_types=1);

namespace App\Middlewares;

use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Framework\Contracts\MiddlewareInterface;
use Framework\Database;

class JWTMiddleware implements MiddlewareInterface
{
    public function __construct(private Database $db)
    {
    }
    public function process(callable $next)
    {
        // dd("JWTMIDDLEWARE");
        if (empty($_COOKIE['token'])) {
            // dd(123);
            $next();
        } else {
            try {
                $key = $_ENV['KEY'];
                $token = $_COOKIE['token'];
                $decoded = JWT::decode($token, new Key($key, 'HS256'));


                // dd($decoded->user_id);
                // Check if the user ID in the token matches the session user ID
                if (!isset($_SESSION['user_id']) || $decoded->data->user_id !== $_SESSION['user_id']) {


                    throw new Exception('User ID mismatch. Please log in again.');
                }

                // If token is valid, proceed to the next middleware/controller

            } catch (ExpiredException $e) {
                //         // Handle token expiration

                try {

                    // Refresh token
                    $newToken = $this->refreshToken($_SESSION['user_id']);
                    // Set the new token in the cookie

                    setcookie('token', $newToken, time() + 3600, '/', '', false, true);

                    $this->db->query(
                        "UPDATE `usres` SET `token` = :newtoken WHERE `id`:id",
                        [
                            'newtoken' => $newToken,
                            'id' => $_SESSION['user_id']
                        ]

                    );
                } catch (Exception $refreshException) {

                    $_SESSION['errors'] = ['email' => $refreshException->getMessage()];
                } finally {
                    $next();
                }
            } catch (Exception $e) {

                $_SESSION['errors'] = ['email' => $e->getMessage()];
            } finally {
                $next();
            }
        }
    }
    private function refreshToken($user_id)
    {
        // Ensure you have the required user ID in the decoded token
        if (!isset($user_id)) {
            throw new Exception('Invalid token.');
        }

        // Retrieve user data from the database
        $userId = $user_id;
        $user = $this->get_user_by_id((int)$userId);
        if (!$user) {
            throw new Exception('User not found.');
        }

        // Create a new token with extended expiration time
        $newToken = JWT::encode(
            [
                'iat' => time(),
                'nbf' => time(),
                'exp' => time() + 3600,
                'data' => [
                    'user_id' => $user_id,
                    'user_rel_id' => $user['rel_id'],
                    'user_rel_type' => $user['rel_type'],
                    'email' => $user['email'],
                    'expire' => time() + 3600
                ]
            ],
            $_ENV['KEY'],
            'HS256'
        );

        return $newToken;
    }
    public function get_user_by_id(int $id)
    {

        $user = $this->db->query("
            SELECT * FROM `users` WHERE `user_id`=:id
        ", [
            'id' => $id
        ])->find();

        if (!$user) {
            return false;
        } else {
            return $user;
        }
    }
}
