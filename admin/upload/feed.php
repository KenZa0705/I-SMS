<?php
// Database configuration
$host = 'localhost'; // or your database host
$db = 'image_uploads';
$user = 'root'; // your database username
$pass = ''; // your database password

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the images from the database
$sql = "SELECT * FROM images ORDER BY upload_time DESC"; // You can change the order if needed
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Feed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .image-feed {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .image-card {
            border: 1px solid #ccc;
            padding: 10px;
            width: 300px;
            border-radius: 5px;
        }

        .image-card img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h1>Image Feed</h1>
    <div class="image-feed">
        <?php
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                echo '<div class="image-card">';
                echo '<img src="uploads/' . htmlspecialchars($row['filename']) . '" alt="Image">';
                echo '<p>' . htmlspecialchars($row['description']) . '</p>';
                echo '<p><small>Uploaded on: ' . $row['upload_time'] . '</small></p>';
                echo '</div>';
            }
        } else {
            echo '<p>No images found.</p>';
        }
        ?>
    </div>
</body>

</html>

<?php
$conn->close();
?>