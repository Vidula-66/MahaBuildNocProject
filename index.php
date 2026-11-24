<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>MahaBuildNOC – Government of Maharashtra</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
    }
    header {
      background: linear-gradient(90deg, #002868, #014aad);
      color: white;
      padding: 25px 0;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }
    header h1 { margin: 0; font-size: 32px; letter-spacing: 1px; }
    header h2 { margin: 5px 0 0; font-size: 18px; font-weight: 400; }

    nav {
      display: flex;
      justify-content: center;
      gap: 20px;
      background-color: #0066cc;
      padding: 12px 0;
      box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    }
    nav a {
      color: white;
      font-weight: 600;
      padding: 10px 18px;
      border-radius: 8px;
      background: #0080ff;
      transition: all 0.3s ease;
      text-decoration: none;
      box-shadow: 0 3px 6px rgba(0,0,0,0.2);
    }
    nav a:hover {
      background: #005bb5;
      transform: translateY(-2px);
      box-shadow: 0 5px 10px rgba(0,0,0,0.3);
    }

    .hero {
      background: url('gov_building.jpg') no-repeat center center/cover;
      height: 400px;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      color: white;
      text-align: center;
    }
    .hero::after {
      content: "";
      position: absolute;
      top:0; left:0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.6);
    }
    .hero-content { position: relative; z-index: 2; animation: fadeIn 1.5s ease-in-out; }
    .hero h2 { font-size: 48px; margin: 0; }
    .hero p { font-size: 20px; margin-top: 12px; font-weight: 400; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 20px;
      max-width: 1200px;
      margin: 40px auto;
      padding: 0 20px;
    }
    .card {
      background: white;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.2); }
    .card h3 { margin-top: 0; color: #002868; font-size: 22px; }
    .card ul { padding-left: 20px; margin: 10px 0 0; }
    .card li { margin-bottom: 8px; font-size: 16px; }
    .btn-primary { display: inline-block; background: #0066cc; color: white; padding: 10px 20px; margin-top: 15px; border-radius: 8px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; }
    .btn-primary:hover { background: #004a99; transform: translateY(-2px); }
    footer { background: #002868; color: white; text-align: center; padding: 20px; margin-top: 50px; font-size: 14px; }

    @media (max-width: 600px) { .hero h2 { font-size: 32px; } .hero p { font-size: 16px; } }

    .welcome-msg { margin: 0 0 10px 20px; font-weight: 600; color: #fff; font-size: 18px; }
  </style>
</head>
<body>

  <header>
    <h1>MahaBuildNOC</h1>
    <h2>Online Building Permission NOC System</h2>
    <?php if(isset($_SESSION['user_name'])): ?>
      <p class="welcome-msg">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
    <?php endif; ?>
  </header>

  <nav>
    <a href="applicant_form.php">📝 Apply Now</a>
    <a href="check_status.html">📩 Check Status</a>
    <?php if(isset($_SESSION['user_name'])): ?>
      <a href="logout.php">🔓 Logout</a>
    <?php else: ?>
      <a href="user_login.php">🔐 User Login</a>
    <?php endif; ?>
    <a href="admin_login.php">🔐 Admin Login</a>
    <a href="officier_login.php">🔐 Officer Login</a>
  </nav>

  <section class="hero">
    <div class="hero-content">
      <h2>Welcome to Maharashtra e-NOC Portal</h2>
      <p>Apply, track, and download your Building NOC digitally.</p>
      <a class="btn-primary" href="applicant_form.php">Apply Now</a>
    </div>
  </section>

  <section class="cards">
    <div class="card">
      <h3>Submit NOC Online</h3>
      <ul>
        <li>Easy application process</li>
        <li>Upload required PDF documents</li>
      </ul>
    </div>
    <div class="card">
      <h3>Track Your Application</h3>
      <ul>
        <li>Real-time status updates</li>
        <li>Receive officer remarks</li>
      </ul>
    </div>
    <div class="card">
      <h3>Download Certificate</h3>
      <ul>
        <li>Get approved NOC digitally</li>
        <li>Print anytime</li>
      </ul>
    </div>
  </section>

  <footer>
    &copy; 2025 Government of Maharashtra | MahaBuildNOC Portal
  </footer>

</body>
</html>
