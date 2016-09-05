<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Metabolite extends AppModel{
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
}