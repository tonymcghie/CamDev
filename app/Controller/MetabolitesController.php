<?php

App::uses('Searchable', 'Controller/Behavior');
App::uses('Viewable', 'Controller/Behavior');
App::uses('Exportable', 'Controller/Behavior');

class MetabolitesController extends AppController {
    use Searchable;
    use Viewable;
    use Exportable;

    public $helpers = ['Html' , 'Form' , 'My' , 'Js', 'Time', 'String', 'BootstrapForm', 'Mustache.Mustache'];
    public $uses = ['Metabolite','Msms_Metabolite','Proposed_Metabolite', 'Chemist'];
    public $layout = 'PageLayout';
    public $components = ['RequestHandler', 'My', 'Session', 'Cookie', 'Auth', 'File', 'Search'];

    public $paginate = [
        'limit' => 50,
        'order' => [
            'Metabolite.exact_mass' => 'asc'
        ]
    ];

    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
        $this->components = array_merge($this->components, $this->getSearchableComponents());
        $this->components = array_merge($this->components, $this->getExportableComponents());
        $this->components = array_unique($this->components);
    }
    
    /**
     * Happens before stuff is called
     * by default deny accesss to all functions
     */
    public function beforeFilter() {
        parent::beforeFilter();


        $this->set('group', 'unknownCompounds');
        //$this->Auth->deny('addMetabolite','editMetabolite','editProposedMetabolite','editMsmsMetabolite');
        $this->Auth->allow('addMetabolite','editMetabolite','editProposedMetabolite','editMsmsMetabolite');
    }
    
    /**
     * Returns weather the user is authorised to access the page
     * @param type $user
     * @return type
     */
    //public function isAuthorized($user) {
        //return $this->My->isAuthorizedMetabolite($user, $this); //removed to stop login popup appearing
    //}

    /**
     * adds a Metabolite
     * @return null
     */
    public function newMetabolite(){
        $this->layout = 'PageLayout';
        $this->set('names', $this->Chemist->find('list', ['fields' => 'name']));
        if (isset($this->request->data['Metabolite'])){ //check if the save button has being clicked
            $data = $this->request->data;      //gets the data
            $this->Metabolite->create();            //Need to add
            if ($this->Metabolite->save($data)){                 //saves the Compound
                return $this->redirect(['controller' => 'General', 'action' => 'welcome', '?' => ['alert' => 'Unknown Compound Saved']]);
            }
        } else if (isset($this->request->data['Proposed_Metabolite'])){
            $data = $this->request->data;      //gets the data
            $this->Proposed_Metabolite->create();            //Need to add
            if ($this->Proposed_Metabolite->save($data)){                 //saves the Compound
                return $this->redirect(['controller' => 'General', 'action' => 'welcome', '?' => ['alert' => 'Proposed Unknown Compound Saved']]);
            }
        } else if (isset($this->request->data['Msms_Metabolite'])){
            $data = $this->request->data;      //gets the data
            $this->Msms_Metabolite->create();            //Need to add
            if ($this->Msms_Metabolite->save($data)){                 //saves the Compound
                return $this->redirect(['controller' => 'General', 'action' => 'welcome', '?' => ['alert' => 'Msms Unknown Compound Saved']]);
            }
        } //adds which ever one was pressed
    }
    
    /**
     * saves a new Unknown Compound (metabolite) to the database
     * @return null
     */
    public function createMetabolite(){         
        $data = $this->request->data;      //gets the data
        
        //sets the date that the sample set was submitted
        $data['Metabolite']['date'] = date('Y-m-d');
        
        $this->Metabolite->create();            //Need to add
        if ($this->Metabolite->save($data)){                 //saves the new Unknown Compound
            return $this->redirect(['controller' => 'General', 'action' => 'welcome', '?' => ['alert' => 'Unknown Compound Saved']]);
        }
    }
    
    /**
     * adds a new proposed to an Unknown Compound (Metabolite)
     * @return null
     */
    public function addProposedid($id = null){
        if ($id == null){
            $id = $this->params['url']['id'];
        } // gets $id from the url
        if (empty($id)) {
            $this->set('error', 'Invalid Unknown');
            return;
        }
        //var_dump($id);
        $this->set('id', $id);
        $data = $this->request->data;      //gets the data
        $this->Proposed_Metabolite->create();            //Need to add
        if ($this->Proposed_Metabolite->save($data)){                 //saves the Compound
            return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'Proposed Unknown Compound Saved']]);
        }
    }
    
    /**
     * adds a new msms spectrum to an Unknown Compound (Metabolite)
     * @return null
     */
    public function addMsms(){         
        $data = $this->request->data;      //gets the data
        $this->Msms_Metabolite->create();            //Need to add
        if ($this->Msms_Metabolite->save($data)){                 //saves the Compound
            return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'Proposed Unknown Compound Saved']]);
        }
    }
    
    /**
     * updates a row in the metabolite table
     * @param String $id
     */
    public function editMetabolite($id = null){
        if ($id == null){
            $id = $this->params['url']['id'];
        } // gets $id from the url
        if (empty($id)) {
            $this->set('error', 'Invalid Unknown');
            return;
        }
        $metabolite = $this->Metabolite->findById($id);
        if (!$metabolite){
            throw new NotFoundExcpetion(__('Invalid Unknown Compound'));
        } //throw error if the id does not belong to a compound
        if ($this->request->is(array('post', 'put'))){ //gets edited data from the view
            $this->Metabolite->id = $id;
            if ($this->Metabolite->save($this->request->data)){
                return;
            } //return if saved successfully
        } //save data if the form is being submitted
        if (!$this->request->data){
           $this->request->data = $metabolite;
        }//update the data to display
    }
    
    /**
     * updates a row in the Proposed Metabolite table
     * @param String $id
     */
    public function editProposedMetabolite($id = null){
        $this->save($this->Proposed_Metabolite, $id);
    }
    
    /**
     * updates a row in the msms table
     * @param type $id
     */
    public function editMsmsMetabolite($id = null){
        $this->save($this->Msms_Metabolite, $id);
    }
    
    /**
     * Saves the data from the form
     * @param type $model
     * @param type $id
     * @return type
     * @throws NotFoundExcpetion
     */
    protected function save($model,$id = null){
        if (!$id){echo "SomeThing went wrong please try again";} //error hadeling
        $set = $model->findById($id); //finds the Metabolite to change
        if (!$set){echo "SomeThing went wrong please try again";}  //error hadeling  
        if ($this->request->is(array('post', 'put'))){
            $model->id = $id;
            if ($model->save($this->request->data)){
                return;
            }
        }
        if (!$this->request->data){
            $this->request->data = $set;
        }     
    }
    
    /**
     * Passes values the view to display them
     * @param String $id
     */
    public function viewMetabolite($id = null){
        if ($id == null){
            $id = $this->params['url']['id'];
        } // gets $id from the url
        if (empty($id)) {
            $this->set('error', 'Invalid Unknown');
            return;
        }
        $meta = $this->Metabolite->find('first', ['conditions' => ['id' => $id]]);
        $msms = $this->Msms_Metabolite->find('all' , ['conditions' => ['metabolite_id' => $id]]);
        $proposed = $this->Proposed_Metabolite->find('all' , ['conditions' => ['metabolite_id' => $id]]);
        $this->set('meta', $meta);
        $this->set('msms', $msms);
        $this->set('proposed' , $proposed);
    }

    function getModel() {
        return $this->Metabolite;
    }
    
    public function docsMetabolite($id = null){
        if ($id == null){
            $id = $this->params['url']['id'];            
        } // gets $id from the url
        
        if (empty($id)) {
            $this->set('error', 'Invalid Unknown');
            return;
        }
        $metabolite = $this->Metabolite->findById($id);
        //var_dump($metabolite);
        if (!$metabolite){
            throw new NotFoundExcpetion(__('Invalid Unknown Compound'));
        } //throw error if the id does not belong to a compound
        //var_dump($metabolite);
        $this->set('metabolite', $metabolite);
        
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->data;
            //var_dump($data);
            //var_dump($id);
            if ($this->request->data){
                $metabolite['Metabolite']['document'] = $data['Document']['document'];
                $this->Metabolite->id=$metabolite['Metabolite']['id']; //sets the record to save by ID
                $this->Metabolite->save($metabolite);    //saves the updated metabolite metadata (document), which now includes the filename
                $this->redirect(['controller' => 'Metabolites', 'action' => 'search']);
            }  //if a file has been selected and the Save button clicked update $metabolite['Metabolite']['document'] and save the record
            
        }
        
        if (!$this->request->data){
           $this->request->data = $metabolite;
        } //update filename to the view
        
    /**           
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->data;
            $set_code = $data['Analysis']['set_code'];
            $id = $data['Analysis']['id'];

            $this->Analysis->id = $data['Analysis']['id'];
            $this->Analysis->save($data);
        }
        
        
        $meta['Metabolite']['document'] = $filename;
        //var_dump($meta);
        $this->Metabolite->id=$metabolite['Metabolite']['id']; //sets the record to save by ID
        $this->Metabolite->save($metabolite);    //saves the updated metabolite metadata (document), which now includes the filename
        
    */    
    /**    
        $filename = '';
        $uploadFile = $this->request->params['form']['document_file'];
        var_dump($uploadFile);
        var_dump($this->request->params);
        
        //$filename = basename($uploadData['name']); // gets the base name of the uploaded file
        $newName = pathinfo($uploadFile['name'])['extension'];
        $filename = 'Unknown_'.$id.'_'.$newName;
        $newPath = 'data/files/unknowns/' . $newName;
        var_dump($filename);
    */   
    }
    
    public function uploadDocument($id) {
        $this->layout = 'ajax';  //nothing visiable on screen
        $this->autoRender = false;
        $uploadedDocument = $this->request->params['form']['document_file'];
        //$id = $this->request->$metabolite['Metabolite']['id'];
        //$id = '30';
        
        if ($uploadedDocument['error'] != 0) {
            $this->response->statusCode(418);
            $this->response->send();
            return;
        }

        $newName = 'Unknown_' . $id . '_document' . '.' . pathinfo($uploadedDocument['name'])['extension'];
        $newPath = 'data/files/unknowns/' . $newName;
        $res = move_uploaded_file($uploadedDocument['tmp_name'], $newPath);

        echo json_encode(['filename' => Router::getPaths()['base'] . '/' . $newPath]);
    }
    
    /**
     * attaches a document to an Unknown Compounds and uploads to Powerplant
     * @param type $id
     
    public function docsMetabolite($id = null){
        if ($id == null){
            $id = $this->params['url']['id'];
        } // gets $id from the url
        if (empty($id)) {
            $this->set('error', 'Invalid Unknown');
            return;
        }
        $meta = $this->Metabolite->findById($id);
        if (!$meta){
            throw new NotFoundExcpetion(__('Invalid Unknown Compound'));
        } //throw error if the id does not belong to a compound
        //$meta = $this->Metabolite->find('first', ['conditions' => ['id' => $id]]);
        //var_dump($meta);
        $msms = $this->Msms_Metabolite->find('all' , ['conditions' => ['metabolite_id' => $id]]);
        $proposed = $this->Proposed_Metabolite->find('all' , ['conditions' => ['metabolite_id' => $id]]);
        $this->set('meta', $meta);
        $this->set('msms', $msms);
        $this->set('proposed' , $proposed);
        
        $filename = '';
        if ($this->request->is('post')) { // checks for the post values
            $uploadData = $this->data['Upload']['doc_path'];
            //var_dump($this->data);
            //var_dump($meta);
            if ( $uploadData['size'] == 0 || $uploadData['error'] !== 0) { // checks for the errors and size of the uploaded file
                return false;
                }
            $filename = basename($uploadData['name']); // gets the base name of the uploaded file
            $filename = 'Unknown_'.$id.'_'.$filename;
            $uploadFolder = WWW_ROOT. 'data/files/unknowns';  // path where the uploaded file has to be saved
            //var_dump($uploadFolder);
            $uploadPath =  $uploadFolder . DS . $filename;
            if( !file_exists($uploadFolder) ){
                mkdir($uploadFolder); // creates folder if  not found
            }
            if (!move_uploaded_file($uploadData['tmp_name'], $uploadPath)) {
                return false;
            }
        $meta['Metabolite']['document'] = $filename;
        //var_dump($meta);
        $this->Metabolite->id=$meta['Metabolite']['id']; //sets the record to save by ID
        $this->Metabolite->save($meta);    //saves the updated metabolite metadata, which now includes the filename
        }
    }*/
}