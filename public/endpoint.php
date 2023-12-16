<?php
session_start();
include '../app/config/conf.php';

$response = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if (password_verify($_POST['password'], $hashed_password)) {
        $_SESSION['logged_in'] = true;
        $response = 'Success';
    } else {
        $response = 'Invalid password';
    }
} else {
    $response = 'Password required';
}

echo $response;