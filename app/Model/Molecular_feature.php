<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('MolecularFeatureDataObject', 'Model/DataObject');
App::uses('SearchableModel', 'Model/Behavior');
App::uses('OverviewableModel', 'Model/Behavior');

class Molecular_feature extends AppModel implements SearchableModel, OverviewableModel{
    
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
            'genus_species',
            'genotype',
            'tissue'];
    }
    
    public function getSearchOptions() {
        return [
            'feature_tag',
            'feature_id',
            'mz',
            'ion_polarity',
            'intensity',
            'sample_reference',
            'experiment_reference',
            'crop',
            'genus_species',
            'tissue',
            'genotype',
            'analyst'];
    }
    
    public function getOverviewOptions() {
        return [
            'crop',
            'genotype',
            'tissue',
            'genus_species',
            'experiment_reference',
            'sample_reference',
            'analyst',
            'feature_tag',
            'ms_instrument_loc',
            'ion_polarity'];
    }
    
    public function getOverviewDisplayColumns() {
        return [
            'crop',
            'genotype',
            'tissue',
            'genus_species',
            'experiment_reference',
            'sample_reference',
            'analyst',
            'feature_tag',
            'ms_instrument_loc',
            'ion_polarity'];
    }
}