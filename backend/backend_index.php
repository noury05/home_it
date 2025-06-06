<?php
    
  session_start();
  if (!isset($_SESSION['user_id'])){
    header("location:../sign_up_sign_in/login.php?error=2");
  }

  include '../inc/connection.php';

  $id = $_SESSION['user_id'];
  $status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';

  $query = "SELECT * FROM users WHERE user_id='$id'";
  $result = $con->query($query);

  $row = $result->fetch_assoc(); 
  $name = $row['name'];

  $sql = "SELECT * FROM users_reviews ORDER BY RAND() LIMIT 4";
  $all_reviews = $con->query($sql);

  $query = "SELECT * FROM properties WHERE user_id='$id'";
  if ($status_filter !== 'all') {
      $query .= " AND status = '$status_filter'";
  }

  $my_properties = $con->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HomeIt - Your Trusted Partner in Selling and Buying Properties</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="..\img\icon.png" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-xxl bg-white p-0">
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
                        <a href="backend_index.php" class="nav-item nav-link active">Home</a>
                        <a href="backend_about.php" class="nav-item nav-link">About</a>
                        <a href="backend_contact.php" class="nav-item nav-link">Contact</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">My account</a>
                            <div class="dropdown-menu rounded-0 m-0">
                                <a href="editAccount.php" class="dropdown-item">Edit My Account</a>
                                <a href="myProperties.php" class="dropdown-item">My Properties</a>
                                <a href="messages.php" class="dropdown-item">Messages</a>
                                <a href="addProperty.php" class="dropdown-item">Add Property</a>
                                <a href="logout.php" class="dropdown-item">Logout</a>
                            </div>
                        </div>
                    </div>
                    <a href="addProperty.php" class="btn btn-primary px-3 d-none d-lg-flex">Add Property</a>
                </div>
            </nav>
        </div>

        <div class="container-fluid bg-white p-0">
            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                <div class="col-md-6 p-5">
                    <h1 class="display-5 mb-4" style="font-family: 'Inter', sans-serif; color: #2a2a2a;">Welcome <span class="text-primary"><i><?= $name ?></i></span> to <span class="text-primary">HomeIt</span>!</h1>
                    <p class="mb-4">Our platform provides a seamless way to list your property for sale and connect with potential buyers. Simplify your property transactions with our user-friendly system and gain visibility for your real estate listings.</p>
                    <a href="#" class="btn btn-primary py-3 px-5">Get Started</a>
                </div>
                <div class="col-md-6">
                    <div class="header-carousel">
                        <img class="img-fluid w-100" src="../img/indexHeader.jpg" alt="Home Image">
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid bg-primary mb-5" style="padding: 35px;">
            <div class="container">
                <form action="myProperties.php" method="get">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text" class="form-control border-0 py-3" name="keyword" placeholder="Search Keyword">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select border-0 py-3" name="type_id">
                                <option value="">Property Type</option>
                                <?php
                                $result = $con->query("SELECT * FROM property_types");
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['type_id']}'>{$row['type']}</option>";
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
                                    echo "<option value='{$row['city_id']}'>{$row['city']}</option>";
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
                        <a class="btn btn-primary py-3 px-5 mt-3" href="backend_index.php">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->
         

        <!-- Property List Start -->
        <div class="container mb-5">
            <h1 class="heading text-center">My Property List</h1>
            <div class="d-flex justify-content-end mb-3">
                <ul class="nav nav-pills">
                    <li class="nav-item me-2">
                        <a href="?status=all" class="btn btn-outline-primary <?= $status_filter === 'all' ? 'active' : '' ?>">All</a>
                    </li>
                    <li class="nav-item me-2">
                        <a href="?status=available" class="btn btn-outline-primary <?= $status_filter === 'available' ? 'active' : '' ?>">Available</a>
                    </li>
                    <li class="nav-item me-2">
                        <a href="?status=sold" class="btn btn-outline-primary <?= $status_filter === 'sold' ? 'active' : '' ?>">Sold</a>
                    </li>
                    <li class="nav-item me-2">
                        <a href="?status=rented" class="btn btn-outline-primary <?= $status_filter === 'rented' ? 'active' : '' ?>">Rented</a>
                    </li>
                </ul>
            </div>

            <?php if (mysqli_num_rows($my_properties) == 0) { ?>
                <div class="text-center">
                    <h4 class="text-muted">No Properties found!</h4>
                    <img src="../img/no_property.jpg" alt="No Properties" class="img-fluid my-3" style="max-width: 300px;">
                    <p class="text-muted">There are currently no properties for this filter.</p>
                </div>
            <?php } else { ?>
                <div class="row g-3">
                    <?php 
                    $count = 0; 
                    while ($row = mysqli_fetch_assoc($my_properties)): 
                        if ($count >= 6) break; 
                        $count++;
                    ?>
                        <div class="col-md-4">
                            <a href="property_details.php?id=<?= $row['property_id'] ?>" class="text-decoration-none">
                                <div class="property-card border rounded shadow-sm" style="padding: 10px;">
                                    <div class="position-relative">
                                        <img src="<?= $row['main_image'] ?: '../img/z-image1.webp' ?>" alt="Property" class="img-fluid">
                                        <span class="badge bg-primary position-absolute" style="top: 10px; left: 10px;">
                                            <?= ucfirst($row['status']) ?>
                                        </span>
                                    </div>
                                    <div class="p-2 text-center">
                                        <h5 class="property-title mb-1" style="font-size: 1.1rem;"><?= $row['title'] ?></h5>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- View More Button -->
                <div class="text-center mt-4">
                    <a href="myProperties.php?status=<?= $status_filter ?>" class="btn btn-primary px-5 py-2">View More</a>
                </div>
            <?php } ?>
        </div>
        <!-- Property List End -->


        <!-- Add Property Section Start -->
        <div class="container py-5 bg-light rounded shadow-sm mt-5">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2 class="mb-4 text-primary fw-bold">Add Your Property Today</h2>
                    <p class="mb-5 fs-5 text-muted">
                        Easily list your property on HomeIt and connect with a vast network of potential buyers and renters. 
                        Showcase your property’s unique features and make your listing stand out. Whether it's for sale or rent, 
                        we provide you with the right tools to attract the right audience. Don’t wait, take the first step toward
                        finding the perfect deal.
                    </p>
                    <a href="addProperty.php" class="btn btn-primary px-5 py-3 shadow-sm">List Your Property</a>
                </div>
                <div class="col-md-6 text-center">
                    <img src="../img/z-photo5.jpg" alt="Add Property" style="width: 400px;" class="img-fluid rounded shadow-lg">
                </div>
            </div>
        </div>
        <!-- Add Property Section End -->


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
                                    <?php 
                                        $query="select name from users where user_id=".$row['user_id'];
                                        $result = mysqli_query($con, $query);  // Assuming $con is the active MySQL connection
                                        $property = mysqli_fetch_assoc($result);
                                        $name = $property ? $property['name'] : 'Unknown';
                                    ?>
                                        <h6 class="fw-bold mb-1"><?php echo $name; ?></h6>
                                        <small>user</small>
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
                        <a class="btn btn-link text-white-50" href="about.html">About Us</a>
                        <a class="btn btn-link text-white-50" href="contact.php">Contact Us</a>
                        <a class="btn btn-link text-white-50" href="addProperty.php">Add Property</a>
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
        // Save the scroll position in local storage before navigating to another filter
        function saveScrollPosition() {
            localStorage.setItem('scrollPosition', window.scrollY);
        }

        // Restore the scroll position when the page loads
        function restoreScrollPosition() {
            const scrollPosition = localStorage.getItem('scrollPosition');
            if (scrollPosition) {
                window.scrollTo(0, parseInt(scrollPosition));
                localStorage.removeItem('scrollPosition');  // Clear after restoring to avoid issues on subsequent loads
            }
        }

        // Attach click event to all filter buttons
        window.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.nav-pills .btn').forEach(button => {
                button.addEventListener('click', saveScrollPosition);
            });
            restoreScrollPosition();
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