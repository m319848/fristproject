<?php
// Database connection
//include 'db_connection.php'; // apna DB connection file
require_once("loginCheck.php");

if(isset($_GET['userId'])) {
    $userId = $_GET['userId'];

    $stmt = $con->prepare("SELECT name FROM meddolic_user_details WHERE user_id = ?");

    if($stmt) {
        $stmt->bind_param("s", $userId);
        $stmt->execute();
        $stmt->bind_result($name);

        if($stmt->fetch()) {
            echo json_encode(['success' => true, 'name' => $name]);
        } else {
            echo json_encode(['success' => false]);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => $con->error]);
    }

    $con->close(); // ✅ correct variable
}
?>