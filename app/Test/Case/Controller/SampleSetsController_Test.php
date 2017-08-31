<?php

App::uses('SampleSetsController', 'Controller');

class SampleSetsController_Test extends ControllerTestCase {
    private $SampleSetController;

    public function setUp() {
        parent::setUp();
        $this->SampleSetController = new SampleSetsController();
    }

    public function testadd(){
        $a = 2;
        $this->assertEquals(2, $a);
        $b = 3;
        $this->assertEquals(3, $b);
        $this->assertEquals(2+3, $a+$b);
    }
}