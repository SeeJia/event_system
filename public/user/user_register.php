<?php

require '../../vendor/autoload.php';

session_start();

$apiUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/user';
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';

    if (!preg_match($passwordPattern, $password)) {
        $_SESSION['message'] = "Your password must be at least 8 characters long and include at least one number, one lowercase letter, one uppercase letter, and one special character";
        header('Location: user_register_page.php');
        exit();
    }

    // Step 1: Check if email already exists
    $ch = curl_init();
    $checkUrl = $apiUrl . '?user_email=eq.' . urlencode($email); // URL for checking email
    curl_setopt($ch, CURLOPT_URL, $checkUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $apiKey,
        'Authorization: Bearer ' . $bearerToken,
        'Content-Type: application/json',
    ]);

    $emailCheckResponse = curl_exec($ch);
    $existingUsers = json_decode($emailCheckResponse, true);

    if (!empty($existingUsers)) {
        // Email already registered
        $_SESSION['message'] = "This email is already registered!";
        header('Location: user_register_page.php');
        curl_close($ch);
        exit();
    }
    curl_close($ch);

    // Step 2: If email is unique, proceed with registration
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $data = json_encode([
        "user_email" => $email,
        "user_password" => $password_hash,
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
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }

    curl_close($ch);

    $todos = json_decode($response, true);

    header("Location: ../../index.php");
    unset($_SESSION['message']);
    exit();
}
?>
