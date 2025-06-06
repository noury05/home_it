<?php
// Include database connection
include '../inc/connection.php';

// Check if 'id' and 'action' are set in the GET request
if (isset($_GET['id']) && isset($_GET['action'])) {
    $messageId = intval($_GET['id']);
    $action = $_GET['action'];

    // Sanitize and validate the action
    $validActions = ['read', 'unread', 'resolved', 'ignore'];
    if (in_array($action, $validActions)) {
        // Update the status in the database
        $query = "UPDATE messages SET status = ? WHERE message_id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'si', $action, $messageId);

        if (mysqli_stmt_execute($stmt)) {
            // Status updated successfully
        } else {
            // Handle error if needed
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Handle invalid action if needed
    }
}

// Determine the referring page (fallback to 'messages.php' if not set)
$referringPage = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'messages.php';

// Redirect back
header("Location: $referringPage");

// Close the database connection
mysqli_close($con);
?>
