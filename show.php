<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'dbconnect.php';

$id = $_GET['id'];
$sql = "SELECT * FROM books WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $book = $result->fetch_assoc();
} else {
    echo "No book found";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Book</title>
</head>
<body>
    <h2>View Book</h2>
    <p>Title: <?php echo $book['title']; ?></p>
    <p>Author: <?php echo $book['author']; ?></p>
    <p>Published Date: <?php echo $book['published_date']; ?></p>
    <p>Genre: <?php echo $book['genre']; ?></p>
    <?php if ($book['image']) {
        echo '<img src="data:image/jpeg;base64,' . base64_encode($book['image']) . '"/>';
    } else {
        echo "<p>No image available</p>";
    }
    ?>
    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
