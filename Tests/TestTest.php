<?php
use PHPUnit\Framework\TestCase ;

use function PHPUnit\Framework\assertEquals;

require_once "../EnglishProSytem/EnglishPro/classes/Student.php";
require_once "../EnglishProSytem/EnglishPro/classes/Database.php";
require_once "../EnglishProSytem/EnglishPro/classes/User.php";

class TestTest extends TestCase {

    public function testLoadQuestions() { 
       
        $test = new Test(1, 'Sample Test'); // Create a Test object

        // Test for placementtestid field
        $field = "placementTestId";
        $test->loadQuestions($field);
        $questions = $test->getQuestions();
        $this->assertEquals(1, $questions[0]['placementTestId']);

        // Test for quizid field
        $test = new Test(1, 'Sample Test'); // Reset the Test object to clear previous questions
        $field = "quizId";
        $test->loadQuestions($field);
        $questions = $test->getQuestions();
        $this->assertEquals(1, $questions[0]['quizId']);
    }

    public function testEvaluateAnwers(){
        //first we should create test obj
        $test = new Test(1, 'Sample Test');
        $field = "placementTestId";
        $test->loadQuestions($field);
        $questions = $test->getQuestions();

        $answers[] = null;
        //try to submit no answers 
        $score = $test->evaluateTest($answers);

        assertEquals($score , 0);
    }



}






?>