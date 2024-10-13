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

<!DOCTYPE html>
<html lang="en">

<head>
    <title>ISMS Portal</title>
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
        <?php include '../cdn/navbar.php'?>
    </header>
    <main>
        <div class="container pt-5">
            <div class="row g-4">
                <!-- left sidebar -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="sticky-sidebar pt-5">
                        <div class="sidebar">
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <a href="admin.php" class="btn active mb-3"><i class="bi bi-house"></i> Home</a>
                                    <a class="btn mb-3" href="create.php"><i class="bi bi-megaphone"></i> Create Announcement</a>
                                    <a class="btn mb-3" href="manage.php"><i class="bi bi-kanban"></i> Manage Post</a>
                                    <a class="btn" href=""><i class="bi bi-clipboard"></i> Logs</a>
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
                            $query = "SELECT * FROM announcement ORDER BY updated_at DESC"; // You can modify the ORDER BY as per your requirement
                            // Prepare and execute the query
                            $stmt = $pdo->prepare($query);
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
                                    $admin_id = $row['admin_id'];
                                    $department = $row['department_id'];
                                    $year_level = $row['year_level_id'];
                                    $updated_at = date('F d, Y', strtotime($row['updated_at']));
                                    ?>

                                    
                                            <div class="card mb-3">
                                                <div class="profile-container d-flex px-3 pt-3">
                                                    <div class="profile-pic">
                                                        <img class="img-fluid" src="path/to/profile/pic.jpg" alt=""> <!-- Profile image can be dynamic if available -->
                                                    </div>
                                                    <p class="ms-1 mt-1"><?php echo htmlspecialchars($admin_id); ?></p>
                                                    <div class="dropdown ms-auto">
                                                        <a href="#" id="dropdownMenuButton<?php echo $announcement_id; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="bi bi-three-dots"></i>
                                                        </a>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $announcement_id; ?>">
                                                            <li><a class="dropdown-item" href="edit_announcement.php?id=<?php echo $announcement_id; ?>">Edit</a></li>
                                                            <li><a class="dropdown-item text-danger" href="delete_announcement.php?id=<?php echo $announcement_id; ?>" onclick="return confirm('Are you sure you want to delete this announcement?')">Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="image-container pb-3 mx-3">
                                                    <img src="uploads/<?php echo htmlspecialchars($image); ?>" alt="Post Image" class="img-fluid"> <!-- Dynamically display post image -->
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

                <div class="col-md-3 d-none d-md-block">
                    <div class="sticky-sidebar pt-5">
                        <div class="filter">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center mb-2">Recent Posts</h5>
                                    <div class="posts">
                                        <div class="d-flex mb-3">
                                            <i class="bi bi-star me-2"></i> <span>JPCS Membership Fee</span>
                                        </div>

                                        <h5 class="text-center card-title">Announcements Filter</h5>
                                        <form class="filtered_option d-flex flex-column" action="">
                                            <label>Choose Department</label>
                                            <div class="checkbox-group mb-3">
                                                <label><input type="checkbox" name="department_filter" value="1"> CECS</label><br>
                                                <label><input type="checkbox" name="department_filter" value="2"> CABE</label><br>
                                                <label><input type="checkbox" name="department_filter" value="3"> CAS</label><br>
                                            </div>

                                            <label>Select Year Level</label>
                                            <div class="checkbox-group">
                                                <label><input type="checkbox" name="year_level" value="1"> 1st Year</label><br>
                                                <label><input type="checkbox" name="year_level" value="2"> 2nd Year</label><br>
                                                <label><input type="checkbox" name="year_level" value="3"> 3rd Year</label><br>
                                                <label><input type="checkbox" name="year_level" value="4"> 4th Year</label><br>

                                            </div>
                                            <button type="button" class="btn btn-primary mt-3">Filter</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script src="admin.js"></script>
    </main>
    <footer>

    </footer>
    <!-- Body CDN links -->
    <?php include '../cdn/body.html'; ?>
</body>

</html>