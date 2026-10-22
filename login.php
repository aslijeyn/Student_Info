
<?php
session_start();

if (isset($_SESSION['auth'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['login_btn'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email === "Admin" && $password === "admin123") {
        session_regenerate_id(true);
        $_SESSION['auth'] = true;
        $_SESSION['auth_user'] = [
            'user_name' => 'Administrator',
            'user_email' => 'Admin'
        ];

        $_SESSION['message'] = "Welcome Administrator";
        header("Location: index.php");
        exit();
    }

    $_SESSION['message'] = "Invalid Email or Password";
    header("Location: login.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Login</title>
</head>
<body>
<div class="container mt-5">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info">
            <?= htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8'); unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header"><h4>Administrator Login</h4></div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" name="login_btn" class="btn btn-primary">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
