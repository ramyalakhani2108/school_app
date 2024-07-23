<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/App/functions.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

header('Content-Type: application/json');

const KEY = "testtoken";

// Get the JSON input
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['token'])) {
    echo json_encode(['valid' => false, 'message' => 'Token not provided']);
    exit;
}
// echo json_encode($input, true);
$token = $input['token'];

try {

    // Decode the token
    $decoded = JWT::decode($token, new Key(KEY, 'HS256'));

    // Token is valid
    echo json_encode(['valid' => true, 'data' => (array) $decoded]);
} catch (Exception $e) {
    // Token is invalid or other error
    
    echo json_encode(['valid' => false, 'message' => 'Invalid token: ' . $e->getMessage()]);
}
