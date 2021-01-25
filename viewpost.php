<?php
include "./assets/php/theme.php";
include "./assets/php/functions.php";

session_start();
$rootlink = $GLOBALS['rootlink'];

if (!isset($_SESSION["login"])) {
    header("Location: " . $rootlink . "/login.php"); // change the location
    exit;
}

$userID = $_SESSION['userid'];
$userData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `user_data` WHERE `id` = '$userID'"));

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= $headTheme; ?>
</head>

<body class="layout-3">
    <div id="app">
        <div class="main-wrapper container">
            <div class="navbar-bg"></div>
            <?= topNavbarTheme($userData['first_name'], $userData['last_name'], $_SESSION['isAdmin']) ?>
            <script>
                document.getElementById("topbar1").className += " active"
            </script>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>View Post</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="<?= $rootlink; ?>/listpost.php">List Post</a></div>
                            <div class="breadcrumb-item">View Post</div>
                        </div>
                    </div>

                    <div class="section-body">
                        <article class="article article-style-c">
                            <div class="article-details">
                                <?php
                                if (isset($_GET['id'])) {
                                    $postid = $_GET['id'];
                                    $queryMysql = mysqli_query($conn, "SELECT post_data.id, post_data.title, post_data.body, post_data.datetime, post_category.name AS category, user_data.first_name, user_data.last_name FROM post_data INNER JOIN post_category ON post_data.category = post_category.id INNER JOIN user_data ON post_data.userid = user_data.id WHERE post_data.id = '$postid'");
                                    if (mysqli_num_rows($queryMysql) != 0) {
                                        $postDatas = mysqli_fetch_assoc($queryMysql); ?>
                                        <div class="article-category"><a href="#"><?= $postDatas['category'] ?></a>
                                            <div class="bullet"></div> <a href="#"><?= $postDatas['datetime'] ?></a>
                                        </div>
                                        <div class="article-title">
                                            <h2><a href="#"><?= $postDatas['title'] ?></a></h2>
                                        </div>
                                        <div>
                                            <?= $postDatas['body'] ?>
                                        </div>
                                        <div class="article-user">
                                            <img alt="image" src="<?= $rootlink; ?>/assets/img/avatar/avatar-1.png">
                                            <div class="article-user-details">
                                                <div class="user-detail-name">
                                                    <a style="color: black;" href="#"><?= $postDatas['first_name'] . " " . $postDatas['last_name'] ?></a>
                                                </div>
                                                <div class="text-job">Admin</div>
                                            </div>
                                        </div>
                                    <?php } else if (mysqli_num_rows($queryMysql) == 0) { ?>
                                        <div class="article-title">
                                            <h2><a href="#">Post Not Found</a></h2>
                                        </div>
                                        <div class="alert alert-danger" role="alert" style="background-color: #f8d7da;color:black">
                                            Are You Lost ?
                                        </div>
                                    <?php }
                                } else if (!isset($_GET['id'])) { ?>
                                    <div class="article-title">
                                        <h2><a href="#">Post Not Found</a></h2>
                                    </div>
                                    <div class="alert alert-danger" role="alert" style="background-color: #f8d7da;color:black">
                                        Are You Lost ?
                                    </div>
                                <?php } ?>
                            </div>
                        </article>
                    </div>
                </section>
            </div>
            <?= footerTheme(); ?>
        </div>
    </div>
    <?= $jsTheme; ?>
</body>

</html>
