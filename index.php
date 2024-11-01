<!-- $2y$10$msNbL.tJHJlkJI21JBYnguiGWKgIGnUz7W0QqjUwB3Ib4c.XHBAwi -->

<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-dark sticky-top" data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand">EventSystem</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#event">Event</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#company">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#contact">Contact</a>
        </li>
      </ul>
    <div class="d-flex">
        <a href="public/user/user_login_page.php" class="btn btn-light">Login</a>
    </div>
    </div>
  </div>
</nav>

<section id="carousel" class="mt-5">
<div class="container">
  <div id="carouselAdvertisementSlide" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselAdvertisementSlide" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselAdvertisementSlide" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselAdvertisementSlide" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    
    <div class="carousel-inner">
        <div class="carousel-item active">
          <img style="height: 500px;" src="./public/image/surfing-8065035_1280.jpg" class="d-block w-100" alt="Event Image">
        </div>
        <div class="carousel-item">
          <img style="height: 500px;" src="./public/image/jogging-4211946_1280.jpg" class="d-block w-100" alt="Event Image">
        </div>
        <div class="carousel-item">
          <img style="height: 500px;" src="./public/image/mountain-climber-2427191_1280.jpg" class="d-block w-100" alt="Event Image">
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
</section>

<section id="event">
<div class="container my-5">
  <h5 class="text-center mb-4">Our Events</h5>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lorem ipsum dolor 1</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sit amet accumsan arcu. Praesent euismod neque non risus gravida, ac facilisis nisi sodales.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lorem ipsum dolor 2</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sit amet accumsan arcu. Praesent euismod neque non risus gravida, ac facilisis nisi sodales.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Lorem ipsum dolor 3</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sit amet accumsan arcu. Praesent euismod neque non risus gravida, ac facilisis nisi sodales.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<section id="company">
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Our Company</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque sit amet accumsan arcu. Proin id sagittis felis. Suspendisse potenti. Integer in venenatis metus. Nullam vehicula dui ac turpis luctus, nec tincidunt erat fringilla. Donec dapibus enim vel nisl tincidunt, a auctor mi tempor. Donec vel massa purus. Vivamus sit amet scelerisque velit.</p>
                    <p class="card-text">Etiam dictum, nulla ut pellentesque volutpat, est erat volutpat mi, sed accumsan ligula nunc eget libero. Vivamus in ultricies purus. Sed bibendum fringilla lacus, sit amet auctor risus varius sit amet. Sed convallis, arcu ac volutpat dapibus, dolor dui consequat arcu, sed tincidunt massa libero at odio.</p>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<section id="contact">
  <div class="container my-5">
      <div class="row">
          <div class="col-12">
              <div class="card">
                  <div class="card-body">
                      <h5 class="card-title">Our Contact</h5>
                      <p class="card-text">Company Address: Lorem ipsum</p>
                      <p class="card-text">Company Phone Number: Lorem ipsum</p>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>

<footer class="bg-dark text-white py-4">
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-md-4 mb-3">
                <h4>EventSystem</h4>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <h5>Links</h5>
                <div class="row">
                    <a href="index.php" class="mt-2 link-light link-underline-opacity-0">Home</a>
                    <a href="#event" class="mt-2 link-light link-underline-opacity-0">Event</a>
                    <a href="#about" class="mt-2 link-light link-underline-opacity-0">About</a>
                    <a href="#contact" class="mt-2 link-light link-underline-opacity-0">Contact</a>
                </div>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <h5>Social Media</h5>
                <a href="https://www.facebook.com/" class="mt-2 link-light link-underline-opacity-0"><i class="bi bi-facebook fs-2"></i></a>
                <a href="https://web.whatsapp.com/" class="mt-2 link-light link-underline-opacity-0"><i class="bi bi-whatsapp fs-2 ms-2"></i></a>
                <a href="https://www.instagram.com/" class="mt-2 link-light link-underline-opacity-0"><i class="bi bi-instagram fs-2 ms-2"></i></a>
            </div>
        </div>
    </div>
</footer>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
</body>
</html>
