<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $errors = array();

    // Retrieve form data
    $name = $_POST['name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($name)) {
        $errors['name'] = "Name is required";
    }

    if (empty($last_name)) {
        $errors['last_name'] = "Last name is required";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }

    if (empty($errors)) {
        // If there are no validation errors, proceed with registration
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the database
        $servername = "localhost";
        $username = "root"; // Replace with your MySQL username
        $password = ""; // Replace with your MySQL password
        $dbname = "health_hub"; // Replace with your database name

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind SQL statement
        $stmt = $conn->prepare("INSERT INTO users (name, last_name, email, phone_number, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $last_name, $email, $phone_number, $hashed_password);

        // Execute the statement
        $stmt->execute();

        // Close the connection
        $stmt->close();
        $conn->close();
        echo "Registration successful!";
    } else {
        // If there are validation errors, display them to the user
        // You can pass the $errors array back to the form for displaying errors next to input fields
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
} else {
    header("Location: register.php");
    exit();
}
?>
