<?php
$GLOBALS['rootlink'] = "http://localhost/lesterrcox";
$GLOBALS['Site Title'] = "Site Title";

$headTheme = '
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>' . $GLOBALS['Site Title'] . '</title>
<!-- General CSS Files -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<!-- Template CSS -->
<link rel="stylesheet" href="' . $GLOBALS['rootlink'] . '/assets/css/style.css">
<link rel="stylesheet" href="' . $GLOBALS['rootlink'] . '/assets/css/components.css">
';

$jsTheme = '
<!-- General JS Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="' . $GLOBALS['rootlink'] . '/assets/js/stisla.js"></script>
<!-- Template JS File -->
<script src="' . $GLOBALS['rootlink'] . '/assets/js/scripts.js"></script>
<script src="' . $GLOBALS['rootlink'] . '/assets/js/custom.js"></script>
';

function topNavbarTheme($first, $last, $isAdmin = false)
{
?>
    <nav class="navbar navbar-expand-lg main-navbar">
        <a href="<?= $GLOBALS['rootlink']; ?>/listpost.php" class="navbar-brand sidebar-gone-hide"><?= $GLOBALS['Site Title']; ?></a>
        <div class="nav-collapse">
            <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
                <i class="fas fa-ellipsis-v"></i>
            </a>
            <ul class="navbar-nav">
                <li id="topbar1" class="nav-item"><a href="<?= $GLOBALS['rootlink']; ?>/listpost.php" class=" nav-link">List Post</a></li>
                <li id="topbar2" class="nav-item"><a href="#" class="nav-link">Lorem</a></li>
                <li id="topbar3" class="nav-item"><a href="#" class="nav-link">Impsum</a></li>
            </ul>
        </div>
        <form class="form-inline ml-auto">
            <ul class="navbar-nav">
            </ul>
        </form>
        <ul class="navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img alt="image" src="<?= $GLOBALS['rootlink']; ?>/assets/img/avatar/avatar-4.png" class="rounded-circle mr-1">
                    <div class="d-sm-none d-lg-inline-block">Hi, <?= $first . " " . $last ?></div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <?php if ($isAdmin) { ?>
                        <div class="dropdown-divider"></div>
                        <a href="<?= $GLOBALS['rootlink']; ?>/admin" class="dropdown-item has-icon">
                            <i class="far fa-user"></i> Admin
                        </a>
                    <?php } ?>
                    <div class="dropdown-divider"></div>
                    <a href="<?= $GLOBALS['rootlink']; ?>/logout.php" class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
<?php }

function admintopNavbarTheme($first, $last)
{
?>
    <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
            <ul class="navbar-nav mr-3">
                <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            </ul>
        </form>
        <ul class="navbar-nav navbar-right">
            <li class="dropdown">
                <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                    <img alt="image" src="<?= $GLOBALS['rootlink']; ?>/assets/img/avatar/avatar-4.png" class="rounded-circle mr-1">
                    <div class="d-sm-none d-lg-inline-block">Hi, <?= $first; ?> <?= $last; ?></div>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="<?= $GLOBALS['rootlink']; ?>/logout.php" class="dropdown-item has-icon text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
<?php }

function adminsidebarTheme()
{
?>
    <div class="main-sidebar">
        <aside id="sidebar-wrapper">
            <div class="sidebar-brand">
                <a href="<?= $GLOBALS['rootlink']; ?>/admin">Site</a>
            </div>
            <div class="sidebar-brand sidebar-brand-sm">
                <a href="<?= $GLOBALS['rootlink']; ?>/admin">St</a>
            </div>
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li id="dashboard"><a class="nav-link" href="<?= $GLOBALS['rootlink']; ?>/admin"><i class="far fa-square"></i> <span>Dashboard</span></a></li>
                <li class="menu-header">Post</li>
                <li id="create-post"><a class="nav-link" href="<?= $GLOBALS['rootlink']; ?>/admin/create-post.php"><i class="far fa-square"></i> <span>Create New Post</span></a></li>
            </ul>
        </aside>
    </div>
<?php }

function footerTheme()
{ ?>
    <footer class="main-footer">
        <div class="footer-left">
            Lorem ipsum dolor
        </div>
        <div class="footer-right">
            Lorem ipsum dolor
        </div>
    </footer>
<?php }
