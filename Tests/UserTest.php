<?php
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

require_once '../EnglishProSytem/EnglishPro/classes/Validation.php'; 
require_once '../EnglishProSytem/EnglishPro/classes/Database.php'; 
require_once '../EnglishProSytem/EnglishPro/classes/User.php';
require_once '../EnglishProSytem/EnglishPro/classes/Student.php'; 

class UserTest extends TestCase {

    private $testUserID;


    protected function setUp(): void {
        $this->testUserID = null;
    }

    protected function tearDown(): void {// after fininshing testing , this method have to be excecuted to clean DB
        if ($this->testUserID !== null) {
            $this->removeTestUser();
        }
    }

    public function testExistingUserRegistration() {
        $username = 'testuser';
        $userType = 1;
        $email = 'majde.zr18@gmail.com';
        $password = 'Test@123';
        $age = 25;
        $phoneNumber = '1234567890';
        $name = 'Test User';

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Username or email already exists. Please choose a different one.');
        User::register($username, $userType, $email, $password, $age, $phoneNumber, $name);
    }

    public function testNonExistingUserRegistration() {
        //create object user
        $username = 'testuser';
        $userType = 1;
        $email = "majde.zr188@gmail.com";
        $password = 'Test@123';
        $age = 25;
        $phoneNumber = '1234567890';
        $name = 'Test User';

        $result = User::register($username, $userType, $email, $password, $age, $phoneNumber, $name);

        assertTrue($result);

        //This for storing the user id , to delete it from DB  after finishing test
        $db = new Database();
        $db->establishConnection();

        // Get the last inserted user ID
        $query = "SELECT * FROM users WHERE email = '$email'";
        $user = $db->query_exexute($query)->fetch_assoc();
        $this->testUserID = $user['userid'];

        $db->closeConnection();
    }

    public function testExistingUserLogin(){ //with an existance user by correct email and password 
        $email = "majde.zr18@gmail.com";
        $password = "Majde-_-ZR1";
        $user = User::login($email, $password);
        assertEquals($user->getEmail() , $email); //user logged in 
    }

    public function testNonExistingUserLogin(){ //with an existance user by wrong email or password 
        $email = "nonExistance@gmail.com";
        $password = "wrongPasswrod1_";
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Invalid email or password. Please try again.");
        $user = User::login($email, $password);
    }

    public function testgetUserByNonExistID(){ //with an existance user by wrong email or password 
        $id = "999999999";
        $user = User :: getUserByID($id);
        assertNull($user);
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