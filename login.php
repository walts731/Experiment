<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-image: url('img/pexels-daian-gan-102129.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: #ffffff;
    }
    .container {
        max-width: 600px;
    }
    form {
        background-color: rgba(0, 0, 0, 0.7);
        color: #ffffff;
        padding: 50px; /* Increased padding for larger height */
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .form-control {
        margin-bottom: 10px; /* Set the margin-bottom to 10 for more space between inputs */
    }
</style>


</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2 class="mb-4 text-center text-dark">Login</h2>
                <form action="login_process.php" method="post">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                    <p class="mt-3 text-center"><strong>Don't have an account? <a href="sign_up.php" class="btn btn-link text-decoration-none">Sign Up</a></strong></p>
                </form>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
