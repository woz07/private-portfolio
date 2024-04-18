<?php
session_start();

// Check if user is already logged in
if(isset($_SESSION["username"])) {
    // If logged in, redirect to addpost.html
    header("Location: addpost.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecs417";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("[-] Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from POST data
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Prepare SQL query (use parameterized queries to prevent SQL injection)
    $sql = "SELECT * FROM USERS WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    
    // Get result set
    $result = $stmt->get_result();

    // Check if any rows were returned
    if ($result->num_rows == 1) {
        // If login successful, set session variable and redirect to addpost.html
        $_SESSION["username"] = $username;
        header("Location: addpost.html");
        exit();
    } else {
        // Display error message if credentials are incorrect
        echo "Invalid username or password.";
    }
}

// Close connection
$conn->close();
?>
