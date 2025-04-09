<?php

require '../../vendor/autoload.php'; 

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    
    $user_email = $_SESSION['email'];
    $user_id = $_GET['user_id'];
    $event_id = $_GET['event_id'];
    $payment_status = 'Pending';
    $file = $_FILES['file'];

    date_default_timezone_set('Asia/Kuala_Lumpur'); // 设置为马来西亚时区
    $currentTime = date('Y-m-d H:i:s'); // 格式为 'YYYY-MM-DD HH:MM:SS'

    $apiPaymentStorage = 'https://drudqpdgdmnjjauhbbts.supabase.co/storage/v1/object/payment-receipt/';
    $apiSecretKey = $_ENV['SUPABASE_API_SECRET_KEY'];
    $bearerSecretToken = $_ENV['SUPABASE_BEARER_SECRET_TOKEN'];
    
    $payment_receipt_curl = curl_init();
    $uniqueFileName = time() . '_' . basename($file['name']);
    $fileUrl = $apiPaymentStorage . $uniqueFileName;
    
    curl_setopt($payment_receipt_curl, CURLOPT_URL, $apiPaymentStorage . $uniqueFileName);
    curl_setopt($payment_receipt_curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($payment_receipt_curl, CURLOPT_POST, true);
    curl_setopt($payment_receipt_curl, CURLOPT_HTTPHEADER, [
        'apikey: ' . $apiSecretKey,
        'Authorization: Bearer ' . $bearerSecretToken,
        'Content-Type: application/octet-stream',
    ]);
    curl_setopt($payment_receipt_curl, CURLOPT_POSTFIELDS, file_get_contents($file['tmp_name']));
    
    $storage_response = curl_exec($payment_receipt_curl);
    $httpCode = curl_getinfo($payment_receipt_curl, CURLINFO_HTTP_CODE);
    
    curl_close($payment_receipt_curl);

    $apiEventUrl = 'https://drudqpdgdmnjjauhbbts.supabase.co/rest/v1/user_event_cart';
    $apiKey = $_ENV['SUPABASE_API_KEY'];
    $bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiEventUrl . '?event_id=eq.' . $event_id . '&user_id=eq.' . $user_id);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); // 使用 DELETE 方法删除数据
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $apiKey,
        'Authorization: Bearer ' . $bearerToken,
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        
        echo 'Error: ' . curl_error($ch);

    } else {
        $apiCheckoutUrl = 'https://drudqpdgdmnjjauhbbts.supabase.co/rest/v1/user_checkout';

    $user_checkout_data = json_encode([
        "user_id" => $user_id,
        "event_id" => $event_id,
        "user_email" => $user_email,
        "payment_status" => $payment_status,
        "payment_file" => $fileUrl,
        "checkout_date" => $currentTime,
    ]);

    $user_checkout = curl_init();

    curl_setopt($user_checkout, CURLOPT_URL, $apiCheckoutUrl);
    curl_setopt($user_checkout, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($user_checkout, CURLOPT_POST, true);
    curl_setopt($user_checkout, CURLOPT_HTTPHEADER, [
        'apikey: ' . $apiKey,
        'Authorization: Bearer ' . $bearerToken,
        'Content-Type: application/json',
    ]);

    curl_setopt($user_checkout, CURLOPT_POSTFIELDS, $user_checkout_data);

    $user_checkout_response = curl_exec($user_checkout);

    curl_close($user_checkout);

    $user_checkout_event = json_decode($user_checkout_response, true);

    header('location:user_cart_list.php?user_id='. $user_id);
    exit();

    }
    curl_close($ch);
}

?>