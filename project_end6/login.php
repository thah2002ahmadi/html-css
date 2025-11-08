<?php

require_once('db_connect.php');

$result = ["status" => 0];

$email = trim($_POST['email']);
$password = trim($_POST['password']);

if (empty($email) || empty($password)) {
    $result["error"] = "Please enter username and password";
} else {
    try {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        if ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($password === $user['password']) {
                session_start();
                $_SESSION['id'] = $user['id'];
                $result["status"] = 1;
                
            } else {
                $result["error"] =  "Invalid username or password";
            }
        } else {
            $result["error"] =  "Invalid username or password";
        }
    } catch (PDOException $e) {
        $result["error"] =  "Error: " . $e->getMessage();
    }
}

$json = json_encode($result);
header('Content-Type: application/json');
echo $json;