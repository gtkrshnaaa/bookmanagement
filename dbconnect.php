<?php
$servername = "localhost";
$username = "root";
$password = "P@ssw0rd!";
$dbname = "bookmanagement";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
