<?php
require_once 'Database.php';
require_once 'Lesson.php';

class Course {
    private $courseId;
    private $levelId;
    private $courseName;
    private $lessons = [];

    public function __construct($courseId = null, $levelId = null, $courseName = null) {
        $this->courseId = $courseId; 
        $this->levelId = $levelId;
        $this->courseName = $courseName;
    }

    public static function getCourseByLevel($levelId) { //getting the course along with it's lessons from database by level id 
        $db = new Database();
        try {
            $db->establishConnection();
            $query = "SELECT * FROM courses WHERE levelId = '$levelId'";
            $result = $db->query_exexute($query);

            if ($row = $result->fetch_assoc()) {
                $course = new Course($row['courseId'], $row['levelId'], $row['courseName']); //creating the course object
                $course->loadLessons(); //loading the questions
                return $course;
            } else {
                throw new Exception("Course not found for the given level.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function loadLessons() {
        $this->lessons = Lesson::getLessonsByCourseId($this->courseId);
    }

    public function getLessons() {
        return $this->lessons;
    }

    public function getCourseName() {
        return $this->courseName;
    }
}
?>
