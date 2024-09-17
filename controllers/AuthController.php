<?php
require_once __DIR__ . '/../config/Database.php'; // Include the Database class
require_once __DIR__ . '/../models/Auth.php'; // Include the Auth class


class AuthController {

   
    private $auth;

    public function __construct() {
        // Create an instance of the Database class
        $database = new Database();
        // Get the PDO connection
        $pdo = $database->getConnection();
        // Pass the PDO connection to the Auth class
        $this->auth = new Auth($pdo);
    }

    // Login method
    public function login($email, $password) {
        // Fetch the user by email
        $user = $this->auth->getUserByEmail($email);
    
        if ($user) {
            // Check if the account is locked
            if ($user['failed_attempts'] >= 3) {
                $_SESSION['login_locked'] = true;
                $_SESSION['login_error'] = "Account locked after 3 failed login attempts.";
                header("Location: /Secure-CRUD/");
                exit;
            }
    
            // Authenticate the user by email and password
            $authenticatedUser = $this->auth->authenticate($email, $password);
    
            if ($authenticatedUser) {
    
                // Start session and store user data
                session_regenerate_id(true);
                $_SESSION['user_id'] = $authenticatedUser['id'];
                $_SESSION['login_locked'] = false; // Unlock on successful login
                $_SESSION['user-failed-attempts'] = 0; 
                $_SESSION['user-role'] = $authenticatedUser['role'];
    
                // Redirect to dashboard
                header("Location: /Secure-CRUD/public/?action=dashboard");
                exit;
            } else {
    
                // Lock after 3 attempts
                if ($user['failed_attempts'] >= 3) { // Account locks on the 3rd failed attempt
                    $_SESSION['login_locked'] = true;
                    $_SESSION['login_error'] = "Account locked after 3 failed login attempts.";
                } else {
                    $_SESSION['login_error'] = "Invalid email or password.";
                }
                
                header("Location: /Secure-CRUD/");
                exit;
            }
        } else {
            // Invalid credentials
            $_SESSION['login_error'] = "Invalid email or password.";
            header("Location: /Secure-CRUD/");
            exit;
        }
    }
    
    
    // Logout method
    public function logout() {
        // Clear session data and destroy session
        session_start();
        session_unset();
        session_destroy();

        // Redirect to login page
        header("Location: http://localhost/Secure-CRUD/");
        exit;
    }

    // Check if the user is logged in
    public function checkAuth() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            // Redirect to login page if not authenticated
            header("Location: /Secure-CRUD/public/index.php?action=login");
            exit;
        }
    }
}

// Example usage
// $controller = new AuthController();
// $controller->login('admin@example.com', 'password');

?>
