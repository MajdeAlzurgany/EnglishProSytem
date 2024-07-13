<?php
require_once 'Database.php';
require_once 'Test.php';

class PlacementTest extends Test {
    public static function getPlacementTest($placementTestId) {
        $db = new Database();
        try {
            // db interaction
            $db->establishConnection();
            $query = "SELECT * FROM placementTest WHERE placementTestId = '$placementTestId'";
            $result = $db->query_exexute($query);
            // Check if a result was returned
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $placementTest = new PlacementTest($row['placementTestId'], $row['title']);
                // Load the questions for the test
                $placementTest->loadQuestions('placementTestId');
                return $placementTest;
            } else {
                throw new Exception('Placement test not found.');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public static function determineLevel($score) {
        if ($score < 3) {
            return 1; // Beginner
        } elseif ($score < 7) {
            return 2; // Intermediate
        } else {
            return 3; // Advanced
        }
    }
}
?>
