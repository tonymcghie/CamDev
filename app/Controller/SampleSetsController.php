<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('CakeEmail', 'Network/Email');

class SampleSetsController extends AppController{
    public $helpers = array('Html' , 'Form' , 'My' , 'Js', 'Time');
    public $uses = array('Analysis' , 'SampleSet' , 'Chemist');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'RequestHandler', 'My', 'Session', 'Cookie', 'Auth');    
    
    /**
     * @LIVE Change loactions
     */    
    //private $file_URL = '/app/app/webroot/data/'; //live
    private $file_URL = 'data/';        //testing   
    
    /**
     * stuff that happens before everything
     */
    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'])){
            $this->SampleSet->username = $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'];
        }//sets the username of the user to a variable that can be used through out the contoller
        $this->Auth->allow('editSet','newSet'); //deny access to edit and new set by default // 'deny' changed to 'allow' for home testing
        $this->Cookie->name = 'View'; //sets a cookie with the name view
        $this->Cookie->time = '365 days'; //sets the time till it expires to be really long
    }
    
    /**
     * return weather or not the user is allowed to access the function
     * @param type $user
     * @return type
     */
    public function isAuthorized($user) {
        $this->set('user', $user);        
        return $this->My->isAuthorizedSampleSet($user, $this); //retrurns false if not logged in and action = new or edit
    }
    
    /**
     * Sends an email. The message is for when a new Sample Set is submitted
     * @param type $options
     */
    private function send_newSS_email($options){
        $Email = new CakeEmail($options); //creates an email object which will set most of the options
        $Email->subject('New Sample Set: '.$options['set_code']); //sets the subject
        $Email->send($options['submitter'].' has submitted a sample set with set code: '.$options['set_code']); //sets the message and sends the email
    }
        
    /**
     * Sends an email. The message is for when a Sample Set is edited
     * @param type $options
     */
    private function send_editSS_email($options){
        $Email = new CakeEmail($options); //creates the email object and sets most of the options
        $Email->subject('Sample Set: '.$options['set_code'].' was edited'); //sets the subject of the emial
        $Email->send($options['editor'].' has edited the sample set with set code: '.$options['set_code']); //sets the message of the email and also sends the email
    }
    
    /**
     * Makes a new set and sends email makes set code
     * @return type
     */
    public function newSet(){        
        if (isset($this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'])){
            $this->set('user', $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']);
        } //sets the username to the view
        
        if ($this->request->is('post')){           
            $data = $this->request->data;      //gets the data
            $data['SampleSet']['status']='submitted'; //sets the initial status of the new sample set to 'submitted'
            $numChem = $this->Chemist->find('count', array('conditions' => array('name' => $data['SampleSet']['chemist']))); //finds the number of chemists with the name entered (should always be 1)
            $chemist = '';
            if ($numChem!==0){
                $chemist = $this->Chemist->find('first', array('fields' => array('Chemist.team', 'Chemist.name_code', 'Chemist.email'),  'conditions' => array('name' => $data['SampleSet']['chemist']))); //finds info for chemist
                $data['SampleSet']['team']=$chemist['Chemist']['team'];  //updates the team
                //$num = 1 + $this->SampleSet->find('count' , array ('conditions' => array('set_code LIKE' => $chemist['Chemist']['name_code'].'%')));       //finds the new number
                $num = 1 + intval($this->SampleSet->query('SELECT MAX(CAST(SUBSTRING(`set_code` FROM 3 FOR 5)AS UNSIGNED)) AS `set_code` FROM cam_data.sample_sets WHERE `set_code` LIKE "'.$chemist['Chemist']['name_code'].'%";')[0][0]['set_code']); //ONLY 2 CHARACTERs AT THE START this finds the highest number on the end of the set code
                $data['SampleSet']['set_code']=$chemist['Chemist']['name_code'].$num; //updates the set_code;
            } //makes sure the chemist is valid
            $data['SampleSet']['date']= date('Y-m-d'); //sets the date that the sample sets was submitted
            $data['SampleSet']['submitter_email'] = $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['email']; //sets the email of the user who submitted the sample set
            if(isset($data['SampleSet']['metadataFile']['error'])&&$data['SampleSet']['metadataFile']['error']=='0'){
                $data['SampleSet']['metaFile'] = $this->uploadFile($data['SampleSet']['metadataFile'], $data['SampleSet']['set_code'].'_Metadata.'.substr(strtolower(strrchr($data['SampleSet']['metadataFile']['name'], '.')), 1));
                unset($data['SampleSet']['metadataFile']); 
            }
            $this->SampleSet->create(); //Need to add set code
            if ($this->SampleSet->save($data)){ //saves the sample set                
                $this->set('set_code', $data['SampleSet']['set_code']);
                
                /**$this->send_newSS_email(['from' => 'no_reply@plantandfood.co.nz',
                    'to' => $chemist['Chemist']['email'],
                    'submitter' => $data['SampleSet']['submitter'],
                    'set_code' => $data['SampleSet']['set_code'],
                    'attachments' => $this->file_URL.'files/samplesets/'.$data['SampleSet']['metaFile']]); //sets the values for the email to the chemist
                $this->send_newSS_email(['from' => 'no_reply@plantandfood.co.nz',
                    'to' =>  $data['SampleSet']['submitter_email'],
                    'submitter' => $data['SampleSet']['submitter'],
                    'set_code' => $data['SampleSet']['set_code']]); //sets the values for the email to the submitter*/
                
                return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'Sample Set Saved. Set Code is '.$data['SampleSet']['set_code']]]); //redirects the page to the blank page and makes an alert message containing the set code
            } else {
                $this->set('error', true);
            } //if the save was successful then send the emails if not send an error to the view
        } //check if the save button has being clicked and makes a new sample set if the form has being submitted   
    }  
    
    /**
     * Updates a sample set
     * @param type $id
     * @return type
     * @throws NotFoundExcpetion
     */
    public function editSet($id = null){
        //needs to reworked so $set (post data) is named differently eg new_setdata, and then used to avoid conflict with the old_setdata
        //then need to be careful that all the chages align
        $new_setdata = $this->request->data; //get the posted data from the form
        echo "NewSetData =", "<br>", var_export($new_setdata), "<br>";
        if (isset($this->request->data['SampleSet']['id'])){ //updates the id to the provious one when editing twice
            $id = $this->request->data['SampleSet']['id'];
        }
        if (!$id){
            throw new NotFoundExcpetion(__('Invalid Sample Set'));
        } //makes sure that the id is set
        $old_setdata = $this->SampleSet->findById($id); //get sampleset data for the last version in the database 
        echo "OldSetData =", "<br>", var_export($old_setdata), "<br>";
        if (!$old_setdata){
            throw new NotFoundExcpetion(__('Invalid Sample Set'));
        }
        $this->set('versions', $this->SampleSet->find('allVersions', ['conditions' => ['set_code' => $old_setdata['SampleSet']['set_code']]])); //sets all the versions so that the view can diplsay them
        $this->set('set_code', $old_setdata['SampleSet']['set_code']); //sets the setcode for the smaple set this means that the view can pass it back
        if (isset($this->request->data['SampleSet'])){
            $new_setdata['SampleSet']['version'] = $old_setdata['SampleSet']['version'] + 1; //makes a new version with a version number 1 greater than the current highest version number
            $new_setdata['SampleSet']['date'] = $old_setdata['SampleSet']['date'];//keeps the submit date the same
            if ($new_setdata['SampleSet']['metadataFile']['error']!='0'){
                    $new_setdata['SampleSet']['metaFile'] = $old_setdata['SampleSet']['metaFile'];
                }
            if(isset($new_setdata['SampleSet']['metadataFile']['error'])&&$new_setdata['SampleSet']['metadataFile']['error']=='0'){
                $new_setdata['SampleSet']['metaFile'] = $this->uploadFile($new_setdata['SampleSet']['metadataFile'], $new_setdata['SampleSet']['set_code'].'_Metadata.'.substr(strtolower(strrchr($new_setdata['SampleSet']['metadataFile']['name'], '.')), 1));
                unset($new_setdata['SampleSet']['metadataFile']); 
            } //uploads metadata file
            unset($new_setdata['SampleSet']['id']); //unsets the id so the new version is saved as a new row
            $this->SampleSet->create(); //create a new version
            //if ($this->SampleSet->save($this->request->data)){ //saves the new version
            if ($this->SampleSet->save($new_setdata)){ //saves the new version
                $this->set('versions', $this->SampleSet->find('allVersions', ['conditions' => ['set_code' => $new_setdata['SampleSet']['set_code']]]));  //updates the version shown on the page
                $set = $this->SampleSet->find('all', ['conditions' => ['SampleSet.set_code LIKE' => $new_setdata['SampleSet']['set_code']]]); //updates $set to be the most recent version
                $this->set('newId', $set[0]['SampleSet']['id']); //passes the new ID to the view               
                
                /**$this->send_editSS_email(['from' => 'no_reply@plantandfood.co.nz',
                    'to' => $this->Chemist->find('first', array('fields' => array('Chemist.email'),  'conditions' => array('name' => $set[0]['SampleSet']['chemist'])))['Chemist']['email'],
                    'editor' => $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'],
                    'set_code' => $set[0]['SampleSet']['set_code']]); //send email to the Chemist when the samplt set is updated
                if ($set[0]['SampleSet']['submitter_email'] != ''){
                    $this->send_editSS_email(['from' => 'no_reply@plantandfood.co.nz',
                        'to' => $set[0]['SampleSet']['submitter_email'],
                        'editor' => $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'],
                        'set_code' => $set[0]['SampleSet']['set_code']]);
                } //send email to the submitter if their email is recoded along with the sample set*/
                
                return;
            }
            echo "NewSetData =", "<br>", var_export($new_setdata), "<br>";
        } //update the Sample Set
        if (!$this->request->data){
            $this->request->data = $new_setdata; //makes sure all the inputs get updated
        } //update the values that should be showing in the form after its being submitted and updated
    }    
    
    /**
     * This will search the the sample sets 
     * @param type $data
     * @return type
     */
    public function searchSet($data = null){
        if ($data != null && !isset($this->request->data['SampleSet'])){ //if the data passed is through the url rather than post then set the data variable to the data passed from the url
            parse_str($data);
            $this->request->data['SampleSet'] = $SampleSet;
        } //if data is passed to the function then set it to be in the $this->request->data variable
        $data = $this->request->data;
        if (isset($this->params->query['search'])) {
            $column = $this->params->query['search']['column'];
            $value = $this->params->query['search']['value'];
            
            $data['SampleSet'] = [];
            $data['SampleSet']['num_boxes'] = 1;
            $data['SampleSet']['cri_0'] = $column;
            $data['SampleSet']['val_0'] = $value;
            $data['SampleSet']['log_0'] = 'AND';
            $data['SampleSet']['match_0'] = 'contain';
        }
        if (isset($data['SampleSet'])){ //if data == null and request->data ==null                
//            $this->paginate = array( 
//            'limit' => 30,
//            'order' => array('SampleSet.date' => 'asc'));     //sets up the pagination options

            $data['SampleSet']['num_boxes'] = (isset($data['SampleSet']['num_boxes']) ? $data['SampleSet']['num_boxes'] : 1); //sets boxnum to 1 if its not already set
            $this->set('box_nums',$data['SampleSet']['num_boxes']);  //passes the box num to the view 
            if ($data['SampleSet']['isDate']==='1'){ //checks if there is a date to search on
                $data['SampleSet']['start_date'] = $data['SampleSet']['start_date']['year'].'-'.$data['SampleSet']['start_date']['month'].'-'.$data['SampleSet']['start_date']['day'];//makes date in  format where sql can compare time helper
                $data['SampleSet']['end_date'] = $data['SampleSet']['end_date']['year'].'-'.$data['SampleSet']['end_date']['month'].'-'.$data['SampleSet']['end_date']['day'];
            }
            //gets the criteria for the search
            $search = $this->My->extractSearchTerm($data, ['submitter', 'chemist', 'set_code', 'crop', 'type', 'p_name', 'p_code', 'exp_reference', 'compounds', 'comments', 'sample_loc', 'set_reason'], 'SampleSet');        

            $results = $this->paginate('SampleSet', $search); //search for the data for the page
            $this->set('num', $this->SampleSet->find('count', ['conditions' => $search]));// finds the num of results
            $this->set('results' ,$results); //sends the reuslts to the page
            $this->set('data', $data); //sends all the data(search criteria) to the view so it can be added to the ajax links
        }
    }       
    
    /**
     * The Controller function for viewing the sample sets
     * this basically adds the derived data from the analysis to the view
     * @param type $id
     * @throws NotFoundExcpetion
     */
    public function viewSet($id = null, $set_code = null){
        if ($set_code!=null){
            //find by set_code and get set id
            $set = $this->SampleSet->find('first', ['conditions' => ['set_code' => $set_code]]);
            //var_dump($set);
            //if set does not exist this redirects the page to the blank page and makes an alert message containing the set code
            if (!$set){
                return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'Sample Set does not exist.']]); 
            }    
        }
        else {
            $set = $this->SampleSet->findById($id); //if the id is passed then find on that
        }
        if (!$set){ //if the set does not exist
            throw new NotFoundException(__('Invalid Sample Set'));
        } //if the sample set with that id exists
        $this->set('info', $set);// passes the set to the page
        $deRes = $this->Analysis->find('all', ['fields' => ['Analysis.derived_results', 'Analysis.title'], 'conditions' => ['set_code' => $set['SampleSet']['set_code']]]); //finds the most recent version
        $this->set('deRes', $deRes); //passes the version to the page
        if (!$this->request->data){
            $this->request->data = $set;
        } //sets the data to go into the hidden inputs
    }    
    
    /**
     * Creates and exports a CSV file from a search
     * @param type $data
     */
    public function export($data = null){
        $this->My->exportCSV('SampleSet', $this->SampleSet, $this, ['set_code', 'submitter', 'chemist', 'crop', 'type', 'number', 'compounds','comments'], $data);  //exports the data to an csv file
    }
    
    /**
     * Ajax function that returns list items the have the chemist details in
     */
    public function nameAutoComplete(){
        $this->autoRender=false; //stops the page from rendering as this is ajax so it outputs data
        $this->layout = 'ajax';     //ajax layout is blank
        $query = $this->request->data['name']; //gets the part name of the name that has being entered
        $results = $this->Chemist->find('all' , array('conditions' => array('name LIKE' => $query.'%')));//gets all names that start with that part of the name
        $elements = '';
        foreach($results as $row){ 
            $elements .= "<li class='ui-menu-item' role='menuitem'><a class='ui-corner-all' tabindex='-1'";
            $elements .= 'onclick="change(\''.$row['Chemist']['name'].'\')"'; 
            $elements .= ">".$row['Chemist']['name']." - ".$row['Chemist']['team']." - ".$row['Chemist']['name_code']."</a></li>";
        } //makes the list of possible names 
        echo $elements;
    }
    /**
     * Ajax function that return json array of data if it finds only one sample set for the set code
     */
    public function getSetCode(){
        $this->autoRender=false;
        $this->layout = 'ajax'; 
        
        $set_code = $this->request->data['setCode']; //gets the set coed to search on
        $results = $this->SampleSet->find('all', ['conditions' => [ 'AND' => [ '0' => [ 'SampleSet.set_code' => $set_code]]]]); //finds the sample set 
        $results = [$results[0]]; //return only the first result
        echo json_encode($results);
    }   
    /**
     * uplaods a new file into the samplesets dir in the files dir
     * @param type $file
     * @param type $newName
     * @return type
     */
    private function uploadFile($file, $newName){ 
        $URL = $this->file_URL.'files/samplesets/'.$newName; //sets the new location
        echo var_export($URL), "<br>";
        $result = move_uploaded_file( $file['tmp_name'], $URL ); //uploads the file
        if ($result){return $newName;}//returns the name if the uplaod was successful
    }
}

