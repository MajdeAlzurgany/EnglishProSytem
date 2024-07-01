<?php
require_once 'Database.php';

class PlacementTest {
    private $placementTestId;
    private $title;
    private $questions;

    public function __construct($placementTestId = null, $title = null) {
        $this->placementTestId = $placementTestId;
        $this->title = $title;
        $this->questions = []; // Initialize questions as an empty array, will be filled by loadQuestions method
    }

    // Method to load questions for the placement test from the database
    public function loadQuestions() {
        $db = new Database();
        try {
            $db->establishConnection();
            // Query to fetch questions related to the placement test ID
            $query = "SELECT * FROM questions WHERE placementTestId = '$this->placementTestId'";
            $result = $db->query_exexute($query);

            // Fetch each question and add it to the questions array
            while ($row = $result->fetch_assoc()) {
                $this->questions[] = $row;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    // Static method to get a placement test by its ID
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
                $placementTest->loadQuestions();
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

    // Method to evaluate the test based on provided answers
    public function evaluateTest($answers) {
        $score = 0;
        // Loop through each question and check the answer
        foreach ($this->questions as $index => $question) {
            if ($answers[$index] == $question['answer']) {
                $score++;
            }
        }
        return $score;
    }

    // Static method to determine the level based on the score
    public static function determineLevel($score) {
        if ($score < 3) {
            return 1; // Beginner
        } elseif ($score < 7) {
            return 2; // Intermediate
        } else {
            return 3; // Advanced
        }
    }

    // Getter methods
    public function getPlacementTestId() {
        return $this->placementTestId;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getQuestions() {
        return $this->questions;
    }
}
?>
