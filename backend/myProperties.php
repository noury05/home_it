<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location:../sign_up_sign_in/login.php?error=2");
    exit();
}
@include '../inc/connection.php';

$user_id = $_SESSION['user_id'];
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$type_id = isset($_GET['type_id']) ? $_GET['type_id'] : '';
$city_id = isset($_GET['city_id']) ? $_GET['city_id'] : '';

// Build the query with dynamic filters
$query = "SELECT * FROM properties WHERE user_id='$user_id'";
if ($status_filter !== 'all') {
    $query .= " AND status = '$status_filter'";
}
if (!empty($keyword)) {
    $query .= " AND (title LIKE '%$keyword%' OR description LIKE '%$keyword%')";
}
if (!empty($type_id)) {
    $query .= " AND type_id = '$type_id'";
}
if (!empty($city_id)) {
    $query .= " AND city_id = '$city_id'";
}
$my_properties = $con->query($query);

$has_active_filters =  !empty($keyword) || !empty($type_id) || !empty($city_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HomeIt - Your Trusted Partner in Finding the Perfect Home</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="../img/icon.png" rel="icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    <!-- Icon Font -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Style -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../css/style3.css" rel="stylesheet">
</head>
<body>
    <div class="container-xxl bg-white p-0">
        <!-- Navbar Start -->
        <div class="container-fluid nav-bar bg-transparent">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
                <a href="backend_index.php" class="navbar-brand d-flex align-items-center text-center">
                    <div class="icon p-2 me-2">
                        <img class="img-fluid" src="../img/icon.png" alt="Icon" style="width: 30px; height: 30px;">
                    </div>
                    <h1 class="m-0 text-primary">HomeIt</h1>
                </a>
                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto">
                        <a href="backend_index.php" class="nav-item nav-link">Home</a>
                        <a href="backend_about.php" class="nav-item nav-link">About</a>
                        <a href="backend_contact.php" class="nav-item nav-link">Contact</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">My account</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="editAccount.php" class="dropdown-item">Edit My Account</a>
                                <a href="addProperty.php" class="dropdown-item">Add Property</a>
                                <a href="myProperties.php" class="dropdown-item active">My Properties</a>
                                <a href="messages.php" class="dropdown-item">Messages</a>
                                <a href="logout.php" class="dropdown-item">Logout</a>
                            </div>
                        </div>
                    </div>
                    <a href="addProperty.php" class="btn btn-primary px-3 d-none d-lg-flex">Add Property</a>
                </div>
            </nav>
        </div>
        <!-- Navbar End -->

        <!-- Search Section Start -->
        <div class="container-fluid bg-primary mb-5" style="padding: 35px;">
            <div class="container">
                <form action="myProperties.php" method="get">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control border-0 py-3" name="keyword" placeholder="Search Keyword" value="<?= htmlspecialchars($keyword) ?>">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select border-0 py-3" name="type_id">
                                <option value="">Property Type</option>
                                <?php
                                $result = $con->query("SELECT * FROM property_types");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $selected = $type_id == $row['type_id'] ? 'selected' : '';
                                    echo "<option value='{$row['type_id']}' {$selected}>{$row['type']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select border-0 py-3" name="city_id">
                                <option value="">Location</option>
                                <?php
                                $result = $con->query("SELECT * FROM cities");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $selected = $city_id == $row['city_id'] ? 'selected' : '';
                                    echo "<option value='{$row['city_id']}' {$selected}>{$row['city']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-dark border-0 w-100 py-3">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Search Section End -->

        <!-- Filter and Clear Button Start -->
        <div class="d-flex justify-content-end mb-3">
            <?php if ($has_active_filters): ?>
                <a href="myProperties.php?status=<?= urlencode($status_filter) ?>" class="btn btn-outline-danger">Clear Filters</a>
            <?php endif; ?>
        </div>
        <div class="d-flex justify-content-end mb-3">
            <div>
                <ul class="nav nav-pills">
                    <li class="nav-item me-2">
                        <a href="?status=all&keyword=<?= urlencode($keyword) ?>&type_id=<?= $type_id ?>&city_id=<?= $city_id ?>" class="btn btn-outline-primary <?= $status_filter === 'all' ? 'active' : '' ?>">All</a>
                    </li>
                    <li class="nav-item me-2">
                        <a href="?status=available&keyword=<?= urlencode($keyword) ?>&type_id=<?= $type_id ?>&city_id=<?= $city_id ?>" class="btn btn-outline-primary <?= $status_filter === 'available' ? 'active' : '' ?>">Available</a>
                    </li>
                    <li class="nav-item me-2">
                        <a href="?status=sold&keyword=<?= urlencode($keyword) ?>&type_id=<?= $type_id ?>&city_id=<?= $city_id ?>" class="btn btn-outline-primary <?= $status_filter === 'sold' ? 'active' : '' ?>">Sold</a>
                    </li>
                    <li class="nav-item me-2">
                        <a href="?status=rented&keyword=<?= urlencode($keyword) ?>&type_id=<?= $type_id ?>&city_id=<?= $city_id ?>" class="btn btn-outline-primary <?= $status_filter === 'rented' ? 'active' : '' ?>">Rented</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="container mb-5">
            <?php if (mysqli_num_rows($my_properties) == 0) { ?>
                <div class="text-center">
                <h4 class="text-muted">No Properties found!</h4>
                <img src="../img/no_property.jpg" alt="No Messages" class="img-fluid my-3" style="max-width: 300px;">
                <p class="text-muted">There are currently no messages for this filter.</p>
            </div>
            <?php } else { ?>
                <h1 class="heading text-center">My Property List</h1>
                <!-- Filter by Status -->

                <div class="row g-4">
                    <?php while ($row = mysqli_fetch_assoc($my_properties)): ?>
                        <div class="col-md-4">
                            <a href="property_details.php?id=<?= $row['property_id'] ?>" class="text-decoration-none">
                                <div class="property-card border rounded shadow-sm">
                                    <div class="property-image">
                                        <img src="<?= $row['main_image'] ?: '../img/z-image1.webp' ?>" alt="Property" class="img-fluid">
                                        <span class="badge bg-primary position-absolute" style="top: 10px; left: 10px;">
                                            <?= ucfirst($row['status']) ?>
                                        </span>
                                    </div>
                                    <div class="p-3">
                                        <h5 class="property-title mb-1"><?= $row['title'] ?></h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php } ?>
        </div>
        <!-- Property List End -->

        <!-- Footer Start -->
        <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-4 col-md-6">
                        <h5 class="text-white mb-4">Get In Touch</h5>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Saida, Lebanon</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+961 001 563</p>
                        <p class="mb-2"><i class="fa fa-envelope me-3"></i>HomeIt@gmail.com</p>
                        <div class="d-flex pt-2">
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <h5 class="text-white mb-4">Quick Links</h5>
                        <a class="btn btn-link text-white-50" href="backend_about.php">About Us</a>
                        <a class="btn btn-link text-white-50" href="backend_contact.php">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="addProperty.php">Add Property</a>
                        <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                        <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <h5 class="text-white mb-4">About HomeIt</h5>
                        <p>HomeIt is your trusted partner in finding your dream home. We provide expert guidance every step of the way.</p>
                        <p><i class="fa fa-heart text-primary"></i> Built with passion and commitment.</p>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="copyright">
                    <div class="row">
                        <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                            &copy; <a class="border-bottom" href="#">HomeIt</a>
                        </div>
                        <div class="col-md-6 text-center text-md-end">
                            <div class="footer-menu">
                                <a href="#">Home</a>
                                <a href="#">Cookies</a>
                                <a href="#">Help</a>
                                <a href="#">FAQs</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="toastNotification" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Notification</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <!-- Toast message will be dynamically inserted here -->
                </div>
            </div>
        </div>

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toastElement = document.getElementById('toastNotification');
            const toastBody = toastElement.querySelector('.toast-body');

            <?php if (isset($_SESSION['toast_message'])): ?>
                toastBody.textContent = "<?= $_SESSION['toast_message']; ?>";
                const toast = new bootstrap.Toast(toastElement);
                toast.show();

                // Clear the session message
                <?php unset($_SESSION['toast_message']); ?>
            <?php endif; ?>
        });
    </script>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/wow/wow.min.js"></script>
    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>
</html>
