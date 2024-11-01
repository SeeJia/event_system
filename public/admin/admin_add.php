<?php

ob_start(); // 启动输出缓冲

require '../../vendor/autoload.php'; 

$apiUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/event';
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

$imageUploadUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/storage/v1/object/event_image/'; 
$apiScretKey = $_ENV['SUPABASE_API_SECRET_KEY'];
$bearerScretToken = $_ENV['SUPABASE_BEARER_SECRET_TOKEN'];

function uploadImage($file) {
    global $imageUploadUrl, $apiScretKey, $bearerScretToken;

    $ch = curl_init();
    $uniqueFileName = time() . '_' . basename($file['name']); 

    curl_setopt($ch, CURLOPT_URL, $imageUploadUrl . $uniqueFileName);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $apiScretKey,
        'Authorization: Bearer ' . $bearerScretToken,
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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $eventName = $_POST['event_name'];
    $eventDescription = $_POST['event_description'];
    
    // 上传图像并获取图像 URL
    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {

        $eventImageUrl = uploadImage($_FILES['file']);
        
        if ($eventImageUrl) {
            $data = json_encode([
                "event_name" => $eventName,
                "event_description" => $eventDescription,
                "event_image" => $eventImageUrl // 包含图像 URL
            ]);
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'apikey: ' . $apiKey,
                'Authorization: Bearer ' . $bearerToken,
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // 发送数据
        
            $response = curl_exec($ch);
        
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
        
            curl_close($ch);
        
            header("Location: admin_event.php"); 
            exit();
        }
    } else {
        echo "Image upload failed!";
        exit();
    }
}

ob_end_flush(); // 发送输出
?>
