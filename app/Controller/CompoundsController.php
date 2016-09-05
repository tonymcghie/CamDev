<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CompoundsController extends AppController{
    public $helpers = array('Html' , 'Form' , 'My', 'Js');
    public $uses = array('Compound');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'My');
    
   /** Sets the options for pagination */
    public $paginate = array(
        'limit' => 25,
        'order' => array(
            'Compound.compound_name' => 'asc'
        )
    );
    
    /**
     * What to do before funcitons are called
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->deny('addCompound', 'editCompound'); //deny access from addCompound and editCompound by default
    }
    
    /**
     * Return weather the user is authorised to access the function
     * @param type $user
     * @return type
     */
    public function isAuthorized($user) {
        return $this->My->isAuthorizedCompound($user, $this);
    }
    
    /**
     * This funciton adds a Compound to the table
     * @return type
     */
    public function addCompound(){
        if ($this->request->is('post')){ //check if the save button has being clicked            
            $data = $this->request->data; //gets the data
            if ($data['Compound']['cas'] != '' && $this->Compound->find('count', ['conditions' => ['cas' => $data['Compound']['cas']]]) > 0){
                $this->set('alert', 'The compound you entered is already in the database');
                return;
            } //if the cas number already exists then exit
            $this->Compound->create(); //adds the compound
            if ($this->Compound->save($data)){                 //saves the Compound
                return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'Compound Saved']]);
            } //if successful then reditrect to blank           
        }  //makes sure that the form was submitted
    }
    
    /**
     * Edit a compound
     * @param type $id
     * @return type
     * @throws NotFoundExcpetion
     */
    public function editCompound($id = null){        
        $set = $this->Compound->findById($id);
        if (!$set){
            throw new NotFoundExcpetion(__('Invalid Compound'));
        } //throw error if the id does not belong to a compound     
        if ($this->request->is(array('post', 'put'))){
            $this->Compound->id = $id;
            if ($this->Compound->save($this->request->data)){
                return;
            } //return if saved successfully
        } //save data if the form is being submitted
        if (!$this->request->data){
            $this->request->data = $set;
        }//update the data to display
    }
    
    /**
     * Searches for compounds in the table will search for synonims when searching on name
     * @param type $data
     * @return type
     */
    public function searchCompound($data = null){
        if ($data!=null&&!isset($this->request->data['Compound'])){
            parse_str($data);
            $this->request->data['Compound'] = $Compound;
        } //sets the data
        if (!isset($this->request->data['Compound'])){
            return;
        } //if compound is not set then exit
        $this->paginate = array(
        'limit' => 20,
        'order' => array('Compound.compound_name' => 'asc')); //sets the pagination values
        $this->request->data['Compound']['num_boxes'] = (isset($this->request->data['Compound']['num_boxes']) ? $this->request->data['Compound']['num_boxes'] : 1); //sets boxnum to 1 if its not already set
        $this->set('box_nums',$this->request->data['Compound']['num_boxes']);  //passes the box num to the view 
        $data = $this->request->data;
        for($i = 0;isset($data['Compound']['cri_'.$i]);$i++){
            $precision = count(explode('.', $data['Compound']['val_'.$i]))==2 ? strlen(explode('.', $data['Compound']['val_'.$i])[1]) : 0;            
            if ($data['Compound']['cri_'.$i] == '[M-H]-'){
                $data['Compound']['val_'.$i] = round(floatval($data['Compound']['val_'.$i]) + 1.0078, $precision);
                $data['Compound']['cri_'.$i] = 'exact_mass';
            } //adjusts mass
            if ($data['Compound']['cri_'.$i] == '[M+COOH-H]-'){
                $data['Compound']['val_'.$i] = round(floatval($data['Compound']['val_'.$i]) - 44.9977, $precision);
                $data['Compound']['cri_'.$i] = 'exact_mass';
            }//adjusts mass
            if ($data['Compound']['cri_'.$i] == '[M+H]+'){
                $data['Compound']['val_'.$i] = round(floatval($data['Compound']['val_'.$i]) - 1.0078, $precision);
                $data['Compound']['cri_'.$i] = 'exact_mass';
            }//adjusts mass
            if ($data['Compound']['cri_'.$i] == '[M+Na]+'){
                $data['Compound']['val_'.$i] = round(floatval($data['Compound']['val_'.$i]) - 22.9898, $precision);
                $data['Compound']['cri_'.$i] = 'exact_mass';
            }//adjusts mass
        } //adjust the mass and the names 
        $search = $this->My->extractSearchTerm($data, ['cas', 'compound_name', 'exact_mass', 'comment'], 'Compound'); //makes search term
        $this->set('results', $this->paginate('Compound', $search)); //gets the results
        $this->set('num', $this->Compound->find('count', ['conditions' =>$search])); //passes the number of results to the view
        $this->set('data', $this->request->data);
    }
    
    /**
     * Exports the search results to a CSV file
     * @param type $data
     */
    public function export($data = null){
        $this->My->exportCSV('Compound', $this->Compound, $this, [], $data); //removed ',true' to make export work
    }
    
    /**
     * Adds a search set to the data array
     * This will make it the same as if it was passed from the form
     * @param Array $data The data array to be changed
     * @param String $cri The criteria to be added
     * @param String $val The value to be added
     * @param String $log The logic of the criteria and value
     * @return Array The new Data Array
     */
    public function addSearchCondition($data, $cri, $val, $log){
        $i = 0;
        while (isset($data['Compound']['cri_'.$i])){
            $i++;
        } //loop untill there is no more pairs to find where to add the next one
        $data['Compound'][('cri_'.$i)] = $cri;
        $data['Compound']['val_'.$i] = $val;
        $data['Compound']['log_'.$i] = $log;
        return $data;
    }       
    
    /**
     * This is the function for the substructre search
     */
    public function subSearch(){
        //empty as everything is done through ajax
    }
    
    /**
     * An Ajax function that checks to see of the result is in the database
     */
    public function filterSubStructRes(){
        $this->autoRender=false; //stops the page from rendering as this is ajax so it outputs data
        $this->layout = 'ajax';     //ajax layout is blank
        $CID = $this->request->data['CID']; 
        $comp = $this->Compound->find('first', ['conditions' => ['pub_chem' => $CID], 'fields' => ['Compound.pub_chem', 'Compound.compound_name', 'Compound.exact_mass']]);
        echo json_encode($comp);
    }
    
    /**
     * An Ajax function that checks to see that the CAS number is not already in use
     */
    public function checkCAS(){
        $this->autoRender=false; //stops the page from rendering as this is ajax so it outputs data
        $this->layout = 'ajax';     //ajax layout is blank
        $CAS = $this->request->data['CAS'];
        $num = $this->Compound->find('count', ['conditions' => ['cas' => $CAS]]);        
        if ($num == 0){
            echo 'true';    
        } else {
            echo 'false';
        }//returns true if unique and false if not
    }
}

