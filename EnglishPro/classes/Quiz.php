<?php
require_once 'Database.php';
require_once 'Test.php';

class Quiz extends Test {
    private $lessonId;

    public function __construct($quizId = null, $lessonId = null, $title = null) {
        parent::__construct($quizId, $title);
        $this->lessonId = $lessonId;
    }

    public static function getQuizByLessonId($lessonId) { //fething the quiz from DB by the lesson id
        $db = new Database();
        try {
            $db->establishConnection();
            $query = "SELECT * FROM quizzes WHERE lessonId = '$lessonId'";
            $result = $db->query_exexute($query);

            if ($row = $result->fetch_assoc()) {
                $quiz = new Quiz($row['quizId'], $row['lessonId'], $row['title']);
                $quiz->loadQuestions('quizId'); //loading the questions from db accordin to the testid stored in the obj quiz 
                return $quiz;
            } else {
                throw new Exception("Quiz not found for the given lesson.");
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }

    public function getLessonId() { //return lesson id
        return $this->lessonId;
    }
}
?>
