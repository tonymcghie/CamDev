<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ProjectsController extends AppController{
    public $helpers = array('Html' , 'Form' , 'My', 'Js');
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
     * Returns weather the user is authorised to access the page
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
        if (isset($this->request->data['Project'])){ //check if the save button has being clicked            
            $data = $this->request->data;      //gets the data
            $this->Project->create();            //Need to add
            if ($this->Project->save($data)){                 //saves the Compound
                return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'New Project Saved']]);
            }
        } 
    }
    
    /**
     * Ajax function that returns list items that have the Project details in
     */
    public function projectAutoComplete(){
        $this->autoRender=false; //stops the page from rendering as this is ajax so it outputs data
        $this->layout = 'ajax';  //ajax layout is blank
        $query = $this->request->data['name']; //gets the part name of the name that has being entered
		$results = $this->Project->find('all' , ['conditions' => ['short_name LIKE' => '%'.$query.'%']]);//gets all project short_names that start with that part of the name
        $elements = '';
        foreach($results as $row){
            $elements .= "<li class='ui-menu-item' role='menuitem'><a class='ui-corner-all' tabindex='-1'";
            $elements .= 'onclick="changeProject(\''.$row['Project']['short_name'].'\')"';
            $elements .= ">".$row['Project']['short_name']." - ".$row['Project']['code']." - ".$row['Project']['type']."</a></li>";
        } //makes the list of possible project names
        echo $elements;
    }
    
        /**
     *	Ajax funtion that gets the data of the projects
     */
    public function getData(){
		$this->autoRender=false;
		$this->layout = 'ajax';
		$shortname = $this->request->data['name'];
		$res = $this->Project->find('first', ['conditions' => ['short_name LIKE' => $shortname ]]);
		echo json_encode($res);
    }

    
    /**
     * exports a search to a CSV file
     * @param array $data
     */
    public function export($data = null){
        $this->My->exportCSV('Metabolite', $this->Metabolite, $this, ['exact_mass', 'ion_type', 'rt_value', 'rt_description','sources','tissue','chemist','experiment_ref','spectra_uv','spectra_nmr','date'], $data, true);  
    }
}