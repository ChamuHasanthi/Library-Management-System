<?php
session_start();
if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'student')) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Staff Dashboard</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <header>
        <img src="images/logo.jpg" class="logo">
        <nav>
           <a href="<?php echo ($_SESSION['role'] === 'staff') ? 'staff_dashboard.php' : 'student_dashboard.php'; ?>">Dashboard</a>
           <a href="about.php">About</a>
           <div class="out">
                <a href="logout.php">Logout</a>
           </div>
        </nav>
    </header>
    
    <img src="images/about.jpeg" class="imag">
    <h1 class="hours">Overview</h1>
    <p class="overview">The Jaffna Hindu College Library Management System provides students and staff easy online access to our library's resources.
     This platform allows users to search, borrow, and reserve books from anywhere, while helping administrators efficiently manage inventory and track usage.
      Our goal is to make library services more accessible and convenient for the entire school community.</p>
    <h1 class="hours">Opening Hours</h1>
    <p class="time">Monday to Friday - 8.00 am to 1.30pm</p>
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
