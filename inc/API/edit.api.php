<?php
session_start();
header("Content-Type: application/json");
require_once("../config.php");
$portfolio = new Portfolio();
$sql = new SQL();
$log = new Log();
$user = new User();
$log->logPath = "../inc/logs/";
$sql->url = $_SERVER['REQUEST_URI'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = @$_SESSION['userid']; 
    $title = $_POST['username'] ?? $_SESSION['username']; 
    $description = $_POST["about_me"];
    $sign = $_POST['signature'] ?? null;
    $img_name = $_FILES['img']['name'];
    $tmp_name = $_FILES['img']['tmp_name'] ?? null;
    $file_extension = pathinfo($img_name, PATHINFO_EXTENSION);
    $img_new_name = $user->generateimgname($user_id, $title,$file_extension); 
    $pic_path = "./upload/" . $img_new_name;

    
    if (!empty($tmp_name) && move_uploaded_file($tmp_name, $pic_path)) {
        try {
            $path = "/upload/" . $img_new_name;
            $link1 =  $_POST["link1"];
            $link2 = $_POST["link2"];
            $link3 = $_POST["link3"];
            $link4 = $_POST["link4"];
            $link5 = $_POST["link5"];
            $link6 = $_POST["link6"];
            $visit_count = 0; 
            $last_visit = date("Y-m-d H:i:s");
            $portfolio->editPost($user_id, $title, $description, $sign, $path, $link1, $link2, $link3, $link4, $link5, $link6, $visit_count, $last_visit);
            echo json_encode(["status" => "success"]);
        } catch (Exception $ex) {
            $log->error($_SERVER["REQUEST_URI"], $ex->getMessage());
            throw $ex;
        }
    } else {
        try {
            $im = $user->getuserPath($user_id);
            $path = $im ?? "/upload/default.png";
            $link1 =  $_POST["link1"];
            $link2 = $_POST["link2"];
            $link3 = $_POST["link3"];
            $link4 = $_POST["link4"];
            $link5 = $_POST["link5"];
            $link6 = $_POST["link6"];
            $visit_count = 0; 
            $last_visit = date("Y-m-d H:i:s");
            $portfolio->editPost($user_id, $title, $description, $sign, $path, $link1, $link2, $link3, $link4, $link5, $link6, $visit_count, $last_visit);
            echo json_encode(["status" => "success"]);
        } catch (Exception $ex) {
            $log->error($_SERVER["REQUEST_URI"], $ex->getMessage());
            throw $ex;
        }
    }
}
