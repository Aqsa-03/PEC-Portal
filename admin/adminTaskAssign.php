<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fyp";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'];
?>

<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Assign Task</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="logo.png">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="./js/init-alpine.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" defer></script>
    <script src="./js/charts-lines.js" defer></script>
    <script src="./js/charts-pie.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <main class="d-flex justify-content-center align-items-center" style="height: 90vh;">
        <form action="adminTaskAssign.php?id=<?php echo $id ?>" method="POST" enctype="multipart/form-data" class="w-50">
            <h1 class="p-5 display-5 text-center">Assign Task to Internees</h1>
            <label class="py-3" for="title">Title <span style="color: red;">*</span></label>
            <input type="text" name="title" class="form-control" id="title" required placeholder="Enter your title">
            <label class="py-3" for="description">Description <span style="color: red;">*</span></label>
            <textarea class="form-control mb-3" name="description" required id="description" placeholder="Enter your description" rows="6"></textarea>
            <div class="d-flex gap-3 mb-3">
                <input type="file" name="file" class="form-control" aria-label="Text input with segmented dropdown button">
                <input type="date" name="date" class="form-control" aria-label="Text input with segmented dropdown button">
            </div>
            <button class="btn btn-primary w-100 py-2" name="createTask" type="submit" href="adminDashboard.php">Create Task</button>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["createTask"])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['date'];

    // Directory where file will be uploaded
    $targetDir = "../uploads/" . $id . "/";
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
                $sql = "INSERT INTO assignTask (title, description, adminAttachFile, deadline, isDone, internee_id, created_at) 
                        VALUES ('$title', '$description', '$targetFilePath', '$deadline', 0, '$id', NOW())";

                if (mysqli_query($conn, $sql)) {
                    echo "Record inserted successfully!";
                    echo "The file " . $fileName . " has been uploaded successfully.";
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            } else {
                // Debugging information
                echo "Sorry, there was an error moving your file to the target directory. ";
                echo "Debug info: targetFilePath = " . $targetFilePath . ", tmp_name = " . $_FILES["file"]["tmp_name"];
            }
        } else {
            echo 'Sorry, only PDF, PNG, JPEG, GIF, DOCX, DOC, ODT files are allowed to upload.';
        }
    } else {
        // Insert query without file
        $sql = "INSERT INTO assignTask (title, description, adminAttachFile, deadline, isDone, internee_id, created_at) 
                VALUES ('$title', '$description', '', '$deadline', 0, '$id', NOW())";

        if (mysqli_query($conn, $sql)) {
            echo "Record inserted successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
    mysqli_close($conn);
}
?>