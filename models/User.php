<?php

    require_once __DIR__ ."../config/database.php";

    class User{

        private $conn;
        private $table_name = "user";

        // Database connection
        public function __construct() {
            $database = new Database();
            $this->conn = $database->getConnection();
        }


        // Add a new user
        public function addUser($name, $email, $password, $role, $tele){
            $sql = "INSERT INTO " . $this->table_name ." (name, email, password, role, tele) VALUES (:name, :email, :password, :role, :tele)";
            $result = $this->conn->prepare($sql);
            
            //Hash Password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $result->bindParam(":name",$name);
            $result->bindParam(":email",$email);
            $result->bindParam(":password",$hashed_password);
            $result->bindParam(":role",$role);
            $result->bindParam(":tele",$tele);

            return $result->execute();
        }


        // Retrieve all users
        public function getAll(){
            $sql = "SELECT * FROM " . $this->table_name;
            $result = $this->conn->query($sql);
            $result->execute();
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }


        // Retrieve a user by ID
        public function getUser($id){
            $sql = "SELECT * FROM ". $this->table_name ." WHERE id = :id";
            $result = $this->conn->query($sql);
            $result->bindParam(':id',$id);
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }

        // Update user
        public function updateUser($id, $name, $email, $password = null, $role, $tele){   

            if($password){
                $sql = 'UPDATE '. $this->table_name .' SET name = :name, email = :email, password = :password, role = :role, tele = :tele WHERE id = :id';

            }
            
        }


    }



?>