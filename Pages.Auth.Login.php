<?php
require 'db.php';
session_start();

// Secure session initialization
session_set_cookie_params([
    'lifetime' => 0,                // Session cookie valid until the browser is closed
    'path' => '/',                  // Cookie available within the entire domain
    'domain' => 'yourdomain.com',   // Change to your domain
    'secure' => true,               // Only send over HTTPS
    'httponly' => true,             // Prevent JavaScript access
    'samesite' => 'Lax'             // Prevent CSRF attacks
]);
session_start();

if (!isset($_SESSION['initialized'])) {
    session_regenerate_id(true);
    $_SESSION['initialized'] = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true); // Prevent session fixation
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['LAST_ACTIVITY'] = time();

        echo "Login successful! Welcome, " . htmlspecialchars($username) . "!";
    } else {
        echo "Invalid username or password!";
    }
}

function is_session_valid() {
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent'])) {
        return false;
    }

    if ($_SESSION['IPaddress'] !== $_SERVER['REMOTE_ADDR']) {
        return false;
    }

    if ($_SESSION['userAgent'] !== $_SERVER['HTTP_USER_AGENT']) {
        return false;
    }

    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > 1800) { // 30 minutes
        return false;
    }

    $_SESSION['LAST_ACTIVITY'] = time(); // Update last activity time stamp

    return true;
}

if (!is_session_valid()) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dore jQuery</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="stylesheet" href="font/iconsmind-s/css/iconsminds.css" />
    <link rel="stylesheet" href="font/simple-line-icons/css/simple-line-icons.css" />

    <link rel="stylesheet" href="css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap.rtl.only.min.css" />
    <link rel="stylesheet" href="css/vendor/bootstrap-float-label.min.css" />
    <link rel="stylesheet" href="css/main.css" />
</head>

<body class="background show-spinner no-footer">
    <div class="fixed-background"></div>
    <main>
        <div class="container">
            <div class="row h-100">
                <div class="col-12 col-md-10 mx-auto my-auto">
                    <div class="card auth-card">
                        <div class="position-relative image-side ">

                            <p class=" text-white h2">جادوی کارِ ما توی جزئیاتشه</p>

                            <p class="white mb-0">
                                برای ورود به سیستم نام کاربری و رمز خود را وارد کنید
                                <br> اگه حساب کاربری نداری نگران نباش، از <a class="white" href="Pages.Auth.Register.html">اینجا</a> میتونی تو سایت اسمتو بویسی
                            </p>
                        </div>
                        <div class="form-side">
                            <a href="Dashboard.Default.html">
                                <span class="logo-single"></span>
                            </a>
                            <h6 class="mb-4">ورود</h6>
                            <form>
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" />
                                    <span>پست الکترونیک</span>
                                </label>

                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" type="password" placeholder="" />
                                    <span>کلمه عبور</span>
                                </label>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#">رمز عبورت یادت رفته؟?</a>
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">ورود</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="js/vendor/jquery-3.3.1.min.js"></script>
    <script src="js/vendor/bootstrap.bundle.min.js"></script>
    <script src="js/dore.script.js"></script>
    <script src="js/scripts.js"></script>
</body>

</html>