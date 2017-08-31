<?php

App::uses('Chemist', 'Model');

class Chemist_Test extends CakeTestCase{
    public $fixtures = ['app.chemist'];
    public $useDbConfig = 'test';

    /** @var Chemist $Chemist Model object */
    private $Chemist;

    public function setUp(){
        parent::setUp();
        $this->Chemist = ClassRegistry::init('Chemist');
    }

    /**
     * Tests only the base case of the nextSampleSetInfo method
     */
    public function test_nextSampleSetInfo() {
        $data = $this->Chemist->nextSampleSetInfo('test_name');
        $this->assertEquals('1', $data->id);
        $this->assertEquals('test_name', $data->name);
        $this->assertEquals('test_team', $data->team);
        $this->assertEquals('test@test.test', $data->email);
        $this->assertEquals('tn1', $data->nextSetCode);
    }
}