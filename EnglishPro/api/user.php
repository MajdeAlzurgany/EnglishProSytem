<?php
// This file handles user registration and login actions.

require_once '../classes/Database.php';
require_once '../classes/Validation.php';
require_once '../classes/User.php';
require_once '../classes/Student.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'register') { // Handle user registration , if the action was register
        $username = $_POST['username'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $age = $_POST['age'];
        $phoneNumber = $_POST['phoneNumber'];
        $userType = 1; // Assuming default user type is student

        try {
            $result = User::register($username, $userType, $email, $password, $age, $phoneNumber, $name);
            if ($result) {
                // Redirect to the main page if success
                $_SESSION['from_signup'] = true;
                header("Location: ../interfaces/index.php");
                exit();
            } else {
                throw new Exception("Registration failed. Please try again.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } else if ($action === 'login') { //Handle user login , if the action was login
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $user = User::login($email, $password);
            if ($user) {
                // Store the user in the session and redirect to the main page
                $_SESSION['user'] = $user;
                header("Location: ../interfaces/index.php");
                exit();
            } else {
                throw new Exception("Login failed. Please try again.");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } 
}
?>
