<?php
// sms_functions.php
require_once 'vendor/autoload.php';
require_once 'sms_config.php';
use GuzzleHttp\Client;

function getStudentsForAnnouncement($pdo, $announcement_id, $year_levels, $departments, $courses) {
    $query = "SELECT DISTINCT s.student_id, s.contact_number 
              FROM student s
              JOIN announcement_year_level ayl ON s.year_level_id = ayl.year_level_id
              JOIN announcement_department ad ON s.department_id = ad.department_id
              JOIN announcement_course ac ON s.course_id = ac.course_id
              WHERE ayl.announcement_id = :announcement_id
              AND ad.announcement_id = :announcement_id
              AND ac.announcement_id = :announcement_id";
    
    try {
        $stmt = $pdo->prepare($query);
        $stmt->execute([':announcement_id' => $announcement_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Database Error in getStudentsForAnnouncement: " . $e->getMessage());
        return [];
    }
}

function sendSMSToStudents($pdo, $announcement_id, $students, $title, $message) {
    $client = new GuzzleHttp\Client();
    $count = 0;
    $results = [];

    foreach ($students as $student) {
        if ($count >= SMS_LIMIT) break;

        try {
            $response = $client->request('POST', INFOBIP_BASE_URL . '/sms/2/text/advanced', [
                'headers' => [
                    'Authorization' => "App " . INFOBIP_API_KEY,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'messages' => [
                        [
                            'from' => SMS_SENDER_NAME,
                            'destinations' => [
                                ['to' => $student['contact_number']]
                            ],
                            'text' => "{$title}\n{$message}"
                        ]
                    ]
                ]
            ]);
            
            $responseBody = json_decode($response->getBody()->getContents());
            $status = $responseBody->messages[0]->status->groupName;

            // Log the SMS status
            logSMSStatus($pdo, $announcement_id, $student['student_id'], $status);
            
            $results[] = [
                'student_id' => $student['student_id'],
                'status' => $status,
                'success' => true
            ];

        } catch (Exception $e) {
            error_log("SMS Sending Error: " . $e->getMessage());
            logSMSStatus($pdo, $announcement_id, $student['student_id'], 'FAILED');
            
            $results[] = [
                'student_id' => $student['student_id'],
                'status' => 'FAILED',
                'success' => false,
                'error' => $e->getMessage()
            ];
        }

        $count++;
    }

    return $results;
}

function logSMSStatus($pdo, $announcement_id, $student_id, $status) {
    try {
        $stmt = $pdo->prepare("INSERT INTO sms_log (announcement_id, student_id, status) 
                              VALUES (:announcement_id, :student_id, :status)");
        $stmt->execute([
            ':announcement_id' => $announcement_id,
            ':student_id' => $student_id,
            ':status' => $status
        ]);
        return true;
    } catch (PDOException $e) {
        error_log("SMS Log Error: " . $e->getMessage());
        return false;
    }
}