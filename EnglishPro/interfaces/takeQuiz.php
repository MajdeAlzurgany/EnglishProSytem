<?php
require_once '../classes/User.php';
require_once '../classes/Student.php';
require_once '../classes/Quiz.php';
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: signin.php");
    exit(); 
}

if (!isset($_SESSION['quiz'])) {
    header("Location: index.php");
    exit(); 
}

$quiz = $_SESSION['quiz'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/quizStyle.css">
    <title>Take Quiz - EnglishPro</title>
</head>
<body>
    <header>
        <h1><a href="index.php">EnglishPro</a></h1>
        <div class="user-info">
            <?php
                echo '<span>Welcome, ' . $_SESSION['user']->getUsername() . '</span>';
            ?>
            <a href="editProfile.php" class="personal-info">Edit profile</a>
            <a href="../api/logout.php" class="logout-button">Log Out</a>
        </div>
    </header>

    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="aboutus.php">About Us</a></li>
        </ul>
    </nav>
    
    <main>
        <h2><?php echo $quiz->getTitle(); ?></h2>
        <form action="../api/quiz.php" method="post">
            <input type="hidden" name="action" value="submit_quiz">
            <?php
            foreach ($quiz->getQuestions() as $index => $question) {
                echo "<div class='question'>";
                echo "<p>{$question['question']}</p>";
                echo '<label><input type="radio" name="answers[' . $index . ']" value="True"> True</label>';
                echo '<label><input type="radio" name="answers[' . $index . ']" value="False"> False</label>';
                echo "</div>";
            }
            ?>
            <input type="submit" value="Submit Quiz" class="btn">
        </form>
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
        <div class="info">
            <div>Phone number: 0919353046</div>
            <div>Email: majde.zr@gmail.com</div>
            <div>Company Location: Libya - Tripoli</div>
        </div>
    </footer>
</body>
</html>
