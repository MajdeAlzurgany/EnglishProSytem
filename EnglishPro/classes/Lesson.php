<?php
require_once 'Database.php';

class Lesson {
    private $lessonId;
    private $courseId;
    private $title;
    private $filePath;

    public function __construct($lessonId = null, $courseId = null, $title = null, $filePath = null) {
        $this->lessonId = $lessonId;
        $this->courseId = $courseId;
        $this->title = $title;
        $this->filePath = $filePath;
    }

    public static function getLessonsByCourseId($courseId) {
        $db = new Database();
        $lessons = [];
        try {
            $db->establishConnection();
            $query = "SELECT * FROM lessons WHERE courseId = '$courseId'";
            $result = $db->query_exexute($query);
    
            while ($row = $result->fetch_assoc()) {
                $lessons[] = new Lesson($row['lessonId'], $row['courseId'], $row['title'], $row['filePath']);
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $db->closeConnection();
        }
        return $lessons;
    }

    public static function getLessonById($lessonId) {
        $db = new Database();
        try {
            $db->establishConnection();
            $query = "SELECT * FROM lessons WHERE lessonId = '$lessonId'";
            $result = $db->query_exexute($query);

            if ($row = $result->fetch_assoc()) {
                return new Lesson($row['lessonId'], $row['courseId'], $row['title'], $row['filePath']);
            } else {
                throw new Exception("Lesson not found.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $db->closeConnection();
        }
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
