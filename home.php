<!DOCTYPE html>
<html>
<head>
    <title>Webshop</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="container">
    <h1>Welcome to our Webshop</h1>
    <div class="product-list">
        <?php
        require_once 'Product.php';
        require_once 'ProductRepo.php';

        // Create a PDO connection to the MySQL database
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

        // Fetch products from the repository
        $products = $productRepository->getAllProducts();

        foreach ($products as $product) {
            echo "<div class='product-item'>";
            echo "<a href='product.php?id=" . $product['id'] . "'>";
            echo "<img src='images/" . $product['image'] . "' alt='" . $product['name'] . "'>";
            echo "<h2>" . $product['name'] . "</h2>";
            echo "<p>Price: $" . $product['price'] . "</p>";
            echo "</a>";
            echo "</div>";
        }
        ?>
    </div>
</div>
</body>
</html>