<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Metabolite_proposed
 *
 * @author CFPAJM
 */
class Proposed_Metabolite extends AppModel{
     public $validate = array(
    'name' => array(
        'rule' => 'notBlank'
    ),
    'formula' => array(
        'rule' => 'notBlank'
    ));
}
