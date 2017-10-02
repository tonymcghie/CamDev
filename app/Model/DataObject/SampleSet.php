<?php

namespace Model\DataObject;

require_once 'DataObject.php';

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 31/08/17
 * Time: 11:23 AM
 */
class SampleSet extends DataObject {

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
        //var_export();
        return [
            'viewURL' => ['controller' => 'SampleSets', 'action' => 'details', '?' => ['id' => $this->id]],
            'editURL' => ['controller' => 'SampleSets', 'action' => 'editSet', '?' => ['id' => $this->id]],
            'analysisURL' => ['controller' => 'Analyses', 'action' => 'editAnalysis','?' => ['set_code' =>  $this->set_code]]
        ];
    }

    public function getTableRowData() {
        $rowData = [];
        foreach ($this->model->getDisplayFields() as $field) {
            $rowData[$field] = $this->$field;
        }
        return $rowData;
    }

    // BACKEND

}