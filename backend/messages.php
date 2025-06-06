<?php
    session_start();
    if (!isset($_SESSION['user_id'])){
        header("location:../sign_up_sign_in/login.php?error=2");
        exit();
    }
    @include '../inc/connection.php';

    $user_id = $_SESSION['user_id'];
    $status_filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

    $status_condition = "";
    if ($status_filter === 'read') {
        $status_condition = "AND status='read'";
    } elseif ($status_filter === 'unread') {
        $status_condition = "AND status='unread'";
    } elseif ($status_filter === 'resolved') {
        $status_condition = "AND status='resolved'";
    } elseif ($status_filter === 'ignore') {
        $status_condition = "AND status='ignore'";
    }

    $sql = "SELECT * FROM messages WHERE user_id='$user_id' $status_condition";
    $messages = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>HomeIt - Your Trusted Partner in Finding the Perfect Home</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="../img/icon.png" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
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
                            <a href="myProperties.php" class="dropdown-item">My Properties</a>
                            <a href="messages.php" class="dropdown-item active">Messages</a>
                            <a href="logout.php" class="dropdown-item">Logout</a>
                        </div>
                    </div>
                </div>
                <a href="addProperty.php" class="btn btn-primary px-3 d-none d-lg-flex">Add Property</a>
            </div>
        </nav>
    </div>
    <br>
    <!-- Navbar End -->

    <!-- Filter and Messages Start -->
    <div class="d-flex justify-content-end mb-3">
        <ul class="nav nav-pills">
            <li class="nav-item me-2">
                <a href="?filter=all" class="btn btn-outline-primary <?= $status_filter === 'all' ? 'active' : '' ?>">All</a>
            </li>
            <li class="nav-item me-2">
                <a href="?filter=read" class="btn btn-outline-primary <?= $status_filter === 'read' ? 'active' : '' ?>">Read</a>
            </li>
            <li class="nav-item me-2">
                <a href="?filter=unread" class="btn btn-outline-primary <?= $status_filter === 'unread' ? 'active' : '' ?>">Unread</a>
            </li>
            <li class="nav-item me-2">
                <a href="?filter=resolved" class="btn btn-outline-primary <?= $status_filter === 'resolved' ? 'active' : '' ?>">Resolved</a>
            </li>
            <li class="nav-item me-3">
                <a href="?filter=ignore" class="btn btn-outline-primary <?= $status_filter === 'ignore' ? 'active' : '' ?>">Ignore</a>
            </li>
        </ul>
    </div>

    <div class="messages-container">
        <h2>Messages from Interested Clients</h2>
        <?php if (mysqli_num_rows($messages) == 0): ?>
            <<div class="text-center">
                <h4 class="text-muted">No messages found!</h4>
                <img src="../img/no_property.jpg" alt="No Messages" class="img-fluid my-3" style="max-width: 300px;">
                <p class="text-muted">There are currently no messages for this filter.</p>
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


    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/main.js"></script>

</body>
</html>
