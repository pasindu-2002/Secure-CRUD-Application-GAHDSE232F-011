<?php

session_start(); // Start the session for user authentication

require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Ramsey\Uuid\Uuid;

// Load Composer's autoloader
// Move up one directory to access vendor




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

    case 'forgot_password':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = isset($_POST['email']) ? $_POST['email'] : '';

            if ($email) {
                $userController = new UserController();
                $user = $userController->findUserByEmail($email);

                if ($user) {
                    // Send the password reset email
                    $token = Uuid::uuid4()->toString();  // Generate a unique token
                    $userController->savePasswordResetToken($user['id'], $token);

                    $resetLink = "http://localhost/Secure-CRUD/public/index.php?action=reset_password&token=" . $token;

                    // Send email using PHPMailer (use the email code provided earlier)
                    $mail = new PHPMailer(true);
                    try {
                        // SMTP settings for Gmail
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';   // Use Gmail SMTP server
                        $mail->SMTPAuth = true;
                        $mail->Username = 'ahperanga@gmail.com';    // Your Gmail email address
                        $mail->Password = 'rbpm psmp jaym jyfw'; // Use App-Specific Password if 2FA is enabled
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
                        $mail->Port = 587; // TLS port for Gmail

                        $mail->setFrom('ahperanga@gmail.com', 'Secure CRUD App');
                        $mail->addAddress($email);

                        $mail->isHTML(true);
                        $mail->Subject = 'Password Reset Request';
                        $mail->Body = "Click this link to reset your password: <a href='$resetLink'>$resetLink</a>";

                        $mail->send();
                        echo 'Password reset link has been sent to your email.';
                    } catch (Exception $e) {
                        echo "Mailer Error: {$mail->ErrorInfo}";
                    }
                } else {
                    echo 'Email not found.';
                }
            }
        }
        break;

    case 'reset_password':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Get the token from the URL
            $token = isset($_GET['token']) ? $_GET['token'] : '';

            if ($token) {
                // Create a controller instance (assuming you have a UserController)
                $userController = new UserController();

                // Verify if the token exists and is valid (method to be implemented in the controller)
                $user = $userController->findUserByResetToken($token);

                if ($user) {
                    // If the token is valid, display the reset password form
                    include 'views/reset_password.php'; // A form to reset password
                } else {
                    // If the token is invalid, display an error
                    echo 'Invalid or expired token.';
                }
            } else {
                echo 'No token provided.';
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Process the reset password form submission
            $token = isset($_POST['token']) ? $_POST['token'] : '';
            $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
            $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

            if ($token && $newPassword && $confirmPassword) {
                // Check if new password and confirm password match
                if ($newPassword === $confirmPassword) {
                    $userController = new UserController();
                    $user = $userController->findUserByResetToken($token);

                    if ($user) {
                        // Update the user's password
                        $userController->updatePassword($user['id'], $newPassword);

                        // Clear the reset token after successful reset
                        $userController->clearResetToken($user['id']);

                        echo 'Password has been successfully reset. You can now login.';
                    } else {
                        echo 'Invalid token.';
                    }
                } else {
                    echo 'Passwords do not match.';
                }
            } else {
                echo 'All fields are required.';
            }
        }
        break;




    default:
        // Display login page
        include __DIR__ . '/../views/login.php';
        break;
}
?>