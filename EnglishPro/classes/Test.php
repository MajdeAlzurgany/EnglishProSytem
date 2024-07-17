<?php
require_once 'Database.php';
class Test {
    protected $testId;
    protected $title;
    protected $questions;

    public function __construct($testId = null, $title = null) {
        $this->testId = $testId;
        $this->title = $title;
        $this->questions = [];
    }

    // Method to load questions for the test
    public function loadQuestions($field) {
        $db = new Database();
        try {
            $db->establishConnection();
            $query = "SELECT * FROM questions WHERE $field = '$this->testId'";
            $result = $db->query_exexute($query);

            while ($row = $result->fetch_assoc()) {
                $this->questions[] = $row;
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        } finally {
            $db->closeConnection();
        }
    }
    public function evaluateTest($answers) {
        $score = 0;
        // Loop through each question and check the answer
        foreach ($this->questions as $index => $question) {
            if (isset($answers[$index])){
                if ($answers[$index] == $question['answer'])
                    $score++;
            }      
        }
        return $score;
    }

    public function getQuestions() {
        return $this->questions;
    }

    public function getTitle() {
        return $this->title;
    }
    public function getTestId(){
        return $this->testId;
    }
}

?>