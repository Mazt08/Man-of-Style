<?php
// Include your database config
include('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azul Cosmetics</title>
    <link rel="stylesheet" href="landing.css">
    <link rel="icon" type="image/x-icon" href="Azul.ico">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Unna:ital,wght@1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <style>
        /*Icon*/
        .fa-solid, .material-icons {
          color: #FF6262;
        }
          
        .fa-solid:hover, .material-icons:hover {
          color: #FFA6A6;
          transition: 0.3s ease;
        }
        
        .navbar-nav, .nav-link {
            display: flex;
            align-items: center;
        }
    </style>
</head>

<body>
    <nav class="navbar sticky-top navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="azul-logo.png" alt="logo" height="60px">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navtabs" aria-controls="navtabs" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navtabs">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php"><i class="material-icons" style="font-size:46px;">home</i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="azul-login.html"><i class="fa-solid fa-user fa-2xl"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="landing">
        <div class="landing-box">
            <a href="azul-registration.html"><button class="landing-button lg-">Sign Up Now</button></a>

            <h2>"Discover beauty redefined at Azul Cosmetics. Elevate your look with our premium cosmetics and skincare essentials. Unleash confidence, embrace style - Azul, where beauty meets innovation."</h2>
        </div>
    </div>

    <div class="landing-details">
        <h2>Why Azul Cosmetics?</h2>
        <hr>

        <div class="landing-row">
            <img src="images/landing-detailspic.png" alt="">

            <p>Elevate your beauty routine with Azul Cosmetics, where quality and innovation converge. Our premium products are crafted with meticulous attention to detail, ensuring you experience the epitome of skincare and makeup excellence. Azul is more than just cosmetics; it's a celebration of individuality and style. Embrace your unique beauty confidently with our thoughtfully curated collection that caters to diverse preferences and skin tones. We take pride in our cruelty-free commitment, offering you guilt-free indulgence in products created with compassion. Choose Azul Cosmetics for an unparalleled blend of elegance, innovation, and ethical beauty practices, and let your radiance shine.</p>
        </div>
        
        <div class="landing-features">
            <span>Premium Quality</span><br>
            Azul Cosmetics takes pride in delivering premium quality products. Our cosmetics are meticulously crafted with the finest ingredients to ensure an unparalleled experience, giving you the confidence to showcase your natural beauty.
        </div>

        <div class="landing-features">
            <span>Innovative Formulations:</span><br>
            Experience the cutting edge of beauty with Azul's innovative formulations. We stay ahead of trends, offering you the latest and most effective products to enhance your skincare and makeup routine.
        </div>

        <div class="landing-features">
            <span>Elegance and Style</span><br>
            Azul Cosmetics is not just about products; it's a lifestyle. We celebrate individuality and empower you to express your unique style. Our cosmetics are designed to elevate your look, adding a touch of elegance to your everyday beauty routine.   
        </div>

        <div class="landing-features">
            <span>Cruelty-Free Commitment:</span><br>
            At Azul, we believe in beauty without compromise. All our products are cruelty-free, reflecting our commitment to ethical practices. You can indulge in our cosmetics guilt-free, knowing that they are created with compassion.    
        </div>

        <div class="landing-features">
            <span>Curated Collection: </span><br>
            Explore a thoughtfully curated collection of cosmetics that cater to diverse skin tones and preferences. Azul Cosmetics offers a range of shades and products to suit every style, making beauty accessible to everyone.  
        </div>
    </div>

    <footer class="page-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <h6 class="text-uppercase font-weight-bold">About Azul:</h6>
                    <p>At Azul, we believe beauty begins with confidence. We are a proudly local beauty shop offering a wide range of high-quality cosmetics and self-care products for every personality and style. From eye-catching eyeliners to nourishing skincare, bold lip colors to everyday hair essentials, Azul is your one-stop destination for everything beauty.</p>
                    <p>Our curated collections are designed to help you express yourself freely and feel beautiful in your own skin every day, any time. Whether you're perfecting your brows, adding a pop of blush, or simply caring for your skin, Azul is here to glow with you.</p>
                    <p>Explore beauty. Embrace confidence. Only at Azul.</p>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12">
                    <h6 class="text-uppercase font-weight-bold">Contact</h6>
                    <p>936a R-6, Project 3, Quezon City, 1014 Metro Manila<br /> azulcosmetics@gmail.com
                        <br /> +63 915 048 2884<br /> +63 995 100 6601</p>
                </div>
            </div>
        </div>
        <div class="footer-copyright text-center">
            © 2025 Copyright: azulcosmetics.com
        </div>
    </footer>
    
    <!-- Modal -->
    <div class="modal fade" id="disclaimerModal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="disclaimerLabel">Disclaimer</h5>
          </div>
          <div class="modal-body">
            This page is for student project purposes only. It is not an official store or business.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">I Understand</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      window.addEventListener('load', function () {
        var disclaimerModal = new bootstrap.Modal(document.getElementById('disclaimerModal'));
        disclaimerModal.show();
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
