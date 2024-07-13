<?php 
require_once '../classes/User.php';
require_once '../classes/Student.php';
require_once '../classes/Course.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: signin.php");
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/matchedStyles.css">
    <link rel="stylesheet" href="../css/Style.css">
    <link rel="stylesheet" href="../css/lessonsStyle.css">
    <title>EnglishPro</title>
</head>
<body>
    <div class="wrapper">
        <header>
            <h1><a href="index.php">EnglishPro</a></h1>
            <div class="user-info">
                <?php
                    echo '<span>Welcome ' . $_SESSION['user']->getUsername() . ", Current Level: " . $_SESSION['user']->getLevel() . '</span>';
                ?>
                <a href="#" class="personal-info">Edit profile</a>
                <a href="../api/logout.php" class="logout-button">Log Out</a>
            </div>
        </header>

        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="showLessons.php">Course</a></li>
            </ul>
        </nav>
        
        <main>
            <h2>Course</h2>
            <?php
                $levelId = $_SESSION['user']->getLevel();
                $course = Course::getCourseByLevel($levelId);
                if ($course) {
                    echo "<div class='course'>";
                    echo "<h3>" . $course->getCourseName() . "</h3>";
                    foreach ($course->getLessons() as $lesson) {
                        echo "<div class='lesson'>";
                        echo "<p>" . $lesson->getTitle() . "</p>";
                        echo "<a href='" . $lesson->getFilePath() . "' target='_blank'>View PDF</a>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "<p>No course found for the current level.</p>";
                }
            ?>
        </main>

        <footer>
            <div class="social-media">
                <a href="https://facebook.com" target="_blank"><img class="face" src="../pictures/face.webp" alt="facebook icon"></a>
                <a href="https://instagram.com" target="_blank"><img class="insta" src="../pictures/Insta.webp" alt="instagram icon"></a>
                <a href="https://youtube.com" target="_blank"><img class="youtube" src="../pictures/youtube.png" alt="youtube icon"></a>
                <a href="https://web.telegram.org/a/" target="_blank"><img class="tele" src="../pictures/Telegram.webp" alt="telegram icon"></a>
                <a href="https://whatsapp.com" target="_blank"><img class="whats" src="../pictures/whats.png" alt="whatsapp icon"></a>
            </div>
            <div class="copyright">
                &copy; 2024 Your Website. All rights reserved.
            </div>
            <p class="info">
                <div>Phone number: 0919353046</div>
                <div>Email: majde.zr@gmail.com</div>
                <div>Company Location: Libya - Tripoli</div>
            </p>
        </footer>
    </div>
</body>
</html>
