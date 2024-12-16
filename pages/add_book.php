<?php
session_start();
if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'student')) {
    header("Location: login.php");
    exit();
}

include '../config/db_config.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'] ?? '';
    $author = $_POST['author'] ?? '';
    $isbn = $_POST['isbn'] ?? '';

    
    if (!empty($title) && !empty($author) && !empty($isbn)) {
         
        $query = "INSERT INTO books (title, author, isbn) VALUES ('$title', '$author', '$isbn')";
        if ($conn->query($query) === TRUE) {
            $_SESSION['message'] = "Book added successfully.";
        } else {
            $_SESSION['message'] = "Error adding book: " . $conn->error;
        }
    } else {
        $_SESSION['message'] = "Please fill out all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Book</title>
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
           <div class="out">
                <a href="logout.php">Logout</a>
           </div>
        </nav>
    </header>

 
    <h1 class="tit">Add Book</h1>

    <div class="search">
       
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>#messageArea">
            <label>Title:</label><br>
            <input type="text" name="title" required><br><br>

            <label>Author:</label><br>
            <input type="text" name="author" required><br><br>

            <label>ISBN:</label><br>
            <input type="text" name="isbn" required><br><br>

            <input type="submit" value="Add Book" class="btn"><br><br>
        </form>
    </div>

   
    <?php 
    if (isset($_SESSION['message'])) {
        echo "<p id='messageArea' style='color:red; margin: 30px; font-size: 20px;'>".$_SESSION['message']."</p>";
        unset($_SESSION['message']);  
    }
    ?>

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
