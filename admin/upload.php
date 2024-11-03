<?php
// announcement_handler.php
require_once '../login/dbh.inc.php';
require_once 'sms_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if an image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $description = htmlspecialchars($_POST['description']);
        $image = $_FILES['image'];
        $title = htmlspecialchars($_POST['title']);
        $admin_id = $_POST['admin_id'];

        // Handle year levels, departments, and courses
        $year_levels = isset($_POST['year_level']) ? $_POST['year_level'] : [];
        $departments = isset($_POST['department']) ? $_POST['department'] : [];
        $courses = isset($_POST['course']) ? $_POST['course'] : [];

        // Check if admin_id is a valid integer
        if (!empty($admin_id) && filter_var($admin_id, FILTER_VALIDATE_INT)) {
            // Define the upload directory
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Get the file extension
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array(strtolower($ext), $allowedExt)) {
                $filename = uniqid('', true) . '.' . $ext;
                $uploadFilePath = $uploadDir . $filename;

                if (move_uploaded_file($image['tmp_name'], $uploadFilePath)) {
                    try {
                        // Start transaction
                        $pdo->beginTransaction();

                        // Create message for SMS (first 250 characters of description)
                        $message = substr($description, 0, 250);

                        // Insert announcement
                        $stmt = $pdo->prepare("INSERT INTO announcement (image, description, title, admin_id, message) 
                                             VALUES (:filename, :description, :title, :admin_id, :message)");
                        
                        $stmt->bindParam(':filename', $filename);
                        $stmt->bindParam(':description', $description);
                        $stmt->bindParam(':title', $title);
                        $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT);
                        $stmt->bindParam(':message', $message);

                        if ($stmt->execute()) {
                            $announcement_id = $pdo->lastInsertId();

                            // Insert all the relationships (your existing code for year_levels, departments, and courses)
                            // ... (keep your existing relationship insertion code here)
                            // Function to get the corresponding ID from a table based on a name field
                            function getIdByName($pdo, $table, $column, $value, $id) {
                                $sql = "SELECT $id FROM $table WHERE $column = ?";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([$value]);
                                return $stmt->fetchColumn(); // Fetch the id (assuming the id column is named `id`)
                            }

                            // Insert into the `announcement_year_level` junction table
                            foreach ($year_levels as $year_level_name) {
                                $year_level_id = getIdByName($pdo, 'year_level', 'year_level', $year_level_name, 'year_level_id');
                                if ($year_level_id) {
                                    $sql = "INSERT INTO announcement_year_level (announcement_id, year_level_id) VALUES (?, ?)";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([$announcement_id, $year_level_id]);
                                }
                            }

                            // Insert into the `announcement_department` junction table
                            foreach ($departments as $department_name) {
                                $department_id = getIdByName($pdo, 'department', 'department_name', $department_name, 'department_id');
                                if ($department_id) {
                                    $sql = "INSERT INTO announcement_department (announcement_id, department_id) VALUES (?, ?)";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([$announcement_id, $department_id]);
                                }
                            }

                            // Insert into the `announcement_course` junction table
                            foreach ($courses as $course_name) {
                                $course_id = getIdByName($pdo, 'course', 'course_name', $course_name, 'course_id');
                                if ($course_id) {
                                    $sql = "INSERT INTO announcement_course (announcement_id, course_id) VALUES (?, ?)";
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute([$announcement_id, $course_id]);
                                }
                            }
                            // If tags were selected, send SMS
                            if (!empty($year_levels) && !empty($departments) && !empty($courses)) {
                                $students = getStudentsForAnnouncement($pdo, $announcement_id, $year_levels, $departments, $courses);
                                $smsResults = sendSMSToStudents($pdo, $announcement_id, $students, $title, $message);
                            }

                            $pdo->commit();
                            
                            echo "<script>window.location.href = 'admin.php';</script>";
                        } else {
                            throw new Exception("Failed to save announcement details.");
                        }
                    } catch (Exception $e) {
                        $pdo->rollBack();
                        error_log("Error in announcement creation: " . $e->getMessage());
                        echo "An error occurred while creating the announcement.";
                    }
                } else {
                    echo "Failed to upload image.";
                }
            } else {
                echo "Invalid image format.";
            }
        } else {
            echo "Invalid admin ID.";
        }
    } else {
        echo "No image uploaded.";
    }
}