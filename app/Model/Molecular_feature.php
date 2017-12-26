<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('MolecularFeatureDataObject', 'Model/DataObject');

class Molecular_feature extends AppModel{
    
     public function buildObjects(array $queryResults){
        $molecular_featureDataObjects = [];
        foreach ($queryResults as $data) {
            $molecular_featureDataObjects[] = new MolecularFeatureDataObject($this, $data['Molecular_feature']);
        }
        return $molecular_featureDataObjects;
    }
    
    public function getDisplayColumns() {
        return ['actions',
            'feature_tag',
            'feature_id',
            'mz',
            'ion_polarity',
            'intensity',
            'sample_reference',
            'experiment_reference',
            'crop',
            'genotype',
            'tissue'];
    }
    
}