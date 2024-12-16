<?php
session_start();
include '../config/db_config.php';

$message = '';   

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['password'] === $password) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];
            if ($user['role'] == 'staff') {
                header("Location: staff_dashboard.php");
            } else {
                header("Location: student_dashboard.php");
            }
            exit();
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "User not found.";
    }
}


if (isset($_SESSION['success_message'])) {
    echo '<div style="margin: 20px; font-size: 18px; color: blue;">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);   
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="header">
        <img src="images/logo.jpg" class="logo">
        <div class="header-right">
            <a href="register.php">Register</a>
        </div>
    </div>

    <?php if ($message): ?>
            <div id="messageArea" style="color: blue; margin: 20px; font-size: 18px;text-align:center;">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

    <div class="container">
        <h1 class="topic">Login</h1>


        <form method="POST">
            <div class="input_group">
                <label>Username:</label><br>
                <input type="text" name="username" required><br>
            </div>
            <div class="input_group">
                <label>Password:</label><br> 
                <input type="password" name="password" required><br><br>
            </div>
            <input type="submit" value="Login" class="login">
        </form>
    </div>

    <footer>
        <h1>Contact us</h1>
        <h2>Connect with us :</h2>
        <table class="contact">
            <tr>
                <td><i class="fa-solid fa-location-dot"></i></td>
                <td>K.K.S.Road, Jaffna</td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-phone"></i></td>
                <td>021 2222431</td>
            </tr>
            <tr>
                <td><i class="fa-solid fa-envelope"></i></td>
                <td>jaffnahinducollege@gmail.com</td>
            </tr>
        </table>
        <div class="media">
            <a href="https://web.facebook.com/JaffnaHinducollegeOfficial/?_rdc=1&_rdr"><img src="images/fb.png"></i></a>
            <a href="https://www.youtube.com/c/jaffnahinducollege"><img src="images/youtube.png"></i></a>
            <a href="https://www.instagram.com/jaffnahinducollege/"><img src="images/instar.png"></i></a>
            <a href="https://www.linkedin.com/school/jaffna-hindu-college/?originalSubdomain=lk"><img src="images/linkedin.png"></i></a>
        </div>
    <p class="copyright">© 2024 The Main Library, Jaffna Hindu college. All rights reserved.</p>
    </footer>
</body>
</html>
