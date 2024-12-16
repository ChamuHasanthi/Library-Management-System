<?php
include '../config/db_config.php';
session_start();
$message = '';   

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $isbn = $_POST['isbn'];
    $issue_date = date("Y-m-d");

    $user_query = "SELECT id FROM users WHERE username = '$username'";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        $user_id = $user['id'];

        $book_query = "SELECT * FROM books WHERE isbn = '$isbn' AND status = 'available'";
        $book_result = $conn->query($book_query);

        if ($book_result->num_rows > 0) {
            $sql = "INSERT INTO issued_books (user_id, isbn, issue_date) VALUES ('$user_id', '$isbn', '$issue_date')";
            $update_book = "UPDATE books SET status = 'issued' WHERE isbn = '$isbn'";
            if ($conn->query($sql) === TRUE && $conn->query($update_book) === TRUE) {
                $message = "Book issued successfully!";
            } else {
                $message = "Error: " . $conn->error;
            }
        } else {
            $message = "Book not available!";
        }
    } else {
        $message = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Issue Book</title>
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

    <h1 class="tit">Issue Book</h1>

    <?php if ($message): ?>
        <div id="messageArea" style="color:red; margin: 20px; font-size: 18px;">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="issue">
    <form method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br>
        <label>ISBN:</label><br>
        <input type="text" name="isbn" required><br><br>
        <input type="submit" value="Issue Book" class="btn">
    </form>
    </div>

    <div class="back">
    <a href="manage_inventory.php">Back to Manage Inventory</a>
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
