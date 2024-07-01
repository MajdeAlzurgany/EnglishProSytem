<?php
// This file handles the placement test actions: taking and submitting the test.

require_once '../classes/Database.php';
require_once '../classes/PlacementTest.php';
require_once '../classes/Student.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') { 
    $action = $_POST['action'];

    if ($action === 'take_placement_test') { // If the action is to take a placement test
        try {
            if (!isset($_SESSION['user'])) {
                throw new Exception("User not logged in.");
            }

            $student = $_SESSION['user'];

            if (!($student instanceof Student)) {
                throw new Exception("Invalid user type.");
            }

            // Student takes the placement test
            $placementTest = $student->takePlacementTest();
            $_SESSION['placementTest'] = $placementTest;
            header("Location: ../interfaces/placementTest.php");
            exit();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    } elseif ($action === 'submit_test') { // If the action is to submit the placement test
        try {
            if (!isset($_SESSION['user']) || !isset($_SESSION['placementTest'])) {
                throw new Exception("User not logged in or test not started.");
            }

            $student = $_SESSION['user'];
            $placementTest = $_SESSION['placementTest'];
            $answers = $_POST['answers'];

            // Evaluate the test and save results
            $score = $placementTest->evaluateTest($answers);

            // Save test results to the database
            $db = new Database();
            $db->establishConnection();
            $query1 = "INSERT INTO userPlacementTest (userid, placementTestId, score) VALUES ('" . $student->getUserID() . "', '" . $placementTest->getPlacementTestId() . "', '$score')";
            $db->query_exexute($query1);

            // Update user's level
            $newLevel = PlacementTest::determineLevel($score); 
            $query2 = "UPDATE users SET level = '$newLevel', has_taken_placement_test = TRUE WHERE userid = '" . $student->getUserID() . "'";
            $db->query_exexute($query2);

            // Update session user level
            $student->updateLevel($newLevel);
            $_SESSION['user'] = $student;
            $_SESSION['from_signup'] = false;
            header("Location: ../interfaces/index.php");
            exit();
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
