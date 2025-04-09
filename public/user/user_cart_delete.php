<?php 

require '../../vendor/autoload.php'; 

session_start();

$user_id = $_GET['user_id'];
$event_id = $_GET['event_id'];

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
    header('location: user_cart_list.php?user_id='. $user_id);
}

curl_close($ch);

?>