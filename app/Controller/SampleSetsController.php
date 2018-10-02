<?php

App::uses('CakeEmail', 'Network/Email');
App::uses('AppController', 'Controller');
App::uses('Searchable', 'Controller/Behavior');
App::uses('Viewable', 'Controller/Behavior');
App::uses('EditableVersions', 'Controller/Behavior');
App::uses('Exportable', 'Controller/Behavior');
App::uses('Importable', 'Controller/Behavior');

class SampleSetsController extends AppController {
    use Searchable;
    use Viewable;
    use EditableVersions;
    use Exportable;
    use Importable;

    public $helpers = ['Html' , 'Form' , 'My' , 'Js', 'Time', 'String', 'BootstrapForm', 'Mustache.Mustache'];
    public $uses = ['Analysis' , 'SampleSet' , 'Chemist', 'Project', 'Crop'];
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
        $this->components = array_merge($this->components, $this->getExportableComponents());
        $this->components = array_merge($this->components, $this->getImportableComponents());
        $this->components = array_unique($this->components);
    }

    protected function getModel() {
        return $this->SampleSet;
    }

    /**
     * stuff that happens before everything
     */
    public function beforeFilter() {
        $this->set('group', 'sampleSets');

        $this->file_URL = Configure::read('live') ? '/app/app/webroot/data/' : 'data/';

        parent::beforeFilter();
        
        //$this->My->isLoggedIn($this->Auth->loggedIn());
        
        if (!$this->Auth->loggedIn()) {
            //echo "loggedOut";
            $this->Session->setFlash('Please SignIn to use Sample Set actions','popup_message');
            $this->redirect(['controller' => 'General', 'action' => 'welcome']);
        }

        //if (isset($this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'])){
        //    $this->SampleSet->username = $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'];
        //} //sets the username of the user to a variable that can be used through out the contoller
        $this->Auth->deny('editSet','newSet'); //deny access to edit and new set by default // 'deny' changed to 'allow' for home testing
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
        $Email->send($options['editor'].' has edited the sample set with set code: '.$options['set_code']. 'Status: '.$options['status']); //sets the message of the email and also sends the email
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

        //sets the date that the sample set was submitted
        $data['SampleSet']['date'] = date('Y-m-d');
        
        //sets the initial status fo the sample set to 'submitted'
        $data['SampleSet']['status'] = 'submitted';

        //sets the email of the user who submitted the sample set
        $data['SampleSet']['submitter_email'] = $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['email'];

        //set up the metaFile name, and uploads to the data/files/samplesets/ folder
        //var_dump($data);
        if(isset($data['SampleSet']['metadataFile']['error']) && $data['SampleSet']['metadataFile']['error']=='0'){
            $newName = $data['SampleSet']['set_code']. '_Metadata_' . time() . '.' . pathinfo($data['SampleSet']['metadataFile']['name'])['extension'];
            $newPath = 'data/files/samplesets/' . $newName;
            $res = move_uploaded_file($data['SampleSet']['metadataFile']['tmp_name'], $newPath);
            
            $data['SampleSet']['metaFile'] = Router::getPaths()['base'] . '/' . $newPath;
            
        }
        unset($data['SampleSet']['metadataFile']);

        $this->SampleSet->create();
        if ($sampleSet = $this->SampleSet->save($data['SampleSet'])){ //saves the sample set
            //if the save was successful then send the emails if not send an error to the view
            $this->send_newSS_email(['from' => 'no_reply@plantandfood.co.nz',
                'to' => $chemist->email,
                'submitter' => $data['SampleSet']['submitter'],
                'set_code' => $data['SampleSet']['set_code']]);
                //sets the values for the email to the analyst
            //if (isset($data['SampleSet']['submitter_email'])) { //send email to submitter if an email address has been set
            //    $this->send_newSS_email(['from' => 'no_reply@plantandfood.co.nz',
            //        'to' =>  $data['SampleSet']['submitter_email'],
            //        'submitter' => $data['SampleSet']['submitter'],
            //        'set_code' => $data['SampleSet']['set_code']]); 
            //        //sets the values for the email to the submitter
            //} /submitter email temporarily disabled 2/10/2018
            $this->set('sampleSet', $data['SampleSet']);
            $this->set('error', false);
            $this->render('create_sample_set');
        } else {
            $this->set('error', true);
        }
    }

    /**
     * Makes a new set and sends emails and makes a new set code
     * @return type
     */
    public function newSet(){
        $this->set('names', $this->Chemist->find('list', ['fields' => 'name']));
        $this->set('p_names', $this->Project->find('list' , ['fields' => 'short_name']));
        $this->set('crop_names', $this->Crop->find('list' , ['fields' => 'crop_name']));
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

    protected function setEditFormRequirements() {
        $this->set('names', $this->Chemist->find('list', ['fields' => 'name']));
        $this->set('p_names', $this->Project->find('list' , ['fields' => 'short_name']));
        $this->set('crops', $this->Crop->find('list' , ['fields' => 'crop_name']));
    }

    protected function doSave($item) {
        //var_dump($item);
        if(isset($item['SampleSet']['metadataFile']['error']) && $item['SampleSet']['metadataFile']['error']=='0'){
            $newName = $item['SampleSet']['set_code']. '_Metadata_' . time() . '.' . pathinfo($item['SampleSet']['metadataFile']['name'])['extension'];
            $newPath = 'data/files/samplesets/' . $newName;
            $res = move_uploaded_file($item['SampleSet']['metadataFile']['tmp_name'], $newPath);

            //echo json_encode(['filename' => Router::getPaths()['base'] . '/' . $newPath]);
            
            $item['SampleSet']['metaFile'] = Router::getPaths()['base'] . '/' . $newPath;
            
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
        
        if(!isset($item['SampleSet']['p_code']) || $item['SampleSet']['p_code']=='') {
            $item['SampleSet']['p_code'] = 'No Project Code supplied';
        } // for older sample sets when p_code has is blank or NULL - set P_code to text so that
        // the record can be saved as p_code is now required.

        unset($item['SampleSet']['id']); //unsets the id so the new version is saved as a new row

        $this->SampleSet->create();
        $newItem = $this->SampleSet->save($item);
        assert($newItem, 'The SampleSet failed to be saved');
        $this->send_editSS_email(['from' => 'no_reply@plantandfood.co.nz',
            'to' => $this->Chemist->find('first', ['fields' => ['Chemist.email'],  'conditions' => ['name' => $item['SampleSet']['chemist']]])['Chemist']['email'],
            'editor' => $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'],
            'status' => $item['SampleSet']['status'],
            'set_code' => $item['SampleSet']['set_code']]);
        if (isset($item['SampleSet']['submitter_email'])){
            $this->send_editSS_email(['from' => 'no_reply@plantandfood.co.nz',
                'to' => $item['SampleSet']['submitter_email'],
                'editor' => $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'],
                'status' => $item['SampleSet']['status'],
                'set_code' => $item['SampleSet']['set_code']]);
        } //send email to the submitter if their email is recorded along with the sample set
        return $newItem['SampleSet']['id'];
    }
}

