<?php
require_once '../login/dbh.inc.php'; // Database connection

// Check if the announcement ID is set
if (isset($_GET['id'])) {
    $announcement_id = $_GET['id'];

    // Perform the deletion
    try {
        $query = "DELETE FROM announcement WHERE announcement_id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $announcement_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Announcement deleted successfully!";
        } else {
            echo "Error deleting announcement.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "No announcement ID provided.";
}

