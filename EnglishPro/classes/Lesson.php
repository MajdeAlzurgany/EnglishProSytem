<?php
require_once 'Database.php';
require_once 'Quiz.php';

class Lesson {
    private $lessonId;
    private $courseId;
    private $title;
    private $filePath;
    private $quiz;

    public function __construct($lessonId = null, $courseId = null, $title = null, $filePath = null) {
        $this->lessonId = $lessonId;
        $this->courseId = $courseId;
        $this->title = $title;
        $this->filePath = $filePath;
    }

    public static function getLessonsByCourseId($courseId) { //returns all lessons of the course id from databse
        $db = new Database();
        $lessons = [];
        try {
            $db->establishConnection();
            $query = "SELECT * FROM lessons WHERE courseId = '$courseId'";
            $result = $db->query_exexute($query);
    
            while ($row = $result->fetch_assoc()) {
                $lesson = new Lesson($row['lessonId'], $row['courseId'], $row['title'], $row['filePath']);
                $lesson->loadQuiz();
                $lessons[] = $lesson;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $db->closeConnection();
        }
        return $lessons;
    }

    public static function getLessonById($lessonId) {//returns a lesson from database and store it in object 
        $db = new Database();
        try {
            $db->establishConnection();
            $query = "SELECT * FROM lessons WHERE lessonId = '$lessonId'";
            $result = $db->query_exexute($query);

            if ($row = $result->fetch_assoc()) {
                $lesson = new Lesson($row['lessonId'], $row['courseId'], $row['title'], $row['filePath']);
                $lesson->loadQuiz();
                return $lesson;
            } else {
                throw new Exception("Lesson not found.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function loadQuiz() { //loading the quiz for specific lesson nby lesson id 
        $this->quiz = Quiz::getQuizByLessonId($this->lessonId);
    }
//getters
    public function getQuiz() {
        return $this->quiz;
    }

    public function getFilePath() {
        return $this->filePath;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getLessonId() {
        return $this->lessonId;
    }
}
?>
