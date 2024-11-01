<?php 

require '../../vendor/autoload.php';

$apiUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/user?select=*&user_email=eq.';
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

session_start();
unset($_SESSION['message']);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email = $_POST['email'];
    $password = $_POST['password'];
}

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $apiUrl. $email);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $bearerToken,
    'Content-Type: application/json',
]);

$response = curl_exec($ch);

curl_close($ch);

$user = json_decode($response, true);

if (!empty($user)){
    $user_email = $user[0]['user_email'];
    $user_password = $user[0]['user_password'];
    $user_id = $user[0]['user_id'];
    
    if (password_verify($password, $user_password)) {
        header('Location: user_dashboard.php');
        $_SESSION['email'] = $user_email;
        unset($_SESSION['message']);
    }
    else{
        $_SESSION['message'] = 'Your email or password is incorrect!';
        header('Location: user_login_page.php');
    }
}

?>
