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
</head>

<body>
    <header>
        <?php include '../cdn/navbar.php'; ?>
    </header>
    <main>
        <div class="container-fluid pt-5">
            <div class="row g-4">
                <!-- left sidebar -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="sticky-sidebar pt-5">
                        <div class="sidebar">
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <a href="admin.php" class="btn mb-3"><i class="bi bi-house"></i> Home</a>
                                    <a class="btn mb-3" href="create.php"><i class="bi bi-megaphone"></i> Create Announcement</a>
                                    <a class="btn active mb-3" href=""><i class="bi bi-kanban"></i> Manage Post</a>
                                    <a class="btn" href=""><i class="bi bi-clipboard"></i> Logs</a>
                                    <a class="btn" href="manage_student.php"><i class="bi bi-person-plus"></i> Manage Student Account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- main content -->
                <div class="col-md-6 pt-5 px-5">
                    <div class="feed-container">
                        <?php
                        require_once '../login/dbh.inc.php';
                        // Assuming you have already connected to the database
                        try {
                            // Query to get the announcements
                            $query = "SELECT * FROM announcement ORDER BY updated_at DESC "; // You can modify the ORDER BY as per your requirement
                            // Prepare and execute the query

                            $query = "SELECT a.*, ad.first_name, ad.last_name 
                                        FROM announcement a 
                                        JOIN admin ad ON a.admin_id = ad.admin_id
                                        WHERE a.admin_id = :id;";

                            $stmt = $pdo->prepare($query);
                            $stmt->bindParam(':id', $admin_id, PDO::PARAM_INT);
                            $stmt->execute();

                            // Fetch all the results
                            $announcements = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            if ($announcements > 0) {
                                // Loop through the announcements and display them
                                foreach ($announcements as $row) {
                                    $announcement_id = $row['announcement_id'];
                                    $title = $row['title'];
                                    $description = $row['description'];
                                    $image = $row['image'];
                                    $announcement_admin_id = $row['admin_id'];
                                    $department = $row['department_id'];
                                    $year_level = $row['year_level_id'];
                                    $admin_first_name = $row['first_name'];
                                    $admin_last_name = $row['last_name'];
                                    $admin_name =  $admin_first_name . ' ' . $admin_last_name;
                                    $updated_at = date('F d, Y', strtotime($row['updated_at']));
                        ?>


                                    <div class="card mb-3">
                                        <div class="profile-container d-flex px-3 pt-3">
                                            <div class="profile-pic">
                                                <img class="img-fluid" src="img/test pic.jpg" alt="">
                                            </div>
                                            <p class="ms-1 mt-1"><?php echo htmlspecialchars($admin_name); ?></p>

                                            <div class="dropdown ms-auto">
                                                <span id="dropdownMenuButton<?php echo $announcement_id; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="bi bi-three-dots"></i>
                                                </span>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $announcement_id; ?>">
                                                    <li><a class="dropdown-item" href="edit_announcement.php?id=<?php echo $announcement_id; ?>">Edit</a></li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#deletePost"
                                                            data-announcement-id="<?php echo $announcement_id; ?>">Delete</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                        <div class="image-container mx-3">
                                            <img src="uploads/<?php echo htmlspecialchars($image); ?>" alt="Post Image" class="img-fluid">
                                        </div>

                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($title); ?></h5>
                                            <p><?php echo htmlspecialchars($description); ?></p>
                                            <p class="card-text">
                                                Tags: <?php echo htmlspecialchars($year_level), htmlspecialchars($department); ?>
                                            </p>
                                            <small>Updated at <?php echo htmlspecialchars($updated_at); ?></small>
                                        </div>
                                    </div>


                        <?php
                                }
                            } else {
                                echo '<p>No announcements found.</p>';
                            }
                        } catch (PDOException $e) {
                            // Handle any errors that occur during query execution
                            echo "Error: " . $e->getMessage();
                        }
                        ?>
                    </div>
                </div>
                <script src="admin.js"></script>
    </main>
    <!-- Body CDN links -->
    <?php include '../cdn/body.html'; ?>
</body>

</html>