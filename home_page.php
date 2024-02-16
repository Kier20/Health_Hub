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

$output = shell_exec("python3 backend.py");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health Hub</title>
    <link rel="stylesheet" type="text/css" href="../style/home_page_style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                <li><a href="#">Calendar</a></li>
            </ul>
            <div class="user-section">
                <span class="welcome">Welcome, <?php echo $user,"\t", $lastname; ?></span>
                <a class="logout-btn" href="?logout">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1>Welcome to Health Hub</h1>
        <form id="searchForm">
            <div class="search-bar">
                <input type="text" id="searchInput" placeholder="Search for diseases...">
                <button type="button" onclick="performSearch()">Search</button>
                <div id="searchResults"></div>
            </div>
        </form>
    </div>
</body>
</html>
