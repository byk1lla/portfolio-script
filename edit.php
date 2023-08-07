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
        <img src="../img/<?= $arr['img']?>" id="image" alt="Profil Resmi">
            <br>
        <input type="file" name="profile_photo" id="uploadimg" accept="image/png, image/gif, image/jpeg" >
    </div>    
    <div class="input">
        <label for="username">Username <yildiz>*</yildiz></label>
        <input type="text" id="username" name="username" placeholder="<?=$arr['username']?>" required>

        <label for="about_me">About Me <yildiz>*</yildiz></label>
        <textarea placeholder="<?=$arr['aboutme']?>" id="about_me" name="about_me" required></textarea>
        
        <label for="signature">Signature <span>(optional)</span></label>
        <textarea placeholder="<?=$arr['sign'] ?? "Type Something..."?>" id="signature" name="signature"></textarea>
    </div>
<div class="social-media-container">
    <h2>Social Media</h2>
    <div>
        <label for="link"><i class="fa-brands fa-tiktok"></i> Tiktok</label>
        <input type="text" placeholder="<?= "https://tiktok.com/@" . $arr['link1'] ?? "https://tiktok.com/@"?>" id="link" name="link1">
    </div>
    
    <div>
        <label for="link"><i class="fa-brands fa-instagram"></i> Instagram</label>
        <input type="text" placeholder="<?= "https://instagram.com/" . $arr['link2'] ?? "https://instagram.com/@"?>" id="link" name="link2">
    </div>
    
    <div>
        <label for="link"><i class="fa-brands fa-github"></i> Github</label>
        <input type="text" placeholder="<?= "https://github.com/" . $arr['link3'] ?? "https://github.com/@"?>"  id="link" name="link3">
    </div>
    
    <div>
        <label for="link"><i class="fa-solid fa-envelope"></i> Mail</label>
        <input type="text" placeholder="<?= "mailto:" . $arr['link4'] ?? "mailto:"?>"  id="link" name="link4">
    </div>
    
    <div>
        <label for="link"><i class="fa-brands fa-steam"></i> Steam</label>
        <input type="text" placeholder="<?= "https://steamcommunity.com/id/" . $arr['link5'] ?? "https://steamcommunity.com/id/"?>"  id="link" name="link5">
    </div>
    
    <div>
        <label for="link"><i class="fa-brands fa-twitter"></i> Twitter</label>
        <input type="text" placeholder="<?= "https://twitter.com/". $arr['link6'] ?? "https://twitter.com/"?>"  id="link" name="link6">    
    </div>

    <div class="social-media-box">

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
