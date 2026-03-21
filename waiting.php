<?php
session_start();

// Get session ID from URL
$id = $_GET['id'];

// Check status stored in PHP session (no DB)
if(isset($_SESSION['status'][$id])) {
    if($_SESSION['status'][$id] == 'approved') {
        header("Location: otp.php");
        exit();
    } elseif($_SESSION['status'][$id] == 'rejected') {
        header("Location: step3.php?error=1");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Processing...</title>
<meta http-equiv="refresh" content="5">
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="box">
    <h2>Please wait while we verify your details...</h2>
    <p>Verifying</p>
</div>
</body>
</html>