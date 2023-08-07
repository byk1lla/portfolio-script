<?php
session_start();
header("Content-Type: application/json");
require_once("../config.php");
$portfolio = new Portfolio();
$sql = new SQL();
$log = new Log();
$log->logPath = "../logs/";
$sql->url = $_SERVER['REQUEST_URI'];
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = @$_SESSION['userid']; 
    $title = $_POST['username']; 
    $description = $_POST["about_me"];
    $sign = $_POST['signature'] ?? null;
    $pic_path = "../img/default.png"; 
    $link1 = $_POST["link1"];
    $link2 = $_POST["link2"];
    $link3 = $_POST["link3"];
    $link4 = $_POST["link4"];
    $link5 = $_POST["link5"];
    $link6 = $_POST["link6"];
    $visit_count = 0; 
    $last_visit = date("Y-m-d H:i:s");
    try {
        $portfolio->editPost($user_id,$title,$description,$sign,$pic_path,$link1,$link2,$link3,$link4,$link5,$link6,$visit_count,$last_visit);
        echo json_encode(["status" => "success"]);
    } catch (Exception $ex) {
        echo json_encode(["status" => "error", "message" => $ex->getMessage()]);
    }}
?>
