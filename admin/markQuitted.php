<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fyp";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Sorry, failed to connect: " . mysqli_connect_error());
}

if (isset($_POST['id'])) {
    $internId = $_POST['id'];
    $updateQuery = "UPDATE currentinternees SET internship_status = 'Quitter' WHERE id = $internId";
    mysqli_query($conn, $updateQuery);

    // Move the row to quitterInternees table
    $moveQuery = "INSERT INTO quitterinternees SELECT * FROM currentinternees WHERE id = $internId";
    $moveResult = mysqli_query($conn, $moveQuery);

    // Delete the row from internees table
    $deleteQuery = "DELETE FROM currentinternees WHERE id = $internId";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($moveResult && $deleteResult) {
        echo "Do You Really Want this Internee to add in Quitter Internees";
    } else {
        echo "Error marking internship as quitted.";
    }
} else {
    echo "Invalid request.";
}
?>
