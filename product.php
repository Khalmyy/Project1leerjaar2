<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <?php
    require_once 'Product.php';
    require_once 'ProductRepo.php';

    // Create a PDO connection to the MySQL database (same as in home.php)
    $host = 'localhost';
    $dbname = 'i_care';
    $username = 'root';

    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    try {
        $pdo = new PDO($dsn, $username, '', $options);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    // Create an instance of the ProductRepository
    $productRepository = new ProductRepository($pdo);

    // Retrieve the selected product ID from the query parameter
    $productId = isset($_GET['id']) ? $_GET['id'] : null;

    // Fetch the selected product from the repository
    $product = $productId ? $productRepository->getProductById($productId) : null;

    if ($product) {
        echo "<div class='product-details'>";
        echo "<div>";
        echo "<img src='images/" . $product['image'] . "' alt='" . $product['name'] . "'>";
        echo "</div>";
        echo "<div>";
        echo "<h2>" . $product['name'] . "</h2>";
        echo "<p>" . $product['description'] . "</p>";
        echo "<p>Price: $" . $product['price'] . "</p>";
        echo "<a href='home.php' class='back-link'>Back to Products</a>";
        echo "</div>";
        echo "</div>";
    } else {
        echo "<p>Product not found.</p>";
    }
    ?>
</div>
</body>
</html>
``