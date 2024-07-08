<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published_date = $_POST['published_date'];
    $genre = $_POST['genre'];
    $image = null;

    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $image = $conn->real_escape_string($image);
    }

    if ($image) {
        $sql = "INSERT INTO books (title, author, published_date, genre, image) VALUES ('$title', '$author', '$published_date', '$genre', '$image')";
    } else {
        $sql = "INSERT INTO books (title, author, published_date, genre) VALUES ('$title', '$author', '$published_date', '$genre')";
    }

    if ($conn->query($sql) === TRUE) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Book</title>
</head>
<body>
    <h2>Add New Book</h2>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="" enctype="multipart/form-data">
        Title: <input type="text" name="title" required><br>
        Author: <input type="text" name="author" required><br>
        Published Date: <input type="date" name="published_date" required><br>
        Genre: <input type="text" name="genre" required><br>
        Upload Image (optional): <input type="file" name="image"><br>
        <button type="submit">Add Book</button>
    </form>
</body>
</html>
