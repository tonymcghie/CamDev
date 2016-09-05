<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sample extends AppModel{
	var $useTable = 'samples'; // This model uses a database table 'samples'
    public $validate = array(
        'sample_name' => array(
            'rule' => 'notBlank'
        ),
        'set_code' => array(
            'rule' => 'notBlank'
        )
    );
}

