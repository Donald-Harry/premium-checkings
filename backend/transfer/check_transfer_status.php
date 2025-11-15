<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "backend/config.php";
include_once WEB_ROOT . "backend/functions.php";

// Check if the 'id' parameter is set in the GET request
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Query to check the status using the provided ID
    $sql = "SELECT status FROM trransfer WHERE reference = '$id'"; // Modify table and ID as necessary
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the status has been updated
        if ($row['status'] === "1") {
            $response = array("status" => "updated", "newStatus" => $row['status']);
        } else {
            $response = array("status" => "no_change");
        }
    } else {
        $response = array("status" => "error", "message" => "No record found for ID: $id");
    }

    // Return the JSON response
    echo json_encode($response);

    $conn->close();
} else {
    echo json_encode(array("status" => "error", "message" => "ID not provided"));
}
