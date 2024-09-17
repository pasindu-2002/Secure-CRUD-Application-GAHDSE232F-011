<?php

require_once __DIR__ . "/../config/database.php";

class Product {

    private $conn;
    private $table_name = "products";

    // Database connection
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Add a new product
    public function addProduct($name, $description, $price, $category_id, $image_path = null) {
        $sql = "INSERT INTO " . $this->table_name . " (name, description, price, category_id, image_path) VALUES (:name, :description, :price, :category_id, :image_path)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":description", $description);
        $stmt->bindParam(":price", $price);
        $stmt->bindParam(":category_id", $category_id);
        $stmt->bindParam(":image_path", $image_path);

        return $stmt->execute();
    }

    // Retrieve all products
    public function getAll() {
        $sql = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve a product by ID
    public function getProduct($id) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update a product
    public function updateProduct($id, $name, $description, $price, $category_id, $image_path = null) {
        if ($image_path) {
            $sql = "UPDATE " . $this->table_name . " SET name = :name, description = :description, price = :price, category_id = :category_id, image_path = :image_path WHERE id = :id";
        } else {
            $sql = "UPDATE " . $this->table_name . " SET name = :name, description = :description, price = :price, category_id = :category_id WHERE id = :id";
        }

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);

        if ($image_path) {
            $stmt->bindParam(':image_path', $image_path);
        }

        return $stmt->execute();
    }

    // Delete a product
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
