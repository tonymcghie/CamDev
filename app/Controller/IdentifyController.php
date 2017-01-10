<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class IdentifyController extends AppController{
    public $helpers = array('Html' , 'Form' , 'My', 'Js');
    public $uses = array('Compound');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'My');
        
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
     * This function contains the code for identifying unknown compounds by accurate mass.
     * 1) a csv file containing accurate masses is read;
     * 2) each mass is conpared with entries in the compound table;
     * 3) successful hits are written into an output file that is sent to Downloads
     */
    public function SelectFile(){
        
    }
    
    public function IdByMass() {

    }


    /**
    public function ReadFile(){
        if($this->request->is('post')){ 
            $data = $this->request->data['Identify'];
            $cols = array();
            for($i = 0;isset($data[$i]);$i++){
                if ($data[$i] != 'none'){
                    array_push($cols, ['colNum' => $i, 'colName' => $data[$i]]);
                    unset($data[$i]);
                }
            } //creates array of column names and columns numbers that is used to match csv columns to table columns
            $file = fopen($this->request->data['Identify']['fileUrl'],"r"); //gets the file
            fgetcsv($file); //skips the titles             
            $toSave = [];
            while (1==1){
                $line = fgetcsv($file);
                if ($line=== false){
                    break;
                } //when there are no more lines exit the loop               
                $newRow = [];
                foreach($cols as $pair){
                    $newRow[$pair['colName']] = $line[$pair['colNum']];
                } //adds the values from the CSV file into an array to save to the table
                $newRow['file'] = $data['fileName']; //adds the file name that it came from so all data from the file can be tracked together
                array_push($toSave, $newRow); //adds the array contining the values to save to an array containing all vlaues to save                
            } //loops through the CSV file an adds the appropriate values to an array
            if ($this->Compoundpfr_data->saveMany($toSave)){
                $this->set('message', 'Import Successful');
            } else {
                $this->set('message', 'Something went wrong');
            } // saves all the values and sets a success or failure message
        }
    } 
    */   
    /**
     * This function displays a message describing the process for identifying unknown compounds by accurate mass
     */
    public function idMass(){
    }
    
    public function SearchMasses(){
        $this->layout = 'MinLayout'; //minimilistic layout that has no formating
        if ($this->request->is('post')){
            //$file = fopen($this->request->data['Identify']['csv_file']['tmp_name'],"r"); //sets up the file for reading
            $dataUrl="/home/tony/temp/TK151_apple_dissect.csv";
            echo $dataUrl;
            $massdata = array();
            $file = fopen($dataUrl,"r"); //sets up the file for reading
            $head = fgetcsv($file); //read the column headers from the datafile
            while (1==1){
                $line = fgetcsv($file);
                if ($line=== false){
                    break;
                } //when there are no more lines exit the loop               
                //var_dump($line);
                $search =  'Compound,exact_mass'.' LIKE '.$line[3].'%';
                var_dump($search);
                $this->Compound->find('all', ['conditions' =>$search]);
                //$compound = $this->Compound->findById($line[3]);
                array_push($massdata, $line); //adds the array contining the values to save to an array containing all vlaues to save                
            } //loops through the CSV file an adds the appropriate values to an array
            $this->set('fileName', $this->request->data['Identify']['csv_file']['name']); //passes the filename to the view 
            $this->set('head', $head); // pass pass table headings to the view 
            $this->set('masses', $massdata); // pass array with the mass data from file to the view 
            //var_dump($massdata);
        }
    }
}