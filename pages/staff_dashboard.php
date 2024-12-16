<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}

include '../config/db_config.php';

$total_books_query = "SELECT COUNT(*) AS total_books FROM books";
$total_books_result = $conn->query($total_books_query);
$total_books = $total_books_result->fetch_assoc()['total_books'];

$available_books_query = "SELECT COUNT(*) AS available_books FROM books WHERE status = 'available'";
$available_books_result = $conn->query($available_books_query);
$available_books = $available_books_result->fetch_assoc()['available_books'];

$total_admins_query = "SELECT COUNT(*) AS total_admins FROM users WHERE role = 'staff'";
$total_admins_result = $conn->query($total_admins_query);
$total_admins = $total_admins_result->fetch_assoc()['total_admins'];

$total_students_query = "SELECT COUNT(*) AS total_students FROM users WHERE role = 'student'";
$total_students_result = $conn->query($total_students_query);
$total_students = $total_students_result->fetch_assoc()['total_students'];
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
           <a href="staff_dashboard.php">Dashboard</a>
           <a href="about.php">About</a>
           <div class="se">
           <a href="search.php"><img src="images/search.png"></a>
           </div>
           <div class="out">
                <a href="logout.php">Logout</a>
           </div>
        </nav>
    </header>

     
    <h1 class="wel">Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <div class="dashboard">
        <a href="manage_inventory.php">Manage Inventory</a>
        <a href="user_management.php">User Management</a>
        <a href="reserved_books.php" >Reserved Books</a>
    </div>
    
    <div class="report">
    <h1>Library Updated Statics</h1>
        <table class="report-table">
            <tr>
                <th>Report Metric</th>
                <th>Count</th>
            </tr>
            <tr>
                <td>Total Number of Books</td>
                <td><?php echo $total_books; ?></td>
            </tr>
            <tr>
                <td>Number of Available Books</td>
                <td><?php echo $available_books; ?></td>
            </tr>
            <tr>
                <td>Total Number of Admins</td>
                <td><?php echo $total_admins; ?></td>
            </tr>
            <tr>
                <td>Total Number of Students</td>
                <td><?php echo $total_students; ?></td>
            </tr>
        </table>
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