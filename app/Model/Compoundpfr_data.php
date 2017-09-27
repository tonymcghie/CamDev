<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'DataObject/Compoundpfr_data.php';

class Compoundpfr_data extends AppModel{
    
    public function buildObjects($queryResults){
        $compoundpfrDataObjects = [];
        foreach ($queryResults as $data) {
            $compoundpfrDataObjects[] = new Model\DataObject\Compoundpfr_data($this, $data['Compoundpfr_data']);
        }
        return $compoundpfrDataObjects;
    }
    
    public function getDisplayFields() {
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
    
}