<?php

    require_once 'config.php';

    class Admin extends Database {

        //Admin login
        public function admin_login($username, $password) {
            $sql = "SELECT username, password FROM admin WHERE username = :username AND password = :password";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['username'=>$username, 'password'=>$password]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row;
        }

        //Count total num of row
        public function totalcount($tablename) {
            $sql = "SELECT * FROM $tablename";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $count = $stmt->rowCount();

            return $count;
        }

        //Count total verified/unverified users
        public function verified_users($status) {
            $sql = "SELECT * FROM users WHERE verified = :status";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['status'=>$status]);
            $count = $stmt->rowCount();

            return $count;
        }

        //Gender percentage
        public function genderPer() {
            $sql = "SELECT gender, COUNT(*) AS number FROM users WHERE gender != '' GROUP BY gender";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $result;
        }

        //User verified/unverified percentage
        public function verifiedPer() {

            $sql = "SELECT verified, COUNT(*) AS number FROM users GROUP BY verified";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        //Count web hits
        public function site_hits() {
            $sql = "SELECT hits FROM visitors";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $count = $stmt->fetch(PDO::FETCH_ASSOC);

            return $count;
        }

        //Fetch all registered users
        public function fetchAllUsers($val) {
            $sql = "SELECT * FROM users WHERE deleted != $val";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        //Fetch user details by id
        public function fetchUserDetailsByID($id) {
            $sql = "SELECT * FROM users WHERE id = :id AND deleted != 0";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        }

        //Delete the user
        public function userAction($id, $val) {
            $sql = "UPDATE users SET deleted = $val WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            return true;
        }

        //Fetch all notes and user info
        public function fetchAllNotes() {
            $sql = "SELECT notes.id, notes.title, notes.note, notes.created_at, notes.updated_at, users.first_name, last_name, users.email FROM notes INNER JOIN users ON notes.uid = users.id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;            
        }

        //Delete the note
        public function deleteNoteOfUser($id) {
            $sql = "DELETE FROM notes WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            return true;
        }

        //Fetch all feedback
        public function fetchFeedback() {
            $sql = "SELECT feedback.id, feedback.subject, feedback.feedback, feedback.created_at, feedback.uid, users.first_name, users.last_name, users.email FROM feedback INNER JOIN users ON feedback.uid = users.id WHERE replied != 1 ORDER BY feedback.id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        //Reply to user
        public function replyFeedback($uid, $message) {
            $sql = "INSERT INTO notification (uid, type, message) VALUES (:uid, 'user', :message)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['uid'=>$uid, 'message'=>$message]);

            return true;
        }

        //Set feedback replied
        public function feedbackReplied($fid) {
            $sql = "UPDATE feedback SET replied = 1 WHERE id = :fid";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['fid'=>$fid]);

            return true;
        }

        //Fetch notification
        public function fetchNotification() {
            $sql = "SELECT notification.id, notification.message, notification.created_at, users.first_name, users.last_name, users.email FROM notification INNER JOIN users ON notification.uid = users.id WHERE type = 'admin' ORDER BY notification.id DESC LIMIT 5";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

        //Remove notification
        public function removeNotification($id) {
            $sql = "DELETE FROM notification WHERE id = :id AND type = 'admin'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id'=>$id]);

            return true;            
        }

        //Fetch all users from DB
        public function exportAllUsers() {
            $sql = "SELECT * FROM users";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }

    }

?>