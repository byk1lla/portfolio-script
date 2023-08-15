<?php

session_start();
$username = $_SESSION['username'];

require("./inc/config.php");
$user = new User();
$port = new Portfolio();
$sql = new SQL();
if(!$sql->connect()){
    throw new PDOException("Database OFFLINE!");
}

$result = $port->getPost($username);



if(!$user->isloggedin()){
    header("Location: ./login");
}

if (isset($_POST['update'])) {
    
    header("Location: u/$username");
    exit;
}
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
    ]


?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="./css/edit_css.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<title>Edit | <?=$arr['username']?></title>
</head>
<body>
<div class="container">
<div class="header">
<a href="../dashboard">
<i class='fa-solid fa-arrow-left'></i>
    <span> Dashboard</span>
</a>
<h2 class="head">Edit MyPage&trade; - <?= $arr['username']?></h2>
<a href="../u/<?=$username?>">
    <span> MyPage&trade;</span> 
    <i class='fa-solid fa-arrow-right'></i>
</a>
</div>
<hr>
<br>
<form method="post" enctype="multipart/form-data">
<div class="pp">
        <h2>Profile Picture</h2>
        <img src="../inc/API<?= $arr['img']?>" id="image" alt="Profil Resmi">
        <br>
        <input type="file" name="img" id="uploadimg" value="<?= $arr['img'] ?>" accept="image/png, image/gif, image/jpeg,image/webp" >
    </div>    
    <div class="input">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="<?=$arr['username']?>">

        <label for="about_me">About Me</label>
        <textarea id="about_me" name="about_me"><?=$arr['aboutme']?></textarea>
        
        <label for="signature">Signature <span>(optional)</span></label>
        <textarea placeholder="Type Something..." id="signature" name="signature"><?=$arr['sign']?></textarea>
    </div>
<div class="social-media-container">
    <h2>Social Media</h2>
    <div>
        <label for="link"><i class="fa-brands fa-spotify"></i> Spotify</label>
        <input type="text" value="<?= $arr['link1']?>" id="link" name="link1">
    </div>
    
    <div>
        <label for="link"><i class="fa-brands fa-instagram"></i> Instagram</label>
        <input type="text" value="<?= $arr['link2']?>" id="link" name="link2">
    </div>
    
    <div>
        <label for="link"><i class="fa-brands fa-github"></i> Github</label>
        <input type="text" value="<?= $arr['link3']?>"  id="link" name="link3">
    </div>
        
    <div>
        <label for="link"><i class="fa-solid fa-envelope"></i> Mail</label>
        <input type="text" value="<?= $arr['link4'] ?? "mailto:"?>"  id="link" name="link4">
    </div>
    
    <div>
        <label for="link"><i class="fa-brands fa-steam"></i> Steam</label>
        <input type="text" value="<?=  $arr['link5']?>"  id="link" name="link5">
    </div>
    
    <div>
        <label for="link"><i class="fa-brands fa-twitter"></i> Twitter</label>
        <input type="text" value="<?= $arr['link6']?>"  id="link" name="link6">    
    </div>
    
</div>
    
    <button type="submit" name="update" id="update">Update</button>

    <br>
    <hr>
    
    <h3 style="text-align: center;"><?=$_SESSION['username'].  " - " . $_SESSION['userid'] ?></h3>
    
</form>
</div>
</body>
</html>
<script src="../inc/js/edit.js"></script>
<script src="./inc/js/config.js"></script>
