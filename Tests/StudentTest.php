<?php
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

require_once '../EnglishProSytem/EnglishPro/classes/Validation.php'; 
require_once '../EnglishProSytem/EnglishPro/classes/Database.php'; 
require_once '../EnglishProSytem/EnglishPro/classes/User.php';
require_once '../EnglishProSytem/EnglishPro/classes/Student.php'; 
require_once '../EnglishProSytem/EnglishPro/classes/PlacementTest.php';

class StudentTest extends TestCase {

    private $testUserID;

    protected function setUp(): void {
        $this->testUserID = null;
    }

    protected function tearDown(): void { // after fininshing testing , this method have to be excecuted to clean DB
        if ($this->testUserID !== null) {
            $this->removeTestUser();
        }
    }

    public function testTakePlacementTest() {
        // Create a student object
        $student = new Student(1, 'testuser', 1, 'testuser@example.com', 'password', 25, '1234567890', 1, 0, 'Test User');

        // Take a placement test
        $placementTest = $student->takePlacementTest();
        assertNotNull($placementTest);
    }

    public function testUpdateLevel() {
        // Create a student object
        $student = new Student(1, 'testuser', 1, 'testuser@example.com', 'password', 25, '1234567890', 1, 100, 'Test User');

        // Update the level
        $newLevel = 2;
        $student->updateLevel($newLevel);

        // Verify the level is updated
        assertEquals($newLevel, $student->getLevel());
    }

    public function testGetLevelById_ExistanceUser() {
        // Create a student object
        $userid = 1;
        $username = 'testuser';
        $userType = 1;
        $email = "testuser@example.com";
        $password = 'password1_';
        $age = 25;
        $phoneNumber = '1234567890';
        $name = 'Test User';
        $level = 1;
        $points = 0;

        $student = new Student($userid ,$username, $userType, $email, $password, $age, $phoneNumber , $level , $points , $name);
        $this->assertNotNull($student);

        // Get the level by ID
        $level = Student::getLevelById($student->getUserID());
        assertEquals(1, $level);
    }

    public function testGetLevelById_NonExistanceUser() {
        // Create a student object
        $userid = 999999;
        $username = 'testuser';
        $userType = 1;
        $email = "testuser@example.com";
        $password = 'password1_';
        $age = 25;
        $phoneNumber = '1234567890';
        $name = 'Test User';
        $level = 1;
        $points = 0;

        $student = new Student($userid ,$username, $userType, $email, $password, $age, $phoneNumber , $level , $points , $name);
        $this->assertNotNull($student);

        // Get the level by ID
        $this->expectException(Exception :: class);
        $this->expectExceptionMessage("User not found or unable to retrieve level.");
        $level = Student::getLevelById($student->getUserID());
        
    }

    public function testGetPlacementStatus() {
        // Create a student object
        $userid = 1;
        $username = 'testuser';
        $userType = 1;
        $email = "testuser@example.com";
        $password = 'password1_';
        $age = 25;
        $phoneNumber = '1234567890';
        $name = 'Test User';
        $level = 1;
        $points = 0;

        $student = new Student($userid ,$username, $userType, $email, $password, $age, $phoneNumber , $level , $points , $name);
        $this->assertNotNull($student);

        // Get the level by ID
        $level = $student->getPlacementStatus($student->getUserID());
        assertEquals(1, $level);
    }

    public function testGetPlacementStatusForNonExistedUser() {
        // Create a student object
        $userid = 9999999999;
        $username = 'testuser';
        $userType = 1;
        $email = "testuser@example.com";
        $password = 'password1_';
        $age = 25;
        $phoneNumber = '1234567890';
        $name = 'Test User';
        $level = 1;
        $points = 0;

        $student = new Student($userid ,$username, $userType, $email, $password, $age, $phoneNumber , $level , $points , $name);
        $this->assertNotNull($student);

        // Get the level by ID
        $this->expectException(Exception :: class);
        $this->expectExceptionMessage("User not found");
        $level = $student->getPlacementStatus($student->getUserID());
    }

    public function testUpdatePoints() {
        // Create a student object
        $student = new Student(1, 'testuser', 1, 'testuser@example.com', 'password', 25, '1234567890', 1, 100, 'Test User');

        // Update the points
        $newPoints = 50;
        $student->updatePoints($newPoints);

        // Verify the points are updated
        assertEquals(150, $student->getPoints());
    }

    public function testUpdatePoints_notUpdated() {
        // Create a student object
        $student = new Student(9000, 'testuser', 1, 'testuser@example.com', 'password', 25, '1234567890', 1, 100, 'Test User'); // non existing user

        // Update the points
        $newPoints = 50;
        $student->updatePoints($newPoints);

        // Verify the points are updated
        assertEquals(150, $student->getPoints());
    }

    public function testGetQuizStatus_taked() {
        // Create a student object
        $student = new Student(1, 'testuser', 1, 'testuser@example.com', 'password', 25, '1234567890', 1, 100, 'Test User');

        // Verify the quiz status for a lesson ID
        $lessonId = 1;
        $status = $student->getQuizStatus($lessonId);

        // The status should be false cause the quiz has been taken before by the student
        assertTrue($status);
    }
    public function testGetQuizStatus_notTaked() { 
        // Create a student object
        $student = new Student(1, 'testuser', 1, 'testuser@example.com', 'password', 25, '1234567890', 1, 100, 'Test User');

        // Verify the quiz status for a lesson ID
        $lessonId = 2;
        $status = $student->getQuizStatus($lessonId);

        // The status should be false since the quiz has not been taken
        assertFalse($status);
    }

    // Clean up the test user after each test
    private function removeTestUser() {
        $db = new Database();
        $db->establishConnection();
        $query = "DELETE FROM users WHERE userid = '$this->testUserID'";
        $db->query_exexute($query);
        $db->closeConnection();
    }
}

?>