<?php

// Starting session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'];

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <title><?= $title ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">SimpleAuth</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item<?= $isThisHome ? ' active' : '' ?>">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <?php if (isset($user)) : ?>
                    <li class="nav-item<?= $isThisDashboard ? ' active' : '' ?>">
                        <a class="nav-link" href="/dashboard.php">Dashboard</a>
                    </li>
                <?php endif ?>
            </ul>
            <div class="d-flex" style="gap: 0.5rem">
                <span class="lead"><?= isset($user) ? 'Welcome, ' . $user->name : 'Hello, GUEST!' ?></span>
                <?php if (isset($user)) : ?>
                    <a href="/logout.php" class="btn btn-danger btn-sm">Logout</a>
                <?php else : ?>
                    <a href="/register.php" class="btn btn-primary btn-sm">Register</a>
                    <a href="/login.php" class="btn btn-dark btn-sm">Login</a>
                <?php endif ?>
            </div>
        </div>
    </nav>