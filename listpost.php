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

$page = 1;
$maxPost = 5;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}
$nowLimit = ($page - 1) * $maxPost;

$postDatas = query("SELECT post_data.id, post_data.title, post_data.body, post_data.datetime, post_category.name AS category, user_data.first_name, user_data.last_name FROM post_data INNER JOIN post_category ON post_data.category = post_category.id INNER JOIN user_data ON post_data.userid = user_data.id ORDER BY `post_data`.`id` DESC LIMIT $nowLimit,$maxPost");
$postNumber = mysqli_num_rows(mysqli_query($conn, "SELECT post_data.id, post_data.title, post_data.body, post_data.datetime, post_category.name AS category, user_data.first_name, user_data.last_name FROM post_data INNER JOIN post_category ON post_data.category = post_category.id INNER JOIN user_data ON post_data.userid = user_data.id"));

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
                        <h1>List Post</h1>
                    </div>

                    <div class="section-body">
                        <?php
                        $indexing = 0;
                        foreach ($postDatas as $postDatas) {
                            if ($indexing == 0 && $page == 1) { ?>
                                <h2 class="section-title">Newest Post</h2>
                            <?php }  ?>
                            <article class="article article-style-c">
                                <div class="article-details">
                                    <div class="article-category"><a href="#"><?= $postDatas['category'] ?></a>
                                        <div class="bullet"></div> <a href="#"><?= $postDatas['datetime'] ?></a>
                                    </div>
                                    <div class="article-title">
                                        <h2><a href="#" style="color: black;"><?= $postDatas['title'] ?></a></h2>
                                    </div>
                                    <p>
                                        <a href="<?= $GLOBALS['rootlink'] ?>/viewpost.php?id=<?= $postDatas['id'] ?>">Read More <i class="fas fa-chevron-right"></i></a>
                                    </p>
                                    <div class="article-user">
                                        <img alt="image" src="<?= $rootlink; ?>/assets/img/avatar/avatar-1.png">
                                        <div class="article-user-details">
                                            <div class="user-detail-name">
                                                <a href="#" style="color: black;"><?= $postDatas['first_name'] . " " . $postDatas['last_name'] ?></a>
                                            </div>
                                            <div class="text-job">Admin</div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <?php if ($indexing == 0 && $page == 1) { ?>
                                <hr>
                        <?php }
                            $indexing++;
                        } ?>
                    </div>
                    <nav aria-label="...">
                        <ul class="pagination" id="paginationContainer">
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                        </ul>
                    </nav>
                </section>
            </div>
            <?= footerTheme(); ?>
        </div>
    </div>
    <?= $jsTheme; ?>
    <script>
        var nowpage = <?= $page ?>;
        var manypost = <?= $postNumber ?>;
        var maxpostpage = <?= $maxPost ?>;
        var baselink = "<?= $GLOBALS['rootlink'] ?>";
        var pagination;
        if (manypost % maxpostpage == 0) {
            pagination = manypost / maxpostpage;
        } else {
            pagination = Math.floor((manypost + maxpostpage) / maxpostpage);
        }
        $(document).ready(function() {
            var paginationstr = "";
            for (let index = 1; index <= pagination; index++) {
                if (index == nowpage) {
                    paginationstr = `${paginationstr}<li class="page-item active"><a class="page-link" href="${baselink}/listpost.php?page=${index}">${index} <span class="sr-only">(current)</span></a></li>`;
                } else {
                    paginationstr = `${paginationstr}<li class="page-item"><a class="page-link" href="${baselink}/listpost.php?page=${index}">${index}</a></li>`;
                }
            }
            document.getElementById('paginationContainer').innerHTML = paginationstr;
        });
    </script>
</body>

</html>