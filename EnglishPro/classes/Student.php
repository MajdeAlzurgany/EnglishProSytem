<?php

require_once 'User.php';
require_once 'PlacementTest.php';

class Student extends User {
    private $level;
    private $points;
    public function __construct($userID = null, $username = null, $userType = null, $email = null, $password = null, $age = null, $phoneNumber = null, $level = null, $points = null, $studentName = null) {
        // Call the parent constructor
        parent::__construct($userID, $username, $userType, $email, $password, $age, $phoneNumber, $studentName);
        $this->level = $level;
        $this->points = $points;
    }

    // Method to take a placement test
    public function takePlacementTest() {
        try {
            // Randomly select a placement test ID
            $placementTestId = rand(1, 5); // Assume there are 5 placement tests

            $placementTest = PlacementTest::getPlacementTest($placementTestId);
            return $placementTest;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateLevel($newLevel) {
        $this->level = $newLevel;
    }

    // Method to get the level of the student by their ID
    public static function getLevelById($userid){
        // Database interaction
        $db = new Database();
        $db->establishConnection();
        $query = "SELECT * FROM users WHERE userid= '$userid'";
        $result = $db->query_exexute($query);
        try {
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                return $user['level'];
            } else {
                throw new Exception("User not found or unable to retrieve level.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function getPlacementStatus($userid){ //function to check from db if the student has taken the placement test before or not
        // Database interaction
        $db = new Database();
        $db->establishConnection();
        $query = "SELECT * FROM users WHERE userid= '$userid'";
        $result = $db->query_exexute($query);
        try {
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                return $user['has_taken_placement_test']; 
            } else {
                throw new Exception("User not found");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function updatePoints($score) { //function to add points after each scores
        $db = new Database();
        $db->establishConnection();

        $query = "UPDATE users SET points = $score + $this->points WHERE userid = '$this->userID'";
        $result = $db->query_exexute($query);

        try{
            if($result){
                $this->points =  $score + $this->points;
            }else {
                throw new Exception("Error , score not updated.");
            }
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }finally{
            $db->closeConnection();
        }
    }
    public function getQuizStatus($lessonId) { //to check if the user has taken the quiz before or not
        $db = new Database();
        $db->establishConnection();

        $query = "SELECT * FROM userquiz uq 
                  JOIN quizzes q ON uq.quizId = q.quizId 
                  WHERE uq.userId = '$this->userID' AND q.lessonId = '$lessonId'";
        $result = $db->query_exexute($query);

        $status = false;
        if ($result && $result->num_rows > 0) {
            $status = true; // Quiz has been taken
        }

        $db->closeConnection();
        return $status;
    }

    // Getter methods
    public function getLevel() {
        return $this->level;
    }

    public function getPoints() {
        return $this->points;
    }
}
?>
