<?php
session_start();
include("db.php");

// When user submits the login form
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Check if user exists
    $query = $conn->prepare("SELECT * FROM applicants WHERE email = ? AND phone = ?");
    $query->bind_param("ss", $email, $phone);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Save login session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        // Redirect to index.php (home page)
        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid Email or Phone Number.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MahaBuildNOC - User Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #007bff, #00c6ff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .login-box {
      background: #fff;
      padding: 40px;
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
      width: 360px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }
    input[type="email"], input[type="text"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ccc;
      border-radius: 8px;
    }
    button {
      width: 100%;
      padding: 12px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
    }
    button:hover {
      background: #0056b3;
    }
    .error {
      color: red;
      text-align: center;
    }
    .back {
      text-align: center;
      margin-top: 10px;
    }
    .back a {
      text-decoration: none;
      color: #007bff;
    }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>User Login</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST" action="">
      <input type="email" name="email" placeholder="Enter Email" required>
      <input type="text" name="phone" placeholder="Enter Phone Number" required>
      <button type="submit" name="login">Login</button>
    </form>
    <div class="back">
      <a href="index.php">⬅ Back to Home</a>
    </div>
  </div>
</body>
</html>
