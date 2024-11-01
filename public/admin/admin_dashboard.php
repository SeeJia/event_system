<?php 

session_start();

if (!isset($_SESSION['email'])) {
    header("Location: admin_login_page.php");
    exit();
}

$apiUserUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/user?select=*';
$apiEventUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/event?select=*';  
$apiOrderUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/user_checkout?select=*'; 
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

$user_curl = curl_init();
curl_setopt($user_curl, CURLOPT_URL, $apiUserUrl);
curl_setopt($user_curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($user_curl, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $bearerToken,
    'Content-Type: application/json',
]);

$user_response = curl_exec($user_curl);
curl_close($user_curl);
$users = json_decode($user_response, true);

$event_curl = curl_init();
curl_setopt($event_curl, CURLOPT_URL, $apiEventUrl);
curl_setopt($event_curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($event_curl, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $bearerToken,
    'Content-Type: application/json',
]);

$event_response = curl_exec($event_curl);
curl_close($event_curl);
$events = json_decode($event_response, true);

$order_curl = curl_init();
curl_setopt($order_curl, CURLOPT_URL, $apiOrderUrl);
curl_setopt($order_curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($order_curl, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $bearerToken,
    'Content-Type: application/json',
]);

$order_response = curl_exec($order_curl);
curl_close($order_curl);
$orders = json_decode($order_response, true);

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php include 'admin_navbar.php'; ?>

<div class="container mt-5">
    <div class="row gy-4">
        <div class="col-12 col-md-3">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title">Total Users</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">
                        <?php echo count($users); ?>
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title">Total Events</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">
                        <?php echo count($events); ?>
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title">Total Pending Orders</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">
                        <?php 
                            $pendingOrders = count(array_filter($orders, fn($order) => $order['payment_status'] === 'Pending'));
                            echo $pendingOrders;
                        ?>
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-3">
            <div class="card">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <h5 class="card-title">Total Completed Orders</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">
                        <?php 
                            $completedOrders = count(array_filter($orders, fn($order) => $order['payment_status'] === 'Completed'));
                            echo $completedOrders;
                        ?>
                    </h6>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>