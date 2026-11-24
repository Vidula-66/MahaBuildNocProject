<?php
$conn = new mysqli("localhost", "root", "", "mahabuildnoc");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>