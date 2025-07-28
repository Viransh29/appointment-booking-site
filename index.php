<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hair Salon - Home</title>
    <link rel="stylesheet" href="salon_home.css">
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">Hair Craft</div>
            <nav>
                <ul>
                    <li><a href="#services">Services</a></li>
                    <li><a href="booking.php">Booking</a></li>
                    <li><a href="#contact">Contact</a></li>
                    <li><a href="#address">Address</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">
        <div class="hero-content">
            <p class="tagline">Discover Our Exceptional Hair Salon Services</p>
            <h1>Welcome to Our Hair Craft Salon - Elevate Your Style</h1>
            <p class="description">
                Explore our wide range of hair treatments, from cutting-edge coloring techniques 
                to nourishing deep conditioning services. Our expert stylists are committed to transforming your look.
            </p>
            <a href="booking.php" class="btn-book">Book Now</a>
        </div>
        <div class="hero-image">
            <img src="IMAGES/original.png" alt="Salon Logo">
        </div>
    </section>

    <section class="offers-section">
        <?php
        require 'config.php'; 

        $sql = "SELECT offer_title, offer_description FROM offers WHERE CURDATE() BETWEEN offer_start_date AND offer_end_date";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Current Offers:</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "<p><strong>" . htmlspecialchars($row['offer_title']) . ":</strong> " . htmlspecialchars($row['offer_description']) . "</p>";
            }
        } else {
            echo "<p>No current offers available.</p>";
        }

        $conn->close();
        ?>
    </section>

    <section class="services" id="services">
    <h2 class="section-title">Explore Our Salon Offerings</h2>
    <p class="section-description">
        From the moment you step into our salon, you'll be immersed in an atmosphere of luxury and sophistication. Our experienced team of stylists and beauty experts is dedicated to making you look and feel your best.
    </p>
    <div class="offerings-container">
    <?php

    require 'config.php';

    $sql = "SELECT name, description, price FROM services";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
            <div class="offering-item">
                <div class="offering-image"></div>
                <h3>' . htmlspecialchars($row['name']) . '</h3>
                <p>' . htmlspecialchars($row['description']) . '</p>
                <p>₹' . htmlspecialchars($row['price']) . '</p>
            </div>
            ';
        }
    } else {
        echo '<p>No services available at the moment. Please check back later!</p>';
    }
    $conn->close();
    ?>
</div>
</section>
    
    <section id="address" class="map-contact-container">
        <div class="map-address">
            <h2>Shop Address</h2>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d232.5055657183326!2d72.8148481!3d21.1886211!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3be04f60aaa45b49%3A0xc1f3e610f9a452e6!2shair%20craft%20salon!5e0!3m2!1sen!2sin!4v1728655804989!5m2!1sen!2sin" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        <div class="contact-section" id="contact">
            <h2 class="section-title">Contact Us</h2>
            <p>Phone: +91-9106865298</p>
            <p>Email: haircraftsalon123@gmail.com</p>
            <p>Address: 1st Floor Jagdamba Nivas, Kakaji Street, Nanpura, Surat</p>
            <p>Follow us on <a href="https://www.instagram.com/haircraft_21/">Instagram</a></p>
        </div>
    </section>

    <footer>
        <div class="footer">
            <p>© 2024 Hair Craft Salon | All rights reserved</p>
        </div>
    </footer>
</body>
</html>