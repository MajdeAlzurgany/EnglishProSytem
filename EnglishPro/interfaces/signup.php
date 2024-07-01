<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/signupStyles.css">
    <link rel="stylesheet" href="../css/matchedStyles.css">
    <title>Sign Up</title>
</head>
<body>
    <header>
        <h1><a href="../HTMLfiles/index.php">EnglishPro</a></h1>
        <img class="logo" src="" alt="LOGO">
    </header>

    <nav class="navbar">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a target="_blank" href="signIn.php">Sign In</a></li>
            <li><a target="_blank" href="signUp.php">Sign Up</a></li>
            <li><a href="aboutus.html">About Us</a></li>
        </ul>
    </nav>
    <main>
        <div class="sign-up-form">
            <h2>Sign Up</h2>
            <form action="../api/user.php" method="post">
                <input type="hidden" name="action" value="register">
                
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email-signup">Email:</label>
                <input type="email" id="email-signup" name="email" required>

                <label for="password-signup">Password:</label>
                <input type="password" id="password-signup" name="password" required>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required min="18">

                <label for="phoneNumber">Phone Number:</label>
                <input type="tel" id="phoneNumber" name="phoneNumber" required>

                <button type="submit" name="signup">Sign Up</button>
            </form>
        </div>
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
            <div>Phone number : 0919353046</div>
            <div>Email : majde.zr@gmail.com </div>
            <div>Company Location: Libya - Tripoli</div>
        </p>
    </footer>
</body>
</html>
