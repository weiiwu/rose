<?php
    require_once 'admin_db.php';
    $admin = new Admin();
    session_start();

    //Admin login
    if(isset($_POST['action']) && $_POST['action'] == 'adminLogin') {
        $username = $admin->test_input($_POST['username']);
        $password = $admin->test_input($_POST['password']);

        $hpassword = sha1($password);

        $loggedInAdmin = $admin->admin_login($username,$hpassword);

        if($loggedInAdmin != null){
            echo 'admin_login';
            $_SESSION['username'] = $username;
        }else{
            echo $admin->showMessage('danger', 'Username or Password is incorrect');
        }
    }
    
    //Fetch all users
    if(isset($_POST['action']) && $_POST['action'] == 'fetchAllUsers') {
        $output = '';
        $data = $admin->fetchAllUsers(0);
        $path = '../assets/php/';

        if($data){
            $output .= '<table class="table table-sm table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th>#</th>                    
                        <th>Image</th>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Phone</th>                    
                        <th>Gender</th>                    
                        <th>Verified</th>                    
                        <th>Action</th>                    
                    </tr>
                </thead>
                <tbody>';
            foreach($data as $row) {
                if($row['photo'] != '') {
                    $uphoto = $path.$row['photo'];
                }else{
                    $uphoto = '../assets/img/avatar.png';
                }

                $output .= '<tr>
                    <td>'.$row['id'].'</td>
                    <td><img src="'.$uphoto.'" class="rounded-circle" width="40px"></td>
                    <td>'.$row['first_name'].' '.$row['last_name'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['phone'].'</td>
                    <td>'.$row['gender'].'</td>
                    <td>'.$row['verified'].'</td>
                    <td>
                        <a href="#" id="'.$row['id'].'" title="View Details" class="text-primary userDetailsIcon" data-toggle="modal" data-target="#showUserDetailsModal"><i class="fas fa-info-circle"></i></a> 
                        <a href="#" id="'.$row['id'].'" title="Delete User" class="text-danger deleteUserIcon"><i class="fas fa-trash-alt"></i></a> 
                    </td>
                </tr>';
            }

            $output .= '</tbody>
                </table>';
            echo $output;

        }else{
            echo '<h3 class="text-center text-secondary">No Data Found</h3>';
        }
    }

    //User Id
    if(isset($_POST['details_id'])) {
        $id = $_POST['details_id'];

        $data = $admin->fetchUserDetailsByID($id);

        echo json_encode($data);
    }

    //Deleted user Id
    if(isset($_POST['del_id'])) {
        $id = $_POST['del_id'];
        $admin->userAction($id, 0);
    }

    //Fetch all deleted users
    if(isset($_POST['action']) && $_POST['action'] == 'fetchAllDeletedUsers') {
        $output = '';
        $data = $admin->fetchAllUsers(1);
        $path = '../assets/php/';

        if($data){
            $output .= '<table class="table table-sm table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th>#</th>                    
                        <th>Image</th>
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Phone</th>                    
                        <th>Gender</th>                    
                        <th>Verified</th>                    
                        <th>Action</th>                    
                    </tr>
                </thead>
                <tbody>';
            foreach($data as $row) {
                if($row['photo'] != '') {
                    $uphoto = $path.$row['photo'];
                }else{
                    $uphoto = '../assets/img/avatar.png';
                }

                $output .= '<tr>
                    <td>'.$row['id'].'</td>
                    <td><img src="'.$uphoto.'" class="rounded-circle" width="40px"></td>
                    <td>'.$row['first_name'].' '.$row['last_name'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['phone'].'</td>
                    <td>'.$row['gender'].'</td>
                    <td>'.$row['verified'].'</td>
                    <td><a href="#" id="'.$row['id'].'" title="Restore User" class="text-dark restoreUserIcon"><i class="fas fa-trash-restore"></i></a> 
                    </td>
                </tr>';
            }

            $output .= '</tbody>
                </table>';
            echo $output;

        }else{
            echo '<h3 class="text-center text-secondary">No Data Found</h3>';
        }
    }

    //Restore user Id    
    if(isset($_POST['res_id'])) {
        $id = $_POST['res_id'];

        $admin->userAction($id, 1);
    }

    //Fetch all notes
    if(isset($_POST['action']) && $_POST['action'] == 'fetchAllNotes') {
        $output = '';
        $data = $admin->fetchAllNotes();

        if($data){
            $output .= '<table class="table table-sm table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th>#</th>                    
                        <th>Name</th>
                        <th>E-Mail</th>
                        <th>Title</th>                    
                        <th>Note</th>                    
                        <th>Written</th>                    
                        <th>Updated</th>                    
                        <th>Action</th>                    
                    </tr>
                </thead>
                <tbody>';
            foreach($data as $row) {

                $output .= '<tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['first_name'].' '.$row['last_name'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['title'].'</td>
                    <td>'.$row['note'].'</td>
                    <td>'.$row['created_at'].'</td>
                    <td>'.$row['updated_at'].'</td>
                    <td><a href="#" id="'.$row['id'].'" title="Delete Note" class="text-danger deleteNoteIcon"><i class="fas fa-trash-alt"></i></a>                    
                    </td>
                </tr>';
            }

            $output .= '</tbody>
                </table>';
            echo $output;

        }else{
            echo '<h3 class="text-center text-secondary">No Data Found</h3>';
        }
    }

    //Delete the note
    if(isset($_POST['note_id'])) {
        $id = $_POST['note_id'];

        $admin->deleteNoteOfUser($id);
    }

    //Fetch all feedback
    if(isset($_POST['action']) && $_POST['action'] == 'fetchAllFeedback') {
        $output = '';
        $data = $admin->fetchFeedback();

        if($data){
            $output .= '<table class="table table-sm table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th>#</th>                    
                        <th>UID</th>
                        <th>Name</th>
                        <th>Email</th>                    
                        <th>Subject</th>                    
                        <th>Feedback</th>                    
                        <th>Sent On</th>                    
                        <th>Action</th>                    
                    </tr>
                </thead>
                <tbody>';
            foreach($data as $row) {

                $output .= '<tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['uid'].'</td>
                    <td>'.$row['first_name'].' '.$row['last_name'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['subject'].'</td>
                    <td>'.$row['feedback'].'</td>
                    <td>'.$row['created_at'].'</td>
                    <td><a href="#" fid="'.$row['id'].'" id="'.$row['uid'].'" title="Reply" class="text-primary replyFeedbackIcon" data-toggle="modal" data-target="#showReplyModal"><i class="fas fa-reply"></i></a>                    
                    </td>
                </tr>';
            }

            $output .= '</tbody>
                </table>';
            echo $output;

        }else{
            echo '<h3 class="text-center text-secondary">No Data Found</h3>';
        }
    }

    //Reply feedback
    if(isset($_POST['message'])) {
        $uid = $_POST['uid'];
        $message = $admin->test_input($_POST['message']);
        $fid = $_POST['fid'];

        $admin->replyFeedback($uid,$message);
        $admin->feedbackReplied($fid);
    }

    //Fetch notification
    if(isset($_POST['action']) && $_POST['action'] == 'fetchNotification') {
        $notification = $admin->fetchNotification();
        $output = '';

        if($notification) {
            foreach($notification as $row) {
                $output .= '<div class="alert alert-dark" role="alert">
                    <button type="button" id="'.$row['id'].'" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="alert-heading lead">New Notification</h4>
                    <p class="mb-0 small">'.$row['message'].' by '.$row['first_name'].' '.$row['last_name'].'</p>
                    <hr class="my-2">
                    <p class="mb-0 float-left small"><b>Email: </b>'.$row['email'].'</p>
                    <p class="mb-0 float-right small">'.$admin->timeInAgo($row['created_at']).'</p>
                    <div class="clearfix"></div>
                </div>';
            }
            echo $output;
        }else{
            echo '<h3 class="text-center text-dark">No new notifications found</h3>';
        }
    }

    //Check notification
    if(isset($_POST['action']) && $_POST['action'] == 'checkNotification') {
        if($admin->fetchNotification()) {
            echo '<i class="fas fa-circle text-danger fa-sm"></i>';
        }else{
            echo '';
        }
    }

    //Remove notification
    if(isset($_POST['notification_id'])) {
        $id = $_POST['notification_id'];
        $admin->removeNotification($id);
    }

    //Handle export all uses in Excel
    if(isset($_GET['export']) && $_GET['export'] == 'excel') {
        header("Content-Type: application/xls");
        header("Content-Disposition: attachment; filename=users.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        $data = $admin->exportAllUsers();
        echo '<table border="1" align=center>';
        echo '<tr>
                <th>#</th>
                <th>Name</th>
                <th>E-Mail</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>DOB</th>
                <th>Joined ON</th>
                <th>Verified</th>
                <th>Deleted</th>
            </tr>';
        foreach ($data as $row) {
            echo '<tr>
                    <td>'.$row['id'].'</td>
                    <td>'.$row['first_name'].' '.$row['last_name'].'</td>
                    <td>'.$row['email'].'</td>
                    <td>'.$row['phone'].'</td>
                    <td>'.$row['gender'].'</td>
                    <td>'.$row['dob'].'</td>
                    <td>'.$row['created_at'].'</td>
                    <td>'.$row['verified'].'</td>
                    <td>'.$row['deleted'].'</td>
                  </tr>';  
        }
        echo '</table>';
    }

?>