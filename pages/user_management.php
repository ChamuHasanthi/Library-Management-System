<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}
include '../config/db_config.php';

$user_borrowed_books = [];
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $user_query = "SELECT id FROM users WHERE username = '$username'";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        $user_id = $user['id'];

        $borrow_query = "SELECT b.title, b.isbn, ib.issue_date FROM issued_books ib 
                         JOIN books b ON ib.isbn = b.isbn WHERE ib.user_id = '$user_id'";
        $borrow_result = $conn->query($borrow_query);

        if ($borrow_result->num_rows > 0) {
            while ($row = $borrow_result->fetch_assoc()) {
                $user_borrowed_books[] = $row;
            }
        } else {
            $message = "No borrowed books for this user.";
        }
    } else {
        $message = "User not found!";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_user'])) {
    $username = $_POST['username'];
    
   
    $user_query = "SELECT id FROM users WHERE username = '$username'";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows > 0) {
        $user = $user_result->fetch_assoc();
        $user_id = $user['id'];

         
        $delete_borrow_query = "DELETE FROM issued_books WHERE user_id = $user_id";
        $conn->query($delete_borrow_query);

         
        $delete_user_query = "DELETE FROM users WHERE id = $user_id";
        if ($conn->query($delete_user_query) === TRUE) {
            $message = "User '$username' and their issued books were successfully removed!";
        } else {
            $message = "Error removing user: " . $conn->error;
        }
    } else {
        $message = "User '$username' not found!";
    }
}

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
    <title>User Management</title>
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

    <h1 class="tit">User Management</h1>
    <div class="user">
    <form method="POST">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>
        <input type="submit" value="Search" class="btn">
        <button type="submit" name="remove_user" class="rem_btn">Remove user</button>
    </form>
    </div>
    <?php if (isset($message)) echo "<p style='color:red;margin:30px;font-size:20px;'>$message</p>"; ?>
    <?php if (!empty($user_borrowed_books)) { ?>
        <h3>Borrowed Books:</h3>
        <table border="1" class="books">
            <tr>
                <th>Title</th>
                <th>ISBN</th>
                <th>Issue Date</th>
            </tr>
            <?php foreach ($user_borrowed_books as $book) { ?>
                <tr>
                    <td><?php echo $book['title']; ?></td>
                    <td><?php echo $book['isbn']; ?></td>
                    <td><?php echo $book['issue_date']; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>

    <div class="back">
    <a href="staff_dashboard.php">Back to Dashboard</a>
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
