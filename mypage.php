<?php
session_start(); 
$uri = $_SERVER['REQUEST_URI'];
$parts = explode('/', $uri);
$username = end($parts);
$username = urldecode($username);
require("./inc/config.php");
define("sql",new SQL);
$portfolio = new Portfolio();
$user = new User();
$log = new Log();
$log->logPath = "./inc/logs/";
$userid = $user->getuserid($username);

$result = $portfolio->getPost($username);
        @$arr = [
            "username" => $result["title"],
            "aboutme" => $result["description"],
            "sign" => $result["sign"],
            "img" => $result["pic_path"],
            "link1" => $result["link1"],
            "link2" => $result["link2"],
            "link3" => $result["link3"],
            "link4" => $result["link4"],
            "link5" => $result["link5"],
            "link6" => $result["link6"],
        ];
sql->connect();
function check($username) {
    global $log;
    $stmt = sql->conn->prepare("SELECT COUNT(username) AS count FROM users WHERE username = :username");
    $stmt->bindParam(":username", $username, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if($result['count'] > 0){
        $log->sys($_SERVER["REQUEST_URI"],"Username Fetched!
        ->$username
        result: True");
        return true;
    }
    else
    {
        $log->sys($_SERVER["REQUEST_URI"],"Username Not Found
        ->$username
        result: False");
        return false;
    }
}

if(!check($username)){
    header("Location: ../error/usernotfound");
}
if($username == @$_SESSION['username']){
    echo "<title>Sayfam | " . $arr['username']. "</title>";
}
else{
    echo "<title>".$arr['username']." | X</title>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        
            <div class="profile-picture">
                <img src="../img/default.png" alt="Profil Resmi">
                <h1 class="username"><?=$arr['username']?></h1>
            </div>
        
            <div class="about-me">
                <h2>About Me</h2>
                <p><?=$arr['aboutme']?></p>
            </div>
            <div class="social-media">
                <h2>Social Accounts</h2>
                <ul>
                        <li>
                            <a href="https://tiktok.com/@<?=$arr['link1']?>" target="_blank" class="social-media-box ">
                            <i class="fa-brands fa-tiktok"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/<?=$arr['link6']?>" target="_blank" class="social-media-box ">
                            <i class="fa-brands fa-twitter"></i>                            
                        </a>
                        </li>
                        <li>
                            <a href="https://github.com/<?=$arr['link3']?>" target="_blank" class="social-media-box ">
                            <i class="fa-brands fa-github"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://instagram.com/<?=$arr['link2']?>" target="_blank" class="social-media-box">
                            <i class="fa-brands fa-instagram"></i>
                            </a>
                        </li>
                        <li>
                            <a href="https://steamcommunity.com/id/<?=$arr['link5']?>" target="_blank" class="social-media-box">
                            <i class="fa-brands fa-steam"></i>
                             </a>
                        </li>
                        <li>
                        <a href="mailto:<?=$arr['link4']?>" target="_blank" class="social-media-box">
                            <i class="fa-solid fa-envelope"></i>
                            </a>
                        </li>
                    
                </ul>
            </div>
        
            <div class="signature">
                <h2>Signature</h2>
                <p>
                <?=$arr['sign']?>
                    
                </p>
                <p>
                <span class="sign">~<?=$arr['username']?></span> 
                </p>
                  
                
            </div>
                
        </div>

</body>
</html>
