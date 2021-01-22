<?php
include "./assets/php/theme.php";
include "./assets/php/functions.php";

session_start();

$rootlink = $GLOBALS['rootlink'];

if (isset($_SESSION["login"])) {
    header("Location: " . $rootlink . "/listpost.php"); // change the location
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= $headTheme; ?>
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand">
                            <img src="LOGO.svg" alt="logo" width="100" class="shadow-light rounded-circle">
                        </div>
                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="#" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="email">Email or Whatsapp Number</label>
                                        <input id="email" type="text" class="form-control" name="email" tabindex="1" required autofocus>
                                        <div class="invalid-feedback">
                                            Please fill in your email
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                            <!--
                                            <div class="float-right">
                                                <a href="<?= $rootlink ?>/forgot-password.php" class=" text-small">
                                                    Forgot Password?
                                                </a>
                                            </div>
                                            -->
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                                        <div class="invalid-feedback">
                                            please fill in your password
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                                            <label class="custom-control-label" for="remember-me">Remember Me</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" name="submitlogin" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="mt-5 text-muted text-center">
                            Don't have an account? <a href="<?= $rootlink ?>/register.php">Create One</a>
                        </div>
                        <div class="simple-footer">
                            Lorem ipsum
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?= $jsTheme; ?>
</body>

</html>
<?php
if (isset($_POST['submitlogin'])) {
    $userEmail = $_POST['email'];
    $userPass = $_POST['password'];

    $verifiedUser = mysqli_query($conn, "SELECT * FROM `user_data` WHERE `email` = '$userEmail' OR `whatsapp` = '$userEmail' ");

    if (mysqli_num_rows($verifiedUser) === 1) {
        $userDatas = mysqli_fetch_assoc($verifiedUser);
        $userId = $userDatas['id'];

        if (password_verify($userPass, $userDatas['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['userid'] = $userId;
            if ($userDatas['admin'] == 1) {
                $_SESSION['isAdmin'] = true;
            } else {
                $_SESSION['isAdmin'] = false;
            }
            if (isset($_POST['remember'])) {
                $params = session_get_cookie_params();
                setcookie(session_name(), $_COOKIE[session_name()], time() + 60 * 60 * 24 * 30, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
            }
            echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Login Complete!',
                text: 'You will be redirected to Member page!',
                showConfirmButton: true,
                closeOnConfirm: false
            }).then(function() {
                window.location.href = '" . $GLOBALS['rootlink'] . "/listpost.php';
            });
            </script>";
        } else {
            echo "<script>
				Swal.fire('Oops...', 'Wrong combination of email and password!', 'error');
				</script>";
            exit;
            header("Location: ". $GLOBALS['rootlink'] ."/login.php");
        }
    } else {
        echo "<script>
				Swal.fire('Oops...', 'Wrong combination of email and password!', 'error');
				</script>";
        exit;
    }
}

?>