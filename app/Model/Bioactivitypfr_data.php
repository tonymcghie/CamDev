<?php

App::uses('BioactivityPfrDataObject', 'Model/DataObject');
App::uses('SearchableModel', 'Model/Behavior');

class Bioactivitypfr_data extends AppModel implements SearchableModel {

    public function getSearchOptions() {
        return ['bioactivity_name',
            'all',
            'value',
            'unit_description' ,
            'bioassay_description' ,
            'bioassay_ref',
            'sample_ref',
            'sample_description',
            'crop',
            'species',
            'tissue',
            'genotype',
            'analyst',
            'file'];
    }

    public function getDisplayColumns() {
        return ['bioactivity_name',
            'sample_ref',
            'reference',
            'value',
            'unit_description' ,
            'bioassay_description' ,
            'crop',
            'genotype',
            'tissue'];
    }

    public function buildObjects(array $queryResults) {
        $bioactivityObjects = [];
        foreach ($queryResults as $data) {
            $bioactivityObjects[] = new BioactivityPfrDataObject($this, $data['Bioactivitypfr_data']);
        }
        return $bioactivityObjects;
    }
}