<?php
use PHPUnit\Framework\TestCase;

require_once '../EnglishPro/classes/User.php';
require_once '../EnglishPro/classes/Database.php';

class UserTest extends TestCase {


    public function testUserRegistration() {
        $username = 'testuser';
        $userType = 1;
        $email = 'majde.zr18@gmail.com';
        $password = 'Test@123';
        $age = 25;
        $phoneNumber = '1234567890';
        $name = 'Test User';

        
        User::register($username, $userType, $email, $password, $age, $phoneNumber, $name);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Username or email already exists. Please choose a different one.');

    }
}
?>
