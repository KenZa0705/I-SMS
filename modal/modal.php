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

    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#postDelete">
            Launch demo modal
        </button>

        <div class="modal fade" id="deletePost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header pb-1" style="border: none">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Post?</h1>
                        <button type="button" class="btn-close delete-modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body py-0" style="border: none;">
                        <p style="font-size: 15px;">Once you deleted this post, it can't be restored.</p>
                    </div>
                    <div class="modal-footer pt-0" style="border: none;">
                        <button type="button" class="btn go-back-btn" data-bs-dismiss="modal">Go Back</button>
                        <button type="button" class="btn delete-btn">Yes, Delete</button>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="postDelete" tabindex="-1" aria-labelledby="post-deleted" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content delete-message">
                    <div class="modal-header" style="border: none">
                        <p class="modal-title fs-5" id="exampleModalLabel">Announcement deleted succesfully.</p>
                        <button type="button" class="btn-close delete-modal-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#announcementModal">
            Open Announcement Form
        </button>

        <!-- Modal -->
        <div class="modal fade" id="announcementModal" tabindex="-1" role="dialog" aria-labelledby="announcementModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="announcementModalLabel">Update Announcement</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                                            <button type="button" class="btn btn-light" id="file-upload-btn" onclick="document.getElementById('image').click();">
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
        </div>

    </main>
    <footer>
        <!-- place footer here -->
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