<?php

    require_once __DIR__ . '/../models/User.php';

    class UserController {

        private $userModel;

        public function __construct() {
            $this->userModel = new User();
        }

        // Add a new user
        public function addUser($name, $email, $password, $role, $tele) {
            if ($this->userModel->addUser($name, $email, $password, $role, $tele)) {
               
                return true;
            } else {
               
                return false;
            }
        }

        // Retrieve all users
        public function getAllUsers() {
            $users = $this->userModel->getAll();
            return $users;
        }

        // Retrieve a user by ID
        public function getUser($id) {
            $user = $this->userModel->getUser($id);
            if ($user) {
                return ['status' => 'success', 'user' => $user];
            } else {
                return ['status' => 'error', 'message' => 'User not found'];
            }
        }

        // Update a user
        public function updateUser($id, $name, $email, $password, $role, $tele) {
            $result = $this->userModel->updateUser($id, $name, $email, $password, $role, $tele);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        // Delete a user
        public function deleteUser($id) {
            if ($this->userModel->delete($id)) {
                return true;
            } else {
                return false;
            }
        }

        public function lockUser($id) {
            $result = $this->userModel->updateStatusLocked($id);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }

        public function activateUser($id) {
            $result = $this->userModel->updateStatusActive($id);
            if ($result) {
                return true;
            } else {
                return false;
            }
        }
    }
?>
