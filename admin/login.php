<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the form is submitted
    $email = $_POST['cEmail'];
    $password = $_POST['password'];

    // Replace the following with your actual credentials
    $validEmail = 'aqsa368945@gmail.com';
    $validPassword = 'abcd1234';

    if ($email == $validEmail && $password == $validPassword) {
        // Authentication successful
        $_SESSION['user_email'] = $email;
        header('Location: adminDashboard.php'); // Redirect to the admin dashboard
        exit();
    } else {
        // Authentication failed
        echo '<script>alert("Email or password is incorrect. Try to login only if you are admin.");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="icon" type="image/x-icon" href="logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Admin Login</title>
    <style>

    </style>
</head>

<body>
    <form method="post" action="login.php" id="fileForm" role="form">
        <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
            <div class="card card0 border-0">
                <div class="row d-flex">
                    <div class="col-lg-6">
                        <div class="card1 pb-5">
                            <div class="row">
                                <img src="./img/logo.png" class="logo">
                                <p class="text">Pakistan Engineering Council <br>
                                <p class="text1">INTERNEE PORTAL</p>
                                </p>
                            </div>
                            <div class="row px-3 justify-content-center mt-4 mb-5 border-line">
                                <img src="./img/picture.png" class="image">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card2 card border-0 px-4 py-5">
                            <div class="row mb-2 px-3">
                                <h6 class="sign mb-0 mr-4 mt-2">Sign In As Admin</h6>
                            </div>
                            <div class="row px-3 mb-4">
                                <div class="line"></div>
                            </div>
                           
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm"><span class="req" style="color:red;">*</span><b> Email
                                            Address</b> &nbsp;&nbsp;(For admins only)</h6>
                                </label>
                                <input class="form-control mb-3" required type="email" name="cEmail" id="cemail"
                                    placeholder="Enter Email" />
                                <div class="status"></div>
                                <div class="error-message mb-2" id="cerrEmail" style="color: red;"></div>
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm"><span class="req" style="color:red;">*
                                        </span><b>Password</b> &nbsp;&nbsp;</h6>
                                </label>
                                <div class="input-group">
                                    <input required name="password" type="password" class="form-control inputpass"
                                        id="password" />
                                    <div class="input-group-append" style="position: relative;">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                            style="left: 10px; top:2px">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                </div>



                                <div id="errPassword" class="error-message mb-2" style="color: red;"></div>
                            </div>


                            
                            <div class="row mb-3 px-3 mt-3">
                                <button type="submit" name="submit_reg" class="btn btn-blue text-center"> Login</button>
                            </div>
                            <div class="row mb-4 px-3">
                                <small class="font-weight-bold">Don't have an account? <a href="signup.php"
                                        class="text-danger ">Register</a></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Add this script to your HTML file or include it in a separate JS file -->


    <script src="js/signup.js"></script>
</body>

</html>