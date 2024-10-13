<?php
require_once '../login/dbh.inc.php'; // DATABASE CONNECTION
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login/login.php");
    exit();
}

//Get info from student session
$user = $_SESSION['user'];
$student_id = $_SESSION['user']['student_id'];
$first_name = $_SESSION['user']['first_name'];
$last_name = $_SESSION['user']['last_name'];
$email = $_SESSION['user']['email'];
$contact_number = $_SESSION['user']['contact_number'];
$department_id = $_SESSION['user']['department_id'];
$year = $_SESSION['user']['year_level_id'];
$course = $_SESSION['user']['course_id'];
?>


<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="user.css">

</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-white text-black fixed-top mb-5">
            <div class="container">
                <div class="user-left d-flex">
                    <div class="d-md-none ms-0 mt-2 me-3">
                        <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                          </button>                        
                    </div>
        
                    <a class="navbar-brand d-flex align-items-center" href="#"><img src="img/brand.png" class="img-fluid branding" alt=""></a>
                </div>

                <div class="user-mid d-none d-md-block">
                    <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button style="border: none; background: none;"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            
                <div class="user-right d-flex align-items-center justify-content-center">
                    <p class="username d-flex align-items-center m-0">Username</p>
                    <div class="user-profile">
                        <div class="dropdown">
                            <button class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" style="border: none; background: none; padding: 0;">
                                <img class="img-fluid w-100" src="img/test pic.jpg" alt="">
                            </button>
                            <ul class="dropdown-menu mt-3" style="left: auto; right:1px;">
                                <li><a class="dropdown-item text-center" href="#">Settings</a></li>
                                <li><a class="dropdown-item text-center" href="#">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>          
        </nav>
    </header>
    <main>
        <div class="container pt-5">
            <div class="row g-4">
                <!-- left sidebar -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="sticky-sidebar pt-5">
                        <div class="filter">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-center card-title">Announcements Filter</p> 
                                    <div class="d-flex justify-content-center">
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
                                            <button class="btn btn-primary mt-3">Filter</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                
                <!-- main content -->
                <div class="col-md-6 pt-5 px-5">
                    <div class="feed-container">
                        <div class="card mb-3">
                            <div class="image-container p-3">
                                <img src="img/c1.jpg" alt="Post Image" class="img-fluid">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Post Title</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi error laboriosam illo nulla culpa exercitationem laudantium optio saepe sequi, nam aut fugit velit minus ipsa debitis sint deleniti doloribus voluptatum.</p>
                                <p class="card-text">
                                    Tags:
                                </p>
                                <small>Updated at October 4, 2024</small>
                            </div>
                        </div>

                    </div>
                    
                    
                </div>
                
                <!-- right sidebar -->
                <div class="col-md-3 d-none d-md-block">
                    <div class="sticky-sidebar pt-5">
                        <div class="card w-100">
                            <div class="card-body">
                              <h5 class="card-title text-center mb-2">Recent Posts</h5>
                              <div class="posts px-4">
                                <div class="d-flex">
                                    <i class="bi bi-star me-2"></i> <span>JPCS Membership Fee</span>
                                </div>
                            </div>
                        </div>
                     </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- offcanvas sidebar -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasSidebarsLabel">
            <div class="offcanvas-header d-flex">
                <img class="img-fluid w-100" src="img/brand.png" alt="">
                <h5 class="offcanvas-title" id="offcanvasSidebarsLabel">ISMS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mx-2">
                <form class="d-flex mx-2 mb-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button style="border: none; background: none;"><i class="bi bi-search"></i></i></button>
                </form>

                <div class="card mb-3">
                    <div class="card-body">
                      <h5 class="card-title text-center mb-2">Recent Posts</h5>
                    </div>
                    <div class="posts px-4">
                        <div class="d-flex">
                            <i class="bi bi-star me-2"></i> <span>JPCS Membership Fee</span>
                        </div>
                    </div>
                  </div>

                  <div class="filter">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-center card-title">Announcements Filter</p> 
                            <div class="d-flex justify-content-center">
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
                                    <button class="btn btn-primary mt-3">Filter</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    
    </main>
    <script src="user.js"></script>
    <footer>

    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>