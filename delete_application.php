<?php
include("db.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Get application to fetch document name
    $sql = "SELECT * FROM applicants WHERE id = $id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // File path for deletion (adjust column name as needed)
        $doc1 = $row['document1'];
        $doc2 = $row['document2'];
        // Add other document fields as needed

        // Delete uploaded files
        if (!empty($doc1) && file_exists("uploads/" . $doc1)) {
            unlink("uploads/" . $doc1);
        }
        if (!empty($doc2) && file_exists("uploads/" . $doc2)) {
            unlink("uploads/" . $doc2);
        }

        // Now delete the DB record
        $delete_sql = "DELETE FROM applicants WHERE id = $id";
        if ($conn->query($delete_sql) === TRUE) {
            // Redirect back to dashboard
            header("Location: admin_dashboard.php?deleted=1");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }

    } else {
        echo "Application not found.";
    }
} else {
    echo "Invalid request.";
}
?>
