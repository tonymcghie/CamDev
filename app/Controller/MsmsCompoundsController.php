<?php

App::uses('Searchable', 'Controller/Behavior');
App::uses('Exportable', 'Controller/Behavior');

class MsmsCompoundsController extends AppController {
    use Searchable;
    use Exportable;

    public $helpers = ['Html' , 'Form' , 'My', 'Js', 'Time', 'String', 'BootstrapForm'];
    public $uses = ['Compound', 'Msms_compound'];
    public $layout = 'PageLayout';
    public $components = ['RequestHandler', 'My', 'Session', 'Cookie', 'Auth', 'File', 'Search'];
    
   /** Sets the options for pagination */
    public $paginate = [
        'limit' => 50,
        'order' => [
            'Compound.compound_name' => 'asc'
        ]
    ];

    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
        $this->components = array_merge($this->components, $this->getSearchableComponents());
        $this->components = array_merge($this->components, $this->getExportableComponents());
        $this->components = array_unique($this->components);
    }

    protected function getModel() {
        return $this->Compound;
    }
    
    /**
     * What to do before functions are called
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('group', 'compounds');
        //$this->Auth->deny('addCompound', 'editCompound'); //deny access from addCompound and editCompound by default
    }
    
    /**
     * Return weather the user is authorized to access the function
     * @param type $user
     * @return type
     */
    public function isAuthorized($user) {
        return $this->My->isAuthorizedCompound($user, $this);
    }

    /**
     * This function adds a Compound to the table
     * @return type
     */
    public function addCompound(){
        if ($this->request->is('post')){ //check if the save button has being clicked            
            $data = $this->request->data; //gets the data
            if ($data['Compound']['cas'] != '' && $this->Compound->find('count', ['conditions' => ['cas' => $data['Compound']['cas']]]) > 0){
                $this->set('alert', 'The compound you entered is already in the database');
                return;
            } //if the cas number already exists then exit
            $this->Compound->create(); //adds the compound
            if ($this->Compound->save($data)){                 //saves the Compound
                return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'Compound Saved']]);
            } //if successful then redirect to blank with a message
        }  //makes sure that the form was submitted
    }
    
    /**
     * Edit a compound
     * @param type $id
     * @return type
     * @throws NotFoundExcpetion
     */
    public function editCompound($id = null){
        //$this->layout = 'main';
        if ($id == null){
            $id = $this->params['url']['id'];
        } // gets $id from the url
        $compound = $this->Compound->findById($id);
        if (!$compound){
            throw new NotFoundExcpetion(__('Invalid Compound'));
        } //throw error if the id does not belong to a compound
        if ($this->request->is(array('post', 'put'))){ //gets edited data from the view
            $this->Compound->id = $id;
            if ($this->Compound->save($this->request->data)){
                //$this->redirect(['controller' => 'Compounds', 'action' => 'search']);
                echo "<script>window.close();</script>";
            } //if saved successfully redirect to Compounds->search
        } //save data if the form is being submitted
        if (!$this->request->data){
           $this->request->data = $compound;
        }//update the data to display
    }
    
    /**
     * Edit a compound
     * @param type $id
     * @return type
     * @throws NotFoundExcpetion
     */
    public function editMsmsCompound($id = null){
        
        if ($id == null) {
            $id = $this->params['url']['id'];
        } // gets $id from the url
        
        $compound = $this->Compound->findById($id);
        if (!$compound){
            throw new NotFoundExcpetion(__('Invalid Compound'));
            //throw error if the id does not belong to a compound
        } else {
            $this->set('compound', $compound);
            // passes the compound info to the view
        }
        
        if ($this->request->is('post')) { //check if the save button has being clicked            
            $data = $this->request->data; //gets the data
        }
        var_dump($data);
        
        $this->Msms_compound->create();
        if ($this->Msms_compound->save($data)) {
            return $this->redirect(['controller' => 'general', 'action' => 'welcome']);
        }  //if save successful then redirect to the welcome screen
        
        /**
        $compound = $this->Compound->findById($id);
        if (!$compound){
            throw new NotFoundExcpetion(__('Invalid Compound'));
        } //throw error if the id does not belong to a compound
        if ($this->request->is(array('post', 'put'))){ //gets edited data from the view
            $this->Compound->id = $id;
            if ($this->Compound->save($this->request->data)){
                //$this->redirect(['controller' => 'Compounds', 'action' => 'search']);
                echo "<script>window.close();</script>";
            } //if saved successfully redirect to Compounds->search
        } //save data if the form is being submitted
        if (!$this->request->data){
           $this->request->data = $compound;
        }//update the data to display
        */
    }
}

