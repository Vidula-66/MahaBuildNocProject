<?php
include("db.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Application Status – MahaBuildNOC</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #a1c4fd, #c2e9fb);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .container {
      background: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      width: 90%;
      max-width: 600px;
      text-align: center;
    }

    h2, h3 {
      color: #003366;
    }

    .status {
      font-weight: bold;
      font-size: 18px;
      margin-bottom: 10px;
    }

    .approved {
      color: green;
    }

    .rejected {
      color: red;
    }

    .pending {
      color: orange;
    }

    .btn-link {
      display: inline-block;
      margin: 10px 5px;
      text-decoration: none;
      background-color: #007bff;
      color: #fff;
      padding: 10px 18px;
      border-radius: 6px;
      font-size: 15px;
    }

    .btn-link:hover {
      background-color: #0056b3;
    }

    .back-link {
      margin-top: 20px;
    }
  </style>
</head>
<body>

<div class="container">
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'])) {
    $email = $_POST['email'];
    $sql = "SELECT * FROM applicants WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row["status"];
        $remark = $row["officer_remark"];
        $certificate = $row["certificate"];
        $id = $row["id"];

        echo "<h2>Application Status</h2>";

        if ($status == "Approved") {
            echo "<h3 class='status approved'>✅ Approved</h3>";
            echo "<p><strong>Officer Remark:</strong> $remark</p>";

            if (!empty($certificate) && file_exists($certificate)) {
                echo "<a class='btn-link' href='print_noc.php?id=$id' target='_blank'>📄 View Certificate</a>";
                echo "<a class='btn-link' href='print_noc.php?id=$id&download=1'>⬇ Download Certificate</a>";
            } else {
                echo "<p class='pending'>✅ Approved, but certificate not uploaded yet.</p>";
            }

        } elseif ($status == "Rejected") {
            echo "<h3 class='status rejected'>❌ Rejected</h3>";
            echo "<p><strong>Officer Remark:</strong> $remark</p>";
        } elseif ($status == "Forwarded") {
            echo "<h3 class='status pending'>⏳ Under Review by Officer</h3>";
            echo "<p>Your application is being reviewed. Please check back later.</p>";
        } else {
            echo "<h3 class='status pending'>🕓 Pending with Admin</h3>";
            echo "<p>Your application is awaiting forwarding to the officer by the admin.</p>";
        }

    } else {
        echo "<p>No record found for this email address. Please check and try again.</p>";
    }
    echo "<div class='back-link'><a class='btn-link' href='check_status.html'>⬅ Back to status check</a></div>";

} else {
    echo "<p>Please submit the form from <a href='check_status.html'>here</a>.</p>";
}
?>
</div>

</body>
</html>
