<?php
    require_once 'session.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require './PHPMailer/src/Exception.php';
    require './PHPMailer/src/PHPMailer.php';
    require './PHPMailer/src/SMTP.php';

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    //Add Note
    if(isset($_POST['action']) && $_POST['action'] == 'add_note') {
        //print_r($_POST);
        $title = $cuser->test_input($_POST['title']);
        $note = $cuser->test_input($_POST['note']);

        $cuser->add_new_note($cid, $title, $note);
        $cuser->notification($cid, 'admin', 'Note added');
    }

    //SHow All Notes
    if(isset($_POST['action']) && $_POST['action'] == 'display_notes') {
        $output = '';

        $notes = $cuser->get_notes($cid);
        //print_r($notes);

        if($notes) {
            $output = '<table class="table table-sm table-striped text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Note</th>
                        <th>Action</th>
                    </tr>
                </thead>
            <tbody>';

            foreach($notes as $row) {
                $output .= '<tr>
                <td>'.$row['id'].'</td>
                <td>'.$row['title'].'</td>
                <td>'.substr($row['note'],0,75).'...</td>
                <td>
                    <a href="#" id="'.$row['id'].'" title="View Details" class="text-info infoBtn"><i class="far fa-file-alt"></i></a> 
                    <a href="#" id="'.$row['id'].'" title="Edit Details" class="text-info editBtn"><i class="far fa-edit" data-toggle="modal" data-target="#editNoteModal"></i></a>
                    <a href="#" id="'.$row['id'].'" title="Delete Details" class="text-info deleteBtn"><i class="far fa-trash-alt"></i></a>
                </td>
                </tr>';
            }

            $output .= '</tbody></table>';
            
            echo $output;

        }else{
            echo '<h3 class="text-center text-dark">No notes found</h3>';
        }

    }

    //Edit Note
    if(isset($_POST['edit_id'])) {
        $id = $_POST['edit_id'];

        $row = $cuser->edit_note($id);
        echo json_encode($row);
    }

    //Update Note
    if(isset($_POST['action']) && $_POST['action'] == 'update_note') {
        $id = $cuser->test_input($_POST['id']);
        $title = $cuser->test_input($_POST['title']);
        $note = $cuser->test_input($_POST['note']);

        $cuser->update_note($id,$title,$note);
        $cuser->notification($cid, 'admin', 'Note updated');
    }

    //Delete Note
    if(isset($_POST['del_id'])) {
        $id = $_POST['del_id'];

        $cuser->delete_note($id);
        $cuser->notification($cid, 'admin', 'Note deleted');
    }

    //View Note
    if(isset($_POST['info_id'])) {
        $id = $_POST['info_id'];

        $row = $cuser->edit_note($id);

        echo json_encode($row);
    }

    //Profile Update 
    if(isset($_FILES['image'])) {
        //print_r($_POST);
        $first_name = $cuser->test_input($_POST['fname']);
        $last_name = $cuser->test_input($_POST['lname']);
        $gender = $cuser->test_input($_POST['gender']);
        $dob = $cuser->test_input($_POST['dob']);
        $phone = $cuser->test_input($_POST['phone']);

        $oldImage = $_POST['oldimage'];
        $folder = 'uploads/';

        if(isset($_FILES['image']['name']) && ($_FILES['image']['name'] != "")) {
            $newImage = $folder.$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $newImage);

            if($oldImage != null) {
                unlink($oldImage);
            }
        }else{
            $newImage = $oldImage;
        }

        $cuser->update_profile($first_name,$last_name,$gender,$dob,$phone,$newImage,$cid);
        $cuser->notification($cid, 'admin', 'Profile updated');
    }

    //Change password
    if(isset($_POST['action']) && $_POST['action'] == 'change_pass') {
        $currentPass = $_POST['curpass'];
        $newPass = $_POST['newpass'];
        $cnewPass = $_POST['cnewpass'];

        $hnewPass = password_hash($newPass, PASSWORD_DEFAULT);

        if($newPass != $cnewPass) {
            echo $cuser->showMessage('danger','Password did not match');
        }else{
            if(password_verify($currentPass, $cpass)) {
                $cuser->change_password($hnewPass,$cid);
                echo $cuser->showMessage('success', 'Password Changed');
                $cuser->notification($cid, 'admin', 'Password Changed');
            }else{
                echo $cuser->showMessage('danger', 'Current password is wrong.');
            }
        }
    }

    //Verify email
    if(isset($_POST['action']) && $_POST['action'] == 'verify_email') {
        try{
            $mail->isSMTP();
            $mail->Host       = 'smtp.mailtrap.io';                 // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                               // Enable SMTP authentication
            $mail->Username   = Database::USERNAME;                 // SMTP username
            $mail->Password   = Database::PASSWORD;                 // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;

            $mail->setFrom($cemail, 'ROSE');
            $mail->addAddress($cemail);                              // Add a recipient

            $mail->isHTML(true);                                    // Set email format to HTML
            $mail->Subject = 'E-Mail Verification';
            $mail->Body    = '<h3>Click the below link to verify your E-Mail.<br><a href="http://localhost/rose/verify_email.php?email='.$cemail.'">http://localhost/rose/verify_email.php?email='.$cemail.'</a><hr />Regards<br>ROSE</h3>';

            $mail->send();
            echo $cuser->showMessage('success', 'The Verification link sent to your E-Mail, please check your e-mail.');

        }catch(Exception $e){
            echo $cuser->showMessage('danger', 'Something went wrong, please try again later!'); //$e->getMessage()
        }
    }

    //Send feedback
    if(isset($_POST['action']) && $_POST['action'] == 'feedback') {
        $subject = $cuser->test_input($_POST['subject']);
        $feedback = $cuser->test_input($_POST['feedback']);

        $cuser->send_feedback($subject,$feedback,$cid);
        $cuser->notification($cid, 'admin', 'Feedback Sent');
    }

    //Fetch notification
    if(isset($_POST['action']) && $_POST['action'] == 'fetchNotification') {
        $notification = $cuser->fetchNotification($cid);
        $output = '';

        if($notification) {
            foreach($notification as $row) {
                $output .= '<div class="alert alert-danger" role="alert">
                    <button type="button" id="'.$row['id'].'" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="alert-heading lead">New Notification</h4>
                    <p class="mb-0 small">'.$row['message'].'</p>
                    <hr class="my-2">
                    <p class="mb-0 float-left small">Reply of feedback from Admin</p>
                    <p class="mb-0 float-right small">'.$cuser->timeInAgo($row['created_at']).'</p>
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
        if($cuser->fetchNotification($cid)){
            echo '<i class="fas fa-info-circle fa-sm text-warning"></i>';
        }else{
            echo '';
        }
    }

    //Remove notification
    if(isset($_POST['notification_id'])) {
        $id = $_POST['notification_id'];
        $cuser->removeNotification($id);
    }
    
?>