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

    public function __construct($model) {
        $this->model = $model;
    }

    function __set($name, $value) {
        if (in_array($name, $this->immutableFields)) {
            return;
        }
        $this->$name = $value;
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