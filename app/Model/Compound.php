<?php

App::uses('CompoundDataObject', 'Model/DataObject');
App::uses('SearchableModel', 'Model/Behavior');

class Compound extends AppModel implements SearchableModel {
    
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
            'formula',
            'exact_mass',
            'cas',
            'compound_type',
            'comment'];
    }
    
    public function getIonAdductFields() {
        return ['compound_name',
            'formula',
            'cas',
            'exact_mass',
            '[M-H]-',
            '[M+COOH-H]-',
            '[M+H]+',
            '[M+Na]+'];
    }

    public function getSearchOptions() {
        return ['compound_name',
            'all',
            'cas',
            'compound_type',
            'exact_mass',
            '[M-H]-',
            '[M+COOH-H]-',
            '[M+H]+',
            '[M+Na]+',
            'pub_chem',
            'chemspider_id',
            'comment'];
    }
}