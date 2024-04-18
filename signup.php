<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user = $_POST["username"];
    $pass = $_POST["password"];

    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = ""; // Fill in your database password here
    $dbname = "ecs417"; // Replace 'your_database_name' with your actual database name

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("[-] Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to insert user details into the 'users' table
    $sql = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        header("Location: login.html");
    } else {
        echo '<script>alert("There was an issue signing you up");</script>';
        header("Location: signup.html");
    }

    // Close the database connection
    $conn->close();
}
?>
