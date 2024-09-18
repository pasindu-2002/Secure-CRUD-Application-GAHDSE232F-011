<?php
// Check if a session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Start session if none is active
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: #f5f5f5;
            font-family: 'Varela Round', sans-serif;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, .2);
        }

        .login-form h2 {
            margin-bottom: 20px;
            font-size: 28px;
            text-align: center;
        }

        .login-form .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .login-form .form-control {
            border-radius: 25px;
            box-shadow: none;
            padding-left: 40px;
        }

        .login-form .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .login-form .form-control-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #007bff;
        }

        .login-form .form-control-show-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #007bff;
        }

        .login-form .btn {
            font-size: 16px;
            border-radius: 25px;
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border: none;
            transition: background 0.3s;
        }

        .login-form .btn:hover {
            background: #0056b3;
        }

        .login-form .text-center {
            margin-top: 20px;
        }

        .login-form .text-center a {
            color: #007bff;
        }

        .login-form .text-center a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
            
        }
    </style>
</head>

<body>
    <div class="login-form">

    <?php 
        if (isset($_SESSION["register-msg"])) {
            if ($_SESSION["register-msg"] === true) {
                echo '<script>alert("User Registered Successfully!");</script>';
            } else {
                echo '<script>alert("User Registration Failed!");</script>';
            }
            unset($_SESSION["register-msg"]);
        }
    ?>


        <h2>Login</h2>

        <form action="http://localhost/Secure-CRUD/public/index.php?action=login" method="POST">

            <div class="form-group position-relative">
                <i class="fas fa-user form-control-icon"></i>
                <input type="text" class="form-control" name="email" id="username" placeholder="Username" 
                    required 
                    <?php if (isset($_SESSION['login_locked']) && $_SESSION['login_locked']) echo 'disabled';?>>
            </div>

            <div class="form-group position-relative">
                <i class="fas fa-lock form-control-icon"></i>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" 
                    required 
                    <?php if (isset($_SESSION['login_locked']) && $_SESSION['login_locked']) echo 'disabled'; unset($_SESSION['login_locked']);?>>
                <i class="fas fa-eye form-control-show-password" id="togglePassword"></i>
            </div>

            <!-- Error message display -->
            <div class="error-message" id="error-message">
                <?php if (isset($_SESSION['login_error'])) {
                    echo $_SESSION['login_error'];
                    // Clear the error message after displaying it
                    unset($_SESSION['login_error']);
                }
                ?>
            </div>


            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <div class="text-center">
                Don't have an account?
                <a href="/Secure-CRUD/public?action=signup"> Sign Up</a>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>