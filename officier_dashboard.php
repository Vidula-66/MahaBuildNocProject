<?php
include("db.php");

// Handle search
$search = '';
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search = trim($_GET['search']);
    // Search by name, email, or phone
    $result = $conn->query("
        SELECT * FROM applicants 
        WHERE status IN ('Forwarded','Approved','Rejected') 
          AND (name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%')
        ORDER BY id DESC
    ");
} else {
    $result = $conn->query("SELECT * FROM applicants WHERE status IN ('Forwarded','Approved','Rejected') ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Officer Dashboard – MahaBuildNOC</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('images/officerdashboard.jpeg') no-repeat center center;
      background-size: cover;
      color: #000;
    }

    .overlay {
      background: rgba(255, 255, 255, 0.6);
      min-height: 100vh;
      padding: 40px 20px;
    }

    h2 {
      text-align: center;
      font-size: 34px;
      color: #003366;
      background-color: rgba(255, 255, 255, 0.8);
      padding: 10px;
      border-radius: 10px;
      display: inline-block;
      margin-bottom: 20px;
    }

    /* Logout button at top-left */
    .back-btn {
        position: fixed;
        top: 20px;
        left: 20px;
        display: inline-block;
        padding: 10px 18px;
        background-color: #6c757d;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 16px;
        transition: background 0.3s ease;
        cursor: pointer;
        z-index: 1000;
    }

    .back-btn:hover {
        background-color: #5a6268;
    }

    .search-form {
      text-align: center;
      margin-bottom: 30px;
    }

    .search-form input[type="text"] {
      width: 50%;
      max-width: 400px;
      padding: 10px;
      font-size: 16px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .search-form input[type="submit"] {
      padding: 10px 16px;
      font-size: 16px;
      border-radius: 6px;
      border: none;
      background-color: #007bff;
      color: white;
      cursor: pointer;
    }

    .search-form input[type="submit"]:hover {
      background-color: #0056b3;
    }

    .card {
      background: rgba(255, 255, 255, 0.95);
      color: #000;
      padding: 20px;
      margin: 30px auto;
      max-width: 750px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .card p {
      margin: 8px 0;
    }

    ul {
      padding-left: 20px;
    }

    .card a {
      color: #007bff;
      text-decoration: none;
    }

    .card a:hover {
      text-decoration: underline;
    }

    .form-section {
      margin-top: 15px;
    }

    input[type="text"],
    select {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 6px;
      border: 1px solid #ccc;
      font-size: 16px;
    }

    input[type="submit"].decision {
      background-color: #28a745;
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    input[type="submit"].decision:hover {
      background-color: #218838;
    }

    hr {
      border: none;
      border-top: 1px solid #ccc;
      margin: 30px auto;
      max-width: 750px;
    }
  </style>
</head>
<body>
  <div class="overlay">

    <!-- ✅ Logout Button (only change done) -->
    <a href="logout2.php" class="back-btn">Logout</a>

    <center><h2>Officer Dashboard – Applications History</h2></center>

    <div class="search-form">
      <form method="get" action="">
        <input type="text" name="search" placeholder="Search by name, email, or phone..." value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Search">
      </form>
    </div>

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $noc_id = "NOC-" . str_pad($row['id'], 5, "0", STR_PAD_LEFT);
            echo "<div class='card'>";
            echo "<p><strong>NOC ID:</strong> $noc_id</p>";
            echo "<p><strong>Name:</strong> {$row['name']}</p>";
            echo "<p><strong>Email:</strong> {$row['email']}</p>";
            echo "<p><strong>Phone:</strong> {$row['phone']}</p>";
            echo "<p><strong>Applied On:</strong> {$row['application_date']}</p>";

            $status = $row['status'];
            $remark = $row['officer_remark'];

            $documents = json_decode($row['document'], true);
            if (!empty($documents)) {
                echo "<p><strong>Uploaded Documents:</strong></p><ul>";
                foreach ($documents as $doc_key => $path) {
                    $label = ucwords(str_replace("_", " ", $doc_key));
                    echo "<li>$label: <a href='$path' target='_blank'>📄 View</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<p style='color:red;'>No documents uploaded.</p>";
            }

            $statusColor = ($status == 'Approved') ? 'green' : (($status == 'Rejected') ? 'red' : '#333');
            echo "<p><strong>Status:</strong> <b style='color:$statusColor;'>$status</b></p>";

            if ($status == 'Forwarded') {
                echo "<div class='form-section'>
                  <form method='post' action='approve_application.php'>
                    <input type='hidden' name='id' value='{$row['id']}'>
                    Remark: <input type='text' name='remark' required>
                    <label>Status:</label>
                    <select name='status' required>
                      <option value='Approved'>✅ Approve</option>
                      <option value='Rejected'>❌ Reject</option>
                    </select>
                    <input type='submit' class='decision' value='Submit Decision'>
                  </form>
                </div>";
            } else {
                echo "<p><strong>Remark:</strong> <i>$remark</i></p>";
            }

            echo "</div><hr>";
        }
    } else {
        echo "<p style='text-align:center; color:red;'>No applications found.</p>";
    }
    ?>

  </div>
</body>
</html>
