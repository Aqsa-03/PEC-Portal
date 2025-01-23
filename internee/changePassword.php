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
                <form action="changepassword.php" method="post" id="changepasswordForm" role="form">
                    <fieldset>
                        <legend class="text-center"><h1>Change Password</h1></legend>

                        <div class="form-group">
                            <label for="old_password"><span class="req">* </span> Old Password: </label>
                            <input required name="old_password" type="password" class="form-control inputpass" id="old_password" />
                        </div>

                        <div class="form-group">
                            <label for="new_password"><span class="req">* </span> New Password: </label>
                            <input required name="new_password" type="password" class="form-control inputpass" id="new_password" />
                        </div>

                        <div class="form-group">
                            <label for="confirm_password"><span class="req">* </span> Confirm Password: </label>
                            <input required name="confirm_password" type="password" class="form-control inputpass" id="confirm_password" />
                        </div>

                        <div class="form-group">
                            <input class="btn" type="submit" name="submit_change_password" value="Change Password">
                        </div>

                        <p>
                            <a href="index.php">Back to Dashboard</a>
                        </p>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
    <!-- Add your JavaScript and footer content here -->
</body>
</html>
<?php
// Initialize variables for user input
$oldPassword = "";
$newPassword = "";
$confirmPassword = "";

// Initialize errors array
$errors = array();

// Check if the form has been submitted
if (isset($_POST['submit_change_password'])) {
    // Get user input
    $oldPassword = isset($_POST['old_password']) ? $_POST['old_password'] : '';
    $newPassword = isset($_POST['new_password']) ? $_POST['new_password'] : '';
    $confirmPassword = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // Validate user input
    if (empty($oldPassword)) {
        array_push($errors, "Old Password is required");
    }
    if (empty($newPassword)) {
        array_push($errors, "New Password is required");
    }
    if (empty($confirmPassword)) {
        array_push($errors, "Confirm Password is required");
    }
    if ($newPassword != $confirmPassword) {
        array_push($errors, "New Password and Confirm Password do not match");
    }

    if (count($errors) == 0) {
        // Query the database to find the user based on their email
        $email = $_SESSION['email'];
        $query = "SELECT * FROM internees WHERE emailAddress='$email'";
        $results = mysqli_query($db, $query);

        if ($results && mysqli_num_rows($results) > 0) {
            $user = mysqli_fetch_assoc($results);
            
            if ($oldPassword === $user['password']) {
                // Update the user's password
                $query = "UPDATE internees SET password='$newPassword' WHERE emailAddress='$email'";
                mysqli_query($db, $query);
                echo '<script>alert("Password has been updated successfully!");</script>';

            } else {
                array_push($errors, "Old Password is incorrect.");
            }
        }
    }
}

?>