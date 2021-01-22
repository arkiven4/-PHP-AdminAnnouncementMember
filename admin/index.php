<?php
include "../assets/php/theme.php";
include "../assets/php/functions.php";

session_start();
$rootlink = $GLOBALS['rootlink'];

if (!isset($_SESSION['isAdmin'])) {
    header("Location: " . $rootlink . "/listpost.php"); // change the location
    exit;
}

$userID = $_SESSION['userid'];
$userData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `user_data` WHERE `id` = '$userID'"));

$manyUser = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `user_data`"));
$manyPost = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `post_data`"));

$page = 1;
$maxPost = 10;
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

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <?= admintopNavbarTheme($userData['first_name'], $userData['last_name']) ?>
            <?= adminsidebarTheme() ?>
            <script>
                document.getElementById("dashboard").className += " active"
            </script>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Dashboard</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-primary">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Registered Member</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= $manyUser ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-danger">
                                    <i class="far fa-newspaper"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Total Post</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= $manyPost ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-warning">
                                    <i class="far fa-file"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Lore</h4>
                                    </div>
                                    <div class="card-body">
                                        1,201
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <div class="card card-statistic-1">
                                <div class="card-icon bg-success">
                                    <i class="fas fa-circle"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>Ipsum</h4>
                                    </div>
                                    <div class="card-body">
                                        47
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Posts List</h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Author</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($postDatas as $postDatas) { ?>
                                                    <tr>
                                                        <td>
                                                            <?= $postDatas['title'] ?>
                                                            <div class="table-links">
                                                                in <a href="#"><?= $postDatas['category'] ?></a>
                                                                <div class="bullet"></div>
                                                                <a href="<?= $rootlink ?>/viewpost.php?id=<?= $postDatas['id'] ?>" target="_blank">View</a>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <a href="#" class="font-weight-600" style="color: black;"><img src="../assets/img/avatar/avatar-1.png" alt="avatar" width="30" class="rounded-circle mr-1"> <?= $postDatas['first_name'] . " " . $postDatas['last_name']  ?></a>
                                                        </td>
                                                        <td>
                                                            <form method="post">
                                                                <a class="btn btn-primary btn-action mr-1" data-toggle="tooltip" title="Edit" href="<?= $GLOBALS['rootlink'] ?>/admin/editpost.php?id=<?= $postDatas['id'] ?>"><i class="fas fa-pencil-alt"></i></a>
                                                                <input type="hidden" name="id" value="<?= $postDatas['id'] ?>">
                                                                <input type="hidden" name="deletePost">
                                                                <a class="btn btn-danger btn-action" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?')?this.parentNode.submit():'';"><i class="fas fa-trash"></i></a>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <nav aria-label="...">
                                        <ul class="pagination" id="paginationContainer">
                                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
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
                    paginationstr = `${paginationstr}<li class="page-item active"><a class="page-link" href="${baselink}/admin/?page=${index}">${index} <span class="sr-only">(current)</span></a></li>`;
                } else {
                    paginationstr = `${paginationstr}<li class="page-item"><a class="page-link" href="${baselink}/admin/?page=${index}">${index}</a></li>`;
                }
            }
            document.getElementById('paginationContainer').innerHTML = paginationstr;
        });
    </script>
</body>

</html>

<?php
if (isset($_POST['deletePost'])) {
    $idpost = $_POST['id'];
    mysqli_query($conn, "DELETE FROM `post_data` WHERE id = $idpost");
    if (mysqli_affected_rows($conn) > 0) {
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Delete Complete!',
            showConfirmButton: true,
            closeOnConfirm: false
        }).then(function() {
            window.location.href = window.location.href;
        });
        </script>";
    } else {
        echo "<script>
        Swal.fire('Oops...', 'Delete failed!', 'error');
        </script>";
    }
}
?>