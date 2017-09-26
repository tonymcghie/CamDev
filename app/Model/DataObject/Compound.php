<?php

namespace Model\DataObject;

require_once 'DataObject.php';

/**
 * Created by PhpStorm.
 * User: tony
 * Date: 26/9/17
 * Time: 10:30 PM
 */
class Compound extends DataObject {

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
            'viewURL' => ['controller' => 'Compound', 'action' => 'viewSet', 100],
            'editURL' => ['controller' => 'Compound', 'action' => 'details', 'id' => $this->id]
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