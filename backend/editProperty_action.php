<?php
// editProperty_action.php

include '../inc/connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("location:../sign_up_sign_in/login.php?error=2");
    exit();
}

if (isset($_GET['id']) && isset($_POST['edit_property'])) {
    $propertyId = intval($_GET['id']);

    // Sanitize and retrieve form inputs
    $title = $con->real_escape_string($_POST['title']);
    $description = $con->real_escape_string($_POST['description']);
    $price = (float)$_POST['price'];
    $address = $con->real_escape_string($_POST['address']);
    $bedrooms = (int)$_POST['bedrooms'];
    $bathrooms = (int)$_POST['bathrooms'];
    $sqft = (int)$_POST['sqft'];
    $purpose = $con->real_escape_string($_POST['purpose']);

    // Handle main image upload if a new file is provided
    $mainImagePath = null;
    if (!empty($_FILES['main_image']['tmp_name'])) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];
        $mainImageExtension = strtolower(pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION));

        if (in_array($mainImageExtension, $allowedExtensions)) {
            $mainImageDir = 'uploads/main_images/';
            if (!is_dir($mainImageDir)) mkdir($mainImageDir, 0777, true);

            $mainImageTmpPath = $_FILES['main_image']['tmp_name'];
            $mainImageName = uniqid('main_') . '.' . $mainImageExtension;
            $mainImagePath = $mainImageDir . $mainImageName;
            move_uploaded_file($mainImageTmpPath, $mainImagePath);
        } else {
            $_SESSION['toast_message'] = 'Invalid main image format. Only JPG, JPEG, PNG, and GIF are allowed.';
            header("Location: property_details.php?id=$propertyId");
            exit();
        }
    }

    // Update query
    $query = "UPDATE properties SET 
                title = '$title', 
                description = '$description', 
                price = $price, 
                address = '$address', 
                bedrooms = $bedrooms, 
                bathrooms = $bathrooms, 
                sqft = $sqft, 
                purpose = '$purpose', 
                updated_at = NOW()";

    // Include main_image in the update if a new file was uploaded
    if ($mainImagePath) {
        $query .= ", main_image = '$mainImagePath'";
    }

    $query .= " WHERE property_id = $propertyId";

    if ($con->query($query)) {
        $_SESSION['toast_message'] = 'Property updated successfully!';
        header("Location: property_details.php?id=$propertyId");
        exit();
    } else {
        $_SESSION['toast_message'] = 'Error updating property. Please try again.';
        header("Location: property_details.php?id=$propertyId");
        exit();
    }
} else {
    $_SESSION['toast_message'] = 'Invalid request.';
    header("Location: property_details.php?id=$propertyId");
    exit();
}
?>
