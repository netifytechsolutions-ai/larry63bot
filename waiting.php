<?php
$id = $_GET['id'];
 $conn = new mysqli("localhost","root","","loan-db");

// check status
$result = $conn->query("SELECT status FROM user_details WHERE id=$id");
$row = $result->fetch_assoc();

// if approved → go next page
if($row['status'] == 'approved'){
    header("Location: otp.php");
    exit();
}

if($row['status'] == 'rejected'){
    header("Location: step3.php?error=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Processing...</title>

<!-- auto refresh every 5 seconds -->
<meta http-equiv="refresh" content="5">

<link rel="stylesheet" href="style.css">
</head>

<body>

<div class="box">
    <h2>please wait while we verify your details...</h2>
    <p>verifying</p>
</div>

</body>
</html>