<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SamplesController extends AppController{
    public $helpers = array('Html' , 'Form' , 'My', 'Js');
    public $uses = array('Sample', 'SampleSet', 'PubChemModel', 'Compound');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'My', 'Pivot');
    
    /*
     *  @LIVE swap file url 
     */
    //private $file_URL = '/app/app/webroot/data/'; //Live
    private $file_URL = 'data/';  //testing
    
    /**
     * returns weather the the user is authorised to access the functions
     * @param type $user
     * @return type
     */
    public function isAuthorized($user) {
        return $this->My->isAuthorizedPFRData($user, $this);
    }
    
    public function viewSamples($id = null) {
		
    $this->paginate = array(
    'limit' => 20,
    'order' => array('Sample.sample_name' => 'asc'));     //sets up the pagination options

    $set = $this->SampleSet->findById($id); //find a sample set by id
    $this->set('info', $set);// passes the sample set info to the view
    $this->set('num', $this->Sample->find('count', array('conditions' => array('set_code' => $set['SampleSet']['set_code']))));// finds the num of results
    //$results = $this->Sample->find('all', array('conditions' => array('set_code' => $set['SampleSet']['set_code']))); //gets the sample records for the specified set_code
    //$search = 'set_code ='.$set['SampleSet']['set_code'];
    $this->set('results', $this->paginate('Sample', array('set_code =' => $set['SampleSet']['set_code']))); //gets the results
    //$this->set('info', $set);// passes the sample set info to the view so it can be displayed with the data
    //$this->set('results', $results);  //passes the sample record to the view
    $this->set('data', $set); //sends all the data (search criteria) to the view 
    }
    
    /**
     * This handles the importing of sample data
     * the uploading and prieview is already done in the view all this does is add the colums to the data base that have been matched to a column
     * in the incoming data table to the database table
     */
    public function import(){
        if($this->request->is('post')){ 
            $data = $this->request->data['Samples'];
            $cols = array();
            for($i = 0;isset($data[$i]);$i++){
                if ($data[$i] != 'none'){
                    array_push($cols, ['colNum' => $i, 'colName' => $data[$i]]);
                    unset($data[$i]);
                }
            } //creates array of column names and columns numbers that is used to match csv columns to table columns
            $file = fopen($this->request->data['Samples']['fileUrl'],"r"); //gets the file
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
            //echo var_dump($toSave),"<br>";
            if ($this->Sample->saveMany($toSave)){
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
            $newURL = $this->file_URL.'files/samples/temp'.rand().'.csv'; //adds a random number to the end of the file name to avoid clashes           
            move_uploaded_file($this->request->data['Samples']['csv_file']['tmp_name'], $newURL); //uploads the file
            $this->set('fileUrl', $newURL); //passes the new URL to the view
            $this->set('fileName', $this->request->data['Samples']['csv_file']['name']); //passes the filename to the view so it can be later added to the table
        } //if the form is submitted then uplaod the csv file
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
    
    public function export($data = null){
        //$this->My->exportCSV('Sample', $this->Sample, $this, [], $data); //removed ',true' to make export work
        //$results = $this->Sample->find('all', array('conditions' => array('set_code' => $set['SampleSet']['set_code']))); //gets the sample records for the specified set_code
        //echo var_dump($data),"<br>";
        parse_str($data);
        $data['SampleSet']['set_code']='TK100';
        $data = $this->Sample->find('all', array('conditions' => array('set_code' => $data['SampleSet']["set_code"])));
        $this->set('data', $data);
        $this->response->download("export.csv");
        $this->layout = 'ajax'; 
    }
}
