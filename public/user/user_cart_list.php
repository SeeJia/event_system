<?php 

require '../../vendor/autoload.php'; 

session_start();

$user_id = $_GET['user_id'];

$apiUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/user_event_cart?select=*';
$apiEventUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/event?select=*';
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

// 查询用户事件
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl . '&user_id=eq.' . $user_id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $bearerToken,
    'Content-Type: application/json',
]);

$response = curl_exec($ch);
curl_close($ch);

$user_events = json_decode($response, true);

// 确保响应有效
// if (empty($user_events)) {
//     header('location: user_cart_list.php?user_id='.$user_id);
// }

$event_ids = [];
foreach ($user_events as $user_event) {
    $event_ids[] = $user_event['event_id'];
}

// 查询事件
$event_results = [];
foreach ($event_ids as $event_id) {
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

    // 解析事件响应并存储结果
    $event_data = json_decode($response_event, true);
    if (!empty($event_data)) {
        $event_results = array_merge($event_results, $event_data);
    }
}

// 输出事件结果
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

<?php require 'user_navbar.php'; ?>

<div class="container mt-5">
    <?php if (!empty($event_results)): ?>
        <?php foreach ($event_results as $event): ?>
            <div class="card mb-3"> 
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-2">
                            <img style="height: 100px;" src="<?php echo htmlspecialchars($event['event_image']); ?>" alt="<?php echo htmlspecialchars($event['event_name']); ?>">
                        </div>
                        <div class="col-12 col-md-8">
                            <h1><?php echo htmlspecialchars($event['event_name']); ?></h1>
                        </div>
                        <div class="col-12 col-md-2">
                            <a href="user_checkout_page.php?user_id=<?php echo $user_event['user_id']; ?>&event_id=<?php echo $event['event_id']; ?>" class="btn btn-dark">Check Out</a>
                            <a href="user_cart_delete.php?user_id=<?php echo $user_event['user_id']; ?>&event_id=<?php echo $event['event_id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="card">
            <div class="card-body">
            <div class="text-center d-flex justify-content-center align-items-center" style="height: 200px;">
                <p>Empty Cart</p>
            </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>