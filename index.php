<?php


require_once 'db.php';

// Create a PDO connection to the MySQL database
$host = 'localhost';
$dbname = 'I_care';
$username = 'root';


$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $options);
} catch (PDOException $e) {
    throw new PDOException($e->getMessage(), (int)$e->getCode());
}

// Fetch products from the database
$stmt = $pdo->query('SELECT id, name, description, price FROM products');
$products = [];
while ($row = $stmt->fetch()) {
    $products[] = new Product($row['id'], $row['name'], $row['price']);
}

// Render each product as a link to its product page
foreach ($products as $product) {
    $productPage = new ProductPage($product);
    echo "<a href='product.php?productId=" . $product->getId() . "'>";
    echo $productPage->render();
    echo "</a>";
}

