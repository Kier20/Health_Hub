<?php
function fetchSymptomsFromDatabase() {
    // Replace the following with your database connection and query logic
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "health_hub";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT symptoms FROM diseases";
    $result = $conn->query($sql);

    $symptoms = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Check if 'symptoms' field is not empty
            if (!empty($row['symptoms'])) {
                // Replace single quotes with double quotes
                $row['symptoms'] = str_replace("'", '"', $row['symptoms']);

                // Check if it's a valid JSON string
                if (is_array(json_decode($row['symptoms'], true))) {
                    $groupedSymptoms = json_decode($row['symptoms'], true);
                    $symptoms = array_merge($symptoms, $groupedSymptoms);
                } else {
                    echo "Invalid JSON format: " . $row['symptoms'] . "<br>"; // Debug line
                }
            } else {
                echo "Empty symptoms data<br>"; // Debug line
            }
        }
    } else {
        echo "No rows found in the database"; // Debug line
    }

    $conn->close();

    return $symptoms;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Condition Checker</title>
    <style>
        /* Resetting default margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
        }

        /* Navbar styles */
        .navbar {
            background-color: #3b3b3b;
            color: #fff;
            padding: 5px 0;
            overflow: hidden;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 24px;
            text-decoration: none;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            padding: 14px 16px;
            display: block;
        }

        .navbar a:hover {
            background-color: #555;
        }

        form {
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            width: 25%;
            float: left;
        }

        input[type="checkbox"] {
            margin-right: 5px;
        }

        button {
            padding: 10px;
            background-color: #333;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #555;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span style="color: #1E90FF;">Health</span>
                <span style="color: #DC143C;">Hub</span>
            </a>
            <a href="home_page.php">Home</a>
        </div>
    </nav>

    <?php
    $symptomsArray = fetchSymptomsFromDatabase();

    if ($symptomsArray !== false && is_array($symptomsArray)) {
        $uniqueSymptoms = array_unique($symptomsArray);
        sort($uniqueSymptoms); // Sort symptoms alphabetically

        echo '<form method="post" action="../extensions/sub_symptom_checker.php">';
        echo '<h2>Select Symptoms:</h2>';

        foreach ($uniqueSymptoms as $symptom) {
            echo '<label>';
            echo '<input type="checkbox" name="symptoms[]" value="' . htmlspecialchars($symptom) . '">';
            echo htmlspecialchars($symptom);
            echo '</label>';
        }

        echo '<br style="clear:both;">'; // Clear the float after the columns
        echo '<button type="submit">Check Health Condition</button>';
        echo '</form>';
    } else {
        echo "Failed to fetch symptoms from the API.";
    }
    ?>
</body>
</html>
