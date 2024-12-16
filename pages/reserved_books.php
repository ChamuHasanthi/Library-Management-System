
<?php
session_start();
if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'student')) {
    header("Location: login.php");
    exit();
}

include '../config/db_config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $isbn = $_POST['isbn'];

    if ($action === 'reserve') {
        $username = $_POST['username'];

         
        $user_query = "SELECT id FROM users WHERE username = '$username'";
        $user_result = $conn->query($user_query);

        if ($user_result->num_rows > 0) {
            $user = $user_result->fetch_assoc();
            $user_id = $user['id'];

            
            $book_query = "SELECT * FROM books WHERE isbn = '$isbn' AND status = 'available'";
            $book_result = $conn->query($book_query);

            if ($book_result->num_rows > 0) {
                
                $update_query = "UPDATE books SET status = 'issued' WHERE isbn = '$isbn'";
                if ($conn->query($update_query)) {
                    $message = "Book reserved successfully.";
                } else {
                    $message = "Error updating book status.";
                }
            } else {
                $message = "Book is not available.";
            }
        } else {
            $message = "User not found.";
        }
    } elseif ($action === 'return') {
         
        $update_query = "UPDATE books SET status = 'available' WHERE isbn = '$isbn'";
        if ($conn->query($update_query)) {
            $message = "Book returned and marked as available.";
        } else {
            $message = "Error updating book status.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserved Books</title>
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    
    <header>
        <img src="images/logo.jpg" class="logo">
        <nav>
           <a href="<?php echo ($_SESSION['role'] === 'staff') ? 'staff_dashboard.php' : 'student_dashboard.php'; ?>">Dashboard</a>
           <a href="about.php">About</a>
           <div class="se">
           <a href="search.php"><img src="images/search.png"></a>
           </div>
           <div class="out">
                <a href="logout.php">Logout</a>
           </div>
        </nav>
    </header>
    <h1 class="tit">Reserved Books</h1>
    <p style='color:red;margin:30px;font-size:20px;'><?php echo $message; ?></p>
    <div class="forms-container">
    <form method="POST">
        <input type="hidden" name="action" value="reserve">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required>
        <input type="submit" class="btn" value="Reserve Book">
    </form>
</div>
<div class="form-section">
    <form method="POST">
        <p class="want">If you don't want that reserved book anymore, Return it.</p>
    
        <input type="hidden" name="action" value="return">
        <label for="isbn">ISBN:</label>
        <input type="text" id="isbn" name="isbn" required>
        <input type="submit" value="Return Book" class="btn">
    </form>
    </div>
    

    <div class="back">
    <a href="<?php echo ($_SESSION['role'] === 'staff') ? 'staff_dashboard.php' : 'student_dashboard.php'; ?>">Back to Dashboard</a>
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
