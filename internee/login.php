<?php session_start(); ?>
<?php
// Start a new or resume an existing session


// Initialize variables for user input
$name = "";
$ntn = "";
$email = "";
$password = "";

// Initialize errors array
$errors = array();

// Database connection settings
$server = "localhost";
$username = "root";
$password = "";
$dbname = "fyp";

// Create a connection to the database
$db = new mysqli($server, $username, $password, $dbname);

// Check the connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Check if the form has been submitted
if (isset($_POST['submit_reg'])) {
    // Get user input
    $ntn = isset($_POST['ntn']) ? $_POST['ntn'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    echo $ntn;
    echo $email;
    echo $password;

    // Validate user input
    if (empty($ntn)) {
        array_push($errors, "NTN Number is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        // Query the database to find a matching user
        $query = "SELECT * FROM internees WHERE (ntnNumber='$ntn')";
        $results = mysqli_query($db, $query);
        
        $user = mysqli_fetch_assoc($results);
        
        if ($password === $user['password']) {

            // User found, set session variables and redirect
                $_SESSION['internee_id'] = $user['id'];
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in!";
                $_SESSION['name'] = $user['fullName'];
                $_SESSION['ntn'] = $user['ntnNumber'];
                $_SESSION['cnic'] = $user['cnicNo'];
                $_SESSION['dateOfBirth'] = $user['dateofBirth'];
                $_SESSION['gradYear'] = $user['graduationYear'];
                $_SESSION['education'] = $user['education'];
                $_SESSION['discipline'] = $user['discipline'];
                $_SESSION['industry'] = $user['industry'];
                $_SESSION['city'] = $user['preferredCity'];
                 header('location: index.php');
                 exit();
            } else {
                array_push($errors, "Login failed. Please check your credentials.");
            }

    }
}

include('errors.php');
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
    <link rel="icon" type="image/x-icon" href="img\logo.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Document</title>
    <style>

    </style>
</head>

<body>
    <form action="login.php" method="post" id="fileForm" role="form">
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
                                <h6 class="sign mb-0 mr-4 mt-2">Sign In As Internee/Engineer</h6>
                            </div>
                            <div class="row px-3 mb-4">
                                <div class="line"></div>
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm"><span class="req" style="color:red;">* </span><b>Enter Engineer ID</b> &nbsp;&nbsp;
                                    </h6>
                                </label>
                                <input  type="text" name="ntn" id="ntn"
                                placeholder="12345/civil " required />
                                <div class="error-message mb-2" id="errNtn" style="color: red;"></div>
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm"><span class="req" style="color:red;">*</span><b> Email
                                            Address</b> &nbsp;&nbsp;(For Registered Internees)</h6>
                                </label>
                                <input class="form-control mb-3" class="form-control" required type="email" name="email" id="email"/>
                                <div class="status"></div>
                                <div id="errEmail" class="error-message" style="color: red;"></div>
                            </div>
                            <div class="row px-3">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm"><span class="req" style="color:red;">*
                                        </span><b>Password</b> &nbsp;&nbsp;</h6>
                                </label>
                                <div class="input-group">
                                    <input  required name="password" type="password" class="form-control inputpass"
                                id="password" />
                                    <div class="input-group-append" style="position: relative;">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword"
                                            style="left: 1px; top:2px">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                </div>



                                <div id="errPassword" class="error-message" style="color: red;"></div>
                            </div>


                            <div class="row px-3 mb-4">
                                <a href="forgetPassword.php" class="ml-auto mb-1 text-sm fw-bold mt-2">Forgot Password?</a>
                            </div>
                            <div class="row mb-3 px-3 mt-3">
                                <input type="submit" name="submit_reg" class="btn btn-blue text-center" value="Login"/>
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
    <script>
    document.addEventListener('DOMContentLoaded', function () {
    var passwordInput = document.getElementById('password');
    var togglePasswordButton = document.getElementById('togglePassword');

    togglePasswordButton.addEventListener('click', function () {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
        } else {
            passwordInput.type = 'password';
        }
    });
});
  </script>
 

    <script src="js/signup.js"></script>


</body>

</html>
