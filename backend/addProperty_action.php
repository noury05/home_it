<?php
include '../inc/connection.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    header("location:../sign_up_sign_in/login.php?error=2");
    exit();
}

if (isset($_POST['submit'])) {
    $user_id = $_SESSION['user_id'];

    // Retrieve and sanitize inputs
    $property_title = $con->real_escape_string($_POST['property_title']);
    $property_description = $con->real_escape_string($_POST['property_description']);
    $property_price = (float)$_POST['property_price'];
    $property_address = $con->real_escape_string($_POST['property_address']);
    $city_id = (int)$_POST['property_city'];
    $bedrooms = (int)$_POST['bedrooms'];
    $bathrooms = (int)$_POST['bathrooms'];
    $area = (int)$_POST['area'];
    $type_id = (int)$_POST['property_type'];
    $status = $con->real_escape_string($_POST['status']);
    $purpose = $_POST['purpose'];

    // File upload directories
    $mainImageDir = 'uploads/main_images/';
    $galleryImageDir = 'uploads/gallery_images/';
    if (!is_dir($mainImageDir)) mkdir($mainImageDir, 0777, true);
    if (!is_dir($galleryImageDir)) mkdir($galleryImageDir, 0777, true);

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'jfif'];

    // Handle main image upload
    if (!empty($_FILES['main_image']['tmp_name'])) {
        $mainImageExtension = strtolower(pathinfo($_FILES['main_image']['name'], PATHINFO_EXTENSION));
        if (!in_array($mainImageExtension, $allowedExtensions)) {
            echo "<div class='alert alert-danger'>Invalid main image format. Only JPG, JPEG, PNG, JFIF, and GIF are allowed.</div>";
            exit();
        }
        $mainImageTmpPath = $_FILES['main_image']['tmp_name'];
        $mainImageName = uniqid('main_') . '.' . $mainImageExtension;
        $mainImagePath = $mainImageDir . $mainImageName;
        move_uploaded_file($mainImageTmpPath, $mainImagePath);
    } else {
        echo "<div class='alert alert-danger'>Please upload a main image.</div>";
        exit();
    }

    // Check at least one gallery image is uploaded
    $galleryImages = [];
    for ($i = 1; $i <= 4; $i++) {
        $galleryImageInput = 'gallery_image_' . $i;
        if (!empty($_FILES[$galleryImageInput]['tmp_name'])) {
            $galleryImageExtension = strtolower(pathinfo($_FILES[$galleryImageInput]['name'], PATHINFO_EXTENSION));
            if (in_array($galleryImageExtension, $allowedExtensions)) {
                $galleryImageTmpPath = $_FILES[$galleryImageInput]['tmp_name'];
                $galleryImageName = uniqid("gallery_{$i}_") . '.' . $galleryImageExtension;
                $galleryImagePath = $galleryImageDir . $galleryImageName;
                move_uploaded_file($galleryImageTmpPath, $galleryImagePath);
                $galleryImages[] = $galleryImagePath;
            } else {
                echo "<div class='alert alert-danger'>Invalid gallery image format for image $i. Only JPG, JPEG, PNG, JFIF, and GIF are allowed.</div>";
                exit();
            }
        }
    }

    // Insert property details into the `properties` table
    $stmt = $con->prepare("
        INSERT INTO properties 
        (title, description, price, address, city_id, bedrooms, bathrooms, sqft, type_id, status, purpose, user_id, main_image) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        'ssdsiiiisssss',
        $property_title,
        $property_description,
        $property_price,
        $property_address,
        $city_id,
        $bedrooms,
        $bathrooms,
        $area,
        $type_id,
        $status,
        $purpose,
        $user_id,
        $mainImagePath
    );

    if ($stmt->execute()) {
        $property_id = $stmt->insert_id;

        // Insert gallery images into `images` table
        $imageStmt = $con->prepare("INSERT INTO images (property_id, image_url) VALUES (?, ?)");
        foreach ($galleryImages as $imagePath) {
            $imageStmt->bind_param('is', $property_id, $imagePath);
            $imageStmt->execute();
        }

        // Redirect to property details with success notification
        $_SESSION['success_message'] = 'Property added successfully!';
        header("Location: property_details.php?id=$property_id");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error adding property. Please try again.</div>";
    }
}
?>
