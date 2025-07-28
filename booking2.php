<?php 
// Include database connection
include 'config.php'; // Ensure this path is correct

// Retrieve form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$service = $_POST['service'];
$date = $_POST['date'];
$time = $_POST['time'];

// Prepare SQL query
$sql = "INSERT INTO appointments (name, email, phone, service, appointment_date, appointment_time)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $email, $phone, $service, $date, $time);

// Execute the statement
if ($stmt->execute()) {
    echo "Connected successfully and appointment booked!";
} else {
    echo "Error: " . $stmt->error; // Show error message
}

$stmt->close();
$conn->close();
?>