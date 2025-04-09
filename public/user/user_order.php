<?php 

require '../../vendor/autoload.php'; 

session_start();

$user_id = $_GET['user_id'];

$user_order_URL = 'https://drudqpdgdmnjjauhbbts.supabase.co/rest/v1/user_checkout?select=*&user_id=eq.'; 
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

$user_order_curl = curl_init();
curl_setopt($user_order_curl, CURLOPT_URL, $user_order_URL .$user_id);
curl_setopt($user_order_curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($user_order_curl, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $bearerToken,
    'Content-Type: application/json',
]);

$order_response = curl_exec($user_order_curl);
curl_close($user_order_curl);

$user_orders = json_decode($order_response, true);

$event_ids = [];
foreach ($user_orders as $user_order) {
    $event_ids[] = $user_order['event_id'];
}

$event_results = [];
foreach ($event_ids as $event_id) {

    $apiEventUrl = 'https://drudqpdgdmnjjauhbbts.supabase.co/rest/v1/event?select=*';
    $ch_event = curl_init();
    curl_setopt($ch_event, CURLOPT_URL, $apiEventUrl . '&event_id=eq.' . $event_id);
    curl_setopt($ch_event, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch_event, CURLOPT_HTTPHEADER, [
        'apikey: ' . $apiKey,
        'Authorization: Bearer ' . $bearerToken,
        'Content-Type: application/json',
    ]);

    $response_event = curl_exec($ch_event);
    curl_close($ch_event);

    $event_data = json_decode($response_event, true);
    if (!empty($event_data)) {
        $event_results = array_merge($event_results, $event_data);
    }
}

foreach ($event_results as $event) {
    // var_dump($event);
}

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php include 'user_navbar.php'; ?>
<div class="container mt-5">
    <?php if (!empty($event_results)): ?>
        <?php foreach ($event_results as $event): ?>
            <?php
                // 查找与当前事件相匹配的订单
                $user_order = array_filter($user_orders, fn($order) => $order['event_id'] === $event['event_id']);
                $user_order = reset($user_order); // 获取第一个匹配项
            ?>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-2">
                            <img class="img-fluid" style="height: 100px;" src="<?php echo htmlspecialchars($event['event_image']); ?>" alt="<?php echo htmlspecialchars($event['event_name']); ?>">
                        </div>
                        <div class="col-12 col-md-8">
                            <h1><?php echo htmlspecialchars($event['event_name']); ?></h1>
                            <p>Status: <?php echo htmlspecialchars($user_order['payment_status'] ?? 'No Status'); ?></p>
                            <div class="d-flex align-items-center">
                                <p class="me-3 mb-0">Your Upload Payment Receipt:</p>
                                <?php if (!empty($user_order['payment_file'])): ?>
                                    <a class="btn btn-dark" href="<?php echo htmlspecialchars($user_order['payment_file']); ?>">Download</a>
                                <?php else: ?>
                                    <p>No Receipt Uploaded</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center d-flex justify-content-center align-items-center" style="height: 200px;">
            <p>Empty Order</p>
        </div>
    <?php endif; ?>
</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>