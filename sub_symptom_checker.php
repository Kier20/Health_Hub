<?php
include '../connection/db_connection.php';
include 'sub_login.php';

$email;
$errors = array();

// Start session to manage user authentication
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: ../index.php");
    exit();
}

createDiseaseSymptomsTable($conn);

function createDiseaseSymptomsTable($conn) {
    $createTableQuery = "
    CREATE TABLE IF NOT EXISTS disease_symptoms (
        id INT PRIMARY KEY AUTO_INCREMENT,
        lastname VARCHAR(255),
        email VARCHAR(255),
        symptoms VARCHAR(255),
        processed BOOLEAN DEFAULT 0 -- Add processed column with default value 0
    )";
    $conn->query($createTableQuery);
}

// Fetch user's lastname and email from the users table
$user_id = $_SESSION['user_id'];
$sqlGetUserData = "SELECT last_name, email FROM users WHERE id='$user_id'";
$result = $conn->query($sqlGetUserData);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastName = $row['last_name'];
    $email = $row['email'];

    // Insert symptoms into the disease_symptoms table along with user information
    // You may need to adjust this part based on your actual symptom selection mechanism
    $selectedSymptoms = isset($_POST['symptoms']) ? $_POST['symptoms'] : array();
    insertSelectedSymptoms($conn, $lastName, $email, $selectedSymptoms);

    // Call the Python script to predict diseases based on the stored symptoms
    exec('python3 C:/xampp/htdocs/health_hub/python/predict_disease.py');

    // Redirect to treatment page or any other page after successful submission
    header("Location: ../php/treatment.php");
    exit();
} else {
    // Handle case where user data is not found
    $errors['user_data'] = "User data not found";
}

function insertSelectedSymptoms($conn, $lastName, $email, $selectedSymptoms) {
    // Combine selected symptoms into a single string
    $groupedSymptoms = "['" . implode("', '", $selectedSymptoms) . "']";
    
    // Escape special characters
    $groupedSymptoms = $conn->real_escape_string($groupedSymptoms);
    $lastName = $conn->real_escape_string($lastName);
    $email = $conn->real_escape_string($email);

    // Insert grouped symptoms into the database
    $insertQuery = "INSERT INTO disease_symptoms (lastname, email, symptoms) VALUES ('$lastName', '$email', '$groupedSymptoms')";
    $conn->query($insertQuery);
}
?>