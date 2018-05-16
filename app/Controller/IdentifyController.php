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
    public $components = array('Paginator', 'My', 'Session');
        
    /**
     * What to do before funcitons are called
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
     * This function contains the code for identifying unknown compounds by accurate mass.
     * 1) a csv file containing accurate masses is read;
     * 2) each mass is compared with entries in the compound table;
     * 3) successful hits are written into an output file that is sent to Downloads
     */
    public function SelectFile(){
        $filename = '';
        if ($this->request->is('post')) { // checks for the post values
            $uploadData = $this->data['Upload']['csv_path'];

            $mass_tolerance = $this->data['Upload']['mass_tolerance']/1000;
            $ion_type = $this->data['Upload']['ion_type'];

            if ( $uploadData['size'] == 0 || $uploadData['error'] !== 0) { // checks for the errors and size of the uploaded file
                return false;
                }
            $filename = basename($uploadData['name']); // gets the base name of the uploaded file
            $uploadFolder = WWW_ROOT. 'data/files/identify';  // path where the uploaded file has to be saved
            $uploadPath =  $uploadFolder . DS . $filename;
            if( !file_exists($uploadFolder) ){
                mkdir($uploadFolder); // creates folder if  not found
            }
            if (!move_uploaded_file($uploadData['tmp_name'], $uploadPath)) {
                return false;
            }
            $identify_parms = array();
            array_push($identify_parms, $filename, $mass_tolerance, $ion_type); //put all the parameters for identifcation into an array
            $massdata = array();
            $head=$this->My->IdentifyHeadings($uploadPath);
            $massdata=$this->My->IdentifyMass($uploadPath, $mass_tolerance, $ion_type);
            $this->set('identify_parms', $identify_parms); //passes the identify parameters to the view 
            $this->set('head', $head); // pass table headings to the view 
            $this->set('masses', $massdata); // pass array with the mass data from file to the view 
            $this->render('search_masses'); //direct to the search_masses view and not the default select_file view
        }  
    }
        
    public function SearchMasses(){
        if ($this->request->is('post')){
            //$file = fopen($this->request->data['Identify']['csv_file']['tmp_name'],"r"); //sets up the file for reading
            $dataUrl="/home/tony/temp/TK151_apple_dissect.csv";
            echo $dataUrl;
            $massdata = array();
            $compounds = array();
            $file = fopen($dataUrl,"r"); //sets up the file for reading
            $head = fgetcsv($file); //read the column headers from the datafile
            array_push($head, "Compound"); //add another column for search hits to the column headers
            $n = 0;
            while (1==1){
                $line = fgetcsv($file);
                if ($line=== false){
                    break;
                } //when there are no more lines exit the loop               

                $mass = $line[3] + 1.00794; //for [M-H] data add the mass of hydrogen to get monoisotopic MW
                $low_mass = $mass - 0.01; //calculate lower and upper limits of the acurate mass window
                $high_mass = $mass + 0.01;
                $search =  array("Compound.exact_mass BETWEEN ? AND ?" => array($low_mass, $high_mass));

                $foundcmpd = $this->Compound->find('first', ['conditions' =>$search]);
                if (isset($foundcmpd["Compound"])){ 
                    array_push($line, $foundcmpd["Compound"]["compound_name"]);
                }

                array_push($massdata, $line); //adds the array contining the values to an array containing all values to save
                array_push($compounds, $foundcmpd); //adds the array containing the found compounds  to an array containing all values to save
                $n = $n + 1;
            } //loops through the CSV file an adds the appropriate values to an array
            $this->set('fileName', $this->request->data['Identify']['csv_file']['name']); //passes the filename to the view 
            $this->set('compounds', $compounds); // pass to the view 
            $this->set('head', $head); // pass table headings to the view 
            $this->set('masses', $massdata); // pass array with the mass data from file to the view 

        }
    }
    
    /**
     * Exports the search results to a CSV file
     * @param type $data
     */
    public function export($filename, $mass_tolerance, $ion_type){
        //if ($identify_parms==null){
            //return;
        //}
        $filename= urldecode($filename);
        $filename=WWW_ROOT. 'data/files/identify'. DS . $filename; //set the correct path to the datafile
        $head=$this->My->IdentifyHeadings($filename); //get the headings from the datafile
        $massdata=$this->My->IdentifyMass($filename, $mass_tolerance, $ion_type); //get the masses from the data file; search compounds and return a compound name
        $this->set('head', $head); //send to view
        $this->set('masses', $massdata); //send to view
        $this->response->download("export.csv");
        $this->layout = 'ajax';
    }
    
}