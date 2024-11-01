<?php 

require '../../vendor/autoload.php'; 

session_start();

$apiUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/event?select=*'; 
$apiKey = $_ENV['SUPABASE_API_KEY'];
$bearerToken = $_ENV['SUPABASE_BEARER_TOKEN'];

if (!isset($_SESSION['email'])) {
    header("Location: admin_login.php"); // Redirect to login if not logged in
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

$_SESSION['email'];

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$apiSearchUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/event?select=*&event_name=eq.'; 

$search_curl = curl_init();

curl_setopt($search_curl, CURLOPT_URL, $apiSearchUrl . $search);
curl_setopt($search_curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($search_curl, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $bearerToken,
    'Content-Type: application/json',
]);

$response_search = curl_exec($search_curl);

curl_close($search_curl);

$search_results = json_decode($response_search, true);

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

<div class="container mt-4">
    <?php if (isset($_SESSION['email'])): ?>
        <a href="#" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addEventModal">NEW EVENT</a>
    <?php endif; ?>
</div>

<div class="container mt-4">
    <form class="d-flex" role="search" method="GET" action="">
        <input class="form-control me-2" type="search" name="search" placeholder="Search event" aria-label="Search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
</div>

<div class="container mt-4">
    <div class="row"> <!-- Add this row wrapper -->
    <?php if (!empty($search_results)): ?>
        <?php foreach ($search_results as $search): ?>
        <div class="col-12 col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <form method="POST" action="" id="form">
                        <input type="hidden" name="id" value="<?php echo $search['event_id']; ?>">
                        <div class="d-flex justify-content-end">
                            <a href="#" class="btn btn-dark me-2" data-bs-toggle="modal" data-bs-target="#updateModal" onclick="populateUpdateModal(<?php echo htmlspecialchars(json_encode($search), ENT_QUOTES, 'UTF-8'); ?>)">Update</a>
                            <a href="admin_delete.php?event_id=<?php echo $search['event_id']; ?>" class="btn btn-danger">Delete</a>
                        </div>
                        <div class="mb-3">
                            <label for="event_name" class="form-label">Event Name</label>
                            <input type="text" id="event_name" name="title" class="form-control" value="<?php echo $search['event_name']; ?>" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="event_description" class="form-label">Event Description</label>
                            <textarea id="event_description" name="description" class="form-control" rows="4" required readonly><?php echo $search['event_description']; ?></textarea>
                        </div>
                        <div class="mb-3">
                            <img style="height: 190px; width: 400px;" src="<?php echo $search['event_image']; ?>" class="img-fluid" alt="Event Image">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($events)): ?>
        <?php foreach ($events as $event): ?>
            <?php if (!in_array($event, $search_results)): // Prevent duplicate display ?>
                <div class="col-12 col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <form method="POST" action="" id="form">
                                <input type="hidden" name="id" value="<?php echo $event['event_id']; ?>">
                                <div class="d-flex justify-content-end">
                                    <a href="#" class="btn btn-dark me-2" data-bs-toggle="modal" data-bs-target="#updateModal" onclick="populateUpdateModal(<?php echo htmlspecialchars(json_encode($event), ENT_QUOTES, 'UTF-8'); ?>)">Update</a>
                                    <a href="admin_delete.php?event_id=<?php echo $event['event_id']; ?>" class="btn btn-danger">Delete</a>
                                </div>
                                <div class="mb-3">
                                    <label for="event_name" class="form-label">Event Name</label>
                                    <input type="text" id="event_name" name="title" class="form-control" value="<?php echo $event['event_name']; ?>" required readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="event_description" class="form-label">Event Description</label>
                                    <textarea id="event_description" name="description" class="form-control" rows="4" required readonly><?php echo $event['event_description']; ?></textarea>
                                </div>
                                <div class="mb-3">
                                    <img style="height: 190px; width: 400px;" src="<?php echo $event['event_image']; ?>" class="img-fluid" alt="Event Image">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="text-center d-flex justify-content-center align-items-center" style="height: 200px;">
            <p>Empty Event</p>
        </div>
    <?php endif; ?>
    </div> <!-- Close row -->
</div>

<?php include 'add_modal.php'; ?>

<?php include 'update_modal.php'; ?>

<script src="js/updateModal.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>