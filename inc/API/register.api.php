<?php
header("Content-Type: application/json");
require "../config.php";
$user = new User();
$sql = new SQL();
$log = new Log();
$log->logPath = "../logs/";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";
    
    $uniqueid = $user->generateID($username);
    $connectionResult = $sql->connect();

    if ($connectionResult === true) {

        $stmt_check = $sql->conn->prepare("SELECT COUNT(*) AS user_count FROM users WHERE username = :username OR eposta = :eposta");
        $stmt_check->bindParam(":username", $username);
        $stmt_check->bindParam(":eposta", $email);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);
        
        if ($result["user_count"] > 0) {
            echo json_encode(array("status" => "error", "message" => "That email or username you entered is Already Used!"));
        } else {
            try {
                $stmt = $sql->conn->prepare("INSERT INTO users (username, eposta, IP, unique_id, password,reg_time, last_login) 
                                            VALUES (:username, :eposta, :IP, :unique_id, :password, NOW(),NOW())");

                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":eposta", $email);
                $stmt->bindValue(":IP", $_SERVER['REMOTE_ADDR']);
                $stmt->bindValue(":unique_id", $uniqueid);
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bindParam(":password", $hashedPassword);
                $stmt->execute();   
                $log->info($_SERVER["REQUEST_URI"],"New Register!\nIP ->[". $_SERVER['REMOTE_ADDR'] . "]\nID->[". $uniqueid . "]");
                echo json_encode(array("status" => "success", "message" => "User registration successful."));
            } catch (PDOException $ex) {
                echo json_encode(array("status" => "error", "message" => "Error registering user."));
            }
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "Database connection failed."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Unsupported request method. OR SomeOne Access With URL"));
}
