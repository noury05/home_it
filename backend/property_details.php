<?php
    
  session_start();
  if (!isset($_SESSION['user_id'])){
    header("location:../sign_up_sign_in/login.php?error=2");
    exit();
  }
  @include '../inc/connection.php';

  $user_id=$_SESSION['user_id'];
  $artID=$_GET['id'];

  $sql = "SELECT * FROM messages WHERE user_id='$user_id' AND property_id='$artID'";
  $messages=$con->query($sql);

  if (isset($_SESSION['success_message'])) {
    echo "<script>window.addEventListener('DOMContentLoaded', function() {
        showToast('{$_SESSION['success_message']}');
    });</script>";
    unset($_SESSION['success_message']);
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
    <style>
        .toast-container {
            z-index: 1050;
        }
    </style>
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



        <!-- -------------------------PHP code--------------------------------- -->
        <?php
            $artID=$_GET['id'];

            $sql="SELECT * FROM properties WHERE property_id='$artID'";
            $result=mysqli_query($con,$sql);
            $row = mysqli_fetch_assoc($result);

            $sqll="SELECT * FROM images WHERE property_id='$artID'";
            $resultt=mysqli_query($con,$sqll);
        ?>
        <!-- -------------------------PHP code--------------------------------- -->

        <!-- property detail start -->
        <div class="container">
            <!-- Featured Image -->
            <div class="featured-image">
                <img src="<?=$row['main_image'] ?: '../img/z-image1.webp'?>" alt="Featured Villa">
            </div>

            <header class="title">
                <h1><?= $row["title"]; ?></h1>
                <div class="tags">
                <?php 
                    $type_query = $con->query("SELECT type FROM property_types WHERE type_id = " . $row['type_id']);
                    $property_type = mysqli_fetch_assoc($type_query)['type'];
                ?>
                    <span class="tag featured"><?= $property_type ?></span>
                    <span class="tag for-sale"><?= $row["purpose"]; ?></span>
                </div>
                <div class="price">$<?= $row["price"]; ?></div>
            </header>
            
            <div class="content">
                <section class="description">
                    <h2>Description</h2>
                    <p><?= $row["description"]; ?></p>
                </section>

                <section class="address">
                    <h2>More Information</h2>
                    <table>
                        <tr>
                            <th>Address</th>
                            <td><?= $row["address"]; ?></td>
                        </tr>
                        <tr>
                        <?php 
                            $city_query = $con->query("SELECT city FROM cities WHERE city_id = " . $row['city_id']);
                            $city = mysqli_fetch_assoc($city_query)['city'];
                        ?>
                            <th>City</th>
                            <td><?= $city ?></td>
                        </tr>
                        <tr>
                            <th>Number of bedrooms</th>
                            <td><?= $row["bedrooms"]; ?></td>
                        </tr>
                        <tr>
                            <th>Number of bathrooms</th>
                            <td><?= $row["bathrooms"]; ?></td>
                        </tr>
                        <tr>
                            <th>Area of the house</th>
                            <td><?= $row["sqft"]; ?> square feet</td>
                        </tr>
                    </table>
                </section>
            </div><br>

            <div class="status-container">
                <p id="status-text">Status: <?= $row["status"]; ?></p>
                <button id="change-btn" onclick="toggleUpdateSection()">Change Status</button>
                <div id="update-section" class="hidden">
                    <form action="update_status.php?id=<?= $row['property_id'] ?>" method="POST">
                        <label>
                            <input type="radio" name="status" value="Available" 
                                <?= $row["status"] === 'available' ? 'checked' : ''; ?>> Available
                        </label>
                        <label>
                            <input type="radio" name="status" value="Rented" 
                                <?= $row["status"] === 'rented' ? 'checked' : ''; ?>> Rented
                        </label>
                        <label>
                            <input type="radio" name="status" value="Sold" 
                                <?= $row["status"] === 'sold' ? 'checked' : ''; ?>> Sold
                        </label>
                        <button type="submit" name="update_status">Update Status</button>
                    </form>
                </div>
            </div>

            <!-- Image Gallery -->
            <section class="gallery">
                <h2>Take a look inside...</h2>
                <div class="gallery-container">
                    <?php while ($images = mysqli_fetch_assoc($resultt)): ?>
                        <img src="<?= $images["image_url"] ?: '../img/z-image1.webp'?>" alt="">
                    <?php endwhile; ?>
                </div>
                <!-- Edit and Delete Buttons -->
                <div class="property-actions" style="text-align: center; margin-top: 20px;">
                    <a href="editProperty.php?id=<?= $row['property_id'] ?>" class="btn styled-button" style="display: inline-block; padding: 10px 20px; color: white; text-decoration: none; border-radius: 5px; margin-right: 10px;">Edit Property</a>
                    <button class="btn delete-btn" onclick="confirmDelete(<?= $row['property_id'] ?>)" style="padding: 10px 20px; background-color: #DC3545; color: white; border: none; border-radius: 5px; cursor: pointer;">Delete Property</button>
                </div>
            </section><br>
        </div>

        <div class="messages-container">
            <h2>Messages from Interested Clients</h2>
            <?php if (mysqli_num_rows($messages) == 0): ?>
                <div class="message-card">
                    <h3>No messages sent</h3>
                </div>
            <?php else: ?>
                <?php while ($msg_row = mysqli_fetch_assoc($messages)): ?>
                    <div class="message-card">
                    <h3>Message marked as <span style="font-size: smaller;"><i>--> <?= htmlspecialchars($msg_row['status']) ?></i></span></h3>
                    <?php 
                        $query="select title from properties where property_id=".$msg_row['property_id'];
                        $result = mysqli_query($con, $query);  // Assuming $con is the active MySQL connection
                        $property = mysqli_fetch_assoc($result);
                        $title = $property ? $property['title'] : 'Unknown Property';
                    ?>
                    <h5>Intended Property <span style="font-size: smaller;"><i>--> <?= $title?></i></span></h5>
                    <p><?= htmlspecialchars($msg_row['client_message']) ?></p>
                        <div class="client-details">
                            <p><strong>Name:</strong> <?= htmlspecialchars($msg_row['client_name']) ?></p>
                            <p><strong>Phone:</strong> <?= htmlspecialchars($msg_row['client_phone']) ?></p>
                            <p><strong>Date Sent:</strong> <?= htmlspecialchars($msg_row['date_sent']) ?></p>
                        </div>
                        <!-- Message Actions -->
                        <div class="message-actions">
                            <a href="markMessage.php?id=<?= $msg_row['message_id'] ?>&action=read" title="Mark as Read" class="message-icon" style="font-size: 30px;">✔</a>
                            <a href="markMessage.php?id=<?= $msg_row['message_id'] ?>&action=unread" title="Mark as Unread" class="message-icon" style="font-size: 30px;">✉</a>
                            <a href="markMessage.php?id=<?= $msg_row['message_id'] ?>&action=resolved" title="Mark as Resolved" class="message-icon" style="font-size: 30px;">✓</a>
                            <a href="markMessage.php?id=<?= $msg_row['message_id'] ?>&action=ignore" title="Ignore Message" class="message-icon" style="font-size: 30px;">✗</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>

        <script>
            function confirmDelete(propertyId) {
                if (confirm('Are you sure you want to delete this property? All related messages will be deleted.')) {
                    window.location.href = `deleteProperty.php?id=${propertyId}`;
                }
            }
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

        function showToast(message) {
            // Create a toast container if it doesn't exist
            if (!document.getElementById('toast-container')) {
                const toastContainer = document.createElement('div');
                toastContainer.id = 'toast-container';
                toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
                document.body.appendChild(toastContainer);
            }

            // Create a new toast element
            const toastHTML = `
                <div class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            ${message}
                        </div>
                        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            `;

            // Append the new toast to the container
            document.getElementById('toast-container').insertAdjacentHTML('beforeend', toastHTML);

            // Initialize and show the toast
            const toastElement = document.getElementById('toast-container').lastElementChild;
            const toast = new bootstrap.Toast(toastElement);
            toast.show();

            // Automatically remove the toast after it hides
            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }
    </script>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/wow/wow.min.js"></script>
    <!-- Template Javascript -->
    <script src="../js/main.js"></script>

</body>
</html>