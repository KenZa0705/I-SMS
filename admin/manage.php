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
                        <div class="sidebar">
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <a href="admin.php" class="btn mb-3"><i class="bi bi-house"></i> Home</a>
                                    <a class="btn mb-3" href="create.php"><i class="bi bi-megaphone"></i> Create Announcement</a>
                                    <a class="btn active mb-3" href=""><i class="bi bi-kanban"></i> Manage Post</a>
                                    <a class="btn" href=""><i class="bi bi-clipboard"></i> Logs</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- main content -->
                <div class="col-md-6 pt-5 px-5">
                    <div class="feed-container">
                        <div class="card mb-3">
                            <div class="profile-container d-flex align-items-center px-3 py-2">
                                <div class="profile-pic">
                                    <img class="img-fluid" src="img/test pic.jpg" alt="">
                                </div>
                                <p class="ms-1 mt-3">Username</p>
                                <div class="dropdown dropdown-edit ms-auto">
                                    <span class="d-flex align-items-center" role="button" data-bs-toggle="dropdown" style="cursor: pointer;">
                                        <i class="bi bi-three-dots"></i>
                                    </span>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                        <li><a class="dropdown-item" href="#">Edit Post</a></li>
                                        <li><a class="dropdown-item" href="#">Delete Post</a></li>
                                    </ul>
                                </div>

                            </div>



                            <div class="image-container pb-3 mx-3">
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
                <script src="admin.js"></script>
    </main>
    <footer>

    </footer>
    <!-- Body CDN links -->
    <?php include '../cdn/body.html'; ?>
</body>

</html>