<?php

// Redirecting to login page for GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return header('Location: /login.php');
}

// Starting session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validating email
if (empty(trim($_POST['email']))) {
    $_SESSION['error']['email'] = 'Email cannot be empty!';
} elseif (empty(filter_input(INPUT_POST, 'email',  FILTER_VALIDATE_EMAIL))) {
    $_SESSION['error']['email'] = 'Email seems invalid!';
}

// Validating password
if (empty(trim($_POST['password']))) {
    $_SESSION['error']['password'] = 'Password cannot be empty!';
}

// Redirecting to login page to display errors
if (isset($_SESSION['error'])) {
    $_SESSION['input'] = [
        'email' => $_POST['email'],
    ];
    return header('Location: /login.php');
}

// Sanitizing data
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

/** @var PDO */
$conn = require_once './db/connection.php';

// Fetching user
$stmt = $conn->prepare('SELECT * FROM `users` WHERE `email` = :email LIMIT 1');
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();

// Checking user
$user = $stmt->fetch(PDO::FETCH_OBJ);
if (
    !$user ||
    ($user && !password_verify($password, $user->password))
) {
    $_SESSION['flash']['danger'] = 'Incorrect email/password combination!';
}

// Redirecting to login page to display flash message
if (isset($_SESSION['flash'])) {
    $_SESSION['input'] = [
        'email' => $_POST['email'],
    ];
    return header('Location: /login.php');
}

// Setting user into session
$_SESSION['user'] = $user;
return header('Location: /dashboard.php');
