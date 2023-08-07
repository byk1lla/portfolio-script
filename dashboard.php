<?php
session_start();
require("./inc/config.php");
$log = new Log();
$main = new Main();
$sql = new SQL();
$user = new User();
$log->logPath = "./inc/logs/";

$main->url = $_SERVER['REQUEST_URI'];
$id = $user->getuserid($_SESSION['username']);
$portfolio = new Portfolio();
$checkmypage = $portfolio->check($_SESSION['userid']);
if (!$sql->connect()) {
    $sql->log->error($sql->url,"Database is Offline!");
    throw new PDOException("Database Offline!");
}
if(!$user->isloggedin()){
    $log->activity($main->url,"Unauthorized User detected!\nRedirected to login.\nIP-> [" . $_SERVER['REMOTE_ADDR'] ."]");
    header("Location: ./login");
}
if(!$checkmypage){
    $portfolio->addPost($_SESSION['userid'],$_SESSION['username'],"",null,"../img/default.png",null,null,null,null,null,null,0,date("Y-m-d H:i:s"));    
}

    // $visit = $user->getvisit($_SESSION['userid']);



if (isset($_POST['logout'])) {
    session_destroy();
    $log->info($main->url,"User Logged out -> " . $_SESSION['username'] . "-" . $_SESSION['userid']);
    header("Location: ./login");
    
}
$username = @$_SESSION['username'];
$welcomeMessage = "Welcome, ";
if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
    $welcomeMessage .= $_SESSION['username'] . "!";
} else {
    $welcomeMessage .= "Guest!";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="./css/admin_css.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Edit | <?=$username?></title>
</head>
<body>
    <div class="header">
        <h2>Dashboard</h2>
        
        <form method="post">
            <button type="submit" name="logout">Logout</button>
        </form>
    </div>
    <div class="welcome-message">
        <p><?= $welcomeMessage ?></p>
    </div>
    <div class="visitor-count">
        <p>Visitors: <?= $visit ?? 0?></p>
        <p>User ID : <?=$id?></p>
    </div>
    <div class="edit-button-container">
        <a href="../edit" class="edit-button">Edit Your MyPage&trade;</a>
    </div>
    <script src="../inc/js/dash.js"></script>
    <script src="../inc/js/config.js"></script>
</body>
</html>
