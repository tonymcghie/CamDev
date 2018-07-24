<?php

App::uses('CompoundDataObject', 'Model/DataObject');
App::uses('SearchableModel', 'Model/Behavior');

class Compound extends AppModel implements SearchableModel {
    
    public $validate = array(
        'cas' => array(
            'rule' => 'notBlank',
            'rule' => 'isUnique',
            'message' => 'That CAS already exists in the database!',
            'last' => true
        ),
        'formula' => array(
            'rule' => 'notBlank'
        ),
        'exact_mass' => array(
            'rule' => 'notBlank'
        ),
        'sys_name' => array(
            'rule' => 'notBlank'
        ),
        'compound_type' => array(
            'rule' => 'notBlank'
        ),
        'compound_name' => array(
            'rule' => 'notBlank',
            'rule' => 'isUnique',
            'message' => 'That CAS already exists in the database!',
            'last' => true
        )
    );
    
    public function buildObjects(array $queryResults){
        $compoundObjects = [];
        foreach ($queryResults as $data) {
            $compoundObjects[] = new CompoundDataObject($this, $data['Compound']);
        }
        return $compoundObjects;
    }
    
    public function getDisplayColumns() {
        return ['actions',
            'compound_name',
            'pseudonyms',
            'cas',
            'compound_type',
            'formula',
            'exact_mass',
            'RMD',
            '[M-H]-',
            '[M+HCOOH-H]-',
            '[M+H]+',
            '[M+Na]+',
            'comment'];
    }

    public function getSearchOptions() {
        return ['compound_name',
            'pseudonyms',
            'all',
            'cas',
            'compound_type',
            'exact_mass',
            'formula',
            '[M-H]-',
            '[M+HCOOH-H]-',
            '[M+H]+',
            '[M+Na]+',
            'pub_chem',
            'chemspider_id',
            'comment'];
    }
    
    public function getSearchableFields() {
        return ['compound_name',
            'cas',
            'compound_type',
            'exact_mass',
            'pub_chem',
            'chemspider_id',
            'comment',
            'pseudonyms',
            'sys_name',
            'formula',
            'compound_type',
            'canonical_smiles',
            'isomeric_smiles'];
    }
    
    public function getSortableResultColumns() {
        return ['compound_name',
            'cas',
            'exact_mass',
            'formula'];
    }
    
}