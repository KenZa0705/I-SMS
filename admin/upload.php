<?php
// Database configuration
require_once '../login/dbh.inc.php';
require __DIR__ . "/vendor/autoload.php";

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;

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
            // Create the directory if it doesn't exist
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Get the file extension
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

            // Check if the file extension is allowed
            if (in_array(strtolower($ext), $allowedExt)) {
                // Create a unique filename
                $filename = uniqid('', true) . '.' . $ext;
                $uploadFilePath = $uploadDir . $filename;

                // Move the uploaded file to the upload directory
                if (move_uploaded_file($image['tmp_name'], $uploadFilePath)) {
                    try {
                        // Insert the file details into the database using PDO
                        $stmt = $pdo->prepare("INSERT INTO announcement (image, description, title, admin_id) VALUES (:filename, :description, :title, :admin_id)");
                        $stmt->bindParam(':filename', $filename);
                        $stmt->bindParam(':description', $description);
                        $stmt->bindParam(':title', $title);
                        $stmt->bindParam(':admin_id', $admin_id, PDO::PARAM_INT); // Ensure admin_id is bound as an integer

                        if ($stmt->execute()) {
                            // Get the ID of the last inserted announcement
                            $announcement_id = $pdo->lastInsertId();

                            // Check if SMS notifications should be sent
                            if (isset($_POST['sendSms']) && $_POST['sendSms'] == '1') {
                                $title = $_POST['title'];
                                $description = $_POST['description'];
                                $message = substr($description, 0, 250); // Limit message to 250 characters

                                // Get students based on tags
                                $students = getStudentsForAnnouncement($pdo, $announcement_id, $year_levels, $departments, $courses);

                                // Send SMS to students
                                sendSmsToStudents($pdo, $announcement_id, $students, $title, $message);
                            }


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

                            echo "<script>
                            window.location.href = 'admin.php';
                                </script>";
                        } else {
                            echo "Failed to save details to database.";
                        }
                    } catch (PDOException $e) {
                        echo "Database error: " . $e->getMessage();
                    }
                } else {
                    echo "Failed to move uploaded file.";
                }
            } else {
                echo "Invalid file extension.";
            }
        } else {
            echo "Invalid admin ID.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
} else {
    echo "Invalid request.";
}

function getStudentsForAnnouncement($pdo, $announcement_id, $year_levels, $departments, $courses) {
    $query = "SELECT DISTINCT s.student_id, s.contact_number 
              FROM student s
              JOIN announcement_year_level ayl ON s.year_level_id = ayl.year_level_id
              JOIN announcement_department ad ON s.department_id = ad.department_id
              JOIN announcement_course ac ON s.course_id = ac.course_id
              WHERE ayl.announcement_id = :announcement_id
              AND ad.announcement_id = :announcement_id
              AND ac.announcement_id = :announcement_id";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute([':announcement_id' => $announcement_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function sendSmsToStudents($pdo, $announcement_id, $students, $title, $message) {
    $apiURL = 'wg43qy.api.infobip.com';
    $apiKey = '90f70a7a0843650f0cd70d01ac47e048-8c7ffe9f-c816-4b9a-88c6-3370b9584292';

    $configuration = new Configuration(host: $apiURL, apiKey: $apiKey);
    $api = new SmsApi(config: $configuration);

    foreach ($students as $student) {
        $destination = new SmsDestination(to: $student['contact_number']);
        $smsMessage = new SmsTextualMessage(
            destinations: [$destination],
            text: $title . "\n" . $message,
            from: "447491163443"
        );

        $request = new SmsAdvancedTextualRequest(messages: [$smsMessage]);

        try {
            $response = $api->sendSmsMessage($request);
            logSmsStatus($pdo, $announcement_id, $student['student_id'], 'SENT');
        } catch (Exception $e) {
            logSmsStatus($pdo, $announcement_id, $student['student_id'], 'FAILED');
            // You might want to log the error message as well
        }
    }
}

function logSmsStatus($pdo, $announcement_id, $student_id, $status) {
    $query = "INSERT INTO sms_log (announcement_id, student_id, status) VALUES (:announcement_id, :student_id, :status)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':announcement_id' => $announcement_id,
        ':student_id' => $student_id,
        ':status' => $status
    ]);
}