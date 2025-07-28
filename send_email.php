<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'config.php';

if (isset($_POST['email']) && !empty($_POST['email'])) {
    $userEmail = $_POST['email'];
    $userName = $_POST['name'];
    $userPhoneNo = $_POST['phone'];
    $appointmentDate = $_POST['date'];
    $appointmentTime = $_POST['time'];
    $service = $_POST['service'];

    $stmt = $conn->prepare("SELECT * FROM appointments WHERE appointment_date = ? AND appointment_time = ? AND service = ?");
    $stmt->bind_param("sss", $appointmentDate, $appointmentTime, $service);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo 'The selected slot is already booked. Please choose a different time.';
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO appointments (user_name, user_email, user_phone_no, appointment_date, appointment_time, service) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $userName, $userEmail, $userPhoneNo, $appointmentDate, $appointmentTime, $service);

    if ($stmt->execute()) {
        echo 'Appointment booked successfully!';
        flush();
        ob_flush();

        // Continue script execution in the background
        ignore_user_abort(true);
        set_time_limit(0);

        // Proceed to send emails after responding to the user
        $date = new DateTime($appointmentDate);
        $formatted_date = $date->format('d-m-Y');
        $formatted_time = date('h:i A', strtotime($appointmentTime));

        try {
            $mail = new PHPMailer(true);
            $mailOwner = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'haircraftsalon123@gmail.com'; 
            $mail->Password = 'defjcbkyrnzrjykf'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Copy the settings to $mailOwner
            $mailOwner = clone $mail;

            // Prepare user email
            $mail->setFrom('haircraftsalon123@gmail.com', 'Hair Craft Team');
            $mail->addAddress($userEmail, $userName);
            $mail->isHTML(true);
            $mail->Subject = 'Appointment Confirmation at Hair Craft';
            $mail->Body = "
    <h2 style='color: #000000;'>Appointment Booked!</h2> <!-- Change color to black -->
    <h3 style='color: #000000;'>Hello $userName,</h3> <!-- Change color to black -->
    <p style='color: #000000;'>Thank you for booking an appointment with us. Here are the details of your appointment:</p>
    <ul>
        <li><strong style='color: #000000;'>Service:</strong> {$service}</li> <!-- Change color to black -->
        <li><strong style='color: #000000;'>Date:</strong> {$formatted_date}</li> <!-- Change color to black -->
        <li><strong style='color: #000000;'>Time:</strong> {$formatted_time}</li> <!-- Change color to black -->
    </ul>
    <p style='color: #000000;'>If you have any queries or need to reschedule, please contact us at haircraftsalon123@gmail.com.</p>
    <p style='color: #000000;'>Best regards,<br>Hair Craft Team</p>
";

            // Send user email
            $mail->send();

            // Prepare and send owner email
            $mailOwner->clearAddresses();
            $mailOwner->setFrom('haircraftsalon123@gmail.com', 'Hair Craft Team');
            $mailOwner->addAddress('haircraftsalon123@gmail.com');
            $mailOwner->isHTML(true);
            $mailOwner->Subject = 'New Appointment Booking';
            $mailOwner->Body = "
    <h2 style='color: #000000;'>New Appointment Booked</h2> <!-- Change color to black -->
    <p style='color: #000000;'>Details of the appointment are as follows:</p>
    <ul>
        <li><strong style='color: #000000;'>User Name:</strong> $userName</li> <!-- Change color to black -->
        <li><strong style='color: #000000;'>User Email:</strong> $userEmail</li> <!-- Change color to black -->
        <li><strong style='color: #000000;'>Date:</strong> {$formatted_date}</li> <!-- Change color to black -->
        <li><strong style='color: #000000;'>Time:</strong> {$formatted_time}</li> <!-- Change color to black -->
        <li><strong style='color: #000000;'>Service:</strong> $service</li> <!-- Change color to black -->
    </ul>
    <p style='color: #000000;'>Please ensure the appointment is managed accordingly.</p>
    <p style='color: #000000;'>Regards,<br>Automated Notification System</p>
";

            $mailOwner->send();
        } catch (Exception $e) {
            error_log('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        }
    } else {
        echo "Error: Could not book the appointment. Please try again.";
    }

    $stmt->close();
} else {
    echo 'Invalid email address.';
}

$conn->close();
?>