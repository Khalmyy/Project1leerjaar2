<?php
require_once 'db.php';

class User
{

    public function __construct()
    {
        $host = 'localhost';
        $dbname = 'I_care';
        $username = 'root';
        $password = '';

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function login($username, $password)
    {
        $query = "SELECT * FROM users WHERE username = :username AND password = :password";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);

        try {
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                // Login successful
                session_start();
                $_SESSION['username'] = $username;
                return true;
            } else {
                // Login failed
                return false;
            }
        } catch (PDOException $e) {
            die("Query failed: " . $e->getMessage());
        }
    }

    public function logout()
    {
        session_start();
        session_destroy();
    }
}

$user = new User();

if ($user->login("myusername", "mypassword")) {
    echo "Login successful!";
} else {
    echo "Login failed!";
}

$user->logout();
?>
