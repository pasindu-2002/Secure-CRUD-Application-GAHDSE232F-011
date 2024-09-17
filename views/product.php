<?php 

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /Secure-CRUD/");
    exit; // Ensure script execution stops after redirection
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Product View</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
        }

        .product-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 15px;
        }

        .product-container::after {
            content: "";
            display: table;
            clear: both;
        }

        .product-view {
            width: 500px;
            margin: 30px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, .2);
            padding: 20px;
            transition: box-shadow 0.3s, transform 0.3s;
            float: left;
            flex: 1 1 calc(33.33% - 60px);
        }

        .product-view:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, .3);
        }

        .product-image {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .product-image img {
            width: 100%;
            height: auto;
            transition: transform 0.3s;
        }

        .product-image:hover img {
            transform: scale(1.05);
        }

        .product-details h2 {
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .product-details .price {
            font-size: 20px;
            color: #28a745;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .product-details .description {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .product-details .specifications {
            font-size: 14px;
            color: #777;
        }

        .product-actions {
            text-align: center;
        }

        .product-actions .btn {
            font-size: 16px;
            border-radius: 30px;
            padding: 12px 25px;
            background: #28a745;
            color: #fff;
            border: none;
            transition: background 0.3s, transform 0.3s;
        }

        .product-actions .btn:hover {
            background: #218838;
            transform: scale(1.05);
        }

        .product-actions .btn-outline {
            background: #fff;
            border: 2px solid #28a745;
            color: #28a745;
        }

        .product-actions .btn-outline:hover {
            background: #28a745;
            color: #fff;
        }
    </style>
</head>

<body>
    <?php include("../includes/header.php"); ?>

    <div class="product-container">
        <div class="product-view">
            <div class="product-image">
                <img src="https://via.placeholder.com/500x300" alt="Product Image">
            </div>
            <div class="product-details">
                <h2>Product 1</h2>
                <div class="price">$199.99</div>

            </div>
            <div class="product-actions">
                <a href="product-details.php" class="btn btn-primary">More Details</a>
            </div>
        </div>

        <!-- Repeat the above block for each product -->
        <div class="product-view">
            <div class="product-image">
                <img src="https://via.placeholder.com/500x300" alt="Product Image">
            </div>
            <div class="product-details">
                <h2>Product 2</h2>
                <div class="price">$299.99</div>

            </div>
            <div class="product-actions">
                <a href="product-details.php" class="btn btn-primary">More Details</a>
            </div>
        </div>
        <div class="product-view">
            <div class="product-image">
                <img src="https://via.placeholder.com/500x300" alt="Product Image">
            </div>
            <div class="product-details">
                <h2>Product 3</h2>
                <div class="price">$399.99</div>

            </div>
            <div class="product-actions">
                <a href="product-details.php" class="btn btn-primary">More Details</a>
            </div>
        </div>
        <div class="product-view">
            <div class="product-image">
                <img src="https://via.placeholder.com/500x300" alt="Product Image">
            </div>
            <div class="product-details">
                <h2>Product 4</h2>
                <div class="price">$499.99</div>

            </div>
            <div class="product-actions">
                <a href="product-details.php" class="btn btn-primary">More Details</a>
            </div>
        </div>
        <div class="product-view">
            <div class="product-image">
                <img src="https://via.placeholder.com/500x300" alt="Product Image">
            </div>
            <div class="product-details">
                <h2>Product 5</h2>
                <div class="price">$599.99</div>

            </div>
            <div class="product-actions">
                <a href="product-details.php" class="btn btn-primary">More Details</a>
            </div>
        </div>
        <div class="product-view">
            <div class="product-image">
                <img src="https://via.placeholder.com/500x300" alt="Product Image">
            </div>
            <div class="product-details">
                <h2>Product 6</h2>
                <div class="price">$699.99</div>

            </div>
            <div class="product-actions">
                <a href="product-details.php" class="btn btn-primary">More Details</a>
            </div>
        </div>


    </div>

    <?php include("../includes/footer.php"); ?>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>



</body>

</html>