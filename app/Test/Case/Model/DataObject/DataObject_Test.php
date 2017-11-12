<?php

require_once APP.'Model/DataObject/SampleSet.php';

/**
 * This tests the DataObject class using the SampleSet subclass
 * as the DataObject class is abstract so cannot be initiated in php 5.6
 * @php5.6
 */
class DataObject_Test extends CakeTestCase {

    public function test_getData() {
        $sampleSetDataObject = new Model\DataObject\SampleSet('model', ['id' => 1, 't1' => 'a', 't2' => 'c']);

        $this->assertEquals(1, $sampleSetDataObject->id);
        $this->assertEquals('a', $sampleSetDataObject->t1);
        $this->assertEquals('c', $sampleSetDataObject->t2);
    }

    public function test_throwExceptionOn_dataNotExisting() {
        $sampleSetDataObject = new Model\DataObject\SampleSet('model', ['id' => 1, 'chemist' => 'chem1']);

        try {
            $sampleSetDataObject->doesntExist;
            throw new Exception('Should not reach here');
        } catch (Exception $e) {
            $this->assertEquals('The Value for doesntExist was not got from the database', $e->getMessage());
        }
    }

    public function test_immutableFields_cannotBeChanged() {
        $sampleSetDataObject = new Model\DataObject\SampleSet('model', ['id' => 1]);

        $this->assertEquals(1, $sampleSetDataObject->id);
        $sampleSetDataObject->id = 2;
        $this->assertEquals(1, $sampleSetDataObject->id);
    }

    public function test_notImmutableFields_canBeChanged() {
        $sampleSetDataObject = new Model\DataObject\SampleSet('model', ['id' => 1, 'chemist' => 'chem1']);

        $this->assertEquals('chem1', $sampleSetDataObject->chemist);
        $sampleSetDataObject->chemist = 'chem2';
        $this->assertEquals('chem2', $sampleSetDataObject->chemist);
    }
}