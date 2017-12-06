<?php

App::uses('DataObject', 'Model/DataObject');

class SampleSetDataObject extends DataObject {

    /** @var string $actions HTML string of the actions to display in table */
    public $actions;

    protected $immutableFields = ['id'];

    // FRONT END DATA HELPERS

    /**
     * {@inheritdoc}
     *
     * This function returns an array of arrays that contain data to make urls
     * They will be turned into buttons in the view.
     * @return array
     */
    public function getActionData() {
        return [
            'viewURL' => ['controller' => 'SampleSets', 'action' => 'details', '?' => ['id' => $this->id]],
            'editURL' => ['controller' => 'SampleSets', 'action' => 'editSet', '?' => ['id' => $this->id]],
            'analysisURL' => ['controller' => 'Analyses', 'action' => 'editAnalysis','?' => ['set_code' =>  $this->set_code]]
        ];
    }

    // BACKEND

}