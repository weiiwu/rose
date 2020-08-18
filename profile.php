<?php
    require_once 'assets/php/header.php';
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-12">
            <div class="card rounded-0 mt-3 border-info">
                <div class="card-header border-info">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a href="#profile" class="nav-link active" data-toggle="tab">Profile</a>
                        </li>                    
                        <li class="nav-item">
                            <a href="#editProfile" class="nav-link" data-toggle="tab">Edit Profile</a>
                        </li>                    
                        <li class="nav-item">
                            <a href="#changePass" class="nav-link" data-toggle="tab">Change Password</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- profile -->
                        <div class="tab-pane container active" id="profile">
                            <div id="verifyEmailAlert"></div>
                            <div class="card-deck">
                                <div class="card border-info align-self-center">
                                    <div class="card-header bg-info text-light text-center lead">
                                        User ID: <?= $cid ?>
                                    </div>   
                                    <?php if(!$cphoto):  ?>
                                        <img src="assets/img/avatar.png" class="img-thumbnail img-fluid">
                                    <?php else: ?>  
                                        <img src="assets/php/<?= $cphoto ?>" class="img-thumbnail img-fluid">
                                    <?php endif ?>
                                </div>                                
                                <div class="card border-info">

                                    <div class="card-body">
                                        <p class="card-text border-bottom border-info">First Name: <?= $cfname; ?></p>
                                        <p class="card-text border-bottom border-info">Last Name: <?= $cfname; ?></p>
                                        <p class="card-text border-bottom border-info">E-Mail: <?= $cemail; ?></p>
                                        <p class="card-text border-bottom border-info">Gender: 
                                        <?php 
                                            if($cgender == '1'){
                                                echo 'Male';
                                            }elseif($cgender == '2'){
                                                echo 'Female';}
                                            else{ 
                                                echo 'None';
                                            } 
                                        ?></p>
                                        <p class="card-text border-bottom border-info">DOB: <?= $cdob; ?></p>
                                        <p class="card-text border-bottom border-info">Phone: <?= $cphone; ?></p>
                                        <p class="card-text border-bottom border-info">Registered On: <?= $reg_on; ?></p>
                                        <p class="card-text border-bottom border-info">E-Mail Verified: <?= ($verified ? 'Yes' : 'No <a href="#" id="verify-email" class="float-right">Verify Now</a>') ?></p>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- profile -->
                        <!-- edit profile -->
                        <div class="tab-pane container fade" id="editProfile">
                            <div class="card-deck">
                                <div class="card border-warning align-self-center">
                                    <div class="card-header bg-info text-light text-center lead">
                                        User ID: <?= $cid ?>
                                    </div>   
                                    <?php if(!$cphoto):  ?>
                                        <img src="assets/img/avatar.png" class="img-thumbnail img-fluid">
                                    <?php else: ?>  
                                        <img src="assets/php/<?= $cphoto ?>" class="img-thumbnail img-fluid">
                                    <?php endif ?>
                                </div>
                                <div class="card border-warning">
                                    <form action="" method="post" class="px-3 mt-2" enctype="multipart/form-data" id="profile-update-form">
                                        <input type="hidden" name="oldimage" value="<?= $cphoto ?>">
                                        <div class="form-group m-0">
                                            <label for="profilePhoto" class="m-1">Upload Profile Image</label>
                                            <input type="file" name="image" id="profilePhoto">
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="first name" class="m-1">First Name</label>
                                            <input type="text" name="fname" id="fname" class="form-control form-control-sm" value="<?= $cfname ?>">
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="last name" class="m-1">Last Name</label>
                                            <input type="text" name="lname" id="lname" class="form-control form-control-sm" value="<?= $clname ?>">
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="gender" class="m-1">Gender</label>
                                            <select name="gender" id="gender" class="form-control form-control-sm">
                                                <option value="" disable <?php if($cgender == null){echo 'selected';} ?>>Select</option>
                                                <option value="1" disable <?php if($cgender == '1'){echo 'selected';} ?>>Male</option>
                                                <option value="2" disable <?php if($cgender == '2'){echo 'selected';} ?>>Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="dob" class="m-1">DOB</label>
                                            <input type="date" name="dob" id="dob" class="form-control form-control-sm" value="<?= $cdob ?>">                                        
                                        </div>

                                        <div class="form-group m-0">
                                            <label for="phone" class="m-1">Phone</label>
                                            <input type="tel" name="phone" id="phone" class="form-control form-control-sm" value="<?= $cphone ?>">                                        
                                        </div>

                                        <div class="form-group mt-2">
                                            <input type="submit" name="profile-update" id="profileUpdateBtn" class="btn btn-info btn-block" value="Update Profile">                                        
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- edit profile -->
                        <!-- change password -->
                        <div class="tab-pane container fade" id="changePass">
                            <div id="changepassAlert"></div>
                            <div class="card-deck">
                                <div class="card border-warning">
                                    <div class="card-header bg-info text-light text-center lead">
                                        Change Password
                                    </div>
                                    <form action="#" method="post" class="px-3 mt-2" id="change-pass-form">
                                        <div class="form-group">
                                            <label for="curpass">Enter your current password</label>
                                            <input type="password" name="curpass" placeholder="Current Password" class="form-control form-control-sm" id="curpass" required minlength="5">
                                        </div>

                                        <div class="form-group">
                                            <label for="newpass">Enter new password</label>
                                            <input type="password" name="newpass" placeholder="New Password" class="form-control form-control-sm" id="newpass" required minlength="5">
                                        </div>

                                        <div class="form-group">
                                            <label for="cnewpass">Confirm new password</label>
                                            <input type="password" name="cnewpass" placeholder="Confirm New Password" class="form-control form-control-sm" id="cnewpass" required minlength="5">
                                        </div>

                                        <div class="form-group">
                                            <p id="changepassError" class="text-danger"></p>
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" value="Change Password" name="changepass" class="btn btn-info btn-block" id="changePassBtn">
                                        </div>
                                    </form>
                                </div>
                            
                            </div>
                        </div>

                        <!-- change password -->
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>  

