<?php
require_once 'Database.php';
require_once 'Validation.php';

class User {
    protected $userID;
    protected $username;
    protected $userType;
    protected $email;
    protected $password;
    protected $age;
    protected $phoneNumber;
    protected $name;

    public function __construct($userID = null, $username = null, $userType = null, $email = null, $password = null, $age = null, $phoneNumber = null, $name = null) {
        $this->userID = $userID;
        $this->username = $username;
        $this->userType = $userType;
        $this->email = $email;
        $this->password = $password;
        $this->age = $age;
        $this->phoneNumber = $phoneNumber;
        $this->name = $name;
    }

    // Getter methods
    public function getUserID() {
        return $this->userID;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getUserType() {
        return $this->userType;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getAge() {
        return $this->age;
    }

    public function getPhoneNumber() {
        return $this->phoneNumber;
    }

    public function getName() {
        return $this->name;
    }

    // Static method to register a new user
    public static function register($username, $userType, $email, $password, $age, $phoneNumber, $name) {
        $db = new Database();
        try {
            // Validate and sanitize the input data
            $username = Validation::sanitizeAndValidateUsername($username);
            $email = Validation::validateEmail($email);
            $password = Validation::validatePassword($password);
            $age = Validation::validateAge($age);
            $phoneNumber = Validation::validatePhoneNumber($phoneNumber);
            $name = Validation::validateName($name);
    
            $db->establishConnection();
    
            // Check if the username or email already exists
            $query_check = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
            $result_check = $db->query_exexute($query_check);
            if ($result_check && $result_check->num_rows > 0) {
                throw new Exception("Username or email already exists. Please choose a different one.");
            }
    
            // Insert the new user into the database
            $query = "INSERT INTO users (username, userType, email, password, age, phonenumber, name, level, points, has_taken_placement_test) 
            VALUES ('$username', '$userType', '$email', '$password', '$age', '$phoneNumber', '$name', NULL, 0, FALSE)";

            $result = $db->query_exexute($query);
    
            if ($result) {
                // Get the inserted user ID
                $userID = $db->getLastInsertId(); 
                // Store the new user object in the session
                $_SESSION['user'] = new Student($userID, $username, $userType, $email, $password, $age, $phoneNumber, 1, 0, $name); //..
            }
    
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            if (isset($db)) {
                $db->closeConnection();
            }
        }
    }

    // Static method to login a user
    public static function login($email, $password) {
        $db = new Database();
        try {
            // Validate the input data
            $email = Validation::validateEmail($email);
            $password = Validation::validatePassword($password);

            $db->establishConnection();
    
            $query = "SELECT * FROM users WHERE email = '$email'";
            $result = $db->query_exexute($query);
    
            // Check if a user was found
            if ($result->num_rows > 0) {
                $userData = $result->fetch_assoc();
                // Return a Student or User object based on userType
                if ($userData['userType'] == 1) {
                    return new Student($userData['userid'], $userData['username'], $userData['userType'], $userData['email'], $userData['password'], $userData['age'], $userData['phonenumber'], $userData['level'], $userData['points'], $userData['name']);
                } else {
                    return new User($userData['userid'], $userData['username'], $userData['userType'], $userData['email'], $userData['password'], $userData['age'], $userData['phonenumber'], $userData['name']);
                }
            } else {
                throw new Exception("Invalid email or password. Please try again.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            if (isset($db)) {
                $db->closeConnection();
            }
        }
    }

    // Static method to get a user by their ID
    public static function getUserByID($userID) {
        $db = new Database();
        try {
            $db->establishConnection();
            // Query to fetch the user by ID
            $query = "SELECT * FROM users WHERE userID = '$userID'";
            $result = $db->query_exexute($query);
    
            // Check if a user was found
            if ($result->num_rows > 0) {
                $userData = $result->fetch_assoc();
                return new User($userData['userid'], $userData['username'], $userData['userType'], $userData['email'], $userData['password'], $userData['age'], $userData['phonenumber'], $userData['name']);
            }
            return null;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            if (isset($db)) {
                $db->closeConnection();
            }
        }
    }
}
?>
