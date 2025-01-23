<?php
// Initialize session
session_start();

// Initialize variables to store user input and errors
$name = "";
$ntn = "";
$cnic = "";
$email = "";
$phone = "";
$dateOfBirth = "";
$gradYear = "";
$education = "";
$discipline = "";
$industry = "";
$city = "";
$address = "";
$resume = "";
$password = "";
$cpassword = "";

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

// Registration form handling
if (isset($_POST['submit_reg'])) {
    // Get form data
    $name = $_POST['name'];
    $ntn = $_POST['ntn'];
    $cnic = $_POST['cnic'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dateOfBirth = $_POST['dateOfBirth'];
    $gradYear = $_POST['gradYear'];
    $education = $_POST['education'];
    $discipline = $_POST['discipline'];
    $industry = $_POST['industry'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    $resume = $_FILES['resume']['name']; // Handle file uploads
    $password = $_POST['password'];
    $cpassword = $_POST['confirmPassword'];

    // Check if CNIC exists in the database
    $checkCnicQuery = "SELECT COUNT(*) as cnicCount FROM internees WHERE cnicNo = ?";
    $stmt = $db->prepare($checkCnicQuery);
    $stmt->bind_param("s", $cnic);
    $stmt->execute();
    $result = $stmt->get_result();
    $cnicCount = $result->fetch_assoc()['cnicCount'];

    // Check if NTN exists in the database
    $checkNtnQuery = "SELECT COUNT(*) as ntnCount FROM internees WHERE ntnNumber = ?";
    $stmt = $db->prepare($checkNtnQuery);
    $stmt->bind_param("s", $ntn);
    $stmt->execute();
    $result = $stmt->get_result();
    $ntnCount = $result->fetch_assoc()['ntnCount'];

    if ($cnicCount > 0) {
        // CNIC exists in the database, show an alert
        echo '<script>alert("CNIC is invalid. It already exists in the database.")</script>';
    } elseif ($ntnCount > 0) {
        // NTN exists in the database, show an alert
        echo '<script>alert("NTN is invalid. It already exists in the database.")</script>';
    } else {
        // Both CNIC and NTN are valid, proceed with registration

        // Validate form input
        if (empty($name) || empty($ntn) || empty($cnic) || empty($email) || empty($phone) || empty($dateOfBirth) || empty($gradYear) || empty($education) || empty($discipline) || empty($industry) || empty($city) || empty($address) || empty($password) || empty($cpassword)) {
            array_push($errors, "All fields are required");
        }
        if ($password != $cpassword) {
            array_push($errors, "Passwords do not match");
        }

        if (count($errors) == 0) {
            // Handle file upload
            $resumeTargetDir = "uploads/";
            $resumeTargetFile = $resumeTargetDir . basename($resume);
            if (!move_uploaded_file($_FILES['resume']['tmp_name'], $resumeTargetFile)) {
                array_push($errors, "Failed to upload resume");
            }

            // Use prepared statements to prevent SQL injection
            $sql = "INSERT INTO internees (fullName, ntnNumber, cnicNo, emailAddress, phoneNo, dateOfBirth, graduationYear, education, discipline, industry, preferredCity, address, uploadResume, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("ssssssssssssss", $name, $ntn, $cnic, $email, $phone, $dateOfBirth, $gradYear, $education, $discipline, $industry, $city, $address, $resumeTargetFile, $password);
                if ($stmt->execute()) {
                    // Copy data to currentInternees from internees where status is active
                    // $insertQuery = "INSERT INTO currentInternees SELECT * FROM internees WHERE internship_status = 'active'";
                    // $result = $db->query($insertQuery);

                    // if (!$result) {
                        // Handle database error
                        // array_push($errors, "Database error: " . $db->error);
                    // }

                    // Redirect to a success page after registration
                    header('location: ./login.php');
                } else {
                    // Handle database error
                    array_push($errors, "Database error: " . $stmt->error);
                }
                $stmt->close();
            } else {
                // Handle statement preparation error
                array_push($errors, "Statement preparation error: " . $db->error);
            }
        }
    }
}

// You can include a file to display errors in your HTML
// Example: include('errors.php');
?>