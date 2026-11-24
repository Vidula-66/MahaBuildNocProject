<?php
include("db.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $u = $_POST['username'];
    $p = $_POST['password'];
    $res = $conn->query("SELECT * FROM officer WHERE username='$u' AND password='$p'");
    if ($res->num_rows > 0) {
        header("Location: officier_dashboard.php");
    } else {
        echo "<script>alert('Invalid Login');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Officer Login – MahaBuildNOC</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: url('images/officier.jpeg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
    }

    .overlay {
      background: rgba(0, 0, 0, 0.6);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      background: rgba(255, 255, 255, 0.95);
      padding: 30px;
      width: 350px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
      text-align: center;
    }

    .login-box h2 {
      margin-bottom: 20px;
      color: #003366;
    }

    .login-box input[type="text"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .login-box input[type="submit"] {
      width: 100%;
      padding: 10px;
      background-color: #28a745;
      color: white;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-bottom: 15px; /* space below login button */
    }

    .login-box input[type="submit"]:hover {
      background-color: #218838;
    }

    /* Back button style */
    .back-btn {
      display: inline-block;
      padding: 10px 18px;
      background-color: #6c757d;
      color: white;
      text-decoration: none;
      border-radius: 6px;
      font-size: 16px;
      transition: background 0.3s ease;
    }

    .back-btn:hover {
      background-color: #5a6268;
    }

    @media (max-width: 400px) {
      .login-box {
        width: 90%;
      }
    }
  </style>
</head>
<body>

<div class="overlay">
  <div class="login-box">
    <h2>Officer Login</h2>
    <form method="post" autocomplete="off">
      <input type="text" name="username" placeholder="Username" required autocomplete="off">
      <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
      <input type="submit" value="Login">
    </form>
    <!-- Back button below login button -->
    <a href="index.html" class="back-btn">⬅ Back to Home</a>
  </div>
</div>

</body>
</html>
