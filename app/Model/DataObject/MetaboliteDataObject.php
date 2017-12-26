<?php

App::uses('DataObject', 'Model/DataObject');

class MetaboliteDataObject extends DataObject {

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
            'viewURL' => ['controller' => 'Metabolites', 'action' => 'viewMetabolite', '?' => ['id' => $this->id]],
            'editURL' => ['controller' => 'Metabolites', 'action' => 'editMetabolite', '?' => ['id' => $this->id]],
            'loaddocURL' => ['controller' => 'Metabolites', 'action' => 'details', '?' => ['id' => $this->id]],
            'msmsURL' => ['controller' => 'Metabolites', 'action' => 'addMsms', '?' => ['id' => $this->id]],
            'proposed_idURL' => ['controller' => 'Metabolites', 'action' => 'addProposedid', '?' => ['id' => $this->id]]
        ];
    }
    // BACKEND

}