<?php 


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
  <title>Register</title>
  <link rel="stylesheet" href="../css/popup.css">
  <link rel="stylesheet" href="../css/loginregister.css">
</head>

<body>
<div class="bg"></div>
<div class="star"></div>
  <div class="container">
    <h1>Register</h1>
    <form id="signup-form">
      <input type="text" id="username"  placeholder="Username" required>
      <input type="email" id="email" placeholder="Email" required>
      <input type="password" id="password" minlength="8" placeholder="Password" required>
      <input type="password" id="password2" minlength="8" placeholder="Password Again" required>

      <input type="submit" value="Register">
    </form>
    <p>
    <span>
      Already have an account? 
    </span>
    <br>
      <a href="./login">
        <strong>Login</strong>
    </a>
    </p>
  </div>
</body>
</html>
<script src="../inc/js/register.js"></script>
<script src="../inc/js/config.js"></script>
