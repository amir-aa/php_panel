<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $user = $_POST['name'];
    $stmt = $pdo->prepare('INSERT INTO users (name,username, password) VALUES (:name,:username, :password)');
    $stmt->execute(['username' => $username, 'password' => $password,'name'=>$name]);

   // echo "User registered successfully!";
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
                                اطلاعاتت رو وارد کن و به همین سرعت ثبت نام کن
                                <br> اگه حساب کاربری نداری نگران نباش، از <a class="white" href="Pages.Auth.Register.html">اینجا</a> میتونی تو سایت اسمتو بویسی
                            </p>
                        </div>
                        <div class="form-side">
                            <a href="Dashboard.Default.html">
                                <span class="logo-single"></span>
                            </a>
                            <h6 class="mb-4">عضویت</h6>

                            <form method="post" action="">
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" name="name" id="name" />
                                    <span>نام</span>
                                </label>
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" name="username" id="username" />
                                    <span>پست الکترونیک</span>
                                </label>
                                <label class="form-group has-float-label mb-4">
                                    <input class="form-control" type="password" name="password" id="password" placeholder="" />
                                    <span>کلمه عبور</span>
                                </label>
                                <div class="d-flex justify-content-end align-items-center">
                                    <button class="btn btn-primary btn-lg btn-shadow" type="submit">عضویت</button>
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