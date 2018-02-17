<?php

App::uses('DataObject', 'Model/DataObject');

class CompoundDataObject extends DataObject {

    /** @var string $actions HTML string of the actions to display in table */
    public $actions;

    protected $immutableFields = ['id'];

    public function __construct($model, $data) {
        parent::__construct($model, $data);
        if (isset($data['exact_mass'])) {
            $this->data['[M-H]-'] = $data['exact_mass'] - 1.007276;
            $this->data['[M+COOH-H]-'] = $data['exact_mass'] + 44.998201;
            $this->data['[M+H]+'] = $data['exact_mass'] + 1.007276;
            $this->data['[M+Na]+'] = $data['exact_mass'] + 22.989218;
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
            'pubchemLink' => ['https://pubchem.ncbi.nlm.nih.gov/compound/'.$this->pub_chem],
            'chemspiderLink' => ['http://www.chemspider.com/Chemical-Structure.'.$this->chemspider_id.'.html'],
            'viewURL' => ['https://pubchem.ncbi.nlm.nih.gov/rest/pug/compound/cid/'.$this->pub_chem. '/PNG'],
            'editURL' => ['controller' => 'Compounds', 'action' => 'editCompound', '?' => ['id' => $this->id]]
        ];
    }

    // BACKEND

}