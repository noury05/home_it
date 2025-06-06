<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("location:../sign_up_sign_in/login.php?error=2");
}
include("../inc/connection.php");

$id = $_SESSION['user_id'];

if (isset($_POST['changePassword'])) {
    $current_password = $_POST['current_password'];
    $sql = "SELECT * FROM users WHERE user_id='$id' AND password='$current_password'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $new_password = $_POST['new_password'];
        $c_new_password = $_POST['confirm_new_password'];

        if ($new_password != $c_new_password) {
            $error = 'Password not matched!';
            $error_encoded = urlencode($error);
            header("Location:changePassword.php?error=$error_encoded");
        } else {
            $update = "UPDATE users SET password = '$new_password' WHERE user_id = $id";
            if (mysqli_query($con, $update)) {
                echo "<script>alert('Password changed successfully! Please log in with your new password.'); window.location.href='../sign_up_sign_in/login.php';</script>";
            } else {
                $error = 'Error updating password. Please try again.';
                $error_encoded = urlencode($error);
                header("Location:changePassword.php?error=$error_encoded");
            }
        }
    } else {
        $error = 'Incorrect current password!';
        $error_encoded = urlencode($error);
        header("Location:changePassword.php?error=$error_encoded");
    }
}
?>
