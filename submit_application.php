<?php
include("db.php");

$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$application_date = $_POST['application_date'];


$upload_dir = "uploads/";
$document_paths = [];

foreach ($_FILES['documents']['tmp_name'] as $key => $tmp_name) {
    $original_name = $_FILES['documents']['name'][$key];
    $ext = pathinfo($original_name, PATHINFO_EXTENSION);

    // Rename file as email + doc name
    $filename = $email . "_" . $key . "." . $ext;
    $target_file = $upload_dir . $filename;

    if (move_uploaded_file($tmp_name, $target_file)) {
        $document_paths[$key] = $target_file;
    } else {
        echo "Failed to upload $key";
        exit;
    }
}

// Convert document array to JSON string to store in database
$document_json = json_encode($document_paths);



$sql = "INSERT INTO applicants (name, email, phone, address, document, application_date)
        VALUES ('$name', '$email', '$phone', '$address', '$document_json', '$application_date')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Application Submitted Successfully'); window.location='index.html';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>