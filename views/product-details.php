<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Product Details</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .product-details-page {
            max-width: 900px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0,0,0,.2);
            padding: 30px;
        }
        .product-details-page .product-image {
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 30px;
        }
        .product-details-page .product-image img {
            width: 100%;
            height: auto;
            transition: transform 0.3s ease;
        }
        .product-details-page .product-image:hover img {
            transform: scale(1.05);
        }
        .product-details-page .product-details h2 {
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .product-details-page .product-details .price {
            font-size: 24px;
            color: #28a745;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .product-details-page .product-details .description {
            font-size: 18px;
            color: #333;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        .product-details-page .product-details .specifications {
            font-size: 16px;
            color: #555;
        }
        .product-details-page .product-details .specifications h5 {
            margin-bottom: 10px;
            font-weight: 600;
        }
        .product-details-page .product-details .specifications ul {
            list-style-type: none;
            padding: 0;
        }
        .product-details-page .product-details .specifications ul li {
            background: #f1f1f1;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
        }
        .product-details-page .quantity-selector {
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .product-details-page .quantity-selector label {
            font-size: 18px;
            font-weight: 600;
        }
        .product-details-page .quantity-selector input {
            width: 80px;
            text-align: center;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 5px;
        }
        .product-details-page .product-actions {
            text-align: center;
            margin-top: 30px;
        }
        .product-details-page .product-actions .btn {
            font-size: 18px;
            border-radius: 30px;
            padding: 12px 25px;
            background: #007bff;
            color: #fff;
            border: none;
            transition: background 0.3s, transform 0.3s;
        }
        .product-details-page .product-actions .btn:hover {
            background: #0056b3;
            transform: scale(1.05);
        }
        .product-details-page .product-actions .btn-outline {
            background: #fff;
            border: 2px solid #007bff;
            color: #007bff;
        }
        .product-details-page .product-actions .btn-outline:hover {
            background: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>

    <?php include("../includes/header.php"); ?>

    <div class="product-details-page">
        <div class="product-image">
            <img src="https://via.placeholder.com/800x400" alt="Product Image">
        </div>
        <div class="product-details">
            <h2>Product Name</h2>
            <div class="price">$199.99</div>
            <div class="description">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque vehicula ex at risus pretium, ac venenatis massa tincidunt.</p>
            </div>
            <div class="specifications">
                <h5>Specifications:</h5>
                <ul>
                    <li>Specification 1</li>
                    <li>Specification 2</li>
                    <li>Specification 3</li>
                </ul>
            </div>
        </div>
        <div class="quantity-selector">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" max="100" value="1">
        </div>
        <div class="product-actions">
            <a href="product.php" class="btn btn-primary">Go Back</a>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
