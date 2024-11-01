<?php 

require '../../vendor/autoload.php'; 

session_start();

$user_id = $_GET['user_id'];
$event_id = $_GET['event_id'];
$payment_status = $_GET['payment_status'];

if ($payment_status == 'Pending'){
    $payment_status = 'Completed';
}else{
    $payment_status = 'Pending';
}

$apiUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/user_checkout?select=*'; 
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

$data = [
    'payment_status'=> $payment_status,
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl.'&event_id=eq.'.$event_id.'&user_id=eq.'.$user_id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $bearerToken,
    'Content-Type: application/json',
]);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Error: ' . curl_error($ch);
} else {
    header('location: admin_order.php');
}

curl_close($ch);

?>

