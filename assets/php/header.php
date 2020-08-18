<?php
    require_once 'assets/php/session.php';
    //echo '<pre>';
    //print_r($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='icon' href='favicon.ico' type='image/x-icon' />
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <title>ROSE - <?= ucfirst(basename($_SERVER['PHP_SELF'], '.php')); ?></title>
</head>
<body>
<nav class="navbar navbar-expand-md bg-info navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="index.php"><img src="img/logo.png" alt="Logo" style="width:20px;"> ROSE</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == "home.php") ? "active" : ""; ?>" href="home.php"><i class="fas fa-home"></i> Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == "profile.php") ? "active" : ""; ?>" href="profile.php"><i class="far fa-id-card"></i> Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == "feedback.php") ? "active" : ""; ?>" href="feedback.php"><i class="fas fa-comment-dots"></i> Feedback</a>
      </li>      
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == "notification.php") ? "active" : ""; ?>" href="notification.php"><i class="far fa-bell"></i> Notification <span id="checkNotification"></span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == "help.php") ? "active" : ""; ?>" href="help.php"><i class="fas fa-question-circle"></i> Help</a>
      </li>
        <!-- Dropdown -->
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
            <i class="fas fa-user-circle"></i> Welcome, <?= $cfname; ?>
            </a>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Setting</a>
                <a class="dropdown-item" href="assets/php/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                <a class="dropdown-item" href="#"> [LINK]</a>
            </div>
        </li>
    </ul>
  </div>
</nav> 