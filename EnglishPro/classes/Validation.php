<?php

class Validation {
    public static function sanitizeString($string) {
        return filter_var($string, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    }

    public static function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email format.');
        }
        return $email;
    }

    public static function validatePassword($password) {
        if (!preg_match('/[@%^&()_<>?":{}|<>]/', $password)) {
            throw new Exception('Password must contain at least one special character.');
        }
        if (preg_match('/[#\'"]/', $password)) {
            throw new Exception('Password should not contain hyphens, hash symbols, single quotes, or double quotes.');
        }
        return $password;
    }

    public static function validatePhoneNumber($phoneNumber) {
        if (!ctype_digit($phoneNumber)) {
            throw new Exception('Phone number should contain only digits.');
        }
        return $phoneNumber;
    }

    public static function validateAge($age) {
        if (!filter_var($age, FILTER_VALIDATE_INT)) {
            throw new Exception('Invalid age format.');
        }
        if ($age < 6) {
            throw new Exception('Age is not valid.');
        }
        return $age;
    }

    public static function sanitizeAndValidateUsername($username) {
        $username = self::sanitizeString($username);
        if (preg_match('/[#\'"]/', $username)) {
            throw new Exception('Username should not contain hash symbols, single quotes, or double quotes.');
        }
        return $username;
    }

    public static function validateName($name) {
        $name = self::sanitizeString($name);
        if (preg_match('/[!@#$%^&*()_<>?":{}|<>]/', $name)) {
            throw new Exception('Name should not contain special characters.');
        }
        return $name;
    }
}
?>
