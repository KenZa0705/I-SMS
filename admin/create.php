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
    <title>Title</title>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- head CDN links -->
    <?php include '../cdn/head.html'; ?>
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="create.css">
</head>

<body>
    <header>
        <?php include '../cdn/navbar.php'; ?>
    </header>
    <main>
        <div class="container-fluid pt-5">
            <div class="row g-4">
                <!-- left sidebar -->
                <?php include '../cdn/sidebar.php'; ?>

                <!-- main content -->
                <div class="col-md-6 pt-5 px-5">
                    <h3 class="text-center"><b>Create Announcement</b></h3>
                    <form action="upload.php" method="POST" enctype="multipart/form-data">
                        <input type="text" id="admin_id" name="admin_id" value="<?php echo $admin_id; ?>" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control title py-3 px-3" id="title" name="title" placeholder="Enter title" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control custom-class py-3 px-3" id="description" name="description" rows="5" placeholder="Enter description" required style="border-radius: 20px;"></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <div class="upload-image-container d-flex flex-column align-items-center justify-content-center bg-white">
                                <div class="d-flex">
                                    <p id="upload-text" class="mt-3">Upload Photo</p>
                                    <input type="file" class="form-control-file" id="image" name="image" style="display: none;" onchange="imagePreview()">
                                    <button class="btn btn-light" id="file-upload-btn">
                                        <i class="bi bi-upload"></i>
                                    </button>
                                    <img class="img-fluid" id="image-preview" src="#" alt="Image Preview" style="display: none; max-width: 100%;">
                                    <i id="delete-icon" class="bi bi-trash" style="position: absolute; top: 5px; right: 5px; display: none; cursor: pointer;" onclick="deleteImage()"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <fieldset>
                                <legend>Year Level</legend>
                                <label for="1st Year"><input type="checkbox" class="form-control title py-3 px-3" id="1st Year" name="1st Year">1st Year</label>
                                <label for="2nd Year"><input type="checkbox" class="form-control title py-3 px-3" id="2nd Year" name="2nd Year">2nd Year</label>
                                <label for="3rd Year"><input type="checkbox" class="form-control title py-3 px-3" id="3rd Year" name="3rd Year">3rd Year</label>
                                <label for="4th Year"><input type="checkbox" class="form-control title py-3 px-3" id="4th Year" name="4th Year">4th Year</label>
                            </fieldset>
                        </div>
                        <div class="form-group mb-3">
                            <fieldset>
                                <legend>Departments</legend>
                                <label for="CICS"><input type="checkbox" class="form-control title py-3 px-3" id="CICS" name="CICS">CICS</label>
                                <label for="CABE"><input type="checkbox" class="form-control title py-3 px-3" id="CABE" name="CABE">CABE</label>
                                <label for="CAS"><input type="checkbox" class="form-control title py-3 px-3" id="CAS" name="CAS">CAS</label>
                                <label for="CIT"><input type="checkbox" class="form-control title py-3 px-3" id="CIT" name="CIT">CIT</label>
                                <label for="CTE"><input type="checkbox" class="form-control title py-3 px-3" id="CTE" name="CTE">CTE</label>
                                <label for="CE"><input type="checkbox" class="form-control title py-3 px-3" id="CE" name="CE">CE</label>
                            </fieldset>
                        </div>
                        <div class="form-group mb-3">
                        <fieldset>
                                <legend>Courses</legend>
                                <label for="BSBA"><input type="checkbox" class="form-control title py-3 px-3" id="BSBA" name="BSBA">Bachelor of Science in Business Accounting</label>
                                <label for="BSMA"><input type="checkbox" class="form-control title py-3 px-3" id="BSMA" name="BSMA">Bachelor of Science in Management Accounting</label>
                                <label for="BSP"><input type="checkbox" class="form-control title py-3 px-3" id="BSP" name="BSP">Bachelor of Science in Psychology</label>
                                <label for="BAC"><input type="checkbox" class="form-control title py-3 px-3" id="BAC" name="BAC">Bachelor of Arts in Communication</label>
                                <label for="BSIE"><input type="checkbox" class="form-control title py-3 px-3" id="BSIE" name="BSIE">Bachelor of Science in Industrial Engineering</label>
                                <label for="BSIT-CE"><input type="checkbox" class="form-control title py-3 px-3" id="BSIT-CE" name="BSIT-CE">Bachelor of Industrial Technology - Computer Technology</label>
                                <label for="BSIT-Electrical">
                                    <input type="checkbox" class="form-control title py-3 px-3" id="BSIT-Electrical" name="BSIT-Electrical">Bachelor of Industrial Technology - Electrical Technology</label>
                                <label for="BSIT-Electronic">
                                    <input type="checkbox" class="form-control title py-3 px-3" id="BSIT-Electronic" name="BSIT-Electronic">Bachelor of Industrial Technology - Electronics Technology</label>
                                <label for="BSIT-ICT">
                                    <input type="checkbox" class="form-control title py-3 px-3" id="BSIT-ICT" name="BSIT-ICT">Bachelor of Industrial Technology - Instrumentation and Control Technology</label>
                                <label for="BSIT">
                                    <input type="checkbox" class="form-control title py-3 px-3" id="BSIT" name="BSIT">Bachelor of Science in Information Technology</label>
                                <label for="BSE">
                                    <input type="checkbox" class="form-control title py-3 px-3" id="BSE" name="BSE">Bachelor of Secondary Education</label>
                            </fieldset>
                        </div>

                        <div class="button-container d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary px-3 mb-3">Post</button>
                        </div>
                    </form>

                </div>
                <script src="create.js"></script>
    </main>
    <!-- Body CDN links -->
    <?php include '../cdn/body.html'; ?>
</body>

</html>