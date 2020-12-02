<?php

$title = 'SimpleAuth - Register';

// Starting session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$input = $_SESSION['input'];
$error = $_SESSION['error'];

unset($_SESSION['input']);
unset($_SESSION['error']);

$user = $_SESSION['user'];
if (isset($user)) {
    return header('Location: /dashboard.php');
}

?>

<?php require_once './includes/head.php' ?>

<h1 class="text-center mt-3">Register for an account</h1>

<form action="/store.php" method="post" class="container col-md-6 offset-md-3 col-lg-4 offset-lg-4 my-4 p-4 border rounded-lg">
    <div class="form-group">
        <label for="userName">Name</label>
        <input type="text" class="form-control<?= isset($error['name']) ? ' is-invalid' : '' ?>" id="userName" name="name" value="<?= $input['name'] ?>">
        <?php if (isset($error['name'])) : ?>
            <span class="invalid-feedback">
                <?= $error['name'] ?>
            </span>
        <?php endif ?>
    </div>
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
        <label for="newPassword">New Password</label>
        <input type="password" class="form-control<?= isset($error['password']) ? ' is-invalid' : '' ?>" id="newPassword" name="password">
        <?php if (isset($error['password'])) : ?>
            <span class="invalid-feedback">
                <?= $error['password'] ?>
            </span>
        <?php endif ?>
    </div>
    <div class="form-group">
        <label for="confirmPassword">Confirm Password</label>
        <input type="password" class="form-control" id="confirmPassword" name="password2">
    </div>
    <button type="submit" class="btn btn-primary">Register</button>
</form>

<?php require_once './includes/foot.php' ?>