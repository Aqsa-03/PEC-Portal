<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fyp";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Sorry, failed to connect: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $internId = $_GET['id'];

    // Update internship_status to 'completed'
    $updateQuery = "UPDATE currentinternees SET internship_status = 'completed' WHERE id = $internId";
    mysqli_query($conn, $updateQuery);

    // Move the row to completedInternees table
    $moveQuery = "INSERT INTO completedinternees SELECT * FROM currentinternees WHERE id = $internId";
    $moveResult=mysqli_query($conn, $moveQuery);

    // Delete the row from internees table
    $deleteQuery = "DELETE FROM currentinternees WHERE id = $internId";
    $deleteResult=mysqli_query($conn, $deleteQuery);

    if ($moveResult && $deleteResult) {
        echo "Do You Really Want this Internee to add in Completed Internees";
    } else {
        echo "Error marking internship as quitted.";
    }
} else {
    echo "Invalid request.";
}
?>
