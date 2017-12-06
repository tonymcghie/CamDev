<?php

App::uses('CompoundPfrDataObject', 'Model/DataObject');
App::uses('SearchableModel', 'Model/Behavior');

class Compoundpfr_data extends AppModel implements SearchableModel {
    
    public function buildObjects(array $queryResults){
        $compoundpfrDataObjects = [];
        foreach ($queryResults as $data) {
            $compoundpfrDataObjects[] = new CompoundPfrDataObject($this, $data['Compoundpfr_data']);
        }
        return $compoundpfrDataObjects;
    }
    
    public function getDisplayColumns() {
        return ['actions',
            'assigned_name',
            'sample_ref',
            'reference',
            'exact_mass',
            'intensity_value',
            'intensity_description',
            'crop',
            'genotype',
            'tissue',
            'analyst'];
    }

    public function getSearchOptions() {
        return [
            'assigned_name',
            'all',
            'assigned_confid',
            'exact_mass',
            'exact_mass_10mDa',
            'exact_mass_50mDa',
            'intensity_description',
            'reference',
            'sample_ref',
            'sample_description',
            'crop',
            'species',
            'tissue',
            'genotype',
            'analyst',
            'file'];
    }
}