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
        if ($this->request->is('get')){
            //$file = fopen($this->request->data['Identify']['csv_file']['tmp_name'],"r"); //sets up the file for reading
            $DataFileUrl="/home/tony/temp/TK151_apple_dissect.csv";
            //$DataFileUrl="/home/tony/temp/SC16_QC_posESI_29863_dissect.csv";
            //$DataFileUrl="/home/tony/temp/SC16_QC_posESI_29863_FMF.csv";
            echo $DataFileUrl;
            $url = $this->params['url'];
            var_dump($url);
            $mass_tolerance = $url['mass_tolerance'];
            $ion_type = $url['ion_type'];
            echo $mass_tolerance;
            echo $ion_type;
            $massdata = array();
            $massdata=$this->My->IdentifyMass($DataFileUrl, $mass_window, $ion_type);
            /**$file = fopen($DataFileUrl,"r"); //sets up the file for reading
            $head = fgetcsv($file); //read the column headers from the datafile
            array_push($head, "Compound"); //add another column for search hits to the column headers
            $n = 0;
            while (1==1){
                $line = fgetcsv($file);
                if ($line=== false){
                    break;
                } //when there are no more lines exit the loop               
                //var_dump($line);
                $mass = $line[3] + 1.00794; //for [M-H] data add the mass of hydrogen to get monoisotopic MW
                //$mass = $line[3] - 1.00794; //for [M+H] data subtract the mass of hydrogen to get monoisotopic MW
                $low_mass = $mass - 0.01; //calculate lower and upper limits of the acurate mass window
                $high_mass = $mass + 0.01;
                $search =  array("Compound.exact_mass BETWEEN ? AND ?" => array($low_mass, $high_mass));
                //var_dump($search);
                $foundcmpd = $this->Compound->find('first', ['conditions' =>$search]);
                if (isset($foundcmpd["Compound"])){ 
                    array_push($line, $foundcmpd["Compound"]["compound_name"]);
                }
                //var_dump($foundcmpd);
                array_push($massdata, $line); //adds the array contining the values to an array containing all values to save
                $n = $n + 1;
            } //loops through the CSV file an adds the appropriate values to an array
             */
            //$this->set('fileName', $this->request->data['Identify']['csv_file']['name']); //passes the filename to the view 
            $this->set('fileName', $url['csv_file']); //passes the filename to the view 
            //$this->set('head', $head); // pass table headings to the view 
            $this->set('masses', $massdata); // pass array with the mass data from file to the view 
            //var_dump($massdata);
        }
    }
    
    /**
     * Exports the search results to a CSV file
     * @param type $data
     */
    public function export($masses = null){
        //$this->My->exportCSV('Identify', $this->Identify, $this, [], $data); //removed ',true' to make export work
         if ($masses==null){
            return;
        }
        parse_str($masses);
        //var_dump($masses);
        /**$data = array();
        $data[$modelstr] = $$modelstr;
        if ($allORSearch){
            $search = $controller->buildConditionsArray($data);
        } else {
            $data[$modelstr]['num_boxes'] = (isset($data[$modelstr]['num_boxes']) ? $data[$modelstr]['num_boxes'] : 1);  
            $search = $controller->My->extractSearchTerm($data, $allColums, $modelstr); 
        }
        $data = $model->find('all', ['conditions' => $search]);*/
        /**foreach ($masses as $row):
            foreach ($row as &$cell):
                // Escape double quotation marks
                $cell = '"' . preg_replace('/"/','""',$cell) . '"';
            endforeach;
            echo implode(',', $row) . "\n";
        endforeach;*/
        $this->set('masses', $masses);
        //$this->response->download("export.csv");
        //$this->layout = 'ajax';
    }
}