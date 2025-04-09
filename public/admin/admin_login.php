<?php 

require '../../vendor/autoload.php';

$apiUrl = 'https://drudqpdgdmnjjauhbbts.supabase.co/rest/v1/admin?select=*';
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

session_start();
unset($_SESSION['message']);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];
}

//curl code to connect API
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $bearerToken,
    'Content-Type: application/json',
]);

$response = curl_exec($ch);

curl_close($ch);

$admin = json_decode($response, true);

if (!empty($admin)){
    $admin_email = $admin[0]['admin_email'];
    $admin_password = $admin[0]['admin_password'];
    
    if (password_verify($password, $admin_password)) {
        header('Location: admin_dashboard.php');
        $_SESSION['email'] = $admin_email;
        unset($_SESSION['message']);
    }
    else{
        $_SESSION['message'] = 'Your email or password is incorrect!';
        header('Location: admin_login_page.php');
    }
}

?>