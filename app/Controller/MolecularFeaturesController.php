<?php

App::uses('ConnectionManager', 'Model');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class MolecularFeaturesController extends AppController{
    public $helpers = array('Html' , 'Form' , 'My', 'Js', 'Time', 'String', 'BootstrapForm');
    public $uses = array('Molecular_feature','PubChemModel', 'Compound');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'My', 'Pivot', 'RequestHandler', 'Session', 'Cookie', 'Auth', 'File', 'Search');
    
    //sets the values for the pagination
    public $paginate = array(
        'limit' => 30,
        'order' => array(
            'Compoundpfr_data.assigned_name' => 'asc'
        )
    );
    
    /*
     *  @LIVE swap file url 
     */
    //private $file_URL = '/app/app/webroot/data/'; //Live
    private $file_URL = 'data/';  //testing

    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('group', 'metabolomicData');
    }
    
    /**
     * returns weather the the user is authorised to access the functions
     * @param type $user
     * @return type
     */
    public function isAuthorized($user) {
        return $this->My->isAuthorizedPFRData($user, $this);
    }
    
    /**
     * Entry point for Metabolomic Data -> Find
     * Control transfers to the find_data view and onto to /Elements/search_form
     * and then back to the search() function below.
     * Search results are displayed as a modal as defined by /Elements/results table 
     */
    public function findData($data = null){   
        
    } 
    
    
    public function search(){
        $data = $this->request->data;
        $this->layout = 'ajax';
        $this->autoRender = false;
        $this->paginate = [
            'limit' => 100,
            'order' => array('Molecular_feature.date' => 'asc')
        ];
        // Listed these here for auto complete reasons and to stop the IDE displaying errors
        $criteria = null;$value = null;$logic = null;$match = null;
        extract($this->request->data['Molecular_feature']);
        $query = $this->Search->build_query($this->Molecular_feature, $criteria, $value, $logic, $match);
        $results = $this->paginate('Molecular_feature', $query);
        
        $resultObjects = $this->Molecular_feature->buildObjects($results);
        $this->set('cols', $this->Molecular_feature->getDisplayColumns());
        $this->set('num', $this->Molecular_feature->find('count', ['conditions' => $query])); //passes the number of results to the view
        $this->set('results', $resultObjects);
        
        $this->set('model', 'Molecular_feature');
        $this->set('data', $data); //pass the search parameters to view so that is can get passed back to controller for action=>export
        $this->render('/Elements/search_results_modal');

    }
    
    
    
    /**
     * exports the current search data as a csv file
     * @param type $data
     */
    public function export($data = null){
        $this->My->exportCSV('Molecular_feature', $this->Molecular_feature, $this, ['feature_tag', 'sample_reference', 'experiment_reference', 'mz', 'ion_polarity','intensity', 'crop', 'genotype','tissue', 'analyst'], $data);  
    }
    
    /**
     * this has graphs the data sinces everything is hadled through ajax and javascript it is empty
     * @param type $data
     */
    public function graphData($data = null){        
        
    }
    /**
     * shows all the field entries for a selected record in the Molecular_features table
     *
     */
	public function viewData($id = null) {
		$data = $this->Molecular_feature->findById($id); //if the id is passed then find on that
        if (!$data){ //if the set does not exist
            throw new NotFoundExcpetion(__('Invalid Data Record'));
        } //if the sample set with that id exists
        $this->set('info', $data);// passes the set to the page
	}

    /**
     * this is the Ajax function for getting the data from the graphing search routine
     * it returns the data in a Json formated string
     */
    public function getData(){  
        $this->autoRender=false; //tells Cake no to render the page as only the Json string should be rendered
        $this->layout = 'ajax'; 
        
        $data = ['Compoundpfr_data' => []];
        $count = 0;
        foreach ($this->request->data['info'] as $pair){
            $data['Compoundpfr_data']['cri_'.$count] = $pair['cri'];
            $data['Compoundpfr_data']['val_'.$count] = $pair['val'];
            $data['Compoundpfr_data']['log_'.$count] = $pair['log'];
            $data['Compoundpfr_data']['match_'.$count] = $pair['match'];
            $count++;
        } //adds the search criteia value and logic to an array in the same structure as if it came from a form
        $options = $this->request->data['options']; // contains the options such as the pivot
        //gets the criteria for the search
        $search = $this->My->extractSearchTerm($data, ['assigned_name', 'assigned_confid', 'exact_mass', 'intensity_description', 'reference', 'sample_ref', 'crop', 'species', 'tissue', 'genotype', 'analyst'], 'Compoundpfr_data');               
        $search = $this->addPsu($data, $search); //adds psydonims from compund table to the search in OR array
        $data = $this->Compoundpfr_data->find('all', ['conditions' => $search]); //finds the data 
        //return;
        if ($options['pivot']!='none'){
            $results = $this->Pivot->FormatGraphData($data, $options['pivot'], 'intensity_value', 'Compoundpfr_data');
        } else {
            $results = $this->My->resultsToGraph($data, 'Compoundpfr_data', $options['xAxis'], $options['yAxis']);
        } //if there is a pivot set then pivot the data if not format the data into a format friendlier to the google charts API
        echo json_encode($results); //echos the Json string back to the ajax call
    }
    
    /**
     * Entry point for CompoundspfrData -> overview
     * Control transfers to the overview_data view and onto to /Elements/overview_form
     * and then back to the overview() function below.
     * Search results are displayed as a modal as defined by /Elements/results table
     */
    
    public function overviewData(){
        
    }
    
    /**
     * Enables the user to obtain a summary review of the data in the CompoundPFR data table.  This is a large table and this tool is useful 
     * for getting an overview of the data in the table 
     */
    public function overview(){
        $this->layout = 'ajax';
        $this->autoRender = false;
        // Listed these here for auto complete reasons and to stop the IDE displaying errors
        $by = null;$value = null;$match = null;$for = null; $review_options=null;
        extract($this->request->data['molecular_features']);
        if ($match == 'contains')$review_by_value = '%'.$value.'%';
        if ($match == 'exact')$review_by_value = $value;
        if ($match == 'starts')$review_by_value = $value.'%';
        //pr($review_by_value);
        $query = "SELECT DISTINCT {$for} "
                . "FROM cam_data.molecular_features as Molecular_feature"
                . " WHERE {$by} LIKE '{$review_by_value}';";
        //var_dump($query);
        //$db_name = ConnectionManager::getDataSource('default')->config['database'];
        $results = $this->Molecular_feature->query("SELECT DISTINCT {$for} "
                . "FROM cam_data.molecular_features as Molecular_feature"
                . " WHERE {$by} LIKE '{$review_by_value}';");
        //var_dump($results);        
        //send everything to the view and display as a modal            
        $this->set('results', $results);
        $this->set('for', $for);
        $this->set('value', $value);
        $this->set('by', $by);
        $this->set('model', 'Molecular_feature');
        $this->render('/Elements/overview_results_modal');    
    }
    
    /**
     * This handles the importing of data
     * the uplaoding and prieview is already done all this does is add the colums to the data base that have being matched to a column in the table to the table
     */
    public function import(){
        if($this->request->is('post')){ 
            $data = $this->request->data['Molecular_feature'];
            $cols = array();
            for($i = 0;isset($data[$i]);$i++){
                if ($data[$i] != 'none'){
                    array_push($cols, ['colNum' => $i, 'colName' => $data[$i]]);
                    unset($data[$i]);
                }
            } //creates array of column names and columns numbers that is used to match csv columns to table columns
            $file = fopen($this->request->data['Molecular_feature']['fileUrl'],"r"); //gets the file
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
            if ($this->Molecular_feature->saveMany($toSave)){
                $this->set('message', 'Import Successful');
            } else {
                $this->set('message', 'Something went wrong');
            } // saves all the values and sets a success or failure message
        } //if you are trying to import data rather than the first display
    }
    
    /**
     * Uploads a CSV file from a iFrame within a page
     */
    public function getCsv(){
        $this->layout = 'MinLayout'; //minimilistic layout that has no formating
        if ($this->request->is('post')){            
            $newURL = $this->file_URL.'files/molecularfeatures/temp'.rand().'.csv'; //adds a random number to the end of the file name to avoid clashes
            move_uploaded_file($this->request->data['Molecular_feature']['csv_file']['tmp_name'], $newURL); //uploads the file
            $this->set('fileUrl', $newURL); //passes the new URL to the view
            $this->set('fileName', $this->request->data['Molecular_feature']['csv_file']['name']); //passes the filename to the view so it can be later added to the table
        } //if the form is submitted then upload the csv file
    }
    
    /**
     * Ajax method that returns the first 6 lines of a CSV file 
     */
    public function getCsvPreview(){
        $this->autoRender=false;
        $this->layout = 'ajax';
        try{            
            $file = fopen($this->request->data['url'],"r");
            $array = array();  
            for ($i = 0; $i < 6;$i++){
                $line = fgetcsv($file, 0, ',', '"'); //gets a line from the CSV file with , separation and " arround the values
                if ($line != false && $line != ""){               
                    array_push($array, $line);
                } //if the line exists then push it to the array of lines
            } //adds the first 6 lines of data to an array
            echo('[');
            foreach($array as $line){
                if ($line != $array[count($array)-1]){                
                    echo($this->makeString($line).',');
                } else {               
                    echo($this->makeString($line).']');
                }
            } //echos the array as a string
            fclose($file);       
        }catch (Exception $e){//if there is a error echo the error message this should be commented out when going live   
            //print_r($e);
        }  //echo the first 6 lines of the data in the CSV file as a string of an array that can be Json decoded 
    }
    
    /**
     * This sanitises each string in the array then returns the Json string of the array
     * @param type $array
     * @return type
     */
    private function makeString($array){
        if (!isset($array) || $array === false){
            return;
        } //makes sure that some data has being passed
        foreach($array as &$val){
            $val = filter_var($val, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);            
        } //filters the string and sets it in the array
        return json_encode($array); //returns the encoded result
    }
    
}
