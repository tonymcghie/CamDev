<?php

App::uses('DataObject', 'Model/DataObject');

class CompoundDataObject extends DataObject {

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
            'pubchemLink' => ['https://pubchem.ncbi.nlm.nih.gov/compound/'.$this->pub_chem],
            'chemspiderLink' => ['http://www.chemspider.com/Chemical-Structure.'.$this->chemspider_id.'.html'],
            'viewURL' => ['controller' => 'Compounds', 'action' => 'addCompound', '?' => ['id' => $this->id]],
            'editURL' => ['controller' => 'Compounds', 'action' => 'editCompound', '?' => ['id' => $this->id]]
        ];
    }

    // BACKEND

}