<?php
session_set_cookie_params(0);
session_start();

if (isset($_SESSION['user_id'], $_SESSION['user_name'])) {
    $user = $_SESSION['user_name'];
    $lastname =  $_SESSION['last_name'];
} else {
    header("Location: index.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Hub</title>
    <link rel="stylesheet" type="text/css" href="treatment_style.css">
    <script src="../script/search.js" defer></script>
</head>
<body>
    <nav class="navbar">
        <div class="container">
        <a class="navbar-brand" href="#">
            <span style="color: #1E90FF;">Health</span>
            <span style="color: #DC143C;">Hub</span>
        </a>
            <ul class="navbar-nav">
                <li><a href="symptom_checker.php">Health Condition Checker</a></li>
                <li><a href="treatment.php">Treatment Procedures</a></li>
                <li><a href="calendar.php">Calendar</a></li>
            </ul>
            <div class="user-section">
                <span class="welcome">Welcome, <?php echo $user,"\t", $lastname; ?></span>
                <a class="logout-btn" href="?logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Treatment Procedures</h1>
        <div class="treatment-list">
        <?php
        // Include the database connection file
        include_once 'db_connection.php';

        // Query to fetch data for the disease "Anemia of chronic disease"
        $sql = "SELECT * FROM diseases WHERE name = 'Anemia of chronic disease'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Display common tests and procedures
            echo "<p><strong>Common Tests and Procedures:</strong> " . $row['common_tests_procedures_desc'] . "</p>";
            echo "<p><strong>Common Tests and Procedures:</strong> " . $row['common_tests_procedures'] . "</p>";

            // Display common medications
            echo "<p><strong>Common Medications:</strong> " . $row['common_medications_desc'] . "</p>";
            echo "<p><strong>Common Medications:</strong> " . $row['common_medications'] . "</p>";
        } else {
            echo "Disease information not found.";
        }

        // Close database connection
        $conn->close();
        ?>
        </div>
    </div>
</body>
</html>
