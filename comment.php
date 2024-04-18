<?php
    // Start session
    session_start();

    // Check if user is logged in
    if (!isset($_SESSION["username"])) {
        // Redirect to login page if not logged in
        header("Location: login.html");
        exit();
    }
    // Retrieve the ID parameter from the URL
    if (isset($_GET["id"])) {
        // Store the ID in the session
        $_SESSION["id"] = $_GET["id"];
    } else {
        echo "Unable to get comments for this post!";
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Ubuntu&display=swap" rel="stylesheet">
    <!-- Font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- My CSS -->
    <link rel="stylesheet" href="./css/global.css">
    <link rel="stylesheet" href="./css/comment.css">
</head>
<body>
    <!-- Header -->
    <header>
        <nav id="navbar">
            <ul>
                <li><a href="./index.html">Home</a></li>
                <li><a href="./about.html">About</a></li>
                <li><a href="./projects.html">Projects</a></li>
                <li><a href="./contact.html">Contact</a></li>
                <li><a href="./login.html">Login</a></li>
                <li><a href="./signup.html">Signup</a></li>
                <li><a href="./addpost.html">Add post</a></li>
                <li><a href="./viewpost.php">View post</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <section id="container">

    <div id="content">
    <?php
        $entryId = $_SESSION['id'];
        $btftc = false; // be the first to comment

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

        // SQL query to select comments for the given entry_id
        $sql = "SELECT * FROM comment WHERE entry_id = $entryId";
        $result = $conn->query($sql);

        // Check if there are any comments
        if ($result->num_rows > 0) {
            // Output comments
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo "<h2>User: " . $row["user"] . "</h2><br>";
                echo "<h2>Comment: " . $row["comment"] . "</h2><br><br>";
                
                // Check if the logged-in user is an admin
                if ($_SESSION["username"] === "usersam") {
                    // If user is admin, display the delete button
                    echo '<form method="POST" action="deletecomment.php">';
                    echo '<input type="hidden" name="comment-id" value="' . $row["id"] . '">';
                    echo '<input type="submit" value="Delete">';
                    echo '</form>';
                }
                
                echo "</div>";
            }
            
        } else {
            // If no comments found, display a message
            echo "No comments found for this entry.<br><br><br>";
            echo '<button><a href="addcomment.html">Be the first to comment!</a></button>';
            $btftc = true;
        }

        // Close the database connection
        $conn->close();

        if (!$btftc) {
            echo '<button><a href="addcomment.html">Add your comment!</a></button>';
        }

        $_SESSION["id"] = $entryId;
    ?>
    </div>

    </section>
    <!-- Footer -->
    <footer>
        <div id="socials">
            <a href="https://www.linkedin.com/in/sameer-muhammad-458291236/" target="_blank"><i class="fa-brands fa-linkedin fa-2x"></i></i></a>
            <a href="https://github.com/woz07" target="_blank"><i class="fa-brands fa-github fa-2x"></i></a>
        </div>
        <p>Sameer Muhammad &copy; 2024</p>
    </footer>

    <script src="./js/viewpost.js"></script>
</body>
</html>