<?php 

require '../../vendor/autoload.php'; 

$apiUrl = 'https://drudqpdgdmnjjauhbbts.supabase.co/rest/v1/event'; 
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

$apiSecretKey = $_ENV['SUPABASE_API_SECRET_KEY'];
$bearerSecretToken = $_ENV['SUPABASE_BEARER_SECRET_TOKEN'];

$event_id = $_GET['event_id'];

$select_event_data_url = 'https://drudqpdgdmnjjauhbbts.supabase.co/rest/v1/event?event_id=eq.'. $event_id;

$ch2 = curl_init();

curl_setopt($ch2, CURLOPT_URL, $select_event_data_url);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $bearerToken,
]);

$select_data_response = curl_exec($ch2);

// 检查是否有错误
if (curl_errno($ch2)) {
    echo 'cURL 错误: ' . curl_error($ch2);
} else {

    $event_data = json_decode($select_data_response, true);

    if (!empty($event_data)) {
        $imageEventURL = $event_data[0]['event_image'];
    } else {
        echo "未找到事件数据";
    }
}

$ch3 = curl_init();
curl_setopt($ch3, CURLOPT_URL, $imageEventURL);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, 'DELETE');
curl_setopt($ch3, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiSecretKey,
    'Authorization: Bearer ' . $bearerSecretToken,
]);

$deleteImageResponse = curl_exec($ch3);
$deleteImageHttpCode = curl_getinfo($ch3, CURLINFO_HTTP_CODE);

curl_close($ch2);
curl_close($ch3);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl . '?event_id=eq.' . $event_id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE'); 
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $bearerToken,
    'Content-Type: application/json',
]);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Error: ' . curl_error($ch);
} else {
    header('location: admin_event.php');
}

curl_close($ch);

?>