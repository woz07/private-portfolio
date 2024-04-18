<?php
session_start();

// Check if logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.html");
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecs417";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("[-] Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve post data from form
    $title = $_POST["title"];
    $body = $_POST["body"]; // Adjusted to match the name attribute in the HTML form
    $date = date("Y-m-d"); // Get current date
    $time = date("H:i:s"); // Get current time

    // Prepare and execute SQL statement to insert data into post table
    $sql = "INSERT INTO post (date, time, title, body) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $date, $time, $title, $body);
    $stmt->execute();

    // Check if insertion was successful
    if ($stmt->affected_rows > 0) {
        echo "Post added successfully.";
        header("Location: viewpost.php");
        exit();
    } else {
        echo "Error adding post.";
    }
}
?>
