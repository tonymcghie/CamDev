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

    public $id;
    public $submitter;
    public $submitter_email;
    public $team;
    public $chemist;
    public $set_code;
    public $type;
    public $number;
    public $p_name;
    public $p_code;
    public $exp_reference;
    public $compounds;
    public $comments;
    public $date;
    public $sample_loc;
    public $set_reason;
    public $containment;
    public $containment_details;
    public $version;
    public $confidential;
    public $metaFile;

    /** @var string $actions HTML string of the actions to display in table */
    public $actions;

    protected $immutableFields = ['id'];

    public function __construct($model, $data) {
        parent::__construct($model);
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

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
            'editURL' => ['controller' => 'SampleSet', 'action' => 'details', 'id' => $this->id],
            'analysisURL' => ['controller' => 'SampleSet', 'action' => 'details', 'id' => $this->id]
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