<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create a database named 'health_hub'
$databaseName = "health_hub";
$sqlCreateDatabase = "CREATE DATABASE IF NOT EXISTS $databaseName";

if ($conn->query($sqlCreateDatabase) !== TRUE) {
    die("Error creating database: " . $conn->error);
}

// Select the 'health_hub' database
$conn->select_db($databaseName);

// Create a 'users' table
$sqlCreateTable = "CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(50) NOT NULL,
    phone_number VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL
)";

if ($conn->query($sqlCreateTable) !== TRUE) {
    die("Error creating 'users' table: " . $conn->error);
}

// Create a 'diseases' table
$sqlCreateDiseasesTable = "CREATE TABLE IF NOT EXISTS diseases (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    symptoms TEXT NOT NULL,
    description TEXT NOT NULL,
    common_tests_procedures_desc TEXT NOT NULL,
    common_tests_procedures TEXT NOT NULL,
    common_medications_desc TEXT NOT NULL,
    common_medications TEXT NOT NULL,
    who_is_at_risk_desc TEXT NOT NULL,
    symptoms_desc TEXT NOT NULL
)";

if ($conn->query($sqlCreateDiseasesTable) === TRUE) {
    echo "\n";

    mysqli_options($conn, MYSQLI_OPT_LOCAL_INFILE, true);

    // Load the dataset into the 'diseases' table
    $sqlLoadDataset = "LOAD DATA LOCAL INFILE 'clean.csv' IGNORE INTO TABLE diseases
                        FIELDS TERMINATED BY '~' 
                        ENCLOSED BY '\"' 
                        LINES TERMINATED BY '\n' 
                        IGNORE 1 ROWS
                        (@id, @name, @symptoms, @description, @common_tests_procedures_desc, @common_tests_procedures, @common_medications_desc, @common_medications, @who_is_at_risk_desc, @symptoms_desc)
                        SET id = NULL, name = @name, symptoms = @symptoms, description = @description, common_tests_procedures_desc = @common_tests_procedures_desc, common_tests_procedures = @common_tests_procedures, common_medications_desc = @common_medications_desc, common_medications = @common_medications, who_is_at_risk_desc = @who_is_at_risk_desc, symptoms_desc = @symptoms_desc;";

    if ($conn->query($sqlLoadDataset) === TRUE) {
        echo "\n";
    } else {
        echo "Error loading dataset: " . $conn->error;
    }
} else {
    echo "Error creating 'diseases' table: " . $conn->error;
}