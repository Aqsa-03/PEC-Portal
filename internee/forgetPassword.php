<?php
include('server.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="css/signup.css">
    <link rel="icon" type="image/x-icon" href="img\logo.png">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form action="forgetPassword.php" method="post" id="resetPasswordForm" role="form">
                    <fieldset>
                        <legend class="text-center"><h1>Reset Password</h1></legend>

                        <div class="form-group">
                            <label for="cnic"><span class="req">* </span> CNIC: </label>
                            <input required name="cnic" type="text" class="form-control" id="cnic" />
                        </div>

                        <div class="form-group">
                            <label for="new_password"><span class="req">* </span> New Password: </label>
                            <input required name="new_password" type="password" class="form-control" id="new_password" />
                        </div>

                        <div class="form-group">
                            <input class="btn" type="submit" name="submit_reset_password" value="Reset Password">
                        </div>

                        <p>
                            <a href="login.php">Back to Login</a>
                        </p>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
<?php
// Initialize variables for user input
$cnic = "";
$newPassword = "";

// Check if the form has been submitted
if (isset($_POST['submit_reset_password'])) {
    // Get user input
    $cnic = isset($_POST['cnic']) ? $_POST['cnic'] : '';
    $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';

    // Validate user input
    if (empty($cnic) || empty($newPassword)) {
        array_push($errors, "CNIC and New Password are required");
    }

    if (count($errors) == 0) {
        // Query the database to find the user based on their CNIC
        $query = "SELECT * FROM internees WHERE cnicNo='$cnic'";
        $results = mysqli_query($db, $query);

        if ($results && mysqli_num_rows($results) > 0) {
            // Reset the password for the user
            $query = "UPDATE internees SET password='$newPassword' WHERE cnicNo='$cnic'";
            mysqli_query($db, $query);

            // Notify the user that the password has been reset
            echo '<script>alert("Password has been reset successfully!");</script>';
        } else {
            array_push($errors, "CNIC not found in the database.");
        }
    }
}
?>
