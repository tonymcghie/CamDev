<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sample extends AppModel{
    public $validate = array(
        'title' => array(
            'rule' => 'notBlank'
        ),
        'set_code' => array(
            'rule' => 'notBlank'
        )
    );
}

