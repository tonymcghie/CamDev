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
    public $uses = array('Test');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'RequestHandler', 'My', 'Session', 'Cookie', 'Auth');
    
    public function index($id) {
        
    }
    
    public function plates(){
        
    }
    
    public function text_input(){
        if ($this->request->is('post')){           
            $data = $this->request->data;  //gets the data from the post
            var_dump($data);
        }
        $this->Test->create();            //Need to add
            if ($this->Test->save($data)){ //saves the Compound
                $this->set('text_input', $data['Test']['text_input']);                
                //return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'New Text Saved']]);
            }
    }
    
    

}
