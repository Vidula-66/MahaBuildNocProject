<?php
include("db.php");
$id = $_POST['id'];
$conn->query("UPDATE applicants SET status='Forwarded' WHERE id=$id");
header("Location: admin_dashboard.php");
?>