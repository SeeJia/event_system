<?php 

require '../../vendor/autoload.php'; 

session_start();

$apiUrl = 'https://drudqpdgdmnjjauhbbts.supabase.co/rest/v1/user_checkout?select=*'; 
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

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

$orders = json_decode($response, true);

?>

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php include 'admin_navbar.php'; ?>

<div class="container mt-5">
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search orders...">
    </div>
    <table class="table">
    <thead class="table-dark">
        <tr>
        <th scope="col">Order ID</th>
        <th scope="col">User ID</th>
        <th scope="col">User Email</th>
        <th scope="col">Event ID</th>
        <th scope="col">Payment Status</th>
        <th scope="col">Payment Receipt</th>
        <th scope="col">Payment Approved</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
        <th scope="row"><?php echo $order['cart_checkout_id']; ?></th>
        <td><?php echo $order['user_id']; ?></td>
        <td><?php echo $order['user_email']; ?></td>
        <td><?php echo $order['event_id']; ?></td>
        <td><?php echo $order['payment_status']; ?></td>
        <td><a href="<?php echo $order['payment_file']; ?>" class="btn btn-dark">Download</a></td>
        <td><a href="admin_update_order.php?event_id=<?php echo $order['event_id']; ?>&user_id=<?php echo $order['user_id']; ?>&payment_status=<?php echo $order['payment_status']; ?>" class="btn btn-dark">
            <?php if($order['payment_status'] == 'Pending'){
                echo 'Completed';
            } else {
                echo 'Pending';
            }
            ?>
            </a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div>

<script src="js/search_table.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>