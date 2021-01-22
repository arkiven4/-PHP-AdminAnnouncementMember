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

if (!isset($_GET['id'])) {
    header("Location: " . $rootlink . "/admin/"); // change the location
    exit;
} else if (isset($_GET['id'])) {
    $postid = $_GET['id'];
    $postData = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `post_data` WHERE `id` = '$postid'"));
}

$categoryDatas = query("SELECT * FROM `post_category` ");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?= $headTheme; ?>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

    <style>
        /* Please add to your summernote.css / summernote-bs4.css file to fix bold. */
        .note-editable b,
        .note-editable strong {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <?= admintopNavbarTheme($userData['first_name'], $userData['last_name']) ?>
            <?= adminsidebarTheme() ?>
            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Editing Post</h1>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Full Summernote</h4>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Title</label>
                                            <div class="col-sm-12 col-md-7">
                                                <input type="text" class="form-control" name="title" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Category</label>
                                            <div class="col-sm-12 col-md-7">
                                                <select name="category" class="form-control selectric" required>
                                                    <?php foreach ($categoryDatas as $categoryDatas) { ?>
                                                        <option value="<?= $categoryDatas['id'] ?>"><?= $categoryDatas['name'] ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Content</label>
                                            <div class="col-sm-12 col-md-7">
                                                <textarea id="summernote" name="editordata"></textarea>

                                            </div>
                                        </div>
                                        <div class="form-group row mb-4">
                                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                            <div class="col-sm-12 col-md-7">
                                                <button type="submit" name="editsubmit" class="btn btn-primary">Publish</button>
                                            </div>
                                        </div>
                                    </form>
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
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                dialogsInBody: true,
                minHeight: 150,
                callbacks: {
                    onImageUpload: function(files, editor, we) {
                        sendFile(files[0], editor, we);
                    }
                },
            });
            $('#summernote').summernote('code', '<?= $postData['body'] ?>');
            document.getElementsByName("title")[0].value = "<?= $postData['title'] ?>";
            document.getElementsByName("category")[0].value = "<?= $postData['category'] ?>";
        });

        function sendFile(file, editor, welEditable) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                url: "<?= $GLOBALS['rootlink'] ?>/assets/php/apiHandler.php",
                data: data,
                cache: false,
                contentType: false,
                processData: false,
                type: 'POST',
                success: function(url) {
                    $('#summernote').summernote('insertImage', url);
                }
            });
        }
    </script>
</body>

</html>
<?php
if (isset($_POST['editsubmit'])) {
    $title = $_POST['title'];
    $categoty = $_POST['category'];
    $editordata = $_POST['editordata'];
    $userID = $_SESSION['userid'];
    $date = date('Y-m-d H:i:s');
    $queryMysql = mysqli_query($conn, "UPDATE `post_data` SET `title` = '$title', `category` =  '$categoty', `body` =  '$editordata', `datetime` =  '$date' WHERE `id` = $postid");

    if ($queryMysql) {
        echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Update Post Complete!',
            showConfirmButton: true,
            closeOnConfirm: false
        }).then(function() {
            window.location.href = '" . $GLOBALS['rootlink'] . "/admin';
        });
        </script>";
    } else {
        echo "<script>
        Swal.fire('Oops...', 'Update Post failed!', 'error').then(function() {
            window.location.href = '" . $GLOBALS['rootlink'] . "/admin';
        });
        </script>";
    }
}

?>