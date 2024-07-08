<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

include 'dbconnect.php';

$error = '';

// Memproses data ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $published_date = $_POST['published_date'];
    $genre = $_POST['genre'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    // Cek apakah ada file gambar yang diunggah
    if (!empty($image)) {
        $image_data = file_get_contents($image_tmp); // Baca data gambar
        $image_data = $conn->real_escape_string($image_data); // Escape data untuk query SQL

        // Jika ada file gambar yang diunggah, update data buku termasuk gambar baru
        $sql = "UPDATE books SET title='$title', author='$author', published_date='$published_date', genre='$genre', image='$image_data' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Error updating record: " . $conn->error;
        }
    } else {
        // Jika tidak ada file gambar yang diunggah, update data buku tanpa mengubah gambar
        $sql = "UPDATE books SET title='$title', author='$author', published_date='$published_date', genre='$genre' WHERE id='$id'";
        if ($conn->query($sql) === TRUE) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "Error updating record: " . $conn->error;
        }
    }
} else {
    // Jika metode bukan POST, ambil data buku berdasarkan ID dari parameter GET
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM books WHERE id='$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $book = $result->fetch_assoc();
        } else {
            $error = "Record not found.";
        }
    } else {
        $error = "ID parameter is missing.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Book</title>
</head>
<body>
    <h2>Edit Book</h2>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $book['id']; ?>">
        Title: <input type="text" name="title" value="<?php echo $book['title']; ?>" required><br>
        Author: <input type="text" name="author" value="<?php echo $book['author']; ?>" required><br>
        Published Date: <input type="date" name="published_date" value="<?php echo $book['published_date']; ?>" required><br>
        Genre: <input type="text" name="genre" value="<?php echo $book['genre']; ?>" required><br>
        Current Image: <?php if (!empty($book['image'])): ?>
            <img src="data:image/jpeg;base64,<?php echo base64_encode($book['image']); ?>" alt="<?php echo $book['title']; ?>" style="width:50px;height:50px;"><br>
        <?php else: ?>
            No image uploaded<br>
        <?php endif; ?>
        Upload New Image (optional): <input type="file" name="image"><br>
        <button type="submit">Update Book</button>
    </form>
</body>
</html>
