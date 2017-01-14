<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP InDevController
 * @author root
 */
class InDevController extends AppController {
    public $helpers = array('Html' , 'Form' , 'My' , 'Js', 'Time');
    public $uses = array();
    public $layout = 'content';

    public function index($id) {
        
    }
    
    public function plates(){
        
    }

}
