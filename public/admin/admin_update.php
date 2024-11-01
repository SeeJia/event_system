<?php 

ob_start(); // 启动输出缓冲

require '../../vendor/autoload.php'; 

$apiUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/event'; 
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

$imageUploadUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/storage/v1/object/event_image/'; 
$apiSecretKey = $_ENV['SUPABASE_API_SECRET_KEY'];
$bearerSecretToken = $_ENV['SUPABASE_BEARER_SECRET_TOKEN'];

$event_id = $_POST['event_id'];
$event_name = $_POST['event_name'];
$event_description = $_POST['event_description'];

function uploadImage($file) {
    global $imageUploadUrl, $apiSecretKey, $bearerSecretToken;

    $ch = curl_init();
    $uniqueFileName = time() . '_' . basename($file['name']); 

    curl_setopt($ch, CURLOPT_URL, $imageUploadUrl . $uniqueFileName);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $apiSecretKey,
        'Authorization: Bearer ' . $bearerSecretToken,
        'Content-Type: application/octet-stream',
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents($file['tmp_name']));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        echo "Upload Failed!: " . curl_error($ch);
        curl_close($ch);
        return null;
    }

    curl_close($ch);

    echo "HTTP Status Code: " . $httpCode . "\n";
    echo "Response: " . $response . "\n";

    if ($httpCode == 200) {
        return $imageUploadUrl . $uniqueFileName;
    } else {
        echo "Upload failed with response code: " . $httpCode;
        return null;
    }
}

$file_url = '';

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

    $select_event_data_url = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/event?event_id=eq.'. $event_id;

    $ch2 = curl_init();

    curl_setopt($ch2, CURLOPT_URL, $select_event_data_url);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, [
        'apikey: ' . $apiKey,
        'Authorization: Bearer ' . $bearerToken,
    ]);

    $select_data_response = curl_exec($ch2);

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

    $eventImageUrl = uploadImage($_FILES['file']);
}

if ($eventImageUrl) {

$data = [
    'event_name' => $event_name,
    'event_description' => $event_description,
    'event_image' => $eventImageUrl,
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl . '?event_id=eq.' . $event_id);
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
    header('location: admin_event.php');
}

curl_close($ch);

}

else{
    $data = [
        'event_name' => $event_name,
        'event_description' => $event_description,
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl . '?event_id=eq.' . $event_id);
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
        header('location: admin_event.php');
    }
    
    curl_close($ch);
}

ob_end_flush(); // 发送输出
?>
