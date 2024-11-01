<?php 

require '../../vendor/autoload.php'; 

session_start();

$apiUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/event?select=*'; 
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

if (!isset($_SESSION['email'])) {
    header("Location: user_login_page.php"); // Redirect to login if not logged in
    exit();
}

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

$events = json_decode($response, true);

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
    <?php
    // display event in every pages
    $eventsPerPage = 3; // number of events need to display in one page
    $totalEvents = count($events); // total events
    $totalPages = ceil($totalEvents / $eventsPerPage); // calculate total pages

    // get current page
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $currentPage = max(1, min($currentPage, $totalPages)); // 确保当前页在有效范围内

    // calculate pages
    $startIndex = ($currentPage - 1) * $eventsPerPage;
    $endIndex = min($startIndex + $eventsPerPage - 1, $totalEvents - 1);

    // show events
    for ($i = $startIndex; $i <= $endIndex; $i++):
        $event = $events[$i]; 
    ?>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-2">
                        <img class="img-fluid" style="height: 100px;" src="<?php echo htmlspecialchars($event['event_image']); ?>" alt="<?php echo htmlspecialchars($event['event_name']); ?>">
                    </div>
                    <div class="col-12 col-md-8">
                        <h1><?php echo htmlspecialchars($event['event_name']); ?></h1>
                    </div>
                    <div class="col-12 col-md-2">
                        <a href="user_add_cart.php?event_id=<?php echo $event['event_id']; ?>&user_id=<?php echo $user['user_id']; ?>" class="btn btn-dark">ADD CART</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endfor; ?>

    <!-- navbar pagination -->
    <nav>
    <ul class="pagination justify-content-center">
        <!-- Previous button -->
        <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
            <a class="page-link" href="<?php echo $currentPage > 1 ? '?page=' . ($currentPage - 1) : '#'; ?>">Previous</a>
        </li>

        <!-- Page numbers -->
        <?php for ($page = 1; $page <= $totalPages; $page++): ?>
            <li class="page-item <?php echo $page == $currentPage ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
            </li>
        <?php endfor; ?>

        <!-- Next button -->
        <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
            <a class="page-link" href="<?php echo $currentPage < $totalPages ? '?page=' . ($currentPage + 1) : '#'; ?>">Next</a>
        </li>
    </ul>
</nav>

</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>