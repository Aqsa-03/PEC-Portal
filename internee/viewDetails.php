<?php
$id = $_GET['id'];
session_start(); //starting the session, to use and store data in session variable

//if the session variable is empty, this means the user is yet to login
//user will be sent to 'login.php' page to allow the user to login
if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "You have to log in first";
    header('location: login.php');
}

// // logout button will destroy the session, and will unset the session variables
// //user will be headed to 'login.php' after loggin out
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
?>
<?php
$stmt = $db->prepare("SELECT * FROM `assignTask` WHERE id=$id ");
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

?>



<!DOCTYPE html>
<html>

<head>
    <title>View Details</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/x-icon" href="img\logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <header class="bg-dark text-white">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between py-3">
                <div>
                    Assigned Task
                </div>

                <div class="text-end">
                    <button type="button" class="btn btn-warning">Log Out</button>
                </div>
            </div>
        </div>
    </header>

    <div class="container mt-3">
        <div class="card p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex flex-column">
                    <h1><?php echo $row['title']; ?></h1>
                    <p><?php echo $row['description']; ?></p>
                    <a href="<?php echo $row['adminAttachFile']; ?>" download=""><?php echo basename($row["adminAttachFile"]) ?></a>
                </div>
                <div class="d-flex flex-column">
                    <p style="color: red;"><?php echo $row['deadline']; ?></p>
                    <span class="badge rounded-pill text-bg-success p-2 " style="opacity: <?php echo $row["isDone"]; ?>">Completed</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-3" style="<?php echo $row["isDone"] ? 'display: none;' : ''; ?>">
        <main class="d-flex justify-content-center align-items-center card" style="height: 90vh;">
            <form action="viewDetails.php?id=<?php echo $id ?>" method="POST" enctype="multipart/form-data" class="w-50">
                <h1 class="display-5 text-center">Submit Task</h1>
                <label class="py-3" for="title">Title</label>
                <input type="text" name="title" value="<?php echo $row['title']; ?>" disabled class="form-control" id="title" required placeholder="Enter your title">
                <label class="py-3" for="file">Attach File <span style="color: red;">*</span></label>
                <input type="file" name="file" class="form-control" aria-label="Text input with segmented dropdown button" required>
                <label class="py-3" for="comment">Comment</label>
                <textarea class="form-control mb-3" name="comment" required id="comment" placeholder="Enter your comment" rows="6"></textarea>

                <button class="btn btn-primary w-100 py-2" name="submit" type="submit">Submit Task</button>
            </form>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $comment = $_POST['comment'];

    // Directory where file will be uploaded
    $targetDir = "../uploads/" . $id . "/submited/ ";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = basename($_FILES["file"]["name"]);
    echo $fileName;
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowTypes = array('pdf', 'png', 'jpeg', 'gif', 'docx', 'doc', 'odt');

    if (!empty($fileName)) {
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                // Insert query
                $sql = "UPDATE assignTask SET `isDone` = '1',`interneeAttachFile` = '$targetFilePath', `taskComment` = '$comment' WHERE `id` = '$id'";

                if (mysqli_query($db, $sql)) {
                    echo "Task submit successfully!";
                    header('Location: ./viewDetails.php?id=' . $id);
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($db);
                }
            } else {
                // Debugging information
                echo "Sorry, there was an error moving your file to the target directory. ";
                echo "Debug info: targetFilePath = " . $targetFilePath . ", tmp_name = " . $_FILES["file"]["tmp_name"];
            }
        } else {
            echo 'Sorry, only PDF, PNG, JPEG, GIF, DOCX, DOC, ODT files are allowed to upload.';
        }
    } 
    mysqli_close($db);
}
?>