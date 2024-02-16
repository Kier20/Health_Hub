<?php
include 'db_connection.php';

$email;
$password_attempt;
$errors = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_attempt = $_POST['password'];

    $sqlCheckEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sqlCheckEmail);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password_attempt, $hashed_password)) {
            session_start();

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['last_name'] = $row['last_name'];
            
            header('Location: home_page.php');
            exit();
        } else {
            $errors['password'] = "Incorrect password";
        }
    } else {
        $errors['email'] = "Email not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <!-- Your HTML Form Here -->

    <!-- Display Errors -->
    <?php if (!empty($errors)): ?>
        <div>
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</body>
</html>
