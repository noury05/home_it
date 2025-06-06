<?php

    require_once '../inc/connection.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>HomeIt - Your Trusted Partner in Finding the Perfect Home</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    
    <!-- Favicon -->
    <link href="..\img\icon.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">

        <!-- Navbar Start -->
        <div class="container-fluid nav-bar bg-transparent">
            <nav class="navbar navbar-expand-lg bg-white navbar-light py-0 px-4">
                <a href="index.php" class="navbar-brand d-flex align-items-center text-center">
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
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="about.php" class="nav-item nav-link">About</a>
                        
                            <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle active" data-bs-toggle="dropdown">Property</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="../frontend/property-list.php" class="dropdown-item active">Property List</a>
                                <a href="../frontend/property_type.php" class="dropdown-item">Property Type</a>
                            </div>
                            </div>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                
                                <a href="../sign_up_sign_in/register.php" class="dropdown-item">SignUp</a>
                                
                                <a href="../sign_up_sign_in/login.php" class="dropdown-item">Login</a>
                                <a href="wishlist.php" class="dropdown-item">My Wishlist</a>
                            </div>
                        </div>
                        <a href="contact.php" class="nav-item nav-link">Contact</a>
                    </div>
                    <a href="../sign_up_sign_in/login.php" class="btn btn-primary px-3 d-none d-lg-flex">Login</a>
                </div>
            </nav>
        </div>
        <!-- Navbar End -->


        <!-- Header Start -->
        <div class="container-fluid header bg-white p-0">
            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6 p-5 mt-lg-5">
                    <h1 class="display-5 mb-4">Property List</h1> 
                        <nav aria-label="breadcrumb">
                        <ol class="breadcrumb text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item text-body active" aria-current="page">Property List</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6">
                    <img class="img-fluid" src="../img/z-header1.webp" alt="">
                </div>
            </div>
        </div>
        <!-- Header End -->


        
        
        <!-- Search Section Start -->
        <div class="container-fluid bg-primary mb-5" style="padding: 35px;">
            <div class="container">
                <div class="row g-2">
                    <!-- Start Form -->
                    <Center>
                    <form action="property-list.php" method="get">
                        <div class="col-md-10">
                            <div class="row g-2">
                                <!-- Search Keyword -->
                                <div class="col-md-4">
                                    <input type="text" class="form-control border-0 py-3" name="keyword" placeholder="Search Keyword" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
                                </div>

                                <!-- Property Type -->
                                <div class="col-md-3">
                                    <select class="form-select border-0 py-3" name="type_id">
                                        <option value="">Property Type</option>
                                        <?php
                                        // Fetch property types from the database
                                        $result = $con->query("SELECT * FROM property_types");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $selected = isset($_GET['type_id']) && $_GET['type_id'] == $row['type_id'] ? 'selected' : '';
                                            echo "<option value='{$row['type_id']}' {$selected}>{$row['type']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Location (City) -->
                                <div class="col-md-3">
                                    <select class="form-select border-0 py-3" name="city_id">
                                        <option value="">Location</option>
                                        <?php
                                        // Fetch cities from the database
                                        $result = $con->query("SELECT * FROM cities");
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $selected = isset($_GET['city_id']) && $_GET['city_id'] == $row['city_id'] ? 'selected' : '';
                                            echo "<option value='{$row['city_id']}' {$selected}>{$row['city']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-dark border-0 w-100 py-3">Search</button>
                                </div>  
                            </div>
                        </div>

                        <!-- Search Button -->
                        
                    </form></Center>
                    <!-- End Form -->
                </div>
            </div>
        </div>
        <!-- Search Section End -->



        <!-- Property List Start -->
        <div class="container-xxl py-5" id="property-listing">
            <div class="container">
                <div class="row g-0 gx-5 align-items-end">
                    <!-- Section Title -->
                    <div class="d-flex justify-content-between align-items-center mb-5">
                        <!-- Title -->
                        <div>
                            <h1 class="mb-0" id="property-type-div">Property Listing</h1>
                            <?php
                            // Fetch the filter values from the query string
                            $type_id = isset($_GET['type_id']) ? intval($_GET['type_id']) : null;
                            $city_id = isset($_GET['city_id']) ? intval($_GET['city_id']) : null;
                            $keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($con, $_GET['keyword']) : '';

                            // Initialize variables to hold type and city names
                            $type_name = '';
                            $city_name = '';

                            // Fetch the type name if type_id is set
                            if ($type_id) {
                                $type_query = "SELECT type FROM property_types WHERE type_id = $type_id LIMIT 1";
                                $type_result = mysqli_query($con, $type_query);
                                if ($type_result && mysqli_num_rows($type_result) > 0) {
                                    $type_row = mysqli_fetch_assoc($type_result);
                                    $type_name = htmlspecialchars($type_row['type']);
                                }
                            }

                            // Fetch the city name if city_id is set
                            if ($city_id) {
                                $city_query = "SELECT city FROM cities WHERE city_id = $city_id LIMIT 1";
                                $city_result = mysqli_query($con, $city_query);
                                if ($city_result && mysqli_num_rows($city_result) > 0) {
                                    $city_row = mysqli_fetch_assoc($city_result);
                                    $city_name = htmlspecialchars($city_row['city']);
                                }
                            }

                            // If filters are set, display the search summary
                            if ($type_name || $city_name || $keyword):
                            ?>
                            <div class="search-summary mt-2">
                                <h4 style="color: #00B98E;">
                                    <span style="color: black;">Filtered Search:</span> 
                                    <?php if ($type_name): ?>
                                        Type: <?= $type_name ?>
                                    <?php endif; ?>
                                    <?php if ($city_name): ?>
                                        | Location: <?= $city_name ?>
                                    <?php endif; ?>
                                    <?php if ($keyword): ?>
                                        | Keyword: <?= htmlspecialchars($keyword) ?>
                                    <?php endif; ?>
                                </h4>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Filter Tabs and Clear Filter Button -->
                        <div class="d-flex align-items-center">
                            <?php
                            $has_active_filters = !empty($_GET['keyword']) || !empty($_GET['city_id']) || !empty($_GET['type_id']);
                            $x = !empty($_GET['purpose']) ? $_GET['purpose'] : '';
                            if ($has_active_filters): ?>
                            <a href="property-list.php" class="btn btn-outline-danger me-3 clear-filter">Clear Filters</a>
                            <?php endif; ?>
                            <ul class="nav nav-pills d-inline-flex">
                                <li class="nav-item me-2">
                                    <a class="btn btn-outline-primary xxc <?= !isset($_GET['purpose']) ? 'active' : '' ?>" href="<?= buildUrl(['purpose'=>null,'page' => 1]) ?>">All</a>
                                </li>
                                <li class="nav-item me-2">
                                    <a class="btn btn-outline-primary xxc <?= (isset($_GET['purpose']) && $_GET['purpose'] == 'for sell') ? 'active' : '' ?>" href="<?= buildUrl(['purpose' => 'for sell', 'page' => 1]) ?>">For Sell</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-outline-primary xxc <?= (isset($_GET['purpose']) && $_GET['purpose'] == 'for rent') ? 'active' : '' ?>" href="<?= buildUrl(['purpose' => 'for rent', 'page' => 1]) ?>">For Rent</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <?php
                        // Set pagination variables
                        $limit = 12; // Properties per page
                        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
                        $offset = ($page - 1) * $limit;

                        // Build the query based on filters
                        $filter_query = "SELECT * FROM properties WHERE status = 'available'";

                        // Apply filters
                        if (!empty($_GET['purpose'])) {
                            $purpose = mysqli_real_escape_string($con, $_GET['purpose']);
                            $filter_query .= " AND purpose = '$purpose'";
                        }

                        if (!empty($_GET['type_id'])) {
                            $type_id = intval($_GET['type_id']);
                            $filter_query .= " AND type_id = $type_id";
                        }

                        if (!empty($_GET['city_id'])) {
                            $city_id = intval($_GET['city_id']);
                            $filter_query .= " AND city_id = $city_id";
                        }

                        if (!empty($_GET['keyword'])) {
                            $keyword = mysqli_real_escape_string($con, $_GET['keyword']);
                            $filter_query .= " AND title LIKE '%$keyword%'";
                        }

                        // Get total number of properties
                        $result = mysqli_query($con, $filter_query);
                        $total_properties = mysqli_num_rows($result);
                        $total_pages = ceil($total_properties / $limit);

                        // Apply LIMIT for pagination
                        $filter_query .= " LIMIT $offset, $limit";

                        // Execute the paginated query
                        $properties = mysqli_query($con, $filter_query);
                        ?>
                        <!-- Property Cards -->
                        <div class="row g-4">
                            <?php if (mysqli_num_rows($properties) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($properties)): ?>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="property-item rounded overflow-hidden">
                                            <div class="position-relative overflow-hidden">
                                                <a href="property_details.php?id=<?= $row['property_id'] ?>">
                                                    <img class="img-fluid" src="<?= $row['main_image'] ?: '../img/z-image1.webp' ?>" alt="" style="width: 3000px; height: 300px; object-fit: cover;">
                                                </a>
                                                <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">
                                                    <?= $row["purpose"] ?>
                                                </div>
                                                <!-- Wishlist Button -->
                                                <button 
                                                    class="wishlist-btn btn btn-outline-danger position-absolute top-0 end-0 m-4" 
                                                    style="border-radius: 50%;display: flex;align-items: center;width: 40px;height: 40px;"
                                                    data-property-id="<?= $row['property_id'] ?>">
                                                    <i class="fa fa-heart"></i>
                                                </button>
                                                <div aria-live="polite" aria-atomic="true" class="position-fixed bottom-0 end-0 p-3" style="z-index: 1055">
                                                    <div id="wishlist-toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
                                                        <div class="toast-header">
                                                            <strong class="me-auto">Wishlist</strong>
                                                            <small class="text-muted">just now</small>
                                                            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                                                        </div>
                                                        <div class="toast-body">
                                                            Notification message here.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="p-4 pb-0">
                                                <h5 class="text-primary mb-3">$<?= $row["price"] ?></h5>
                                                <a class="d-block h5 mb-2" href="property_details.php?id=<?= $row['property_id'] ?>">
                                                    <?= $row["title"] ?>
                                                </a>
                                                <p><i class="fa fa-map-marker-alt text-primary me-2"></i><?= $row["address"] ?></p>
                                            </div>
                                            <div class="d-flex border-top">
                                                <small class="flex-fill text-center border-end py-2">
                                                    <i class="fa fa-ruler-combined text-primary me-2"></i><?= $row["sqft"] ?> Sqft
                                                </small>
                                                <small class="flex-fill text-center border-end py-2">
                                                    <i class="fa fa-bed text-primary me-2"></i><?= $row["bedrooms"] ?> Bed
                                                </small>
                                                <small class="flex-fill text-center py-2">
                                                    <i class="fa fa-bath text-primary me-2"></i><?= $row["bathrooms"] ?> Bath
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="col-12 text-center">
                                    <img src="../img/no_property.jpg" alt="No properties found" class="img-fluid mb-3" style="max-width: 300px; height: auto;">
                                    <p>No properties match your search criteria. Please try adjusting your filters.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <nav>
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                        <a class="page-link scroll-to-listing" href="<?= buildUrl(['page' => $i]) ?>#property-listing">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- Property List End -->

        <?php
        // Function to build dynamic URLs with preserved query parameters
        function buildUrl($params = []) {
            $query = array_merge($_GET, $params);
            return '?' . http_build_query($query);
        }
        ?>
        <script>
            // Handle Clear Filters
            document.querySelectorAll('.clear-filter').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const href = e.target.href || e.target.parentNode.href;
                    location.href = href + '#property-listing';
                });
            });
            document.querySelectorAll('.xxc').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const href = e.target.href || e.target.parentNode.href;
                    location.href = href + '#property-listing';
                });
            });
        </script>

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
                        <a class="btn btn-link text-white-50" href="about.php">About Us</a>
                        <a class="btn btn-link text-white-50" href="contact.php">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="properties-list.php">Properties List</a>
                        <a class="btn btn-link text-white-50" href="">Privacy Policy</a>
                        <a class="btn btn-link text-white-50" href="">Terms & Condition</a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <h5 class="text-white mb-4">About HomeIt</h5>
                        <p>HomeIt is your trusted partner in finding your dream home. Whether you're looking for apartments, villas, or real estate trends, we provide expert guidance every step of the way.</p>
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


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Check if 'type_id' is present in the URL
            const urlParams = new URLSearchParams(window.location.search);
            const typeId = urlParams.get("type_id");

            if (typeId || purpose) {
                // Scroll to the specific div
                const targetDiv = document.getElementById("property-listing");
                if (targetDiv) {
                    targetDiv.scrollIntoView({ behavior: "smooth", block: "center" });
                }
            }
        });
    </script>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/wow/wow.min.js"></script>
    
    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
    <script>
        
        document.addEventListener("DOMContentLoaded", function () {
            function getWishlist() {
                const wishlistCookie = document.cookie
                    .split("; ")
                    .find((row) => row.startsWith("wishlist="));
                try {
                    return wishlistCookie ? JSON.parse(decodeURIComponent(wishlistCookie.split("=")[1])) : [];
                } catch (error) {
                    console.error("Failed to parse wishlist cookie:", error);
                    return [];
                }
            }

            function saveWishlist(wishlist) {
                const expiryDate = new Date();
                expiryDate.setFullYear(expiryDate.getFullYear() + 1);
                document.cookie = `wishlist=${encodeURIComponent(
                    JSON.stringify(wishlist)
                )}; expires=${expiryDate.toUTCString()}; path=/`;
            }

            function updateWishlistButtons() {
                const wishlist = getWishlist();
                document.querySelectorAll(".wishlist-btn").forEach((button) => {
                    const propertyId = button.getAttribute("data-property-id");
                    const icon = button.querySelector("i");

                    if (wishlist.includes(propertyId)) {
                        button.classList.add("active");
                        icon.className = 'fa fa-heart'; // Filled heart icon
                    } else {
                        button.classList.remove("active");
                        icon.className = 'fa fa-heart'; // Outline heart icon
                    }
                });
            }

            function showToast(message) {
                const toastElement = document.getElementById('wishlist-toast');
                const toastBody = toastElement.querySelector('.toast-body');
                toastBody.textContent = message;
                
                const toast = new bootstrap.Toast(toastElement); // Initialize Bootstrap toast
                toast.show(); // Show the toast
            }

            document.body.addEventListener("click", function (e) {
                if (e.target.closest(".wishlist-btn")) {
                    const button = e.target.closest(".wishlist-btn");
                    const propertyId = button.getAttribute("data-property-id");
                    let wishlist = getWishlist();

                    if (wishlist.includes(propertyId)) {
                        wishlist = wishlist.filter((id) => id !== propertyId);
                        showToast("Removed from wishlist");
                    } else {
                        wishlist.push(propertyId);
                        showToast("Added to wishlist");
                    }

                    saveWishlist(wishlist);
                    updateWishlistButtons();
                }
            });

            updateWishlistButtons();
        });
    </script>
</body>

</html>