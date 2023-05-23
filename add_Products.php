<?php
// database configuration
$servername = "localhost";
$username = "root";
$dbname = "I_care";

// connect to the database
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// handle form submission
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // get form data
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    $featured =$_POST['featured'];

    // move uploaded image to the uploads folder
    move_uploaded_file($tmp_name, $target_file);

    // insert product into database
    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, featured) VALUES (:name, :description, :price, :image, :featured)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':image', $image);
    $stmt->bindParam('featured', $featured);
    $stmt->execute();

    // redirect to homepage
    header("Location: home.php");
    exit;
}
?>

<!-- HTML form to add product with image upload -->
<form method="POST" enctype="multipart/form-data">
    <label for="name">Product Name:</label>
    <input type="text" id="name" name="name" required>

    <label for="description">Product Description:</label>
    <textarea id="description" name="description" required></textarea>

    <label for="price">Product Price:</label>
    <input type="number" id="price" name="price" step="0.01" required>

    <label for="image">Product Image:</label>
    <input type="file" id="image" name="image" accept="image/*" required>

    <label for="featured">featured:</label>
    <input type="featured" id="featured" name="featured"  required>

    <input type="submit" value="Add Product">
</form>