<?php

require '../../vendor/autoload.php'; 

session_start();

$apiSearchUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/event?select=*&event_name=eq.'; 
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $search_event = $_POST['search'];

    $search_curl = curl_init();

    curl_setopt($search_curl, CURLOPT_URL, $apiSearchUrl . $search_event);
    curl_setopt($search_curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($search_curl, CURLOPT_HTTPHEADER, [
        'apikey: ' . $apiKey,
        'Authorization: Bearer ' . $bearerToken,
        'Content-Type: application/json',
    ]);

    $response_search = curl_exec($search_curl);

    curl_close($search_curl);

    $search_results = json_decode($response_search, true);

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
    <?php if (!empty($search_results)): ?>
        <?php foreach ($search_results as $search): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-2">
                            <img class="img-fluid" style="height: 100px;" src="<?php echo htmlspecialchars($search['event_image']); ?>" alt="<?php echo htmlspecialchars($search['event_name']); ?>">
                        </div>
                        <div class="col-12 col-md-8">
                            <h1><?php echo htmlspecialchars($search['event_name']); ?></h1>
                        </div>
                        <div class="col-12 col-md-2">
                            <a href="user_add_cart.php?event_id=<?php echo $search['event_id']; ?>&user_id=<?php echo $user['user_id']; ?>" class="btn btn-dark">ADD CART</a>
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