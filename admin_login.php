<?php
include("db.php");
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $u = $_POST['username'];
    $p = $_POST['password'];
    $res = $conn->query("SELECT * FROM admin WHERE username='$u' AND password='$p'");
    if ($res->num_rows > 0) {
        header("Location: admin_dashboard.php");
    } else {
        echo "<script>alert('Invalid Login');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Login – MahaBuildNOC</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-image: url('images/adminlogin.jpeg'); /* ✅ Set background image */
      background-size: cover;
      background-position: center;
      font-family: 'Segoe UI', sans-serif;
      height: 100vh;
    }

    .login-box {
      background: rgba(255, 255, 255, 0.95);
      width: 350px;
      margin: 120px auto;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
      text-align: center;
    }

    .login-box h2 {
      text-align: center;
      color: #003366;
      margin-bottom: 20px;
    }

    .login-box input[type="text"],
    .login-box input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .login-box input[type="submit"] {
      width: 100%;
      background-color: #0066cc;
      color: white;
      padding: 10px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 10px;
    }

    .login-box input[type="submit"]:hover {
      background-color: #004a99;
    }

    /* Back button style */
    .back-btn {
      display: inline-block;
      margin-top: 15px;
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
        margin: 80px auto;
      }
    }
  </style>
</head>
<body>

  <div class="login-box">
    <h2>Admin Login</h2>
    <form method="post" autocomplete="off">
      <input type="text" name="username" placeholder="Username" required autocomplete="off">
      <input type="password" name="password" placeholder="Password" required autocomplete="new-password">
      <input type="submit" value="Login">
    </form>

    <!-- Back button -->
    <a href="index.html" class="back-btn">⬅ Back to Home</a>
  </div>

</body>
</html>
