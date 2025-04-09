<?php 

require '../../vendor/autoload.php'; 

$apiUserUrl = 'https://drudqpdgdmnjjauhbbts.supabase.co/rest/v1/user?select=*&user_email=eq.'; 

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

<nav class="navbar navbar-expand-lg bg-dark sticky-top" data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand" href="user_dashboard.php">EventSystem</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="user_dashboard.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="user_event_list.php">Event</a>
        </li>
      </ul>

      <form action="user_search.php" method="POST" class="d-flex mx-auto" role="search">
        <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search" style="width: 300px;">
        <button class="btn btn-light" type="submit">Search</button>
      </form>
      
      <ul class="navbar-nav ms-auto">
      <?php foreach ($users as $user): ?>
        <li class="nav-item me-2">
          <a class="nav-link active" aria-current="page" href="user_order.php?user_id=<?php echo $user['user_id']; ?>">Order</a>
        </li>
        <li class="nav-item">
            <a href="user_cart_list.php?user_id=<?php echo $user['user_id']; ?>"><i class="bi bi-cart-fill text-light fs-4 me-3"></i></a>
        </li>
        <?php endforeach; ?>
        <li class="nav-item">
          <a class="btn btn-light" href="user_logout.php">LOGOUT</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
