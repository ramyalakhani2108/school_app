<?php
header('Content-Type: application/json');

echo json_encode($_COOKIE['token']);
