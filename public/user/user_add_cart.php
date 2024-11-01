<?php 

require '../../vendor/autoload.php'; 

session_start();

$user_id = $_GET['user_id'];
$event_id = $_GET['event_id'];

$apiUserEventUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/user_event_cart'; 
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

$user_event_data = json_encode([
    "user_id" => $user_id,
    "event_id" => $event_id,
]);

$chUser_Event = curl_init();

curl_setopt($chUser_Event, CURLOPT_URL, $apiUserEventUrl);
curl_setopt($chUser_Event, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chUser_Event, CURLOPT_POST, true);
curl_setopt($chUser_Event, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $bearerToken,
    'Content-Type: application/json',
]);

curl_setopt($chUser_Event, CURLOPT_POSTFIELDS, $user_event_data);

$user_event_response = curl_exec($chUser_Event);

curl_close($chUser_Event);

$user_events = json_decode($user_event_response, true);

header('location:user_dashboard.php');
exit();
?>
