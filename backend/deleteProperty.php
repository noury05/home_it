<?php
session_start();

// Database connection
include '../inc/connection.php';

// Check if 'id' is set in the GET request
if (isset($_GET['id'])) {
    $propertyId = intval($_GET['id']);

    // Start a transaction to ensure data integrity
    mysqli_begin_transaction($con);

    try {
        // Delete from messages table
        $deleteMessagesQuery = "DELETE FROM messages WHERE property_id = ?";
        $stmt = mysqli_prepare($con, $deleteMessagesQuery);
        mysqli_stmt_bind_param($stmt, 'i', $propertyId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Delete from images table
        $deleteImagesQuery = "DELETE FROM images WHERE property_id = ?";
        $stmt = mysqli_prepare($con, $deleteImagesQuery);
        mysqli_stmt_bind_param($stmt, 'i', $propertyId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Delete from properties table
        $deletePropertyQuery = "DELETE FROM properties WHERE property_id = ?";
        $stmt = mysqli_prepare($con, $deletePropertyQuery);
        mysqli_stmt_bind_param($stmt, 'i', $propertyId);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Commit the transaction
        mysqli_commit($con);

        // Set success message in session
        $_SESSION['toast_message'] = 'Property deleted successfully.';

        // Redirect to myProperties.php
        header("Location: myProperties.php");
        exit;

    } catch (Exception $e) {
        // Rollback the transaction in case of error
        mysqli_rollback($con);

        // Set error message in session
        $_SESSION['toast_message'] = 'Failed to delete property. Please try again.';

        // Redirect to myProperties.php
        header("Location: myProperties.php");
        exit;
    }
} else {
    // Redirect if 'id' is not set
    $_SESSION['toast_message'] = 'No property ID provided.';
    header("Location: myProperties.php");
    exit;
}
?>
