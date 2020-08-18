<?php
    session_start();
    if(!isset($_SESSION['username'])) {
        header('location:index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php

        $title = basename($_SERVER['PHP_SELF'], '.php');
        $title = explode('_', $title);
        $title = ucfirst($title[1]);

    ?>
    <title><?= $title ?> | Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/cosmo/bootstrap.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js" defer></script>
    <link href="assets/css/styles.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>  
    <script type="text/javascript">
        $(document).ready(function(){
            $("#open-nav").click(function(){
                $(".admin-nav").toggleClass('animate');
            })
        })
    </script>
    </head>
<body>
    <div class="container-fluid">
        <div class="row small">
            <div class="admin-nav p-0">
                <h4 class="text-light text-center p-2">Admin Panel</h4>

                <div class="list-group list-group-flush">

                    <a href="admin_dashboard.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php') ? "nav-active" : ""; ?>"><i class="fas fa-chart-pie"></i> Dashboard</a>

                    <a href="admin_users.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin_users.php') ? "nav-active" : ""; ?>"><i class="fas fa-user-friends"></i> Users</a>

                    <a href="admin_notes.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin_notes.php') ? "nav-active" : ""; ?>"><i class="fas fa-sticky-note"></i> Notes</a>

                    <a href="admin_feedback.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin_feedback.php') ? "nav-active" : ""; ?>"><i class="fas fa-comment"></i> Feedback</a>

                    <a href="admin_notification.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin_notification.php') ? "nav-active" : ""; ?>"><i class="fas fa-bell"></i> Notification <span id="checkNotification"></span></a>                    

                    <a href="admin_deleteduser.php" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin_deleteduser.php') ? "nav-active" : ""; ?>"><i class="fas fa-user-slash"></i> Deleted Users</a>
                    
                    <a href="assets/php/admin_action.php?export=excel" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php') ? "nav-active" : ""; ?>"><i class="fas fa-table"></i> Export Users</a>

                    <a href="#" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php') ? "nav-active" : ""; ?>"><i class="fas fa-id-card"></i> Profile</a>

                    <a href="#" class="list-group-item text-light admin-link <?= (basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php') ? "nav-active" : ""; ?>"><i class="fas fa-cog"></i> Setting</a>
                </div>
            </div>
            <div class="col">
                <div class="row">
                    <div class="col-lg-12 bg-primary pt-2 justify-content-between d-flex">
                        <a href="#" class="text-light" id="open-nav"><h3><i class="fas fa-bars"></i></h3></a>
                        <h4 class="text-light"><?= $title ?></h4>

                        <a href="assets/php/logout.php" class="text-light mt-1"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </div>
                </div>