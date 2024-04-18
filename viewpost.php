<?php
// Start session
session_start();

// Check if user is logged in
if (!isset($_SESSION["username"])) {
    // Redirect to login page if not logged in
    header("Location: login.html");
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
    <link rel="stylesheet" href="./css/viewpost.css">
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
                <li><a href="#" id="active">View post</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <section id="container">


    <?php
        // Database connection details
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "ecs417";

        // Connect to the database
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("[-] Connection failed: " . $conn->connect_error);
        }

        // Retrieve post data from the database
        $sql = "SELECT * FROM post";
        $result = $conn->query($sql);

        // Array to store posts
        $posts = array();

        // Check if there are any posts
        if ($result->num_rows > 0) {
            // Fetch each row and add it to the posts array
            while ($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }

            // Sort posts using bubble sort algorithm by date and time in descending order
            $n = count($posts);
            for ($i = 0; $i < $n - 1; $i++) {
                for ($j = 0; $j < $n - $i - 1; $j++) {
                    // Combine date and time strings for comparison
                    $date1 = $posts[$j]["date"] . " " . $posts[$j]["time"];
                    $date2 = $posts[$j + 1]["date"] . " " . $posts[$j + 1]["time"];
                    // Compare datetime strings using strtotime
                    if (strtotime($date1) < strtotime($date2)) {
                        // Swap posts if necessary
                        $temp = $posts[$j];
                        $posts[$j] = $posts[$j + 1];
                        $posts[$j + 1] = $temp;
                    }
                }
            }
            
            echo '<div id="content">';

            // Output sorted posts
            foreach ($posts as $post) {
                // Wrap each post in a div with the card class
                echo '<div class="card">';
                echo "<h2>By: " . $post["username"] . "</h2>";
                echo "<h2>Title:<br>" . $post["title"] . "</h2>";
                echo "<h3>Post:<br>" . $post["body"] . "</h3><br>";
                echo "<h4>Date: " . $post["date"] . "</h4>";
                echo "<h4>Time: " . $post["time"] . "</h4>";
                echo '<button><a href="comment.php?id=' . $post["id"] . '">Comments</a></button>';
                echo '</div>';
            }            

            echo '</div>';
        } else {
            // If no posts found, display a message
            echo "No posts found.";
        }

        // Close the database connection
        $conn->close();
    ?>


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
