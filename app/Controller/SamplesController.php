<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SamplesController extends AppController{
    public $helpers = array('Html' , 'Form' , 'My');
    public $uses = array('Analysis', 'SampleSet', 'Sample');
    public $layout = 'PageLayout';
    //public $components = ['My', 'RequestHandler', 'PhpExcel'];
	public $components = array('Paginator', 'My', 'RequestHandler', 'PhpExcel');
    
    /**
     * @LIVE swap file URL
     */
    private $file_URL = '/app/app/webroot/data/'; //live
    //private $file_URL = 'data/';        //testing
    
    /**
     * this happens before everything else
     */
    public function beforeFilter() {
        parent::beforeFilter();
        //by default users are not allowed
        $this->Auth->allow('editAnalysis');
    }
    
    /**
     * returns weather the user is authorised to access this controller
     * @param type $user
     * @return type
     */
    public function isAuthorized($user) {
        return $this->My->isAuthorizedAnalysis($user, $this); //returns false if the user is not a chemist
    }

	public function viewSamples($id = null) {
		
		$this->paginate = array(
        'limit' => 20,
        'order' => array('Sample.sample_name' => 'asc'));     //sets up the pagination options

        $set = $this->SampleSet->findById($id); //find a sample set by id
        $this->set('info', $set);// passes the sample set info to the view
		$this->set('num', $this->Sample->find('count', array('conditions' => array('set_code' => 'TK94'))));// finds the num of results
		$results = $this->Sample->find('all', array('conditions' => array('set_code' => $set['SampleSet']['set_code']))); //gets the sample records for the specified set_code
		$this->set('results', $results);  //passes the sample record to the view
		$this->set('data', $this->request->data); //sends all the data (search criteria) to the view so it can be added to the ajax links 
    }
	
	public function importSamples($id = null) {

		$set = $this->SampleSet->findById($id); //find a sample set by id
        $this->set('info', $set);// passes the sample set info to the view

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
            if ($this->Compoundpfr_data->saveMany($toSave)){
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
            $newURL = $this->file_URL.'files/Samples/temp'.rand().'.csv'; //adds a random number to the end of the file name to avoid clashes           
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
    
    
    public function editAnalysis($set_code = null){                    
        $data = $this->request->data;        
        if ($set_code == null){
            $set_code = $this->params['url']['set_code'];
        } //gets the set_code
        if (isset($data['Analysis']['key'])){ 
            $this->Analysis->create();
            $this->Analysis->save($data);
        }//creates a new row
        if (isset($data['Analysis'][0])){
            $set_code = $data['Analysis']['set_code'];
            unset($data['Analysis']['set_code']); //makes sure the set_code doesnt change
            foreach ($data['Analysis'] as &$row){ 
                //File upload stuff
                if (isset($row['newImg'])){
                    unset($row['newImg']);                    
                } //unsets the newImg value as the images are uplaoded through a separate iFrame      
                if (isset($row['p_data']['error'])&&$row['p_data']['error']=='0'){ //uplaods an img if there is one to upload
                    $row['processed'] = $this->uploadFile($row['p_data'],
                            $set_code.'_'.$row['title'].'_'.'additionalData'.'_'.$row['id'].'.'.substr(strtolower(strrchr($row['p_data']['name'], '.')), 1));
                }   //calls the functoin to upload a new additional data file and sets the name variable           
                if (isset($row['d_data']['error'])&&$row['d_data']['error']=='0'){ //uplaods an img if there is one to upload
                    $row['derived_results'] = $this->uploadDataFile($row['d_data'],
                            $set_code.'_'.$row['title'].'_'.'processedData'.'_'.$row['id'].'.xlsx',
                            $row,
                            $set_code);
                }   //calls the function to upload a new processed data file and sets the name variable
                if(isset($row['d_data'])){
                    unset($row['d_data']);
                } //unsets d_data as its not a column in the table
                if(isset($row['p_data'])){
                    unset($row['p_data']);
                } //unsets p_data as its not a column in the table
                //end file uploading stuff
                if (!isset($row['id'])){continue;}
                unset($row['imgURL']);
                
                $this->Analysis->id=$row['id']; //sets the row to save to 
                $this->Analysis->save($row);    //saves the row
            }           
        } //check to make sure that the analysis exists before trying to save it
        if (isset($set_code)){         
            $results = $this->Analysis->find('all', array('conditions' => array('set_code' => $set_code)));
            $this->set('results', $results);
            $this->set('set_code', $set_code);
        } //updates the values showing
        if (isset($this->params['url']['isTablet']) && $this->params['url']['isTablet']==='true'){
            $this->autoRender = false;
            $this->set('tabletView', 'true');
            $this->layout= 'TabletLayout';
            $this->render('edit_analysis_tablet');
        } else {
            $this->set('tabletView', 'false');
            $this->autoRender = true;
        } //choose weather to render the tablet view or the desktop view
    }
    
    /**
     * function to be called by Ajax that uploads a new image
     * @return type
     */
    public function uploadNewImg(){                
        $this->layout = 'MinLayout'; //sets the layout to a minimilistic one contains the bear minimum with as little formating as possible.
        $id = $this->params['url']['id'];
        $imgURL = $this->Analysis->find('first', ['feilds' => ['imgURL'], 'conditions' => ['id' => $id]])['Analysis']['imgURL']; //finds the current imgURL for the row
        $this->set('id', $id);
        $this->set('imgURL', $imgURL);
        if (isset($this->request->data['Analysis']['newImg']['error']) && $this->request->data['Analysis']['newImg']['error'] === 0){ 
            $this->Analysis->id = $id;       
            $newImgURL = $this->uploadImg(['id' => $id, 'newImg' => $this->request->data['Analysis']['newImg'], 'imgURL' => $imgURL]);
            if($newImgURL === false){ //if the uploading didnt work
                echo 'There was an Error uploading the file';
                return;
            }
            $this->Analysis->saveField('imgURL', $newImgURL); //updates just the imgURl field
            $this->set('imgURL', $newImgURL);
        } //if there is a files selected (an image) the upload it
    } 
}
