<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to login page if not logged in
    header("Location: login.html");
    exit();
}

// Check if the form is submitted and the comment_id is set
if (isset($_POST["comment-id"])) {
    // Get the comment ID from the form submission
    $commentId = $_POST["comment-id"];
    
    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ecs417";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("[-] Connection failed: " . $conn->connect_error);
    }

    // Prepare a delete statement
    $sql = "DELETE FROM comment WHERE id = ?";

    // Prepare and bind parameters
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $commentId);

    // Execute the delete statement
    if ($stmt->execute()) {
        header("Location: viewpost.php");
    } else {
        echo '<script>alert("Unable to delete comment");</script>';
    }

    // Close the database connection
    $conn->close();
}
?>
