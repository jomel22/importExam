<?php
namespace Tests\Action;
use PHPUnit\Framework\TestCase;
use App\Action\FHelper as FHelper;
use App\Action\DBOperations as ImportDB;

class FunctionTest extends TestCase {


  public function testCleanData(){

    $data = '$2.00';

    $fhelper = new FHelper();

    $this->assertEquals(2.00, $fhelper->removeCurrency($data));


  } 

}

?>
