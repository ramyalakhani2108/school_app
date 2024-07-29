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

use App\Services\ProfileService;
use App\Services\UserService;
use DomainException;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Framework\Contracts\MiddlewareInterface;
use Framework\Database;
use Framework\Exceptions\ValidationException;

class AuthTokenMiddleware implements MiddlewareInterface
{


    // public function process(callable $next)
    // {
    //     try {
    //         // Assuming token is stored in a cookie

    //         if (!isset($_COOKIE['token'])) {
    //             throw new ValidationException(['email' => ['Token not found, please log in.']]);
    //         }

    //         $key = $_ENV['KEY'];
    //         $token = $_COOKIE['token'];
    //         $decoded = JWT::decode($token, new Key($key, 'HS256'));

    //         // dd($decoded->user_id);
    //         // Check if the user ID in the token matches the session user ID
    //         if (!isset($_SESSION['user_id']) || $decoded->data->user_id !== $_SESSION['user_id']) {


    //             throw new Exception('User ID mismatch. Please log in again.');
    //         }

    //         // If token is valid, proceed to the next middleware/controller
    //         $next();
    //     } catch (ExpiredException $e) {
    //         // Handle token expiration

    //         try {

    //             // Refresh token
    //             $newToken = $this->refreshToken($_SESSION['user_id']);
    //             // Set the new token in the cookie

    //             setcookie('token', $newToken, time() + 3600, '/', '', false, true);

    //             $this->database->query(
    //                 "UPDATE `usres` SET `token` = :newtoken WHERE `id`:id",
    //                 [
    //                     'newtoken' => $newToken,
    //                     'id' => $_SESSION['user_id']
    //                 ]

    //             );

    //             $next();
    //         } catch (Exception $refreshException) {
    //             dd($refreshException->getMessage());
    //             $_SESSION['errors'] = ['email' => $refreshException->getMessage()];
    //             $next();
    //         }
    //     } catch (DomainException $e) {

    //         // Handle JWT decoding errors (including malformed UTF-8 characters)
    //         $_SESSION['errors'] = ['email' => "Token Malformed"];
    //         // redirectTo("/login");
    //         $next();
    //     } catch (SignatureInvalidException $e) {

    //         $_SESSION['errors'] = ['email' => $e->getMessage()];
    //         $next();
    //     } catch (ValidationException $e) {

    //         $next();
    //     } catch (ValidationException $e) {

    //         $_SESSION['errors'] = ['email' => $e->getMessage()];
    //         // session_regenerate_id();

    //         $next();
    //     }
    // }

    // private function refreshToken($user_id)
    // {
    //     // Ensure you have the required user ID in the decoded token
    //     if (!isset($user_id)) {
    //         throw new Exception('Invalid token.');
    //     }

    //     // Retrieve user data from the database
    //     $userId = $user_id;
    //     $user = $this->get_user_by_id((int)$userId);
    //     if (!$user) {
    //         throw new Exception('User not found.');
    //     }

    //     // Create a new token with extended expiration time
    //     $newToken = JWT::encode(
    //         [
    //             'iat' => time(),
    //             'nbf' => time(),
    //             'exp' => time() + 3600,
    //             'data' => [
    //                 'user_id' => $user_id,
    //                 'user_rel_id' => $user['rel_id'],
    //                 'user_rel_type' => $user['rel_type'],
    //                 'email' => $user['email'],
    //                 'expire' => time() + 3600
    //             ]
    //         ],
    //         $_ENV['KEY'],
    //         'HS256'
    //     );

    //     return $newToken;
    // }

    // public function get_user_by_id(int $id)
    // {

    //     $user = $this->database->query("
    //         SELECT * FROM `users` WHERE `user_id`=:id
    //     ", [
    //         'id' => $id
    //     ])->find();

    //     if (!$user) {
    //         return false;
    //     } else {
    //         return $user;
    //     }
    // }
    public function process(callable $next)
    {

        if (empty($_SESSION['user_id'])) {
            redirectTo("/login");
        }
        $next();
    }
}
