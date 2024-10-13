<?php
require_once '../login/dbh.inc.php'; // DATABASE CONNECTION
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login/login.php");
    exit();
}

//Get info from admin session
$user = $_SESSION['user'];
$admin_id = $_SESSION['user']['admin_id'];
$first_name = $_SESSION['user']['first_name'];
$last_name = $_SESSION['user']['last_name'];
$email = $_SESSION['user']['email'];
$contact_number = $_SESSION['user']['contact_number'];
$department_id = $_SESSION['user']['department_id'];
?>
<!doctype html>
<html lang="en">

<head>
    <title>Edit Announcement</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
    <!-- Include your head CDN links -->
    <?php include '../cdn/head.html'; ?>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="create.css">
</head>

<body>
    <header>
        <!-- Navbar and user profile section -->
        <?php include '../cdn/navbar.php'; ?> <!-- Assuming you have a separate file for the navbar -->
    </header>

    <main>
        <div class="container pt-5">
            <div class="row g-4">
                <!-- Sidebar -->
                <?php include '../cdn/sidebar.php'; ?> <!-- Assuming sidebar is in a separate file -->

                <!-- Main content -->
                <div class="col-md-6 pt-5 px-5">
                    <h3 class="text-center"><b>Edit Announcement</b></h3>

                    <?php
                    require_once '../login/dbh.inc.php'; // Database connection

                    if (isset($_GET['id'])) {
                        $announcement_id = $_GET['id'];

                        // Fetch existing announcement data
                        $query = "SELECT * FROM announcement WHERE announcement_id = :id";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(':id', $announcement_id, PDO::PARAM_INT);
                        $stmt->execute();
                        $announcement = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($announcement) {
                            $title = $announcement['title'];
                            $description = $announcement['description'];
                            $image = $announcement['image'];
                            $department_id = $announcement['department_id'];
                            $year_level_id = $announcement['year_level_id'];

                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                $new_title = $_POST['title'];
                                $new_description = $_POST['description'];
                                $new_department_id = $_POST['department'];
                                $new_year_level_id = $_POST['year_level'];

                                // Handle image upload
                                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                                    $image_tmp_name = $_FILES['image']['tmp_name'];
                                    $image_name = $_FILES['image']['name'];
                                    $uploadDir = 'uploads/';

                                    // Get the file extension
                                    $ext = pathinfo($image_name, PATHINFO_EXTENSION);
                                    $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

                                    if (in_array(strtolower($ext), $allowedExt)) {
                                        // Create a unique filename
                                        $filename = uniqid('', true) . '.' . $ext;
                                        $uploadFilePath = $uploadDir . $filename;

                                        // Move the file to the upload directory
                                        move_uploaded_file($image_tmp_name, $uploadFilePath);
                                        $new_image = $filename; // Set the new image filename
                                    }
                                } else {
                                    $new_image = $image; // Keep the old image
                                }


                                // Update the announcement
                                $update_query = "UPDATE announcement SET title = :title, description = :description, image = :image, department_id = :department, year_level_id = :year_level, updated_at = NOW() WHERE announcement_id = :id";
                                $stmt = $pdo->prepare($update_query);
                                $stmt->bindParam(':title', $new_title);
                                $stmt->bindParam(':description', $new_description);
                                $stmt->bindParam(':image', $new_image);
                                $stmt->bindParam(':department', $new_department_id);
                                $stmt->bindParam(':year_level', $new_year_level_id);
                                $stmt->bindParam(':id', $announcement_id);

                                if ($stmt->execute()) {
                                    echo "<script>
                                            alert('Announcement was updated successfully!');
                                            window.location.href = 'admin.php';
                                          </script>";
                                } else {
                                    echo "<div class='alert alert-danger'>Error updating announcement.</div>";
                                }
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Announcement not found.</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>No announcement ID provided.</div>";
                    }
                    ?>

                    <!-- Form to edit the announcement -->
                    <?php if ($announcement): ?>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group mb-3">
                                <label for="title">Title</label>
                                <input type="text" class="form-control title py-3 px-3" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <textarea class="form-control custom-class py-3 px-3" id="description" name="description" rows="5" required><?php echo htmlspecialchars($description); ?></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" id="department" name="department" value="<?php echo htmlspecialchars($department_id); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="year_level">Year Level</label>
                                <input type="text" class="form-control" id="year_level" name="year_level" value="<?php echo htmlspecialchars($year_level_id); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <div class="upload-image-container d-flex flex-column align-items-center justify-content-center bg-white">
                                    <div class="d-flex">
                                        <p id="upload-text" class="mt-3">Upload Photo</p>
                                        <input type="file" class="form-control-file" id="image" name="image" style="display: none;" onchange="imagePreview()">
                                        <button class="btn btn-light" id="file-upload-btn" onclick="document.getElementById('image').click();">
                                            <i class="bi bi-upload"></i>
                                        </button>
                                        <img id="image-preview" src="uploads/<?php echo htmlspecialchars($image); ?>" alt="Image Preview" style="display: block; max-width: 100%; margin-top: 15px;">
                                        <i id="delete-icon" class="bi bi-trash" style="position: absolute; top: 5px; right: 5px; display: block; cursor: pointer;" onclick="deleteImage()"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="button-container d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-3">Update</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <script src="create.js"></script> <!-- JavaScript for image upload and preview -->
    </main>

    <footer>
        <!-- Footer content -->
        <?php include '../cdn/footer.html'; ?>
    </footer>
    <!-- Body CDN links -->
    <?php include '../cdn/body.html'; ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const preview = document.getElementById('image-preview');
            const uploadText = document.getElementById('upload-text');
            const uploadBtn = document.getElementById('file-upload-btn');
            const deleteIcon = document.getElementById('delete-icon');
            
            // Check if the image is already loaded
            if (preview.src !== "#" && preview.src.trim() !== "") {
                preview.style.display = 'block';  // Show the image
                uploadText.style.display = 'none';  // Hide the upload text
                uploadBtn.style.display = 'none';  // Hide the upload button
                deleteIcon.style.display = 'block';  // Show the delete icon
            }
        });
    </script>
</body>

</html>
