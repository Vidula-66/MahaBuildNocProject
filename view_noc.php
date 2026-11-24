<?php
$id = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>View NOC</title>
<style>
.btn {
  padding: 10px 15px;
  background-color: #007bff;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  margin-bottom: 20px;
  display: inline-block;
}
.btn:hover { background-color: #0056b3; }
</style>
</head>
<body>
<a class="btn" href="check_status.php">⬅ Back to Status</a>
<iframe src="print_noc.php?id=<?php echo $id; ?>" width="100%" height="600px"></iframe>
</body>
</html>
