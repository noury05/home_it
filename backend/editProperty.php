<?php
    
  session_start();

  if (!isset($_SESSION['user_id'])){
    header("location:../sign_up_sign_in/login.php?error=2");
  }
  include("../inc/connection.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HomeIt - Your Trusted Partner in Finding the Perfect Home</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="..\img\icon.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconect" href="https://fonts.googleapis.com">
    <link rel="preconect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
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
                                
                                <a href="editAccount.php" class="dropdown-item active">Edit My Account</a>
                                <a href="addProperty.php" class="dropdown-item">Add Property</a>
                                
                                <a href="myProperties.php" class="dropdown-item">My Properties</a>
                                <a href="messages.php" class="dropdown-item">Messages</a>

                                <a href="logout.php" class="dropdown-item">Logout</a>
                            </div>
                        </div>
                    </div>
                    <a href="addProperty.php" class="btn btn-primary px-3 d-none d-lg-flex">Add Property</a>
                </div>
            </nav>
        </div><br><br>
        <!-- Navbar End -->


        <?php
        

        // Check if 'id' is set in the GET request
        if (isset($_GET['id'])) {
            $propertyId = intval($_GET['id']);

            // Fetch property details
            $propertyQuery = "SELECT * FROM properties WHERE property_id = ?";
            $stmt = mysqli_prepare($con, $propertyQuery);
            mysqli_stmt_bind_param($stmt, 'i', $propertyId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $property = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
        }
        ?>

        <div class="container">
            <div class="contact-form">
                <h2>Edit Property</h2>

                <form action="editProperty_action.php?id=<?= $propertyId ?>" method="POST" enctype="multipart/form-data">
                    <!-- Property Image -->
                    <div class="profile-photo-container" style="width: 100%; max-width: 600px; margin: 0 auto;">
                        <img src="<?= !empty($property['main_image']) ? $property['main_image'] : '../img/z-image1.webp'; ?>" alt="Property Image" class="profile-photo" style="width: 100%; height: auto; border-radius: 12px; object-fit: cover;">
                    </div>
                    <label for="main_image">Change Property Image:</label>
                    <input type="file" id="main_image" name="main_image" accept="image/*">

                    <!-- Title -->
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" placeholder="Enter property title" value="<?= htmlspecialchars($property['title']); ?>" required>

                    <!-- Description -->
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" placeholder="Enter property description" required><?= htmlspecialchars($property['description']); ?></textarea>

                    <!-- Price -->
                    <label for="price">Price ($):</label>
                    <input type="number" id="price" name="price" placeholder="Enter property price" value="<?= htmlspecialchars($property['price']); ?>" required>

                    <!-- Address -->
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" placeholder="Enter property address" value="<?= htmlspecialchars($property['address']); ?>" required>

                    <!-- Bedrooms -->
                    <label for="bedrooms">Number of Bedrooms:</label>
                    <input type="number" id="bedrooms" name="bedrooms" placeholder="Enter number of bedrooms" value="<?= htmlspecialchars($property['bedrooms']); ?>" required>

                    <!-- Bathrooms -->
                    <label for="bathrooms">Number of Bathrooms:</label>
                    <input type="number" id="bathrooms" name="bathrooms" placeholder="Enter number of bathrooms" value="<?= htmlspecialchars($property['bathrooms']); ?>" required>

                    <!-- Square Feet -->
                    <label for="sqft">Area (sqft):</label>
                    <input type="number" id="sqft" name="sqft" placeholder="Enter area in square feet" value="<?= htmlspecialchars($property['sqft']); ?>" required>

                    <!-- Purpose -->
                    <label>Purpose:</label>
                    <div class="radio-group">
                        <label>
                            <input type="radio" name="purpose" value="for seff" <?= $property['purpose'] === 'for sell' ? 'checked' : ''; ?>> For Sale
                        </label>
                        <label>
                            <input type="radio" name="purpose" value="for rent" <?= $property['purpose'] === 'for rent' ? 'checked' : ''; ?>> For Rent
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" name="edit_property">Update Property</button>
                </form>
            </div>
        </div>




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
                        <p>HomeIt is your trusted partner in finding your dream home. Whether you're looking for apartments, 
                            villas, or real estate trends, we provide expert guidance every step of the way.</p>
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
</body>

</html>