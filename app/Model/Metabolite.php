<?php

App::uses('MetaboliteDataObject', 'Model/DataObject');
App::uses('SearchableModel', 'Model/Behavior');

class Metabolite extends AppModel implements SearchableModel {
    public $validate = array(
    'exact_mass' => array(
        'rule' => 'notBlank'
    ),
    'ion_type' => array(
        'rule' => 'notBlank'
    ),
    'rt_value' => array(
        'rule' => 'notBlank'
    ),
    'rt_description' => array(
        'rule' => 'notBlank'
    ),
    'sources' => array(
        'rule' => 'notBlank'
    ),
    'tissue' => array(
        'rule' => 'notBlank'
    ),
    'chemist' => array(
        'rule' => 'notBlank'
    ),
    'experiment_ref' => array(
        'rule' => 'notBlank'
    ),
    'start_date' => array(
        'rule' => 'notBlank'
    ));

    public function buildObjects(array $queryResults){
        $metaboliteObjects = [];
        foreach ($queryResults as $data) {
            $metaboliteObjects[] = new Model\DataObject\MetaboliteDataObject($this, $data['Metabolite']);
        }
        return $metaboliteObjects;
    }
    
    public function getDisplayColumns() {
        return ['actions',
            'id',
            'exact_mass',
            'ion_type',
            'rt_value',
            'rt_description',
            'sources',
            'tissue',
            'chemist',
            'experiment_ref'];
    }

    public function getSearchOptions() {
        return ['sources',
        'all',
        'exact_mass',
        'experiment_ref',
        'sources',
        'tissue',
        'chemist'];
    }
}