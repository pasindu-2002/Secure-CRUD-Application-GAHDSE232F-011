<?php
// controllers/ProductController.php

require_once __DIR__ . '/../models/Product.php';

class ProductController
{
    public function index()
    {
        // Retrieve all products from the database
        $product = new Product();
        $products = $product->getAll();

        // Display the product list
        require_once __DIR__ . '/../views/product/index.php';
    }

    public function create()
    {
        // Display the form to create a new product
        require_once __DIR__ . '/../views/product/create.php';
    }

    public function store()
    {
        // Handle form submission to create a new product
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        $product = new Product();
        $product->create($name, $price, $description);

        // Redirect to the product list
        header('Location: ?action=product_index');
    }

    public function edit($id)
    {
        // Retrieve the product by its ID
        $product = new Product();
        $productDetails = $product->getById($id);

        // Display the edit form with existing product details
        require_once __DIR__ . '/../views/product/edit.php';
    }

    public function update($id)
    {
        // Handle form submission to update an existing product
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        $product = new Product();
        $product->update($id, $name, $price, $description);

        // Redirect to the product list
        header('Location: ?action=product_index');
    }

    public function delete($id)
    {
        // Handle product deletion
        $product = new Product();
        $product->delete($id);

        // Redirect to the product list
        header('Location: ?action=product_index');
    }

    public function show($id)
    {
        // Retrieve and display a single product's details
        $product = new Product();
        $productDetails = $product->getById($id);

        require_once __DIR__ . '/../views/product/show.php';
    }
}
?>