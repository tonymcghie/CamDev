<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'DataObject/Compound.php';

class Compound extends AppModel{
    
    public function buildObjects($queryResults){
        $compoundObjects = [];
        foreach ($queryResults as $data) {
            $compoundObjects[] = new Model\DataObject\Compound($this, $data['Compound']);
        }
        return $compoundObjects;
    }
    
    public function getDisplayFields() {
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
    
}