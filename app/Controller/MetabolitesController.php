<?php

App::uses('Searchable', 'Controller/Behavior');

class MetabolitesController extends AppController {
    use Searchable {
        Searchable::getComponents as public getSearchableComponents;
    }
    public $helpers = array('Html' , 'Form' , 'My' , 'Js', 'Time', 'String', 'BootstrapForm');
    public $uses = array('Metabolite','Msms_Metabolite','Proposed_Metabolite', 'Chemist');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'RequestHandler', 'My', 'Session', 'Cookie', 'Auth', 'File', 'Search');

    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
        $this->components = array_merge($this->components, $this->getSearchableComponents());
    }
    
    /**
     * Happens before stuff is called
     * by default deny accesss to all functions
     */
    public function beforeFilter() {
        parent::beforeFilter();

        $this->Paginator->settings= [
            'limit'=>50,
            'order' => [
                'Metabolite.exact_mass' => 'asc'
            ]
        ];
        $this->set('group', 'unknowCompounds');
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
    public function addMetabolite(){
        $this->layout = 'PageLayout';
        $this->set('names', $this->Chemist->find('list', ['fields' => 'name']));
        if (isset($this->request->data['Metabolite'])){ //check if the save button has being clicked
            $data = $this->request->data;      //gets the data
            $this->Metabolite->create();            //Need to add
            if ($this->Metabolite->save($data)){                 //saves the Compound
                return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'Unknown Compound Saved']]);
            }
        } else if (isset($this->request->data['Proposed_Metabolite'])){
            $data = $this->request->data;      //gets the data
            $this->Proposed_Metabolite->create();            //Need to add
            if ($this->Proposed_Metabolite->save($data)){                 //saves the Compound
                return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'Proposed Unknown Compound Saved']]);
            }
        } else if (isset($this->request->data['Msms_Metabolite'])){
            $data = $this->request->data;      //gets the data
            $this->Msms_Metabolite->create();            //Need to add
            if ($this->Msms_Metabolite->save($data)){                 //saves the Compound
                return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'Msms Unknown Compound Saved']]);
            }
        } //adds which ever one was pressed
    }
    
    /**
     * saves the unknown metabolite to the database
     * @return null
     */
    public function createMetabolite(){         
        $data = $this->request->data;      //gets the data
        $this->Metabolite->create();            //Need to add
        if ($this->Metabolite->save($data)){                 //saves the Compound
            return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'Unknown Compound Saved']]);
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
        var_dump($id);
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
    
    /**
     * exports a search to a CSV file
     * @param array $data
     */
    public function export($data = null){
        $this->My->exportCSV('Metabolite', $this->Metabolite, $this, ['exact_mass', 'ion_type', 'rt_value', 'rt_description','sources','tissue','chemist','experiment_ref','spectra_uv','spectra_nmr','date'], $data, true);  
    }

    function getModel() {
        return $this->Metabolite;
    }
}