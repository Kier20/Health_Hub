<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style/index_style.css">
    <title>User Login</title>
    <script src="../script/transition.js" defer></script>
</head>
<body>
<div class="container">
    <div class="form-container">
        <form id="loginForm" class="form" method="post" action="../extensions/sub_login.php">
            <h2>User Login</h2>
            <div class="input-group">
                <label for="login-email">Email:</label>
                <input type="email" id="login-email" name="email" required>
            </div>
            <div class="input-group">
                <label for="login-password">Password:</label>
                <input type="password" id="login-password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <p class="switch-form">Don't have an account? <a href="#" onclick="switchForm()">Register</a></p>
        </form>

        <form id="registerForm" class="form hidden" method="post" action="../extensions/sub_register.php">
            <h2>User Registration</h2>
            <div class="input-group">
                <label for="reg-name">Name:</label>
                <input type="text" id="reg-name" name="name" required>
            </div>
            <div class="input-group">
                <label for="reg-lastname">Last Name:</label>
                <input type="text" id="reg-lastname" name="last_name" required>
            </div>
            <div class="input-group">
                <label for="reg-email">Email:</label>
                <input type="email" id="reg-email" name="email" required>
            </div>
            <div class="input-group">
                <label for="reg-phone">Phone Number:</label>
                <input type="text" id="reg-phone" name="phone_number" required>
            </div>
            <div class="input-group">
                <label for="reg-password">Password:</label>
                <input type="password" id="reg-password" name="password" required>
            </div>
            <div class="input-group">
                <label for="reg-confirm-password">Confirm Password:</label>
                <input type="password" id="reg-confirm-password" name="confirm_password" required>
            </div>
            <button type="submit">Register</button>
            <p class="switch-form">Already have an account? <a href="#" onclick="switchForm()">Login</a></p>
        </form>
    </div>
</div>
</body>
</html>