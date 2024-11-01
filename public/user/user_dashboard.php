<?php 

require '../../vendor/autoload.php'; 

session_start();

$apiUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/event?limit=12'; 
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

$apiUserUrl = 'https://rrbelxfhgynojbawqdkl.supabase.co/rest/v1/user?select=*&user_email=eq.'; 

$chUser = curl_init();

curl_setopt($chUser, CURLOPT_URL, $apiUserUrl .$_SESSION['email']);
curl_setopt($chUser, CURLOPT_RETURNTRANSFER, true);
curl_setopt($chUser, CURLOPT_HTTPHEADER, [
    'apikey: ' . $apiKey,
    'Authorization: Bearer ' . $bearerToken,
    'Content-Type: application/json',
]);

$response_user = curl_exec($chUser);

curl_close($chUser);

$users = json_decode($response_user, true);

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

<div class="container mt-4">
  <?php foreach ($users as $user): ?>
    <h5>Welcome, <?php echo $user['user_email']; ?></h5>
  <?php endforeach; ?>
</div>

<div class="container">
  
  <div id="carouselAdvertisementSlide" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselAdvertisementSlide" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselAdvertisementSlide" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselAdvertisementSlide" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    
    <div class="carousel-inner">
        <div class="carousel-item active">
          <img style="height: 500px;" src="../image/surfing-8065035_1280.jpg" class="d-block w-100" alt="Event Image">
        </div>
        <div class="carousel-item">
          <img style="height: 500px;" src="../image/jogging-4211946_1280.jpg" class="d-block w-100" alt="Event Image">
        </div>
        <div class="carousel-item">
          <img style="height: 500px;" src="../image/mountain-climber-2427191_1280.jpg" class="d-block w-100" alt="Event Image">
        </div>
    </div>
    
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselAdvertisementSlide" data-bs-slide="prev">
      <i style="font-size: 50px;" class="bi bi-arrow-left-circle-fill"></i>
      <span class="visually-hidden">Previous</span>
    </button>
    
    <button class="carousel-control-next" type="button" data-bs-target="#carouselAdvertisementSlide" data-bs-slide="next">
      <i style="font-size: 50px;" class="bi bi-arrow-right-circle-fill"></i>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  
</div>

<div class="container mt-5">
  <div class="row">
    <div class="col-6">
      <h5 class="mb-3">OUR EVENT</h5>
    </div>
    <div class="col-6 text-end">
      <button id="prev_btn" onclick="moveCarousel(-2)" class="btn btn-dark mb-3 mr-1">
        <i class="bi bi-arrow-left"></i>
      </button>
      <button id="next_btn" onclick="moveCarousel(2)" class="btn btn-dark mb-3">
        <i class="bi bi-arrow-right"></i>
      </button>
    </div>
  </div>

  <div id="eventCarouselCard" class="carousel carousel-dark slide" data-bs-ride="false">
    <div class="carousel-inner">
      <?php foreach (array_chunk($events, 4) as $index => $eventRow): // 每4个事件作为一组 ?>
        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
          <div class="row">
            <?php foreach ($eventRow as $event): ?>
              <div class="col-md-3 mb-3"> <!-- 每个事件占4列，确保这里的col在循环内部 -->
                <div class="card">
                  <input type="hidden" name="id" value="<?php echo $event['event_id']; ?>">
                  <img style="height:200px;" class="img-fluid" alt="Event Image" src="<?php echo $event['event_image']; ?>">
                  <div class="card-body">
                    <h5><?php echo $event['event_name']; ?></h5>
                    <p><?php echo $event['event_description']; ?></p>
                    <a href="user_add_cart.php?event_id=<?php echo $event['event_id']; ?>&user_id=<?php echo $user['user_id']; ?>" class="btn btn-dark">ADD CART</a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script src="js/carousel.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>