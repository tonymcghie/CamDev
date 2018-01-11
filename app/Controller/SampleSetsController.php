<?php

App::uses('CakeEmail', 'Network/Email');
App::uses('AppController', 'Controller');
App::uses('Searchable', 'Controller/Behavior');
App::uses('Viewable', 'Controller/Behavior');
App::uses('EditableVersions', 'Controller/Behavior');

class SampleSetsController extends AppController {
    use Searchable {
        Searchable::getComponents as public getSearchableComponents;
    }
    use Viewable;
    use EditableVersions;

    public $helpers = ['Html' , 'Form' , 'My' , 'Js', 'Time', 'String', 'BootstrapForm', 'Mustache.Mustache'];
    public $uses = ['Analysis' , 'SampleSet' , 'Chemist', 'Project'];
    public $layout = 'PageLayout';

    public $components = ['RequestHandler', 'My', 'Session', 'Cookie', 'Auth', 'File'];

    public $paginate = [
        'limit' => 20,
        'order' => [
            'SampleSet.date' => 'desc'
        ]
    ];

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

    protected function setEditFormRequirements() {
        $this->set('names', $this->Chemist->find('list', ['fields' => 'name']));
    }

    protected function doSave($item) {
        if(isset($item['SampleSet']['metadataFile']['error']) && $item['SampleSet']['metadataFile']['error']=='0'){
            $item['SampleSet']['metaFile'] = $this->uploadFile(
                $item['SampleSet']['metadataFile'],
                $item['SampleSet']['set_code'].'_Metadata.'.substr(strtolower(strrchr($item['SampleSet']['metadataFile']['name'], '.')), 1)
            );
            unset($item['SampleSet']['metadataFile']);
        }

        $maxVersion = $this->SampleSet->find(
            'all',
                [
                    'fields' => ['SampleSet.version'],
                    'conditions' => ['set_code' => $item['SampleSet']['set_code']]
                ]
        )[0]['SampleSet']['version'];
        $item['SampleSet']['version'] = $maxVersion + 1;

        unset($item['SampleSet']['id']); //unsets the id so the new version is saved as a new row

        $this->SampleSet->create();
        $newItem = $this->SampleSet->save($item);
        assert($newItem, 'The SampleSet failed to be saved');
        $this->send_editSS_email(['from' => 'no_reply@plantandfood.co.nz',
            'to' => $this->Chemist->find('first', ['fields' => ['Chemist.email'],  'conditions' => ['name' => $item['SampleSet']['chemist']]])['Chemist']['email'],
            'editor' => $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'],
            'set_code' => $item['SampleSet']['set_code']]);
        if (isset($item['SampleSet']['submitter_email'])){
            $this->send_editSS_email(['from' => 'no_reply@plantandfood.co.nz',
                'to' => $item['SampleSet']['submitter_email'],
                'editor' => $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'],
                'set_code' => $item['SampleSet']['set_code']]);
        } //send email to the submitter if their email is recoded along with the sample set
        return $newItem['SampleSet']['id'];
    }
}

