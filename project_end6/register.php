<?php
require_once('db_connect.php');

$result = ["status" => 0];

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = trim($_POST['password']);
$firstname = trim($_POST['firstname']);
$lastname = trim($_POST['lastname']);

if (empty($username) || empty($email) || empty($password) || empty($firstname) || empty($lastname)) {
    $result["error"] = "Please fill out all fields";
} else {
    try {
        // Check if email already exists
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $email_count = $stmt->fetchColumn();

        // Check if username already exists
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $username_count = $stmt->fetchColumn();

        if ($email_count > 0) {
            $result["error"] = "Email already exists";
        } elseif ($username_count > 0) {
            $result["error"] = "Username already exists";
        } else {
            $sql = "INSERT INTO users (username, email, password, first_name, last_name) VALUES (:username, :email, :password, :firstname, :lastname)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
            $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
            $stmt->execute();

            $result["status"] = 1;
        }
    } catch (PDOException $e) {
        $result["error"] = "Error: " . $e->getMessage();
    }
}

$json = json_encode($result);
header('Content-Type: application/json');
echo $json;
?>
