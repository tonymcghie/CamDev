<?php

namespace Model\DataObject;

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 31/08/17
 * Time: 11:30 AM
 */
abstract class DataObject {

    protected $model;
    protected $immutableFields;
    protected $data;

    public function __construct($model, $data) {
        $this->model = $model;
        $this->data = $data;
    }

    function __set($name, $value) {
        if (in_array($name, $this->immutableFields)) {
            return;
        }
        $this->data[$name] = $value;
    }

    function __get($name) {
        if (!isset($this->data[$name])) {
            trigger_error('The Value for '.$name.' was not got from the database');
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
    public abstract function getTableRowData();

    // BACK END HELPERS



}