<script type="text/javascript">
    $(document).ready(function(){
        //Profile update
        $("#profile-update-form").submit(function(e){
            e.preventDefault();

            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                processData: false,
                contentType: false,
                cache: false,
                data: new FormData(this),
                success: function(response){
                    location.reload();
                }
            });
        });

        //Change password
        $("#changePassBtn").click(function(e){
            if($("#change-pass-form")[0].checkValidity()){
                e.preventDefault();
                $("#changePassBtn").val('Please wait...');

                if($("#newpass").val() != $("#cnewpass").val()){
                    $("#changepassError").text('*Passwords did not match');
                    $("#changePassBtn").val('Change Password');
                }else{
                    $.ajax({
                        url: 'assets/php/process.php',
                        method: 'post',
                        data: $("#change-pass-form").serialize()+'&action=change_pass',
                        success:function(response){
                            $("#changepassAlert").html(response);
                            $("#changePassBtn").val('Change Password');
                            $("#changepassError").text('');
                            $("#change-pass-form")[0].reset();
                        }
                    });
                }
            }
        });

        //Verify email
        $("#verify-email").click(function(e){
            e.preventDefault();
            $(this).text('Please wait...');

            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: { action: 'verify_email' },
                success: function(response){
                    $("#verifyEmailAlert").html(response);
                    $("#verify-email").text('Verify Now');
                }
            })
        })

        //Check notification
        checkNotification();
        function checkNotification(){
            $.ajax({
                url: 'assets/php/process.php',
                method: 'post',
                data: { action: 'checkNotification' },
                success:function(response) {
                    //console.log(response);
                    $("#checkNotification").html(response);
                }
            });
        }
    });
</script>
</body>
</html>