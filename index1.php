
<?php
header('Content-Type: application/json');
include 'connection.php';

$response = ['donors' => 0, 'patients' => 0];

if ($con) {
    $donorQuery = mysqli_query($con, "SELECT COUNT(*) AS num_donors FROM donor");
    $patientQuery = mysqli_query($con, "SELECT COUNT(*) AS num_patients FROM patients");

    if ($donorQuery && $patientQuery) {
        $response['donors'] = mysqli_fetch_assoc($donorQuery)['num_donors'];
        $response['patients'] = mysqli_fetch_assoc($patientQuery)['num_patients'];
    }
} else {
    http_response_code(500);
    $response = ['error' => 'Database connection failed'];
}

echo json_encode($response);
?>
