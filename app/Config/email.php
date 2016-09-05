<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of email
 *
 * @author CFPAJM
 */
App::uses('CakeEmail', 'Network/Email');

class emailConfig  {
    
    public $email = array(
        'host' => 'smtp.pfr.co.nz',
        'port' => 25,
        'username' => '',
        'password' => '',
        'transport' => 'Smtp'
    );
}
