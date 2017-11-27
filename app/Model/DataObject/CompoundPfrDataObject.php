<?php

App::uses('DataObject', 'Model/DataObject');

class CompoundPfrDataObject extends DataObject {

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
            'DataViewURL' => ['controller' => 'CompoundpfrData', 'action' => 'viewData', '?' => ['id' => $this->id]],
            'SetViewURL' => ['controller' => 'CompoundpfrData', 'action' => 'viewSet', '?' => ['reference' => $this->reference]]
        ];
    }
    // BACKEND

}