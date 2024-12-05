<?php
$formSubmitted = false;
$userData = [];
$uploadedImages = []; 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['imageUpload']) && $_FILES['imageUpload']['error'] == 0) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["imageUpload"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["imageUpload"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["imageUpload"]["tmp_name"], $targetFile)) {
                $uploadedImages[] = $targetFile; 
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    } else {
        echo "No image uploaded or there was an error with the file upload.";
    }

  
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        $formSubmitted = true;

    
        $userData[] = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'image' => !empty($uploadedImages) ? $uploadedImages[0] : null  
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to IGM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            margin: 0;
            background-color: #b76e79; 
            overflow: auto;
            transition: background-image 1s ease-in-out, background-color 1s ease-in-out; 
        }

        .container {
            padding: 20px;
            z-index: 1;
            position: relative;
        }

        form {
            margin-top: 20px;
            max-width: 500px;
            padding: 20px;
            border-radius: 5px;
            background-color: #b76e79;
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
            color: #e53935;
            font-size: 1.2em;
        }

        .jewelry-images {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
            overflow-x: auto;
        }

        .jewelry-images img {
            width: 200px;
            margin: 10px;
            border: 2px solid #ddd;
            transition: transform 0.3s ease;
        }

        .jewelry-images img:hover {
            transform: scale(1.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #008CBA;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #userTable {
            display: none;
            max-height: 300px;
            overflow-y: auto;
        }

        #backButton {
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            position: absolute;
            top: 178px;
            right: 10px;
            display: none; 
        }

        #backButton:hover {
            background-color: #e53935;
        }
        #uploadedImage{
          display: none;
        }
    </style>
</head>
<body id="pageBody">

    <div class="container">
        <h1>Customer Query</h1>
        <p>Please fill out the form below and we'll get back to you as soon as possible.</p>

        <?php if ($formSubmitted): ?>
            <div id="successMessage">
                <p>Thank you for your message, we will get back to you shortly!</p>
            </div>
            <?php if (!empty($uploadedImages)): ?>
                <div id="uploadedImage">
                    <h3>Uploaded Image:</h3>
                    <img src="<?php echo htmlspecialchars($uploadedImages[0]); ?>" alt="Uploaded Image">
                </div>
            <?php endif; ?>
            <button id="viewUsersBtn" onclick="toggleUserTable()">View Users</button>
        <?php else: ?>
            <form id="contactForm" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>

                <label for="imageUpload">Upload Image:</label>
                <input type="file" id="imageUpload" name="imageUpload" accept="image/*">

                <button type="submit">Submit</button>
            </form>
        <?php endif; ?>

        <div class="jewelry-images" id="jewelryImages">
            
            <?php if (!empty($uploadedImages)): ?>
              <h2>Jewelry Gallery</h2>
                <?php foreach ($uploadedImages as $image): ?>
                    <img src="<?php echo htmlspecialchars($image); ?>" alt="Uploaded Jewelry">
                <?php endforeach; ?>
            <?php else: ?>
                <p class="jewelry-header" style="display:none">No images uploaded yet.</p>
            <?php endif; ?>
        </div>

        <div id="userTable">
            <h2>Submitted User Query</h2>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($formSubmitted): ?>
                        <?php foreach ($userData as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['message']); ?></td>
                                <td>
                                    <?php if ($user['image']): ?>
                                        <img src="<?php echo htmlspecialchars($user['image']); ?>" alt="User Image" style="width: 50px;">
                                    <?php else: ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <button id="backButton" onclick="goBack()" style="display: block;">Go Back</button>

    </div>

    <script>
        function hideForm() {
            document.getElementById("contactForm").style.display = "none";
        }

        function toggleUserTable() {
            const userTable = document.getElementById("userTable");
            const button = document.getElementById("viewUsersBtn");
            const backButton = document.getElementById("backButton");

            if (userTable.style.display === "none" || userTable.style.display === "") {
                userTable.style.display = "block";  
                button.textContent = "Hide Users";  
                backButton.style.display = "inline-block";  
            } else {
                userTable.style.display = "none";  
                button.textContent = "View Users";  
                backButton.style.display = "inline-block";  
            }
        }

        function goBack() {
            window.location.href = "http://test.com";  
        }
    </script>

</body>
</html>
