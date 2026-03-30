<?php
// Local PHP Email Form Implementation
// This is a pure local implementation without third-party dependencies

$receiving_email_address = 'contact@example.com'; // Change this to your actual email

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['error' => 'Invalid email address']);
        exit;
    }

    // Prepare email content
    $email_subject = "Contact Form: " . $subject;
    $email_body = "From: " . $name . " (" . $email . ")\n\n";
    $email_body .= "Message:\n" . $message;

    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send email
    if (mail($receiving_email_address, $email_subject, $email_body, $headers)) {
        echo json_encode(['success' => 'Message sent successfully!']);
    } else {
        echo json_encode(['error' => 'Failed to send message. Please try again later.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
?>
