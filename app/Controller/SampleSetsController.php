<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('CakeEmail', 'Network/Email');

class SampleSetsController extends AppController{
    public $helpers = ['Html' , 'Form' , 'My' , 'Js', 'Time', 'String', 'BootstrapForm'];
    public $uses = ['Analysis' , 'SampleSet' , 'Chemist', 'Project'];
    public $layout = 'content';
    public $components = ['Paginator', 'RequestHandler', 'My', 'Session', 'Cookie', 'Auth', 'File', 'Search'];

    // Define models for code completion perposes
    //private $Analysis, $SampleSet, $Chemist, $Project;
    
    /**
     * @LIVE Change loactions
     */    
    private $file_URL = '/app/app/webroot/data/'; //live
    //private $file_URL = 'data/';        //testing   
    
    /**
     * stuff that happens before everything
     */
    public function beforeFilter() {
        parent::beforeFilter();

//        if (isset($this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'])){
//            $this->SampleSet->username = $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'];
//        }//sets the username of the user to a variable that can be used through out the contoller
//        $this->Auth->allow('editSet','newSet'); //deny access to edit and new set by default // 'deny' changed to 'allow' for home testing
//        $this->Cookie->name = 'View'; //sets a cookie with the name view
//        $this->Cookie->time = '365 days'; //sets the time till it expires to be really long

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
     * @param array $options
     */
    private function send_newSS_email($options){
        return;
        $Email = new CakeEmail($options); //creates an email object which will set most of the options
        $Email->subject('New Sample Set: '.$options['set_code']); //sets the subject
        $Email->send($options['submitter'].' has submitted a sample set with set code: '.$options['set_code']); //sets the message and sends the email
    }
        
    /**
     * Sends an email. The message is for when a Sample Set is edited
     * @param array $options
     */
    private function send_editSS_email($options){
        return;
        $Email = new CakeEmail($options); //creates the email object and sets most of the options
        $Email->subject('Sample Set: '.$options['set_code'].' was edited'); //sets the subject of the emial
        $Email->send($options['editor'].' has edited the sample set with set code: '.$options['set_code']); //sets the message of the email and also sends the email
    }

    public function createSampleSet(){
        $this->layout = 'content';
        $data = $this->request->data;
        // Find the number of chemists with the name entered (should always be 1)
        $numChem = $this->Chemist->find('count', array('conditions' => array('name' => $data['SampleSet']['chemist'])));
        $chemist = '';
        if ($numChem!==0){
            $chemist = $this->Chemist->find('first', array('fields' => array('Chemist.team', 'Chemist.name_code', 'Chemist.email'),  'conditions' => array('name' => $data['SampleSet']['chemist']))); //finds info for chemist
            $data['SampleSet']['team']=$chemist['Chemist']['team'];  //updates the team
            //$num = 1 + $this->SampleSet->find('count' , array ('conditions' => array('set_code LIKE' => $chemist['Chemist']['name_code'].'%')));       //finds the new number
            $num = 1 + intval($this->SampleSet->query('SELECT MAX(CAST(SUBSTRING(`set_code` FROM 3 FOR 5)AS UNSIGNED)) AS `set_code` FROM camdata.sample_sets WHERE `set_code` LIKE "'.$chemist['Chemist']['name_code'].'%";')[0][0]['set_code']); //ONLY 2 CHARACTERs AT THE START this finds the highest number on the end of the set code
            $data['SampleSet']['set_code'] = $chemist['Chemist']['name_code'].$num; //updates the set_code;
        } else {
            $data['SampleSet']['set_code'] = 'undefined';
        } //makes sure the chemist is valid
        $data['SampleSet']['date']= date('Y-m-d'); //sets the date that the sample sets was submitted
        $data['SampleSet']['submitter_email'] = $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['email']; //sets the email of the user who submitted the sample set
        if(isset($data['SampleSet']['metadataFile']['error']) && $data['SampleSet']['metadataFile']['error']=='0'){
            $data['SampleSet']['metaFile'] =
                $this->File->uploadFile($data['SampleSet']['metadataFile'],
                    'SampleSet_Metadata',
                    $data['SampleSet']['set_code'].'_Metadata.'.substr(strtolower(strrchr($data['SampleSet']['metadataFile']['name'], '.')), 1));
            unset($data['SampleSet']['metadataFile']);
        }
        $this->SampleSet->create(); //Need to add set code
        if ($this->SampleSet->save($data['SampleSet'])){ //saves the sample set
            $this->set('set_code', $data['SampleSet']['set_code']);

            $this->send_newSS_email(['from' => 'no_reply@plantandfood.co.nz',
                'to' => $chemist['Chemist']['email'],
                'submitter' => $data['SampleSet']['submitter'],
                'set_code' => $data['SampleSet']['set_code'],
                'attachments' => isset($data['SampleSet']['metaFile']) ? $this->file_URL.'files/samplesets/'.$data['SampleSet']['metaFile'] : '']); //sets the values for the email to the chemist
            $this->send_newSS_email(['from' => 'no_reply@plantandfood.co.nz',
                'to' =>  $data['SampleSet']['submitter_email'],
                'submitter' => $data['SampleSet']['submitter'],
                'set_code' => $data['SampleSet']['set_code']]); //sets the values for the email to the submitter
            $this->set('error', false);
            $this->set('set_code', $data['SampleSet']['set_code']);
        } else {
            $this->set('error', true);
        } //if the save was successful then send the emails if not send an error to the view
    }
    /**
     * Makes a new set and sends emails makes set code
     * @return type
     */
    public function newSet(){
        $this->layout = 'content';
        $this->set('names', $this->Chemist->find('list', ['fields' => 'name']));
        $this->set('p_names', $this->Project->find('list' , ['fields' => 'short_name']));

        if (isset($this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'])){
            $this->set('user', $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']);
        } //sets the username to the view
    }
    
    /**
     * Updates a sample set
     * @param type $id
     * @return type
     * @throws NotFoundExcpetion
     */
    public function editSet($id = null){
        if (isset($this->request->data['SampleSet']['id'])){ //updates the id to the provious one when editing twice
            $id = $this->request->data['SampleSet']['id'];
        }
        if (!$id){
            throw new NotFoundExcpetion(__('Invalid Sample Set'));
        } //makes sure that the id is set
        $set = $this->SampleSet->findById($id); 
        if (!$set){
            throw new NotFoundExcpetion(__('Invalid Sample Set'));
        } //makes sure that the set exists                
        $this->set('versions', $this->SampleSet->find('allVersions', ['conditions' => ['set_code' => $set['SampleSet']['set_code']]])); //sets all the versions so that the view can diplsay them
        $this->set('set_code', $set['SampleSet']['set_code']); //sets the setcode for the smaple set this means that the view can pass it back
        if (isset($this->request->data['SampleSet'])){
            $this->request->data['SampleSet']['version'] = $set['SampleSet']['version'] + 1; //makes a new version with a version number 1 greater than the current highest version number
            $this->request->data['SampleSet']['date'] = $set['SampleSet']['date'];//keeps the submit date the same
            if(isset($data['SampleSet']['metadataFile']['error'])&&$data['SampleSet']['metadataFile']['error']=='0'){
                $data['SampleSet']['metaFile'] = $this->uploadFile($data['SampleSet']['metadataFile'], $data['SampleSet']['set_code'].'_Metadata.'.substr(strtolower(strrchr($data['SampleSet']['metadataFile']['name'], '.')), 1));
                unset($data['SampleSet']['metadataFile']); 
            } //uploads metadata file
            unset($this->request->data['SampleSet']['id']); //unsets the id so the new version is saved as a new row
            $this->SampleSet->create(); //create a new version
            if ($this->SampleSet->save($this->request->data)){ //saves the new version
                $this->set('versions', $this->SampleSet->find('allVersions', ['conditions' => ['set_code' => $set['SampleSet']['set_code']]]));  //updates the version shown on the page
                $set = $this->SampleSet->find('all', ['conditions' => ['SampleSet.set_code LIKE' => $set['SampleSet']['set_code']]]); //updates $set to be the most recent version
                $this->set('newId', $set[0]['SampleSet']['id']); //passes the new ID to the view               
                
                $this->send_editSS_email(['from' => 'no_reply@plantandfood.co.nz',
                    'to' => $this->Chemist->find('first', array('fields' => array('Chemist.email'),  'conditions' => array('name' => $set[0]['SampleSet']['chemist'])))['Chemist']['email'],
                    'editor' => $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'],
                    'set_code' => $set[0]['SampleSet']['set_code']]); //send email to the Chemist when the samplt set is updated
                if ($set[0]['SampleSet']['submitter_email'] != ''){
                    $this->send_editSS_email(['from' => 'no_reply@plantandfood.co.nz',
                        'to' => $set[0]['SampleSet']['submitter_email'],
                        'editor' => $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'],
                        'set_code' => $set[0]['SampleSet']['set_code']]);
                } //send email to the submitter if their email is recoded along with the sample set
                
                return;
            }
        } //update the Sample Set
        if (!$this->request->data){
            $this->request->data = $set; //makes sure all the inputs get updated
        } //update the values that should be showing in the form after its being submitted and updated
    }    
    
    /**
     * Entry point for Sample Sets -> Find
     * Control transfers to the search_set view and onto to /Elements/search_form
     * and then back to the search() function below.
     * Search results are displayed as a modal as defined by /Elements/results table 
     */
    public function searchSet(){
        
    }

    public function search(){
        $this->layout = 'ajax';
        $this->autoRender = false;
        $this->paginate = [
            'limit' => 30,
            'order' => array('SampleSet.date' => 'asc')
        ];
        // Listed these here for auto complete reasons and to stop the IDE displaying errors
        $criteria = null;$value = null;$logic = null;$match = null;
        extract($this->request->data['SampleSet']);
        //$criteria = 'set_code';$value = 'TK123';$logic = 'AND';$match = 'contains';
        var_export($criteria);var_export($value);var_export($match);var_export($logic);
        $query = $this->Search->build_query($this->SampleSet, $criteria, $value, $logic, $match);
        $results = $this->paginate('SampleSet', $query);
        $this->set('results', $results);
        $this->set('model', 'SampleSet');
        $this->render('/Elements/results_table');
        //var_export($results);
    }
    
    /**
     * The Controller function for viewing the sample sets
     * this bassically adds the derived data from the analysis to the view
     * @param type $id
     * @throws NotFoundExcpetion
     */
    public function viewSet($id = null){
        $set = $this->SampleSet->findById($id); //if the id is passed then find on that
        if (!$set){ //if the set does not exist
            throw new NotFoundExcpetion(__('Invalid Sample Set'));
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
}

