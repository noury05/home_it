<?php
  include "../inc/connection.php";

  session_start();
  if (!isset($_SESSION['user_id'])){
    header("location:../sign_up_sign_in/login.php?error=2");
    exit();
  }

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
                                
                                <a href="editAccount.php" class="dropdown-item">Edit My Account</a>
                                <a href="addProperty.php" class="dropdown-item active">Add Property</a>
                                
                                <a href="myProperties.php" class="dropdown-item">My Properties</a>
                                <a href="messages.php" class="dropdown-item">Messages</a>

                                <a href="logout.php" class="dropdown-item">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
        <!-- Navbar End -->


        <!-- Add Property Start -->
        <div class="container">
            <div class="title">
                <br><br><h1>Add Property</h1>
            </div>
            <form class="contact-form" action="addProperty_action.php" method="POST" enctype="multipart/form-data">
                <h2>Property Details</h2>

                <!-- Property Title -->
                <input type="text" name="property_title" placeholder="Property Title" required>

                <!-- Property Description -->
                <textarea name="property_description" placeholder="Property Description" required></textarea>

                <!-- Property Price -->
                <input type="number" name="property_price" placeholder="Price ($)" required>

                <!-- Address -->
                <input type="text" name="property_address" placeholder="Address" required>
                <h3>The property is for </h3>
                <div>
                    <label><input type="radio" name="purpose" value="for sell" required> Sell</label>
                    <label><input type="radio" name="purpose" value="for rent" required> Rent</label>
                </div>
                <!-- City -->
                <h3>City</h3>
                <select id='cities' name="property_city" required>
                <option value="">Select City</option>
                    <?php
                        $sql="SELECT * FROM cities";

                        $result=mysqli_query($con,$sql);

                        while($row=mysqli_fetch_assoc($result)){

                        echo"<option value=".$row['city_id'].">".$row['city']."</option>";
                        }
                    ?>
                </select><br>

                <!-- Number of Bedrooms -->
                <input type="number" name="bedrooms" placeholder="Number of Bedrooms" required>

                <!-- Number of Bathrooms -->
                <input type="number" name="bathrooms" placeholder="Number of Bathrooms" required>

                <!-- Area in sqft -->
                <input type="number" name="area" placeholder="Area (sqft)" required><br>

                <!-- Property Type -->
                <h3>Property Type</h3>
                <select name="property_type" required>
                    <option value="">Select Type</option>
                    <?php
                    $types = $con->query("SELECT type_id, type FROM property_types");
                    while ($type = $types->fetch_assoc()): ?>
                        <option value="<?= $type['type_id'] ?>"><?= $type['type'] ?></option>
                    <?php endwhile; ?>
                </select><br>

                <!-- Property Status -->
                <h3>Status</h3>
                <div>
                    <label><input type="radio" name="status" value="available" required> Available</label>
                    <label><input type="radio" name="status" value="rented" required> Rented</label>
                    <label><input type="radio" name="status" value="sold" required> Sold</label>
                </div><br>

                <!-- Main Image -->
                <h3>Main Image</h3>
                <input type="file" name="main_image" accept="image/*" id="mainImageInput" required>
                <img id="mainImagePreview" src="" alt="Main Image Preview" style="display:none; max-width: 200px; margin-top: 10px;"><br>

                <!-- Gallery Images -->
                <h3>Gallery Images</h3>
                <div class="gallery-container">
                    <input type="file" name="gallery_image_1" accept="image/*" id="galleryImageInput1" required>
                    <img id="galleryImagePreview1" src="" alt="Gallery Image 1 Preview" style="display:none; max-width: 150px; margin-top: 10px;">
                    
                    <input type="file" name="gallery_image_2" accept="image/*" id="galleryImageInput2" required>
                    <img id="galleryImagePreview2" src="" alt="Gallery Image 2 Preview" style="display:none; max-width: 150px; margin-top: 10px;">
                    
                    <input type="file" name="gallery_image_3" accept="image/*" id="galleryImageInput3" required>
                    <img id="galleryImagePreview3" src="" alt="Gallery Image 3 Preview" style="display:none; max-width: 150px; margin-top: 10px;">
                    
                    <input type="file" name="gallery_image_4" accept="image/*" id="galleryImageInput4" required>
                    <img id="galleryImagePreview4" src="" alt="Gallery Image 4 Preview" style="display:none; max-width: 150px; margin-top: 10px;">
                </div><br>

                <script>
                                        
                    function previewImage(inputElement, previewElementId) {
                        const file = inputElement.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const previewElement = document.getElementById(previewElementId);
                                previewElement.src = e.target.result;
                                previewElement.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        }
                    }

                    document.getElementById('mainImageInput').addEventListener('change', function() {
                        previewImage(this, 'mainImagePreview');
                    });

                    for (let i = 1; i <= 4; i++) {
                        const galleryInput = document.getElementById('galleryImageInput' + i);
                        galleryInput.addEventListener('change', function() {
                            previewImage(this, 'galleryImagePreview' + i);
                        });
                    }


                </script>

                <!-- Submit Button -->
                <button type="submit" name="submit">Add Property</button>
            </form>
        </div><br>
        <!-- Add Property End -->


  
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

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="../js/wow/wow.min.js"></script>
    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
    

</div>
</body>
</html>