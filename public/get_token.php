<?php
header('Content-Type: application/json');


if (isset($_COOKIE['token'])) {
    echo json_encode($_COOKIE['token']);
} else {
    return;
}
