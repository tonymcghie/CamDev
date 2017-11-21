<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CompoundsController extends AppController{
    public $helpers = array('Html' , 'Form' , 'My', 'Js', 'Time', 'String', 'BootstrapForm');
    public $uses = array('Compound');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'RequestHandler', 'My', 'Session', 'Cookie', 'Auth', 'File', 'Search');
    
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
        $this->set('group', 'compounds');
        //$this->Auth->deny('addCompound', 'editCompound'); //deny access from addCompound and editCompound by default
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
        $this->layout = 'PageLayout';
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
        $this->layout = 'main';
        $data = $this->request->data;        
        if ($id == null){
            $id = $this->params['url']['id'];
        } // gets $id from the url
        var_dum($id);
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
     * Entry point for Compounds -> Find
     * Control transfers to the search_compound view and onto to /Elements/search_form
     * and then back to the search() function below.
     * Search results are displayed as a modal as defined by /Elements/compound_results table 
     */
    public function search(){
        $this->set('model', 'Compound');
        $this->helpers[] = 'Mustache.Mustache';
        $this->Paginator->settings= [
            'limit'=>10,
            'order' => [
                'SampleSet.date' => 'asc'
            ]
        ];

        if (!empty($this->request->query)) {
            $query = $this->Search->build_query($this->Compound, $this->request->query);
            $results = $this->paginate('Compound', $query);

            $resultObjects = $this->Compound->buildObjects($results);

            $this->set('cols', $this->Compound->getDisplayFields());
            $this->set('ion_cols', $this->Compound->getIonAdductFields());
            $this->set('results', $resultObjects);
            $ion_adducts = $this->getIonAdducts($results);  //make a new array with ion adduct m/z values

            $this->set('ion_adducts', $ion_adducts);  //pass results to view so the ion adducts values can be displayed
            $this->set('num', $this->Compound->find('count', ['conditions' => $query])); //passes the number of results to the view
            $this->set('data', $this->request->query);
        }
    }
    
    /**
     * This function contains the code for identifying unknown compounds by accurate mass.
     * 1) a csv file containing accurate masses is read;
     * 2) each mass is conpared with entries in the compound table;
     * 3) successful hits are written into an output file that is sent to Downloads
     */
    public function IdByMass(){
    } 
        
    /**
     * This function displays a message describing the process for identifying unknown compounds by accurate mass
     */
    public function idMass(){
    } 
    
    /**
     * Exports the search results to a CSV file
     * @param type $data
     */
    public function export($datastr = null){

        parse_str($datastr, $data);  //extract search parameters from the url
        $criteria = null;$value = null;$logic = null;$match = null;
        extract($data['Compound']);
        $query = $this->Search->build_query($this->Compound, $criteria, $value, $logic, $match); //build the search query
        $search_results = $this->Compound->find('all', ['conditions' => $query]);  //find the data
        $this->set('data', $search_results); //send data to export view
        $this->response->download("export_compounds.csv"); //download the named csv file
        $this->layout = 'ajax';
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
    /**
     * A function to get input and compute the amounts of compound required to make a solution of a given concentration
     */
    public function reagentsCompound($id = null) {
        $compound = $this->Compound->findById($id); //find a compound by id
        $this->set('info', $compound);// passes the compound info to the view
    } 
    /**
     * A function to an results array into an ion_results array containing
     * exact masses for adduct ions
     */
    public function getIonAdducts($data) {
        $ion_adducts = [];
        foreach ($data as $row){//cycle through all the compounds and do the calculations and add the required data
            $new_data = array('compound_name' => $row['Compound']['compound_name'],
                'formula' => $row['Compound']['formula'],
                'cas' => $row['Compound']['cas'],
                'exact_mass' => $row['Compound']['exact_mass'],
                '[M-H]-' => $row['Compound']['exact_mass'] - 1.00794,
                '[M+COOH-H]-' => $row['Compound']['exact_mass'] + 44.9977,
                '[M+H]+' => $row['Compound']['exact_mass'] + 1.0078,
                '[M+Na]+' => $row['Compound']['exact_mass'] + 22.9898);
            array_push($ion_adducts, $new_data);

        }
        return $ion_adducts;
    }
}

