<?php
session_set_cookie_params(0);
session_start();

if (!isset($_SESSION['user_id'], $_SESSION['user_name'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Details</title>
    <link rel="stylesheet" type="text/css" href="../style/home_page_style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            color: #333;
        }

        p {
            margin-bottom: 10px;
        }

        nav {
            background-color: black;
            overflow: hidden;
        }

        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        nav a:hover {
            background-color: #ddd;
            color: black;
        }

        #userName {
            position: fixed;
            top: 20px;
            right: 20px;
            color: white;
            font-size: 16px;
        }

        .section {
            margin-top: 20px;
        }

        .section-header {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="home_page.php" onclick="goToHomePage()">Home</a>
    </nav>
    <div id="userName"><?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name'], ENT_QUOTES, 'UTF-8') : ''; ?></div>

    <?php
    // Check if the 'id' parameter is set in the URL
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Assume the Flask app is running on the same server
        $details_url = 'http://127.0.0.1:5000/details?id=' . $id;
        $details_json = @file_get_contents($details_url);

        try {
            if ($details_json === false) {
                throw new Exception('Error fetching details. Please try again later.');
            }

            $selectedDisease = json_decode($details_json, true);

            if (
                !$selectedDisease ||
                !isset($selectedDisease['name'], $selectedDisease['description'], $selectedDisease['symptoms'], $selectedDisease['common_tests_procedures'], $selectedDisease['common_medications'], $selectedDisease['who_is_at_risk_desc'])
            ) {
                throw new Exception('Error: Details not found or incomplete for the selected disease.');
            }

            // Output details
            echo '<h2>Disease Name</h2>';
            echo '<p>' . htmlspecialchars($selectedDisease['name'], ENT_QUOTES, 'UTF-8') . '</p>';

            echo '<h2>Description</h2>';
            echo '<p>' . htmlspecialchars($selectedDisease['description'], ENT_QUOTES, 'UTF-8') . '</p>';

            // Display symptoms
            displaySection('Symptoms', $selectedDisease['symptoms']);

            // Display common tests and procedures
            displaySection('Common Tests and Procedures', $selectedDisease['common_tests_procedures']);

            // Display common medications
            displaySection('Common Medications', $selectedDisease['common_medications']);

            // Display who is at risk
            echo '<div class="section">';
            echo '<h2 class="section-header">Who Is at Risk</h2>';
            echo '<p>' . htmlspecialchars($selectedDisease['who_is_at_risk_desc'], ENT_QUOTES, 'UTF-8') . '</p>';
            echo '</div>';
        } catch (Exception $e) {
            echo '<div class="error-message">Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</div>';
        }
    } else {
        echo '<div class="error-message">Error: Invalid request. Please provide a disease ID.</div>';
    }

    function displaySection($header, $content) {
        echo '<div>';
        echo '<h2>' . $header . '</h2>';
    
        if (is_array($content) && !empty($content)) {
            echo '<ul>';
            foreach ($content as $item) {
                // Remove square brackets and both single and double quotation marks from array elements
                $item = str_replace(['[', ']', "'", '"'], '', $item);
                echo '<li>' . $item . '</li>';
            }
            echo '</ul>';
        } elseif (is_string($content)) {
            // Remove square brackets and both single and double quotation marks from the string
            $content = str_replace(['[', ']', "'", '"'], '', $content);
            echo '<p>' . $content . '</p>';
        } else {
            echo '<p>No ' . strtolower($header) . ' information available.</p>';
        }
    
        echo '</div>';
    }
    ?>

    <script>
        function goToHomePage() {
            window.location.href = 'home_page.php';
        }

        var diseaseId = <?php echo json_encode((string)$_GET['id']); ?>;
        console.log('ID from URL:', diseaseId);

        // Check the structure of the details variable
        console.log('Details:', <?php echo json_encode($selectedDisease); ?>);

        // Check if the selected disease is present in the details
        var selectedDisease = <?php echo json_encode($selectedDisease, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE); ?>;
        console.log('Selected Disease:', selectedDisease);
    </script>
</body>
</html>