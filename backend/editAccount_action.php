<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location:../sign_up_sign_in/login.php?error=2");
    exit;
}

include("../inc/connection.php");

$id = $_SESSION['user_id'];

if (isset($_POST['delete_photo'])) {
    $sql = "UPDATE users SET profile_photo = NULL, updated_at = NOW() WHERE user_id = $id";
    mysqli_query($con, $sql);

    // Set success message in session
    $_SESSION['toast_message'] = 'Profile photo deleted successfully.';
    header("location:editAccount.php");
    exit;
}

if (isset($_POST['edit_info'])) {
    $name = $con->real_escape_string($_POST['name']);
    $phone = $con->real_escape_string($_POST['phone']);

    $sql = "UPDATE users SET name = '$name', phone = '$phone' WHERE user_id = $id";
    mysqli_query($con, $sql);

    // File upload directories
    $mainImageDir = 'uploads/profile_photo/';
    if (!is_dir($mainImageDir)) mkdir($mainImageDir, 0777, true);

    // Handle main image upload
    if (!empty($_FILES['profile_photo']['tmp_name'])) {
        $mainImageTmpPath = $_FILES['profile_photo']['tmp_name'];
        $fileType = mime_content_type($mainImageTmpPath);

        // Allowed MIME types
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/jfif', 'image/webp'];

        if (in_array($fileType, $allowedTypes)) {
            $mainImageName = uniqid('profile_') . '.' . pathinfo($_FILES['profile_photo']['name'], PATHINFO_EXTENSION);
            $mainImagePath = $mainImageDir . $mainImageName;

            if (move_uploaded_file($mainImageTmpPath, $mainImagePath)) {
                $sql = "UPDATE users SET profile_photo = '$mainImagePath', updated_at = NOW() WHERE user_id = $id";
                mysqli_query($con, $sql) or die(mysqli_error($con));

                // Set success message in session
                $_SESSION['toast_message'] = 'Profile information and photo updated successfully.';
                header("location:editAccount.php");
                exit;
            } else {
                echo "<script>
                    alert('Failed to upload image. Please retry.');
                    window.location.href = 'editAccount.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('Only image files (JPEG, PNG, GIF, JPG, JFIF, WEBP) are allowed.');
                window.location.href = 'editAccount.php';
            </script>";
        }
    } else {
        $_SESSION['toast_message'] = 'Profile information updated successfully.';
        header("location:editAccount.php");
        exit;
    }
}
?>
