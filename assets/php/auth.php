<?php

    require_once 'config.php';

    class Auth extends Database {

        public function register($first_name, $last_name, $email, $password) {

            $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (:first_name, :last_name, :email, :pass)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['first_name'=>$first_name, 'last_name'=>$last_name, 'email'=>$email, 'pass'=>$password]);

            return true;
        }

        public function user_exist($email) {
            
            $sql = "SELECT email FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email'=>$email]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        }

        public function login($email) {
            $sql = "SELECT email, password FROM users WHERE email = :email AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email'=>$email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        public function currentUser($email) {
            $sql = "SELECT * FROM users WHERE email = :email AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email'=>$email]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        public function forgot_password($token,$email) {
            $sql = "UPDATE users SET token = :token, token_expire = DATE_ADD(NOW(), INTERVAL 10 MINUTE) WHERE email = :email";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['token'=>$token, 'email'=>$email]);

            return true;
        }

        public function reset_pass_auth($email, $token) {
            $sql = "SELECT id FROM users WHERE email = :email AND token =:token AND token != '' AND token_expire > NOW() AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email'=>$email, 'token'=>$token]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        public function update_new_pass($pass, $email) {
            $sql = "UPDATE users SET token = '', password = :pass WHERE email = :email AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['pass'=>$pass, 'email'=>$email]);

            return true;
        }

        public function add_new_note($uid, $title, $note) {
            $sql = "INSERT INTO notes (uid, title, note) VALUES (:uid, :title, :note)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['uid'=>$uid, 'title'=>$title, 'note'=>$note]);

            return true;
        }

        public function get_notes($uid) {
            $sql = "SELECT * FROM notes WHERE uid = :uid";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['uid'=>$uid]);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        public function edit_note($id) {
            $sql = "SELECT * FROM notes WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        }

        public function update_note($id, $title, $note) {
            $sql = "UPDATE notes SET title = :title, note = :note, updated_at = NOW() WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['title'=>$title, 'note'=>$note, 'id'=>$id]);

            return true;
        }

        public function delete_note($id) {
            $sql = "DELETE FROM notes WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            return true;
        }

        public function update_profile($first_name,$last_name,$gender,$dob,$phone,$photo,$id) {
            $sql = "UPDATE users SET first_name = :first_name, last_name = :last_name, gender = :gender, dob = :dob, phone = :phone, photo = :photo WHERE id = :id AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['first_name'=>$first_name, 'last_name'=>$last_name, 'gender'=>$gender, 'dob'=>$dob, 'phone'=>$phone, 'photo'=>$photo, 'id'=>$id]);

            return true;
        }

        public function change_password($pass,$id) {
            $sql = "UPDATE users SET password = :pass WHERE id = :id AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['pass'=>$pass, 'id'=>$id]);

            return true;
        }

        public function verify_email($email) {
            $sql = "UPDATE users SET verified = 1 WHERE email = :email AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email'=>$email]);

            return true;
        }

        public function send_feedback($sub, $feed, $uid) {
            $sql = "INSERT INTO feedback (uid, subject, feedback) VALUES (:uid, :sub, :feed)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['uid'=>$uid, 'sub'=>$sub, 'feed'=>$feed]);

            return true;
        }

        public function notification($uid, $type, $message) {
            $sql = "INSERT INTO notification (uid, type, message) VALUES (:uid, :type, :message)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['uid'=>$uid, 'type'=>$type, 'message'=>$message]);

            return true;
        }

        public function fetchNotification($uid) {
            $sql = "SELECT * FROM notification WHERE uid = :uid AND type = 'user'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['uid'=>$uid]);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function removeNotification($id) {
            $sql = "DELETE FROM notification WHERE id = :id AND type = 'user'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);
            return true;
        }
    }

?>