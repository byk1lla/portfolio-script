<?php 
include "./config.php";

define("log",new Log());

log->alert($_SERVER["REQUEST_URI"],"Someone Try Access The Folder With URL
Request URI -> [" . $_SERVER["REQUEST_URI"]."]
IP -> [" . $_SERVER["REMOTE_ADDR"]."]
");

?>
