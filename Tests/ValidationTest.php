<?php

use PHPUnit\Framework\TestCase;

require_once 'EnglishPro/classes/Validation.php'; 

class ValidationTest extends TestCase {

    public function testInvalidEmail() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid email format.');
        Validation::validateEmail('invalidemail');
    }

    public function testValidEmail() {
        $this->assertEquals('valid.email@example.com', Validation::validateEmail('valid.email@example.com'));
    }

    public function testInvalidPassword() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Password must contain at least one special character.');
        Validation::validatePassword('password');
    }

    public function testValidPassword() {
        $this->assertEquals('P@ssword1', Validation::validatePassword('P@ssword1'));
    }

    public function testInvalidPhoneNumber() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Phone number should contain only digits.');
        Validation::validatePhoneNumber('123-456-7890');
    }

    public function testValidPhoneNumber() {
        $this->assertEquals('1234567890', Validation::validatePhoneNumber('1234567890'));
    }

    public function testInvalidAge() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Age is not valid.');
        Validation::validateAge(5);
    }

    public function testValidAge() {
        $this->assertEquals(25, Validation::validateAge(25));
    }

    public function testInvalidUsername() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Username should not contain hash symbols, single quotes, or double quotes.');
        Validation::sanitizeAndValidateUsername('invalid#username');
    }

    public function testValidUsername() {
        $this->assertEquals('validusername', Validation::sanitizeAndValidateUsername('validusername'));
    }

    public function testInvalidName() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Name should not contain special characters.');
        Validation::validateName('invalid@name');
    }

    public function testValidName() {
        $this->assertEquals('Valid Name', Validation::validateName('Valid Name'));
    }

}
?>
