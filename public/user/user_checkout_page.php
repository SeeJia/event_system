<?php 

require '../../vendor/autoload.php'; 

session_start();

$user_id = $_GET['user_id'];
$event_id = $_GET['event_id'];

$apiUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/user_event_cart?select=*';
$apiEventUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/event?select=*';
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

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

$events_list = json_decode($response_event, true);

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
    <div class="card text-center">
        <div class="card-body">
            <?php foreach ($events_list as $event): ?>
                <div class="row">
                    <div class="col-12">
                        <img style="height: 100px;" src="<?php echo htmlspecialchars($event['event_image']); ?>" alt="<?php echo htmlspecialchars($event['event_name']); ?>">
                    </div>
                    <div class="col-12">
                        <h1><?php echo htmlspecialchars($event['event_name']); ?></h1>
                    </div>
                    <div class="col-12">
                        <form id="uploadForm" action="user_checkout.php?user_id=<?php echo $user_id; ?>&event_id=<?php echo $event_id; ?>" method="POST" enctype="multipart/form-data">
                          
                            <div class="form-group d-flex justify-content-center align-items-center">
                                <label for="file" class="me-3">Upload your payment receipt:</label>
                                <input type="file" class="form-control" id="fileInput" name="file" required style="width: auto;" />
                            </div>
                            
                            <hr/>
                            <div class="col-12">
                                <button type="submit" class="btn btn-dark">Pay</button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>