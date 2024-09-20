<?php

require_once __DIR__ . "/../config/database.php";

class User {

    private $conn;
    private $table_name = "users";

    // Database connection
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Add a new user
    public function addUser($name, $email, $password, $role, $tele) {
        // Validate and sanitize inputs
        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $role = filter_var($role, FILTER_SANITIZE_STRING);
        $tele = filter_var($tele, FILTER_SANITIZE_STRING);
    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email format.");
        }
    
        // Generate a unique salt
        $salt = bin2hex(random_bytes(16)); // 16 bytes = 32 characters
    
        //pepper value
        $pepper = "e4f9c9a6a4f2e9d8c5e0b5d9a6d9c4b0f8e1d6f3b2a0e3f4e";
    
        // Combine salt, pepper, and password, then hash with SHA256
        $salted_password = $password . $salt;
        $peppered_password = $salted_password . $pepper;
        $hashed_password = hash('sha256', $peppered_password);
    
        // Prepare and execute SQL statement
        $sql = "INSERT INTO " . $this->table_name . " (name, email, password, role, tele, salt) VALUES (:name, :email, :password, :role, :tele, :salt)";
        $stmt = $this->conn->prepare($sql);
    
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":role", $role);
        $stmt->bindParam(":tele", $tele);
        $stmt->bindParam(":salt", $salt); // Store the salt
    
        return $stmt->execute();
    }
    

    // Retrieve all users
    public function getAll() {
        $sql = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve a user by ID
    public function getUser($id) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user
    public function updateUser($id, $name, $email, $password, $role, $tele) {
        if ($password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE " . $this->table_name . " SET name = :name, email = :email, password = :password, role = :role, tele = :tele WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':password', $hashed_password);
        } else {
            $sql = "UPDATE " . $this->table_name . " SET name = :name, email = :email, role = :role, tele = :tele WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
        }

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':tele', $tele);

        return $stmt->execute();
    }


    public function updateStatusActive($id) {
        $query = "UPDATE " . $this->table_name . " SET failed_attempts = 0, last_attempt = NULL WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function updateStatusLocked($id) {
        $query = "UPDATE " . $this->table_name . " SET failed_attempts = 4 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


    // Delete a user
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function findUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Fetch the user data
        return $stmt->fetch(PDO::FETCH_ASSOC); // Returns user data or false if not found
    }

    public function savePasswordResetToken($email, $token, $expires) {
        $stmt = $this->conn->prepare("UPDATE users SET reset_token = :token, token_expires = :expires WHERE email = :email");
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':expires', $expires);
        $stmt->bindParam(':email', $email);
        return $stmt->execute(); // Returns true on success
    }

    // Save the password reset token

    // Find user by reset token
    public function findUserByResetToken($token) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE reset_token = :token");
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  // Return user data or false if not found
    }

    // Update the user's password
    public function updatePassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);  // Hash the password
        $stmt = $this->conn->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();  // Return true if successful
    }

    // Clear the reset token after password reset
    public function clearResetToken($userId) {
        $stmt = $this->conn->prepare("UPDATE users SET reset_token = NULL WHERE id = :id");
        $stmt->bindParam(':id', $userId);
        return $stmt->execute();  // Return true if successful
    }
}

?>
