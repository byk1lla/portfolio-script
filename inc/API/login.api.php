<?php
header("Content-Type: application/json");
require "../config.php";
session_start();
$sql = new SQL();
$user = new User();
$log = new Log();
$log->logPath = "../logs/";
if (!$sql->connect()) {
  echo json_encode(array('success' => false, 'message' => 'Database connection error'));
  exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if (empty($username) || empty($password)) {
    echo json_encode(array('success' => false, 'message' => 'Please provide both username and password'));
    exit;
  }

  try {
    $query = $sql->conn->prepare("SELECT * FROM users WHERE (username = :username OR eposta = :username)");
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    if ($result) {
      if (password_verify($password, $result['password'])) {

        $_SESSION['username'] = $result['username'];
        $_SESSION['userid'] = $result['unique_id'];
        $user->login($_SESSION['userid'], $_POST['device'], $_POST['browser']);
        $log->info($sql->url, "User Logged in -> " . $_SESSION['username'] . "-" . $_SESSION['userid']);
        echo json_encode(array('success' => true, 'user' => $result));
      } else {
        echo json_encode(array('success' => false, 'message' => 'Invalid password'));
        $log->activity($_SERVER["REQUEST_URI"], "LoginExcepiton
        ->$username
        ->$password
        Invalid Password!");
        exit;
      }
    } else {
      echo json_encode(array('success' => false, 'message' => 'User not found'));
      exit;
    }
  } catch (Exception $ex) {
    echo json_encode(array('success' => false, 'message' => $ex->getMessage()));
    exit;
  }
}
