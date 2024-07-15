<?php
// This file handles the quiz actions: taking and submitting the quiz.

require_once '../classes/Database.php';
require_once '../classes/Quiz.php';
require_once '../classes/Student.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $action = $_POST['action'];

    if ($action === 'take_quiz') { // If the action is to take a quiz
        try {
            if (!isset($_SESSION['user'])) {
                throw new Exception("User not logged in.");
            }

            $lessonId = $_POST['lessonId'];
            $quiz = Quiz::getQuizByLessonId($lessonId);
            if (!$quiz) {
                throw new Exception("Quiz not found.");
            }

            $_SESSION['quiz'] = $quiz;
            header("Location: ../interfaces/takeQuiz.php");
            exit();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } elseif ($action === 'submit_quiz') { // If the action is to submit the quiz
        try {
            if (!isset($_SESSION['user']) || !isset($_SESSION['quiz'])) {
                throw new Exception("User not logged in or quiz not started.");
            }

            $student = $_SESSION['user'];
            $quiz = $_SESSION['quiz'];
            $answers = $_POST['answers'];

            // Evaluate the quiz and save results
            $score = $quiz->evaluateTest($answers);

            // Save quiz results to the database
            $db = new Database();
            $db->establishConnection();
            $query = "INSERT INTO userquiz (userId, quizId, score) VALUES ('" . $student->getUserID() . "', '" . $quiz->getTestId() . "', '$score')";
            $db->query_exexute($query);

            unset($_SESSION['quiz']);

            $student->updatePoints($score); // updating the points of the user by adding it the score

            echo "Quiz submitted successfully. Your score is $score.";
        } catch (Exception $e) {
            echo $e->getMessage();
        } finally {
            $db->closeConnection();
        }
    } else {
        echo "Invalid action.";
    }
} else {
    header("Location: ../interfaces/index.php");
    exit();
}
?>
