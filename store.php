<?php

// Redirecting to registration page for GET requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return header('Location: /register.php');
}

// Starting session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Validating name
if (empty(trim($_POST['name']))) {
    $_SESSION['error']['name'] = 'Name cannot be empty!';
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
} elseif (
    empty(trim($_POST['password2'])) ||
    trim($_POST['password2'] !== trim($_POST['password']))
) {
    $_SESSION['error']['password'] = 'Passwords do not match!';
}

// Redirecting to registration page to display errors
if (isset($_SESSION['error'])) {
    $_SESSION['input'] = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
    ];
    return header('Location: /register.php');
}

// Sanitizing data
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

/** @var PDO */
$conn = require_once './db/connection.php';

// Checking for existing user
$stmt = $conn->prepare('SELECT id FROM `users` WHERE `email` = :email LIMIT 1');
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $_SESSION['error']['email'] = 'Email is already registered!';
    $_SESSION['input'] = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
    ];
    return header('Location: /register.php');
}

// Hashing password
$password = password_hash($password, PASSWORD_DEFAULT);

// Creating new user in database
$stmt = $conn->prepare(
    'INSERT INTO `users` (`name`, `email`, `password`) VALUES (:name, :email, :password)'
);
$stmt->bindParam(':name', $name, PDO::PARAM_STR);
$stmt->bindParam(':email', $email, PDO::PARAM_STR);
$stmt->bindParam(':password', $password, PDO::PARAM_STR);
$stmt->execute();

// Redirecting to login page to display confirmation of registration
$_SESSION['flash']['success'] = 'Registration is successful! You can login now.';
return header('Location: /login.php');
