<?php
include("db.php");

// Handle search
$search_query = "";
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search_query = trim($_GET['search']);
    $result = $conn->query("
        SELECT * FROM applicants 
        WHERE name LIKE '%$search_query%' 
           OR email LIKE '%$search_query%' 
           OR phone LIKE '%$search_query%'
        ORDER BY id DESC
    ");
} else {
    $result = $conn->query("SELECT * FROM applicants ORDER BY id DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard – MahaBuildNOC</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: url('images/admin.jpeg') no-repeat center center;
      background-size: cover;
      color: #fff;
      min-height: 100vh;
      padding: 20px;
    }

    h2 {
      text-align: center;
      font-size: 32px;
      color: #ffffff;
      background-color: rgba(0, 0, 0, 0.6);
      padding: 10px;
      border-radius: 8px;
    }

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

    .search-container {
        text-align: center;
        margin: 20px auto;
    }

    .search-container input[type="text"] {
        padding: 10px;
        width: 250px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    .search-container input[type="submit"] {
        padding: 10px 18px;
        border: none;
        border-radius: 6px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
        font-size: 16px;
        margin-left: 5px;
    }

    .search-container input[type="submit"]:hover {
        background-color: #0056b3;
    }

    .applicant-card {
      background: rgba(255, 255, 255, 0.9);
      color: #000;
      border-radius: 12px;
      padding: 20px;
      margin: 20px auto;
      max-width: 800px;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }

    .applicant-card p {
      margin: 8px 0;
    }

    .applicant-card ul {
      padding-left: 20px;
    }

    .applicant-card a {
      color: #007bff;
      text-decoration: none;
    }

    .applicant-card a:hover {
      text-decoration: underline;
    }

    form {
      margin-top: 15px;
    }

    form input[type="submit"],
    form input[type="file"] {
      margin-top: 8px;
      padding: 8px 12px;
      font-size: 14px;
      border: none;
      border-radius: 5px;
    }

    form input[type="submit"] {
      background-color: #0066cc;
      color: white;
      cursor: pointer;
    }

    form input[type="submit"]:hover {
      background-color: #004a99;
    }

    hr {
      border: 0;
      border-top: 1px solid #ccc;
      margin: 40px auto;
      max-width: 800px;
    }
  </style>
</head>
<body>

<!-- ✅ Updated Logout Button (Only change done here) -->
<a href="logout1.php" class="back-btn">Logout</a>

<h2>Admin Dashboard – MahaBuildNOC</h2>

<div class="search-container">
    <form method="get" action="">
        <input type="text" name="search" placeholder="Search by name, email or phone" value="<?php echo htmlspecialchars($search_query); ?>" required>
        <input type="submit" value="Search">
    </form>
</div>

<?php
if ($result->num_rows == 0) {
    echo "<p style='text-align:center;color:white;'>No applicants found.</p>";
}

while ($row = $result->fetch_assoc()) {
    $id = $row['id'];
    $status = $row['status'];
    $certificate = $row['certificate'];
    $noc_id = "NOC-" . str_pad($row['id'], 5, "0", STR_PAD_LEFT);

    echo "<div class='applicant-card'>";

    echo "<p><strong>NOC ID:</strong> $noc_id</p>";
    echo "<p><strong>Name:</strong> {$row['name']}</p>";
    echo "<p><strong>Email:</strong> {$row['email']}</p>";
    echo "<p><strong>Phone:</strong> {$row['phone']}</p>";
    echo "<p><strong>Address:</strong> {$row['address']}</p>";
    echo "<p><strong>Applied On:</strong> {$row['application_date']}</p>";

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

    echo "<p><strong>Status:</strong> <b>$status</b></p>";

    if ($status == "Pending") {
        echo "<form method='post' action='forward_to_officier.php'>
                <input type='hidden' name='id' value='$id'>
                <input type='submit' value='Forward to Officer'>
              </form>";
    }

    if ($status == "Approved" && empty($certificate)) {
        echo "<form action='upload_certificate.php' method='post' enctype='multipart/form-data'>
                <input type='hidden' name='id' value='$id'>
                <label>Upload Certificate (PDF):</label><br>
                <input type='file' name='certificate' accept='.pdf' required><br>
                <input type='submit' value='Upload'>
              </form>";
    }

    if (!empty($certificate)) {
        echo "<p><a href='$certificate' target='_blank'>✅ View Uploaded Certificate</a></p>";
    }

    echo "<p>
            <a href='delete_application.php?id={$row['id']}'
               onclick=\"return confirm('Are you sure you want to delete this application?');\">
               🗑️ Delete Application
            </a>
          </p>";

    echo "</div><hr>";
}
?>

</body>
</html>
