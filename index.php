<?php
// Variable to check if the form was submitted
$formSubmitted = false;

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // You can process or store the data here (e.g., send an email or save to a database)

    // Mark the form as submitted
    $formSubmitted = true;

    // Display the collected data (Optional: you can remove this or change it to a success message)
    echo "<h2>Your Submitted Data:</h2>";
    echo "Name: " . htmlspecialchars($name) . "<br>";
    echo "Email: " . htmlspecialchars($email) . "<br>";
    echo "Message: " . nl2br(htmlspecialchars($message)) . "<br>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        form {
            margin-top: 20px;
            max-width: 500px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
        }
        button:hover {
            background-color: #45a049;
        }
        #successMessage {
            color: green;
            font-size: 1.2em;
        }
    </style>
</head>
<body>

    <h1>Contact Us</h1>
    <p>Please fill out the form below and we'll get back to you as soon as possible.</p>

    <!-- Success message, shown if the form was submitted -->
    <?php if ($formSubmitted): ?>
        <div id="successMessage">
            <p>Thank you for your message, we will get back to you shortly!</p>
        </div>
    <?php else: ?>
        <!-- Contact Form -->
        <form id="contactForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" onsubmit="hideForm()">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" required></textarea>

            <button type="submit">Submit</button>
        </form>
    <?php endif; ?>

    <script>
        // Function to hide the form after submission
        function hideForm() {
            document.getElementById("contactForm").style.display = "none";
        }
    </script>

</body>
</html>
