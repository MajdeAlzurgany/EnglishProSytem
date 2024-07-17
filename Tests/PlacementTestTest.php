<?php
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

require_once "../EnglishProSytem/EnglishPro/classes/PlacementTest.php";
require_once "../EnglishProSytem/EnglishPro/classes/Database.php";
require_once "../EnglishProSytem/EnglishPro/classes/Test.php";

class PlacementTestTest extends TestCase{
    //to get placement test that is exist in the db
    public function testGetExistPlacementTest(){
        $placementTestId = 3 ; 
        $placementTest = PlacementTest :: getPlacementTest($placementTestId);
        assertEquals($placementTestId , $placementTest->getTestId());
    }
    //test getting placement test that is NOT exist in the db 
    public function testNonGetExistPlacementTest(){
        $placementTestId = 9999 ; 
        $this->expectException(Exception :: class);
        $this->expectExceptionMessage("Placement test not found.");
        PlacementTest :: getPlacementTest($placementTestId);
    }
    //test determine level according to the score passed 
    public function testdetermineLevel(){
        assertEquals(PlacementTest::determineLevel(0) , 1 );
        assertEquals(PlacementTest::determineLevel(3) , 2 );
        assertEquals(PlacementTest::determineLevel(7) , 3 );
        assertEquals(PlacementTest::determineLevel(10) , 3 );
        
    }

}




?>