<div class="card mb-3">
    <div class="profile-container d-flex px-3 pt-3">
        <div class="profile-pic">
            <img class="img-fluid" src="img/test pic.jpg" alt="">
        </div>
        <p class="ms-1 mt-1"><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></p>
        <?php if (isset($admin_id) && $admin_id === $row['admin_id']) : ?>
            <div class="dropdown ms-auto">
                <span id="dropdownMenuButton<?php echo $row['announcement_id']; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots"></i>
                </span>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $row['announcement_id']; ?>">
                    <li><a class="dropdown-item" href="edit_announcement.php?id=<?php echo $row['announcement_id']; ?>">Edit</a></li>
                    <li>
                        <a class="dropdown-item text-danger" href="#"
                            data-bs-toggle="modal"
                            data-bs-target="#deletePost"
                            data-announcement-id="<?php echo $row['announcement_id']; ?>">Delete</a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <div class="image-container mx-3">
        <a href="uploads/<?php echo htmlspecialchars($row['image']); ?>" data-lightbox="image-<?php echo $row['announcement_id']; ?>" data-title="<?php echo htmlspecialchars($row['title']); ?>">
            <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" alt="Post Image" class="img-fluid">
        </a>
    </div>

    <div class="card-body">
        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
        <div class="card-text">
            <p class="mb-2"><?php echo htmlspecialchars($row['description']); ?></p>

            Tags:
            <?php
            $all_tags = array_merge(explode(',', $row['year_levels']), explode(',', $row['departments']), explode(',', $row['courses']));
            foreach ($all_tags as $tag) : ?>
                <span class="badge rounded-pill bg-danger mb-2"><?php echo htmlspecialchars(trim($tag)); ?></span>
            <?php endforeach; ?>
        </div>

        <small>Updated at <?php echo htmlspecialchars(date('F d, Y', strtotime($row['updated_at']))); ?></small>
    </div>
</div>