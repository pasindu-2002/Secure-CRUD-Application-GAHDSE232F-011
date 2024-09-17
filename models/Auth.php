<?php

class Auth {
    private $table_name = 'users'; // Define the table name here
    private $conn;
    private $max_attempts = 3; // Maximum number of login attempts
    private $lockout_duration = 15 * 60; // Lockout duration in seconds (e.g., 15 minutes)
    private $pepper = "e4f9c9a6a4f2e9d8c5e0b5d9a6d9c4b0f8e1d6f3b2a0e3f4e"; // Your secret pepper

    public function __construct($pdo) {
        $this->conn = $pdo;
    }

    public function authenticate($email, $password) {
        try {
            $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $salt = $user['salt'];
                $stored_hash = $user['password'];
                $pepper = "e4f9c9a6a4f2e9d8c5e0b5d9a6d9c4b0f8e1d6f3b2a0e3f4e";
        
                // Hash the provided password with the stored salt and pepper
                $salted_password = $password . $salt;
                $peppered_password = $salted_password . $pepper;
                $hashed_password = hash('sha256', $peppered_password);
        
                // Compare with the stored hash
                if ($hashed_password === $stored_hash) {
                    $this->resetFailedAttempts($user['id']);
                    return $user;
                }
                else{
                    $this->incrementFailedAttempts($user['id']); // Increment failed attempts
                }
            }

        } catch (PDOException $e) {
            // Handle database connection or query execution errors
            error_log("Database error: " . $e->getMessage());
        }
    }

    private function isAccountLocked($user) {
        if ($user['failed_attempts'] >= $this->max_attempts) {
            $last_attempt_time = strtotime($user['last_attempt']);
            $current_time = time();
            return ($current_time - $last_attempt_time) < $this->lockout_duration;
        }
        return false;
    }

    private function incrementFailedAttempts($user_id) {
        $query = "UPDATE " . $this->table_name . " SET failed_attempts = failed_attempts + 1, last_attempt = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
    }

    private function resetFailedAttempts($user_id) {
        $query = "UPDATE " . $this->table_name . " SET failed_attempts = 0, last_attempt = NULL WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $user_id);
        $stmt->execute();
    }

    public function getUserByEmail($email) {
        // Fetch the user by email from the database
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
    }
}

?>
