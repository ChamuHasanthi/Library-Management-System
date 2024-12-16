<?php
session_start();
if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'staff' && $_SESSION['role'] !== 'student')) {
    header("Location: login.php");
    exit();
}

include '../config/db_config.php';

$search_results = [];
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_type = $_POST['search_type'] ?? '';   
    $search_term = $_POST['search_term'] ?? '';  
    if (!empty($search_type) && !empty($search_term)) {
        $query = "SELECT * FROM books WHERE $search_type LIKE '%$search_term%'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $search_results[] = $row;
            }
        } else {
            $message = "No books found for the given search criteria.";
        }
    } else {
        $message = "Please select a search type and enter a search term.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Dashboard</title>
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
     
    <h1 class="tit">Search Books</h1>

    

    <div class="search">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>#messageArea">

        <label>Search By:</label><br>
        <select name="search_type" required>
            <option value="" disabled selected>Select Search Criteria</option>
            <option value="author">Author</option>
            <option value="title">Title</option>
            <option value="isbn">ISBN</option>
        </select><br><br>

        <label>Search Term:</label><br>
        <input type="text" name="search_term" required><br><br>

        <input type="submit" value="Search" class="btn"><br><br>
    </form>
    </div>

    <?php if (isset($message)) echo "<p id='messageArea' name='messageArea' style='color:red;margin:30px;font-size:20px;'>$message</p>"; ?>

    
    <?php if (!empty($search_results)) { ?>
    <h3 id="messageArea" name="messageArea">Search Results:</h3>

        <table border="1" class="books">
            <tr>
                <th>Title</th>
                <th>ISBN</th>
                <th>Author</th>
                <th>Status</th>
            </tr>
            <?php foreach ($search_results as $book) { ?>
                <tr>
                    <td><?php echo $book['title']; ?></td>
                    <td><?php echo $book['isbn']; ?></td>
                    <td><?php echo $book['author']; ?></td>
                    <td><?php echo $book['status']; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } ?>
    
    

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
