<?php
    session_start();
    // Check if user is logged in
    if (!isset($_SESSION["username"])) {
        // Redirect to login page if not logged in
        header("Location: login.html");
        exit();
    }

    // Get the comment from the POST field
    $comment = $_POST['comment'];

    // Get the username from the session
    $user = $_SESSION['username'];

    // Get the comment ID from the session
    $entryID = $_SESSION['id'];

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

    // Insert the comment into the comment table
    $sql = "INSERT INTO comment (entry_id, user, comment) VALUES ('$entryID', '$user', '$comment')";

    if ($conn->query($sql) === TRUE) {
        echo "Comment added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();

    header("Location: viewpost.php");
?>
