<?php

// declare(strict_types=1);

// namespace App\Middlewares;

// use DomainException;
// use Exception;
// use Firebase\JWT\JWT;


// use Firebase\JWT\Key;
// use Firebase\JWT\SignatureInvalidException;
// use Framework\Contracts\MiddlewareInterface;
// use Framework\Exceptions\ValidationException;

// class AuthTokenMiddleware implements MiddlewareInterface
// {


//     public function process(callable $next)
//     {
//         try {
//             // Assuming token is stored in a cookie
//             if (!isset($_COOKIE['token'])) {
//                 throw new Exception('Token not found, please log in.');
//             }

//             // Decode the token
//             $decoded = JWT::decode($_COOKIE['token'], new Key($_ENV['KEY'], 'HS256'));
//             if (!isset($_SESSION['id']) || $decoded->user_id !== $_SESSION['id']) {

//                 $_SESSION['errors'] = ['email' => "Token Malformed"];

//                 // $referer = $_SERVER['HTTP_REFERER'];

//                 redirectTo("/login");
//             }

//             // If token is valid, proceed to the next middleware/controller
//             $next();
//         } catch (DomainException $e) {
//             // Handle JWT decoding errors (including malformed UTF-8 characters)

//             $_SESSION['errors'] = ['email' => "Token Malformed"];

//             // $referer = $_SERVER['HTTP_REFERER'];

//             redirectTo("/login");
//         } catch (SignatureInvalidException $e) {
//             // Handle other errors

//             $_SESSION['errors'] = ['email' => $e->getMessage()];



//             redirectTo("/login");

//             // $this->handleTokenError($e->getMessage());
//         } catch (Exception $e) {
//             $_SESSION['errors'] = ['email' => $e->getMessage()];



//             redirectTo("/login");
//         }
//     }
// }

// <?php

declare(strict_types=1);

namespace App\Middlewares;

use DomainException;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;

class AuthTokenMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        try {
            // Assuming token is stored in a cookie
            if (!isset($_COOKIE['token'])) {
                throw new Exception('Token not found, please log in.');
            }

            $key = $_ENV['KEY'];
            $token = $_COOKIE['token'];
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            // dd($decoded);
            // dd($decoded->user_id);
            // Check if the user ID in the token matches the session user ID
            if (!isset($_SESSION['user_id']) || $decoded->data->user_id !== $_SESSION['user_id']) {
                throw new Exception('User ID mismatch. Please log in again.');
            }

            // If token is valid, proceed to the next middleware/controller
            $next();
        } catch (ExpiredException $e) {
            // Handle token expiration
            try {
                $decoded = JWT::decode($token, new Key($key, 'HS256'));
                // Refresh token
                $newToken = $this->refreshToken($decoded);
                // Set the new token in the cookie
                setcookie('token', $newToken, time() + 3600, '/', '', false, true);
                $next();
            } catch (Exception $refreshException) {
                $_SESSION['errors'] = ['email' => $refreshException->getMessage()];
                redirectTo("/login");
            }
        } catch (DomainException $e) {
            // Handle JWT decoding errors (including malformed UTF-8 characters)
            $_SESSION['errors'] = ['email' => "Token Malformed"];
            redirectTo("/login");
        } catch (SignatureInvalidException $e) {
            // Handle signature errors
            $_SESSION['errors'] = ['email' => $e->getMessage()];
            redirectTo("/login");
        } catch (ValidationException $e) {
            $_SESSION['errors'] = $e->errors;
            redirectTo($_SERVER['HTTP_REFERER']);
        } catch (Exception $e) {
            $_SESSION['errors'] = ['email' => $e->getMessage()];
            redirectTo($_SERVER['HTTP_REFERER'] ?? '/login');
        }
    }

    private function refreshToken($decoded)
    {
        // Ensure you have the required user ID in the decoded token
        if (!isset($decoded->user_id)) {
            throw new Exception('Invalid token structure.');
        }

        // Retrieve user data from the database
        $userId = $decoded->user_id;
        $user = $this->getUserById($userId);
        if (!$user) {
            throw new Exception('User not found.');
        }

        // Create a new token with extended expiration time
        $newPayload = [
            'user_id' => $userId,
            'exp' => time() + 3600 // Extend expiration by 1 hour
        ];

        $newToken = JWT::encode($newPayload, $_ENV['KEY'], 'HS256');
        return $newToken;
    }

    private function getUserById($userId)
    {
        // Implement the logic to get user by ID from the database
        // For example:
        // $user = UserModel::find($userId);
        // return $user;
        // Placeholder for actual database logic
        return true;
    }
}
