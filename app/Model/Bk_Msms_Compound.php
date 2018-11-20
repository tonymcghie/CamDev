<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Metabolites_msms
 *
 * @author CFPAJM
 */
class Msms_Compound extends AppModel{
     public $validate = array(
    'id' => array(
        'rule' => 'notBlank'),
    'compound_id' => array(
            'rule' => 'notBlank'),
    'msms_ions' => array(
            'rule' => 'notBlank'),
    'parent_mz' => array(
            'rule' => 'notBlank')
    );
}
