<?php

    session_start();
    require_once 'auth.php';
    $cuser = new Auth();

    if(!isset($_SESSION['user'])){
        header('location:index.php');
        die;
    }

    $cemail = $_SESSION['user'];

    $data = $cuser->currentUser($cemail);

    $cid = $data['id'];
    $cfname = $data['first_name'];
    $clname = $data['last_name'];
    $cpass = $data['password'];
    $cphone = $data['phone'];
    $cgender = $data['gender'];
    $cdob = $data['dob'];
    $cphoto = $data['photo'];
    $created = $data['created_at'];

    $reg_on = date('d/M/Y', strtotime($created));

    $verified = $data['verified'];

    if($verified == 0){
        $verified = false; //"Not Verified!";
    }else{
        $verified = true; //"Verified!";
    }

?>    