<?php
session_start();   

include '../config/db_config.php';

$message = '';   

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    
    if (strlen($password) < 8 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[\W_]/', $password)) {
        $message = "Password must be at least 8 characters long and include letters, numbers, and symbols.";
    } else {
        
        $check_query = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($check_query);

        if ($result->num_rows > 0) {
            $message = "Username already exists. Please choose a different one.";
        } else {
             
            $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
            if ($conn->query($sql) === TRUE) {
                 
                $_SESSION['success_message'] = "Registration successful! You can now login.";
                header('Location: login.php');
                exit();   
            } else {
                $message = "Error: " . $conn->error;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
<div class="header">
    <img src="images/logo.jpg" class="logo">
    <div class="header-right">
        <a href="login.php">Login</a>
    </div>
</div>

<?php if ($message): ?>
        <div id="messageArea" style="margin: 20px; font-size: 18px; color: blue;">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>


<div class="container">
    <h1 class="topic">Register</h1>

   
    <form method="POST">
        <div class="input_group">
            <label>Username:</label><br>
            <input type="text" name="username" required><br>
        </div>
        <div class="input_group">
            <label>Password:</label><br>
            <input type="password" name="password" required><br>
        </div>
        <label>Role:</label><br>
        <select name="role" required style="width: 250px; height: 40px; font-size: 16px; padding: 5px 10px;">
            <option value="student">Student</option>
            <option value="staff">Staff</option>
        </select><br><br>

        <input type="submit" value="Register" class="register">
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
        <a href="https://web.facebook.com/JaffnaHinducollegeOfficial/?_rdc=1&_rdr"><img src="images/fb.png"></a>
        <a href="https://www.youtube.com/c/jaffnahinducollege"><img src="images/youtube.png"></a>
        <a href="https://www.instagram.com/jaffnahinducollege/"><img src="images/instar.png"></a>
        <a href="https://www.linkedin.com/school/jaffna-hindu-college/?originalSubdomain=lk"><img src="images/linkedin.png"></a>
    </div>

    <p class="copyright">© 2024 The Main Library, Jaffna Hindu college. All rights reserved.</p>
</footer>
</body>
</html>
