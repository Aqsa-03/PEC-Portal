<?php
session_start(); // Starting the session, to use and store data in session variable

// If the session variable is empty, this means the user is yet to login
if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
}

// Logout button will destroy the session, and will unset the session variables
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    header("location: login.php");
}

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

// Assuming 'internee_id' is stored in session when the internee logs in
$internee_id = $_SESSION['internee_id'];

// Get the total number of tasks assigned to the internee
$stmt = $db->prepare("SELECT COUNT(*) as total FROM assignTask WHERE internee_id = ?");
$stmt->bind_param("i", $internee_id);
$stmt->execute();
$resultCount = $stmt->get_result();
$totalTasks = $resultCount->fetch_assoc()['total'];

// Get task details assigned to the internee
$stmt = $db->prepare("SELECT id, title, deadline FROM assignTask WHERE internee_id = ?");
$stmt->bind_param("i", $internee_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Internee Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/x-icon" href="img\logo.png">
</head>

<body>

    <header class="bg-dark text-white">
        <div class="container ">
            <div class="d-flex flex-wrap align-items-center justify-content-between py-3">
                <div>
                    <img src="img\logo.png" alt="" width="70px" height="60px" />
                </div>
                <div style="font-size: 24px; font-weight: bold;">
                    DASHBOARD
                </div>
                <div class="text-end">
                    <a href="login.php" class="btn btn-success">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-3">
        <div class="card p-3">
            <?php if (isset($_SESSION['email'])) : ?>
                <h1 class="display-6 w-full text-center py-3 "><b>Welcome</b> <?php echo $_SESSION['name']; ?></h1>
            <?php endif ?>

            <div class="d-flex align-items-center justify-content-between">
                <div class="text-start w-50">
                    <p class="font-bold"><strong>Total Tasks:</strong> <?php echo $totalTasks; ?></p>
                </div>
            </div>

        </div>

        <div class="row py-3">
            <table class="w-full table">
                <thead>
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Title</th>
                        <th class="px-4 py-3">Deadline</th>
                        <th class="px-4 py-3">Quick Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='text-gray-700 dark:text-gray-400'>";
                        echo "<td class='px-4 py-3'><div class='flex items-center text-sm'><div class='relative hidden w-8 h-8 mr-3 rounded-full md:block'></div><div><p class='font-semibold'>" . $row['id'] . "</p></div></div></td>";
                        echo "<td class='px-4 py-3 text-sm'>" . $row['title'] . "</td>";
                        echo "<td class='px-4 py-3 text-sm'>" . $row['deadline'] . "</td>";
                        echo "<td class='px-4 py-3 text-sm'>
                        <a href='./viewDetails.php?id=" . $row['id'] . "' class='delete-btn px-2 py-1'>View</a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>