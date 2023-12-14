<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Website</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        section {
            padding: 20px;
        }
        header {
            position: relative;
            background: url('img/bg.png') center center;
            background-size: cover;
            color: white; 
        }
        footer {
            background-color: #343a40; /* Same color as the navbar */
            color: white;
            text-align: center;
            padding: 10px 0; /* Add padding for better appearance */
        }
    button {
        padding: 10px 20px;
        font-size: 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    </style>
</head>
<body class="bg-secondary">
    <header class="navbar navbar-dark bg-dark">
        <div class="container">
        <img src="img/logo.png" alt="CRE8 Logo" height="30" class="px-3 rounded-circle">
            <a class="navbar-brand" href="#">Welcome to CRE8 Where Style Meets Confidence!</a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="login.php">Login</a>
                        <a class="dropdown-item" href="sign_up.php">Sign Up</a>
                    </div>
                </li>
            </ul>
        </div>
    </header>

    <div class="container mt-4 text-light">
    

<section>
    <button class="center">Shop Now</button>
</section>

        <section>
            <h2>About Us</h2>
            <p>
                Welcome to our website! We are dedicated to providing you with quality products and excellent service.
            </p>
        </section>

        <section>
            <h2>Featured Products</h2>
            <p>
                Check out our latest and featured products. We have something for everyone!
            </p>
            <!-- Bootstrap Carousel for Featured Products -->
            <div id="featuredCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
                <div class="carousel-inner text-dark">
                    <div class="carousel-item active">
                        <img src="img/r3.jpg" class="d-block mx-auto w-50" alt="Plain Shirt">
                        <div class="carousel-caption d-none d-md-block text-dark">
                            <h5>Plain Shirt</h5>
                            <p>This is a plain shirt.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/h4.jpg" class="d-block mx-auto w-50" alt="Product 2">
                        <div class="carousel-caption d-none d-md-block text-dark">
                            <h5>Hoodie</h5>
                            <p>orange hoodie. </p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/polo (2).jpg" class="d-block mx-auto w-50" alt="Product 2">
                        <div class="carousel-caption d-none d-md-block text-dark">
                            <h5>polo</h5>
                            <p>polo men.</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="img/long1.jpg" class="d-block mx-auto w-50" alt="Product 2">
                        <div class="carousel-caption d-none d-md-block text-dark">
                            <h5>sweatshirst</h5>
                            <p>green.</p>
                        </div>
                    </div>

                    <!-- Add more carousel items as needed -->
                </div>
                <a class="carousel-control-prev" href="#featuredCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#featuredCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <!-- End of Bootstrap Carousel -->
        </section>

        <section>
            <h2>Contact Us</h2>
            <p>
                If you have any questions or need assistance, feel free to <a href="contact.php">contact us</a>.
            </p>
        </section>
    </div>

    <footer class="bg-info">
        <p>&copy; <?php echo date("Y"); ?> CRE8. All rights reserved.</p>
    </footer>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap dropdowns) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

