<?php

App::uses('DataObject', 'Model/DataObject');

class BioactivityPfrDataObject extends DataObject {

    /** @var string $actions HTML string of the actions to display in table */
    public $actions;

    /**
     * Gets the data needed for rendering the actions in the search results table
     * @return array
     */
    public function getActionData() {
        return [];
    }
}