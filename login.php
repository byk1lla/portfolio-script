<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | X</title>
  <link rel="stylesheet" href="./css/loginregister.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
  .swal2-confirm {
    background-color: #007bff;
    color: #fff; 
    border: none;
    font-weight: bold;
    box-shadow: none;
  }

  .swal2-cancel {
    background-color: #dc3545; 
    color: #fff; 
    border: none;
    font-weight: bold;
    box-shadow: none;
  }
</style>
<body>
<div class="bg"></div>
<div class="star"></div>
  <div class="container">
    <h1>Login | X</h1>
    <a href='./register'></a>
    <form id="login-form">
      <input type="text" id="username" placeholder="Username" required>
      <input type="password" id="password" placeholder="Password" required>

      <input type="submit" value="Login">
    </form>
    <br>

    <p>
    <span class='loginspan'>
    Doesn't Have an Account?
    </span>
    <br>
      <a class='loginlink' href="./register">
        <strong class='loginstrong'>Register</strong>
    </a>
    </p>
  </div>

</body>
</html>
<script src="../inc/js/login.js"></script>
<script src="../inc/js/config.js"></script>
<script src="../inc/js/dash.js"></script>
