<?php

/**
 * This is a object that represent a row in the database table
 * @author Andrew McGhie
 */
abstract class DataObject {

    /** @var \AppModel $model related model */
    protected $model;
    /** @var array $immutableFields fields that cannot be changed*/
    protected $immutableFields;
    /** @var array $data */
    protected $data;

    public function __construct($model, $data) {
        $this->model = $model;
        $this->data = $data;

        // Set the default to empty string.
        foreach ($this->data as $key => $value) {
            if ($value == null) {
                $this->data[$key] = '';
            }
        }
    }

    function __set($name, $value) {
        if (in_array($name, $this->immutableFields)) {
            assert(false,
                "You should not be changing the immutable field '$name'");
            return;
        }
        $this->data[$name] = $value;
    }

    function __get($name) {
        if (!isset($this->data[$name])) {
            trigger_error('The Value for -'.$name.'- was not got from the database');
            return '';
        }
        return $this->data[$name];
    }



    // FUNCTIONS FOR GETTING FRONT END DATA

    /**
     * Gets the data needed for rendering the actions in the search results table
     * @return array
     */
    public abstract function getActionData();

    /**
     * TODO shift to searchable something as the model has to implement searcable model for
     * this to work
     * @return array
     */
    public function getTableRowData() {
        $rowData = [];
        foreach ($this->model->getDisplayColumns() as $field) {
            $rowData[$field] = $this->$field;
        }
        return $rowData;
    }

    // BACK END HELPERS



}