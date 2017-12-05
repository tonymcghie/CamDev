<?php

App::uses('CakeEmail', 'Network/Email');
App::uses('AppController', 'Controller');
App::uses('Searchable', 'Controller/Behavior');

class SampleSetsController extends AppController {
    use Searchable {
        Searchable::getComponents as public getSearchableComponents;
    }

    public $helpers = ['Html' , 'Form' , 'My' , 'Js', 'Time', 'String', 'BootstrapForm'];
    public $uses = ['Analysis' , 'SampleSet' , 'Chemist', 'Project'];
    public $layout = 'PageLayout';

    public $components = ['Paginator', 'RequestHandler', 'My', 'Session', 'Cookie', 'Auth', 'File'];

    /** @var string $file_URL sets the location to save files to */
    private $file_URL;

    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
        $this->components = array_merge($this->components, $this->getSearchableComponents());
    }

    protected function getModel() {
        return $this->SampleSet;
    }

    /**
     * stuff that happens before everything
     */
    public function beforeFilter() {
        $this->set('group', 'sampleSets');

        $file_URL = Configure::read('live') ? '/app/app/webroot/data/' : 'data/';

        $this->Paginator->settings= [
            'limit'=>10,
            'order' => [
                'SampleSet.date' => 'asc'
            ]
        ];

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
        $errors = [];
        $data = $this->request->data;

        if ($chemist = $this->Chemist->nextSamplesetInfo($data['SampleSet']['chemist'])) {
            $data['SampleSet']['team'] = $chemist->team;
            $data['SampleSet']['set_code'] = $chemist->nextSetCode;
        } else {
            $errors[] = "No Chemist was found with the name {$data['SampleSet']['chemist']}";
        }

        //sets the date that the sample sets was submitted
        $data['SampleSet']['date'] = date('Y-m-d');

        //sets the email of the user who submitted the sample set
        $data['SampleSet']['submitter_email'] = $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['email'];

        if(isset($data['SampleSet']['metadataFile']['error']) && $data['SampleSet']['metadataFile']['error']=='0'){
            $data['SampleSet']['metaFile'] =
                $this->File->uploadFile($data['SampleSet']['metadataFile'],
                    'SampleSet_Metadata',
                    $data['SampleSet']['set_code'].'_Metadata.'.substr(strtolower(strrchr($data['SampleSet']['metadataFile']['name'], '.')), 1));
        }
        unset($data['SampleSet']['metadataFile']);

        $this->SampleSet->create();
        if ($sampleSet = $this->SampleSet->save($data['SampleSet'])){ //saves the sample set
            //if the save was successful then send the emails if not send an error to the view
            $this->send_newSS_email(['from' => 'no_reply@plantandfood.co.nz',
                'to' => $chemist->email,
                'submitter' => $data['SampleSet']['submitter'],
                'set_code' => $data['SampleSet']['set_code'],
                'attachments' => isset($data['SampleSet']['metaFile']) ? $this->file_URL.'files/samplesets/'.$data['SampleSet']['metaFile'] : '']); //sets the values for the email to the chemist
            $this->send_newSS_email(['from' => 'no_reply@plantandfood.co.nz',
                'to' =>  $data['SampleSet']['submitter_email'],
                'submitter' => $data['SampleSet']['submitter'],
                'set_code' => $data['SampleSet']['set_code']]); //sets the values for the email to the submitter
            $this->set('sampleSet', $sampleSet);
            $this->render('details');
        } else {
            $this->set('error', true);
        }
    }

    /**
     * Makes a new set and sends emails makes set code
     * @return type
     */
    public function newSet(){
        $this->set('names', $this->Chemist->find('list', ['fields' => 'name']));
        $this->set('p_names', $this->Project->find('list' , ['fields' => 'short_name']));
        // TODO test this should set the values in the form
        if (isset($this->request->data['id'])){
            $this->set('SampleSet', $this->SampleSet->find('list', ['id' => $this->request->data['id']]));
        }
        $this->set('SampleSets', $this->SampleSet->find('list', [
            'conditions' => ['id' => 5],
            'fields' => ['SampleSet.p_name']
        ]));
        // end test
        if (isset($this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'])){
            $this->set('user', $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']);
        }
    }
    
    /**
     * Updates a sample set
     * @param type $id
     * @return type
     * @throws NotFoundExcpetion
     */
    public function editSet($id = null){
        //if (isset($this->request->data['SampleSet']['id'])){ //updates the id to the provious one when editing twice
            //$id = $this->request->data['SampleSet']['id'];
        //}
        $this->layout = 'main';
        $data = $this->request->data;        
        if ($id == null){
            $id = $this->params['url']['id'];
        } // gets $id from the url
        if (!$id){
            throw new NotFoundExcpetion(__('Invalid Sample Set'));
        } //makes sure that the id is set
        $set = $this->SampleSet->findById($id);

        if (!$set){
            throw new NotFoundExcpetion(__('Invalid Sample Set'));
        } //makes sure that the set exists                
        $this->set('versions', $this->SampleSet->find('allVersions', ['conditions' => ['set_code' => $set['SampleSet']['set_code']]])); 
        //sets all the versions so that the view can display them
        $this->set('set_code', $set['SampleSet']['set_code']); //sets the setcode for the sample set this means that the view can pass it back
        if (isset($this->request->data['SampleSet'])){
            $this->request->data['SampleSet']['version'] = $set['SampleSet']['version'] + 1; 
            //makes a new version with a version number 1 greater than the current highest version number
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
     * The Controller function for viewing the sample sets
     * this bassically adds the derived data from the analysis to the view
     * @param type $id
     * @throws NotFoundExcpetion
     * Old function no longer used, but retained because it is an example of how to find the most recent version of the Sample Set
     */
    public function viewSet($id = null){
        $id = 363;
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
     * The Controller function for viewing the sample set information
     * and accessing the uploaded files.
     * Sample Set data is found using the ID and uploaded files specified in the Analysis tabs are added to the view.
     * @param type $id
     */
    public function details($id = null) {
        $data = $this->request->data;        
        if ($id == null){
            $id = $this->params['url']['id'];
        } // gets $id from the url
        if (empty($id)) {
            $this->set('error', 'Invalid Sample Set');
            return;
        }
        $sampleSet = $this->SampleSet->findById($id); 
        if (empty($sampleSet)) {
            $this->set('error', 'Sample Set not found');
            return;
        }

        $this->set('info', $sampleSet);
        $this->view = 'view_set';
    }

    /**
     * Creates and exports a CSV file from a search
     * @param type $data
     */
    public function export(){
        $query = $this->Search->build_query($this->SampleSet, $this->request->query);
        $search_results = $this->SampleSet->find('all', ['conditions' => $query]);
        $this->set('data', $search_results);
        $this->response->download("export_samplesets.csv");
        $this->layout = 'ajax';
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

//    public function search() {
//        $this->set('criteria_options', [
//            ['value' => 'set_code', 'text' => 'Set Code'],
//            ['value' => 'all', 'text' => 'All'],
//            ['value' => 'submitter', 'text' => 'PFR Collaborator'],
//            ['value' => 'chemist', 'text' => 'Chemist'],
//            ['value' => 'p_name', 'text' => 'Project Name'],
//            ['value' => 'p_code', 'text' => 'Project Code'],
//            ['value' => 'crop', 'text' => 'Crop'],
//            ['value' => 'compounds', 'text' => 'Compounds'],
//            ['value' => 'comments', 'text' => 'Comments'],
//            ['value' => 'exp_reference', 'text' => 'Experiment Reference'],
//            ['value' => 'team', 'text' => 'Team']]);
//
//        $this->set('title', 'Find Sample Set');
//        $this->doSearch($this, $this->SampleSet);
//    }
}

