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

        public function findUserByEmail($email) {
            $user = $this->userModel->findUserByEmail($email);
            
            if ($user) {
                return $user; // User found
            } else {
                return false; // User not found
            }
        }

        public function savePasswordResetToken($email, $token) {
            $user = $this->userModel->findUserByEmail($email);
            if ($user) {
        
                $expires = date('Y-m-d H:i:s', strtotime('+1 hour')); // Set expiration to 1 hour from now
    
                if ($this->userModel->savePasswordResetToken($email, $token, $expires)) {
                    // Send email with the reset link
                    $resetLink = "http://localhost/Secure-CRUD/public/index.php?action=resetPassword&token=" . $token;
                    $this->savePasswordResetToken($email, $resetLink);
                    return $user; // Success
                }
            }
            return false; // User not found or failed to save token
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

        public function findUserByResetToken($token) {
            return $this->userModel->findUserByResetToken($token);
        }
    
        // Update user's password
        public function updatePassword($userId, $newPassword) {
            return $this->userModel->updatePassword($userId, $newPassword);
        }
    
        // Clear reset token after successful password reset
        public function clearResetToken($userId) {
            return $this->userModel->clearResetToken($userId);
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
