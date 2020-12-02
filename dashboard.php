<?php

$title = 'SimpleAuth - Dashboard';
$isThisDashboard = true;

// Starting session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'];
if (empty($user)) {
    return header('Location: /login.php');
}

?>

<?php require_once './includes/head.php' ?>

<h1 class="text-center mt-3">Dashboard</h1>

<?php require_once './includes/foot.php' ?>