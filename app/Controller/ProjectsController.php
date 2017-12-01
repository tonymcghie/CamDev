<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProjectsController extends AppController{
    public $helpers = array('Html' , 'Form' , 'My', 'Js', 'Time', 'String', 'BootstrapForm');
    public $uses = array('Project');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'RequestHandler', 'My');
    
    public $paginate = array(
        'limit' => 2,
        'order' => array(
            'Metabolite.exact_mass' => 'asc'
        ));
    
    /**
     * Happens before stuff is called
     * by default deny accesss to all functions
     */
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->deny('addMetabolite','editMetabolite','editProposedMetabolite','editMsmsMetabolite');
        $this->Auth->allow('addProject','addMetabolite');
    }
    
    /**
     * Returns weather the user is authorized to access the page
     * @param type $user
     * @return type
     */
    //public function isAuthorized($user) {
        //return $this->My->isAuthorizedMetabolite($user, $this); //removed to stop login popup appearing
    //}

    /**
     * adds a project
     * @return null
     */
    public function addProject(){
        $this->layout = 'PageLayout';
        if (isset($this->request->data['Project'])){ //check if the save button has being clicked            
            $data = $this->request->data;      //gets the data
            $this->Project->create();            //Need to add
            if ($this->Project->save($data)){                 //saves the Compound
                return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'New Project Saved']]);
            }
        } 
    }
}