<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NamechangerController extends AppController{
    public $helpers = array('Html' , 'Form' , 'My', 'Js');
    public $uses = array('Compound');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'My', 'Session');
        
    /**
     * What to do before functions are called
     */
    public function beforeFilter() {
        parent::beforeFilter();

        //deny access from addCompound and editCompound by default
        $this->Auth->deny('addCompound', 'editCompound');
        $this->set('group', 'compounds');
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
     * This function contains the code for matching compound names with compounds names in the database.
     * 1) a csv file containing compound names is read;
     * 2) each names is compared with the name entries in the compound table;
     * 3) successful hits are written into an output file that is sent to Downloads
     */
    public function SelectFile(){
        $filename = '';
        if ($this->request->is('post')) { // checks for the post values
            $uploadData = $this->data['Upload']['csv_path'];

            if ( $uploadData['size'] == 0 || $uploadData['error'] !== 0) { // checks for the errors and size of the uploaded file
                return false;
                }
            $filename = basename($uploadData['name']); // gets the base name of the uploaded file
            $uploadFolder = WWW_ROOT. 'data/files/namechanger';  // path where the uploaded file has to be saved
            $uploadPath =  $uploadFolder . DS . $filename;
            if( !file_exists($uploadFolder) ){
                mkdir($uploadFolder); // creates folder if  not found
            }
            if (!move_uploaded_file($uploadData['tmp_name'], $uploadPath)) {
                return false;
            }
            $identify_parms = array();
            array_push($identify_parms, $filename); //put all the parameters for identifcation into an array
            $massdata = array();
            $head=$this->My->NamechangeHeadings($uploadPath); //get the headings from the datafile
            $data=$this->My->Namechange($uploadPath); //get compound from the data file; search compounds and return a compound name
            $this->set('identify_parms', $identify_parms); //passes the identify parameters to the view 
            $this->set('head', $head); // pass table headings to the view 
            $this->set('data', $data); // pass array with the mass data from file to the view 
            $this->render('search_names'); //direct to the search_masses view and not the default select_file view
        }  
    }
        
    /**
     * Exports the search results to a CSV file
     * @param type $data
     */
    public function export($filename){
        //if ($identify_parms==null){
            //return;
        //}
        $filename= urldecode($filename) . '.csv';
        //var_dump($filename);
        $filename=WWW_ROOT. 'data/files/namechanger'. DS . $filename; //set the correct path to the datafile
        $head=$this->My->NamechangeHeadings($filename); //get the headings from the datafile
        $data=$this->My->Namechange($filename); //get the masses from the data file; search compounds and return a compound name
        $this->set('head', $head); //send to view
        $this->set('masses', $data); //send to view
        $this->response->download("export.csv");
        $this->layout = 'ajax';
    }
    
}