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
                    <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                        <div class="login-brand">
                            <img src="LOGO" alt="logo" width="100" class="shadow-light rounded-circle">
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Register</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST">
                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="first_name">First Name</label>
                                            <input id="first_name" type="text" class="form-control" name="first_name" autofocus>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="last_name">Last Name</label>
                                            <input id="last_name" type="text" class="form-control" name="last_name">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email">
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Whatsapp Number</label>
                                        <input id="whatsapp" type="text" class="form-control" name="whatsapp">
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="form-group col-6">
                                            <label for="password" class="d-block">Password</label>
                                            <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator" name="password">
                                            <div id="pwindicator" class="pwindicator">
                                                <div class="bar"></div>
                                                <div class="label"></div>
                                            </div>
                                        </div>
                                        <div class="form-group col-6">
                                            <label for="password2" class="d-block">Password Confirmation</label>
                                            <input id="password2" type="password" class="form-control" name="password-confirm">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="agree" class="custom-control-input" id="agree">
                                            <label class="custom-control-label" for="agree">I agree with the terms and conditions</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" name="submitregister" class="btn btn-primary btn-lg btn-block">
                                            Register
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="simple-footer">
                            Lore Ipsum
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
if (isset($_POST['submitregister'])) {
    $userMail = $_POST['email'];
    $userWA = $_POST['whatsapp'];

    $verifiedUser = mysqli_query($conn, "SELECT * FROM `user_data` WHERE `email` = '$userMail' OR `whatsapp` = '$userWA'");

    if (mysqli_num_rows($verifiedUser) === 1) {
        echo "<script>
				Swal.fire('Oops...', 'Email or Whatsapp number is already registered!', 'error');
				</script>";
        exit;
    } else {
        if ($_POST['password'] != $_POST['password-confirm']) {
            echo "<script>
				Swal.fire('Oops...', 'Password Not Match!', 'error');
				</script>";
            exit;
        } else {
            $firstName = stripslashes(htmlspecialchars($_POST['first_name']));  
            $lastName = stripslashes(htmlspecialchars($_POST['last_name']));
            $userPass = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $regisQuery = mysqli_query($conn, "INSERT INTO `user_data` (`id`, `email`, `whatsapp`, `first_name`, `last_name`, `password`, `admin`) VALUES (NULL, '$userMail', '$userWA', '$firstName', '$lastName', '$userPass', '0');");

            if ($regisQuery) {
                echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Registration Complete!',
            text: 'You will be redirected to login page!',
            showConfirmButton: true,
            closeOnConfirm: false
        }).then(function() {
            window.location.href = '" . $GLOBALS['rootlink'] . "/login.php';
        });
        </script>";
            } else {
                echo "<script>
        Swal.fire('Oops...', 'Registration failed!', 'error');
        </script>";
            }
        }
    }
}