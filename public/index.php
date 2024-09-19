<?php

session_start(); // Start the session for user authentication

require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/AuthController.php';

// Initialize controllers
$userController = new UserController();
$authController = new AuthController();

// Get the requested action from the URL or form submission
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Handle actions
switch ($action) {
    case 'register':
        // Register a new user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = isset($_POST['role']) ? $_POST['role'] : "user";
            $tele = $_POST['tele'];

            $response = $userController->addUser($name, $email, $password, $role, $tele);

            if (isset($_POST['role']) && $response) {
                header('Location: http://localhost/Secure-CRUD/public?action=dashboard_users');
                exit;
            }

            if ($response) {
                $_SESSION["register-msg"] = true;
                header('Location: http://localhost/Secure-CRUD/');
                exit;
            } else {
                $_SESSION["register-msg"] = false;
                header('Location: http://localhost/Secure-CRUD/public?action=signup');
                exit;
            }
        }
        break;

    case 'login':
        // Authenticate a user
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $response = $authController->login($email, $password);
        }
        break;

    case 'signup':
        // Log out the user
        include __DIR__ . '/../views/register.php';
        break;

    case 'logout':
        // Log out the user
        $response = $authController->logout();
        echo json_encode($response);
        break;

    case 'getUser':
        // Retrieve a user by ID
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $response = $userController->getUser($id);
            echo json_encode($response);
        }
        break;

    case 'getAllUsers':
        // Retrieve all users
        $users = $userController->getAllUsers();
        echo json_encode($users);
        break;

    // PHP code for handling user update
    case 'updateUser':
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = isset($_POST['password']) && !empty($_POST['password']) ? $_POST['password'] : null;
            $role = $_POST['role'];
            $tele = $_POST['tele'];

            $response = $userController->updateUser($id, $name, $email, $password, $role, $tele);

            if ($response) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update user.']);
            }
        }
        break;



    // PHP code for deleting the user
    case 'deleteUser':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $response = $userController->deleteUser($id);
            if ($response) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        }
        break;

    case 'dashboard':
        // Check if session variable is set
        if (isset($_SESSION['user-role']) && isset($_SESSION['user_id'])) {
            $role = $_SESSION['user-role'];
            $id = $_SESSION['user_id'];

            if ($role == "user") {
                include __DIR__ . '/../views/product.php';
            } elseif ($role == 'admin') {
                include __DIR__ . '/../views/admin/product.php';
                // If you have another view for admin, include it here or handle it as needed
            } elseif ($role == 'editor') { // Assuming 'editor' is a valid role
                include __DIR__ . '/../views/editor/product.php';
            } else {
                // Handle cases where the role is not recognized
                include __DIR__ . '/../views/404.php'; // Example of a fallback page
            }
        } else {
            // Handle the case where the session variable is not set
            header("Location: /Secure-CRUD/");
        }
        break;

    case 'dashboard_users':
        // Delete a user
        if (isset($_SESSION['user_id'])) {
            include __DIR__ . '/../views/admin/users.php';
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Secure-CRUD/");
            exit; // Ensure script execution stops after redirection
        }
        
        break;

    case 'dashboard_product':
        // Delete a user
        if (isset($_SESSION['user_id'])) {
            include __DIR__ . '/../views/admin/product.php';
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /Secure-CRUD/");
            exit; // Ensure script execution stops after redirection
        }
        
        break;

    case 'updateStatus':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';
            $action = isset($_POST['action']) ? $_POST['action'] : '';

            $response = ['success' => false]; // Default response

            if ($userId && $action) {
                if ($action === 'lock') {
                    $success = $userController->lockUser($userId);
                } elseif ($action === 'activate') {
                    $success = $userController->activateUser($userId);
                }

                $response['success'] = $success;
            }

            // Return JSON response
            header('Content-Type: application/json');
            echo json_encode($response);
        }
        break;


    default:
        // Display login page
        include __DIR__ . '/../views/login.php';
        break;
}
?>