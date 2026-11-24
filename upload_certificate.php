<?php
$conn = new mysqli("localhost", "root", "", "mahabuildnoc");

$id = $_POST['id'];

$target_dir = "uploads/";
$filename = basename($_FILES["certificate"]["name"]);
$target_file = $target_dir . $filename;

if (move_uploaded_file($_FILES["certificate"]["tmp_name"], $target_file)) {
    $sql = "UPDATE applicants SET certificate='$target_file' WHERE id=$id";
    $conn->query($sql);
    echo "<script>alert('Certificate uploaded successfully'); window.location.href='admin_dashboard.php';</script>";
} else {
    echo "Error uploading file.";
}
?>