<?php

$title = 'SimpleAuth - Login';

// Starting session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$flash = $_SESSION['flash'];
$input = $_SESSION['input'];
$error = $_SESSION['error'];

unset($_SESSION['flash']);
unset($_SESSION['input']);
unset($_SESSION['error']);

$user = $_SESSION['user'];
if (isset($user)) {
    return header('Location: /dashboard.php');
}

?>

<?php require_once './includes/head.php' ?>

<h1 class="text-center mt-3">Login to your account</h1>

<form action="/auth.php" method="post" class="container col-md-6 offset-md-3 col-lg-4 offset-lg-4 my-4 p-4 border rounded-lg">
    <?php if (isset($flash['danger'])) : ?>
        <p class="alert alert-danger">
            <?= $flash['danger'] ?>
        </p>
    <?php elseif (isset($flash['success'])) : ?>
        <p class="alert alert-success">
            <?= $flash['success'] ?>
        </p>
    <?php endif ?>
    <div class="form-group">
        <label for="emailAddress">Email</label>
        <input type="email" class="form-control<?= isset($error['email']) ? ' is-invalid' : '' ?>" id="emailAddress" name="email" value="<?= $input['email'] ?>">
        <?php if (isset($error['email'])) : ?>
            <span class="invalid-feedback">
                <?= $error['email'] ?>
            </span>
        <?php endif ?>
    </div>
    <div class="form-group">
        <label for="currentPassword">Password</label>
        <input type="password" class="form-control<?= isset($error['password']) ? ' is-invalid' : '' ?>" id="currentPassword" name="password">
        <?php if (isset($error['password'])) : ?>
            <span class="invalid-feedback">
                <?= $error['password'] ?>
            </span>
        <?php endif ?>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
</form>

<?php require_once './includes/foot.php' ?>