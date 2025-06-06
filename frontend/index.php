<?php

    

  require_once '../inc/connection.php';

  $sql = "SELECT * FROM client_reviews ORDER BY RAND() LIMIT 4";
  $all_reviews = $con->query($sql);

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
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="about.php" class="nav-item nav-link">About</a>
                        
                            <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Property</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="../frontend/property-list.php" class="dropdown-item">Property List</a>
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
        <div class="container-fluid bg-white p-0">
            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6 p-5">
                    <h1 class="display-5 mb-4">Find A <span class="text-primary">Perfect Home</span> To Live With Your Family</h1>
                    <p class="mb-4">Discover homes designed for family living spacious rooms, safe neighborhoods, and modern amenities. Make the best choice for your loved ones today and start your journey toward a happier, more comfortable life.</p>
                    <a href="#" class="btn btn-primary py-3 px-5">Get Started</a>
                </div>
                <div class="col-md-6">
                    <div class="header-carousel">
                        <img class="img-fluid w-100" src="../img/carousel-1.jpg" alt="Home Image">
                    </div>
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




        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="about-img position-relative overflow-hidden p-5 pe-0">
                            <img class="img-fluid w-100" src="../img/about-us-pexels.jpg">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <h1 class="mb-4">#1 Place To Find The Perfect Property</h1>
                        <p class="mb-4">Discover your dream home with us! From cozy apartments to luxurious villas, 
                                        we offer a wide range of properties tailored to suit every lifestyle and budget.<br>
                                        Explore our listings, get expert guidance, and make your next move stress-free. 
                                        Start your journey to the perfect property today!"</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Browse properties that match your vision and budget.</p>
                        <p><i class="fa fa-check text-primary me-3"></i>From start to finish, we`re here to guide you to your perfect property.</p>
                        <p><i class="fa fa-check text-primary me-3"></i>Start your journey to a new home with our trusted guidance.</p>
                        <a class="btn btn-primary py-3 px-5 mt-3" href="about.php">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Category Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5" style="max-width: 600px;">
                    <h1 class="mb-3">Property Types</h1>
                    <p>This section outlines the various property types available, 
                        including houses, villas, shops, apartments, and offices.</p>
                </div>
                <div class="row g-4">
                    <?php
                    // Query to fetch all property types and their images
                    $query = "SELECT type_id, type, image FROM property_types";
                    $result = mysqli_query($con, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $type_id = $row['type_id'];
                        $type = $row['type'];
                        $image = $row['image'];

                        // Query to count properties of the current type
                        $count_query = "SELECT COUNT(*) AS property_count FROM properties WHERE type_id = $type_id and status='available'";
                        $count_result = mysqli_query($con, $count_query);
                        $count_row = mysqli_fetch_assoc($count_result);
                        $property_count = $count_row['property_count'] ?? 0;
                    ?>
                        <div class="col-lg-3 col-sm-6">
                            <a class="cat-item d-block bg-light text-center rounded p-3" href="property-list.php?type_id=<?php echo urlencode($type_id); ?>">
                                <div class="rounded p-4">
                                    <div class="icon mb-3">
                                        <img class="img-fluid" src="<?php echo $image; ?>" alt="<?php echo $type; ?>" style="width: 60px; height: 60px;">
                                    </div>
                                    <h6><?php echo $type; ?></h6>
                                    <span class="font-weight-bolder mb-0">
                                        <?php echo $property_count; ?> properties
                                    </span>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <!-- Category End -->



       <!-- Property List Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="row g-0 gx-5 align-items-end">
                    <!-- Section Title -->
                    <div class="col-lg-6">
                        <div class="text-start mx-auto mb-5">
                            <h1 class="mb-3">Property Listing</h1>
                            <p>Check out our latest property listings, offering a range of options for every taste and budget. Detailed information and high-quality images help you find your ideal home.</p>
                        </div>
                    </div>
                    <!-- Tabs -->
                    <div class="col-lg-6 text-start text-lg-end">
                        <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                            <li class="nav-item me-2">
                                <a class="btn btn-outline-primary active" data-bs-toggle="pill" href="#tab-1">Featured</a>
                            </li>
                            <li class="nav-item me-2">
                                <a class="btn btn-outline-primary" data-bs-toggle="pill" href="#tab-2">For Sell</a>
                            </li>
                            <li class="nav-item me-0">
                                <a class="btn btn-outline-primary" data-bs-toggle="pill" href="#tab-3">For Rent</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tab Content -->
                <!-- Tab Content -->
                <div class="tab-content">
                    <?php 
                    // Tabs Array
                    $all_properties = $con->query("SELECT * FROM properties WHERE status = 'available' ORDER BY RAND() LIMIT 6");
                    $sell_properties = $con->query("SELECT * FROM properties WHERE purpose = 'for sell' AND status = 'available' ORDER BY RAND() LIMIT 6");
                    $rent_properties = $con->query("SELECT * FROM properties WHERE purpose = 'for rent' AND status = 'available' ORDER BY RAND() LIMIT 6");
                    
                    $tabs = [
                        'tab-1' => $all_properties,
                        'tab-2' => $sell_properties,
                        'tab-3' => $rent_properties,
                    ];
                    foreach ($tabs as $tabId => $properties): ?>
                    <div id="<?= $tabId ?>" class="tab-pane fade <?= $tabId === 'tab-1' ? 'show active' : '' ?> p-0">
                        <div class="row g-4">
                            <?php while ($row = mysqli_fetch_assoc($properties)): ?>
                                <!-- Property Card -->
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
                            <!-- Browse More Button -->
                            <div class="col-12 text-center">
                                <a class="btn btn-primary py-3 px-5" href="property-list.php">Browse More Properties</a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
        <!-- Property List End -->


        <!-- Testimonial Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center mx-auto mb-5"style="max-width: 600px;">
                    <h1 class="mb-3">Our Clients Say!</h1>
                    <p>Take a look at what our clients are saying about their experience with us. From personalized service to finding 
                        the ideal home, we're committed to making every client's dream come true.</p>
                </div>

                <div class="owl-carousel testimonial-carousel">
                <?php 
                if ($all_reviews) {
                    while ($row = mysqli_fetch_assoc($all_reviews)) { ?>
                        <div class="testimonial-item bg-light rounded p-3">
                            <div class="bg-white border rounded p-4">
                                <p><?php echo htmlspecialchars($row["message"]); ?></p>
                                <div class="d-flex align-items-center">
                                    <img class="img-fluid flex-shrink-0 rounded" 
                                        src="../img/dumbo.jfif" 
                                        style="width: 45px; height: 45px;">
                                    <div class="ps-3">
                                        <h6 class="fw-bold mb-1"><?php echo htmlspecialchars($row["name"]); ?></h6>
                                        <small>client</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php 
                    }
                } else {
                    echo "<p>No testimonials available at this time.</p>";
                }
                ?>
                </div>
            </div>
        </div>
        <!-- Testimonial End -->


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