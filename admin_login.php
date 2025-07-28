<?php
require 'config.php'; // Include your database connection

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'], $_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare and execute the SQL statement to fetch admin details
        $stmt = $conn->prepare("SELECT password FROM admin WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if the admin exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();

            // Verify the password
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['admin_loggedin'] = true; // Set session variable
                header("Location: view_appointments.php"); // Redirect to view appointments
                exit;
            } else {
                echo "<script>document.getElementById('error-message').innerText = 'Invalid credentials. Please try again.';</script>";
            }
        } else {
            echo "<script>document.getElementById('error-message').innerText = 'No account found with that email.';</script>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<script>document.getElementById('error-message').innerText = 'Please fill out the form.';</script>";
    }
}
?>