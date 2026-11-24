<?php
session_start();
session_destroy();
header("Location: officier_login.php");
exit();
?>
