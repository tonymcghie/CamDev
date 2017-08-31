<?php

class SampleSet_Test extends CakeTestCase {

    public $fixtures = ['app.sampleSet'];
    public $useDbConfig = 'test';

    /** @var SampleSet $SampleSet Sample Set model */
    private $SampleSet;

    public function setUp() {
        parent::setUp();
        $this->SampleSet = ClassRegistry::init('SampleSet');
    }

    /**
     * Check that the SampleSet model can find a record using id
     */
    public function test_findId() {
        $data = $this->SampleSet->find('all', ['conditions' => ['id' => 1]]);
        $this->assertNotNull($data);
        $this->assertEquals(1, $data[0]['SampleSet']['id']);
        $this->assertEquals(1, count($data));
    }

    /**
     * Check that the SampleSet model can find a record using set code
     */
    public function test_findSetCode() {
        $data = $this->SampleSet->find('all', ['conditions' => ['set_code' => 'ch1']]);
        $this->assertEquals(1, $data[0]['SampleSet']['id']);
        $this->assertEquals(1, count($data));
    }

    /**
     * Checks that with multiple versions finds only finds the most recent version
     */
    public function test_findCorrectVersion() {
        $data = $this->SampleSet->find('all', ['conditions' => ['set_code' => 'tn2']]);
        $this->assertEquals(2, $data[0]['SampleSet']['version']);
        $this->assertEquals('tn2', $data[0]['SampleSet']['set_code']);
        $this->assertEquals(4, $data[0]['SampleSet']['id']);
        $this->assertEquals(1, count($data));
    }

    /**
     * Checks that only the submitter or the chemist can see samplesets that are confidential
     */
    public function test_findConfidential() {
        $data = $this->SampleSet->find('all', ['conditions' => ['id' => 2]]);
        $this->assertEquals(0, count($data));
        $this->SampleSet->username = 'sub2';
        $data = $this->SampleSet->find('all', ['conditions' => ['id' => 2]]);
        $this->assertEquals(1, count($data));
        $this->assertEquals(2, $data[0]['SampleSet']['id']);
        $this->SampleSet->username = 'chem2';
        $data = $this->SampleSet->find('all', ['conditions' => ['id' => 2]]);
        $this->assertEquals(1, count($data));
        $this->assertEquals(2, $data[0]['SampleSet']['id']);
    }

    /**
     * Checks that when finding multiple results confidentiality and recent version works
     */
    public function test_findAggregation() {
        $data = $this->SampleSet->find('all', ['conditions' => ['set_code LIKE' => 'tn%']]);
        // One confidential and one old version have being filtered
        $this->assertEquals(1, count($data));
        $this->SampleSet->username = 'sub2';
        $data = $this->SampleSet->find('all', ['conditions' => ['set_code LIKE' => 'tn%']]);
        // The confidential one has nolonger being filtered
        $this->assertEquals(2, count($data));
    }
}