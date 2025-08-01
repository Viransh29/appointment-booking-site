
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hair Craft Salon - Book Appointment</title>
    <link rel="stylesheet" href="booking.css">
    <script src="booking.js" defer></script>
</head>
<body>
    <header>
        <h1>Hair Craft Salon</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
            </ul>
        </nav>
    </header>

    <section id="book">
        <h2>Book an Appointment</h2>
        
        <form id="booking-form" action="send_email.php" method="POST">
            
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>
        
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        
            <label for="phone">Mobile Number:</label>
            <input type="tel" id="phone" name="phone" required>
        
            <label for="service">Select Service:</label>
            <select id="service" name="service" required>
                <option value="Haircut for Men">Haircut (Men)</option>
                <option value="Haircut for Women">Haircut (Women)</option>
                <option value="Keratin Treatment">Keratin Treatment</option>
                <option value="Hair Coloring">Hair Coloring</option>
                <option value="Hair Treatment">Hair Treatment</option>
                <option value="Beard Trimming">Beard Trimming</option>
                <option value="Hair Spa">Hair Spa</option>
                <option value="Scalp Treatment">Scalp Treatment</option>
            </select>
        
            <label for="date">Select Date:</label>
            <input type="date" id="date" name="date" required>
        
            <label for="time">Select Time:</label>
            <select id="time" name="time" required>
                <!-- Time slots dynamically added with JavaScript -->
            </select>
        
            <button type="submit">Book Now</button>
        </form>
        <p id="booking-status"></p>
    </section>
    
    <footer>
        <p>© 2024 Hair Craft Salon | All rights reserved</p>
    </footer>
</body>
</html>