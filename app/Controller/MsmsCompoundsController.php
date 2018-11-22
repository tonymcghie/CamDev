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
     * Add a new msms for the selected compound
     * Called from CompoundDataObject.php
     * @param type $id
     * @return type
     * @throws NotFoundExcpetion
     */
    
    public function MsmsCompoundTabs($compound_name = null, $compound_id = null){
        if ($compound_id == null){
            $compound_id = isset($this->request->query['compound_id']) ? $this->request->query['compound_id'] : $this->request->data['Msms_compound']['compound_id'];
        } // gets $compound_id from the url
        //var_dump('compound_id');
        $this->set('compound_id', $compound_id);
        $titles = $this->Msms_compound->find('all', ['conditions' => ['compound_id' => $compound_id], 'fields' => ['Msms_compound.id', 'Msms_compound.msms_title']]);
        $this->set('titles', $titles);
        if ($this->request->is('post')) {
            $this->Msms_compound->create();
            $this->Msms_compound->save($this->request->data);
            $newId = $this->Msms_compound->id;
            $this->redirect(['controller' => 'MsmsCompounds',
                'action' => 'editMsmsCompound',
                '?' => ['compound_id' => $compound_id, 'id' => $newId]]);
        }
        $this->render('edit_msms_compound');
    }
    
    public function newMsmsCompound($compound_name = null, $compound_id = null, $currentMsms = null){
        // get the compound_id from the url
        $compound_id = $this->request->query['compound_id'];
        // initialise the basic msms data
        $compound = $this->Compound->findById($compound_id);
        $data['Msms_compound']['compound_name'] = $compound['Compound']['compound_name'];
        $data['Msms_compound']['cas'] = $compound['Compound']['cas'];
        $data['Msms_compound']['compound_id'] = $compound_id;
        $data['Msms_compound']['msms_title'] = "New Title ...";
        $this->set('compound', $compound_id);
        $this->set('currentMsms', $data);
        $this->Msms_compound->create();
        $this->Msms_compound->save($data);
        $newId = $this->Msms_compound->id;
        $this->redirect(['controller' => 'MsmsCompounds', 'action' => 'editMsmsCompound', '?' => ['compound_id' => $compound_id, 'id' => $newId]]);          
    }
    
    /**
     * Called when the save button is clicked on an msms entry already exists for the compound. 
     * Msms data can be edited and saved to the database
     */
    public function editMsmsCompound() {
        //get the compound_id and send to View
        //var_dump($this->request->params);
        //$compound_id = $this->request->params['url']['compound_id'];
        $compound_id = $this->request->query['compound_id'];
        if (!isset($compound_id)) {
            throw new Exception('the compound_id parameter was not passed');
        }
        $this->set('compound_id', $compound_id);
        //get the id and send to View
        //$id = $this->request->params['url']['id'];
        $id = $this->request->query['id'];
        //var_dump($id);
        if (empty($id)) {
            $msms_data = $this->Msms_compound->find('first', ['conditions' => ['compound_id' => $compound_id]]);
            //var_dump($msms_data);
            //if (!empty($msms_data['Msms_compound']['id'])) {
                $id = $msms_data['Msms_compound']['id'];
            //} else {
            //    $id = 0;
            //}
            //if the id is not obtained from the url, find the first id from Msms_compound
        }
        $this->set('id', $id);
        //get the compound data and send to View
        $compound = $this->Compound->findById($compound_id);
        $this->set('compound', $compound);
        
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->data;
            $id = $data['Msms_compound']['id'];
            if (!isset($data['Msms_compound']['id'])) {
                 $this->Msms_compound->create();
                 // if id not set then create a new record in Msms_compound
            } else {
                $this->Msms_compound->id = $data['Msms_compound']['id'];
                //else if id exists update the  record
            }
            $this->Msms_compound->save($data);    
        }
        
        if ((isset($compound_id)) && (isset($id))) {
            $msms = $this->Msms_compound->find('first', ['conditions' => ['id' => $id]]);
            //there are msms data for this compound, find and set the first msms to the active
        } else if ((isset($compound_id)) && (empty($id))) {
            //there are no current msms data for this compound; therefore set $msms to NULL.
            $msms = NULL;
        }
        // added for debugging
        if ($this->Msms_compound->find('first', ['conditions' => ['id' => $id]])) {
            $new = 'a msms exists';
        } else {
            $new = 'msms does not exist';
        }
        $this->set('new', $new);
        //
        
        $titles = $this->Msms_compound->find('all', ['conditions' => ['compound_id' => $compound_id], 'fields' => ['Msms_compound.id', 'Msms_compound.msms_title']]);
        $this->set('titles', $titles);
        $this->set('currentMsms', $msms);
    }
    
    
    /**
     * Adds a new msms for the selected compound
     * @param type $id
     * @return type
     * @throws NotFoundExcpetion
     * This is a development and probably will be removed once the tabbed version
     * is working okay.
     */
    public function addMsmsCompound($id = null){
        //$this->layout = 'main';
        if ($id == null){
            $id = $this->request->params['url']['id'];
        } // gets $id from the url
        $compound = $this->Compound->findById($id);
        $this->set('compound', $this->Compound->findById($id));
        if (!$compound){
            throw new NotFoundExcpetion(__('Invalid Compound'));
        } //throw error if there is no compound for this id
        $this->set('compound', $this->Compound->findById($id));

        //if (isset($this->request->data['Msms_compound'])){ //check if the save button has being clicked 
            //$data = $this->request->data;      //gets the data
            //var_dump($data);
            //$this->Msms_compound->create();    //setup to add new record
            //if ($this->Project->save($data)){  //saves the msms compound data
                //return $this->redirect(['controller' => 'General', 'action' => 'welcome']);
            //}
        //} 
        //if ($this->request->is(array('post', 'put'))){ //gets edited data from the view
            //$data = $this->request->data; //gets the data
            //var_dump($data);
            //$this->Compound->id = $id;
            //if ($this->Compound->save($this->request->data)){
                //$this->redirect(['controller' => 'Compounds', 'action' => 'search']);
                //echo "<script>window.close();</script>";
            //} //if saved successfully redirect to Compounds->search

        //} //save data if the form is being submitted
        //if (!$this->request->data){
           //$this->request->data = $compound;
       //}//update the data to display
    }
    
    public function saveMsmsCompound($id = null){
        if (isset($this->request->data['Msms_compound'])){ //check if the save button has being clicked 
            $data = $this->request->data;      //gets the data
            if (!isset($data['Msms_compound']['id'])) {
                 $this->Msms_compound->create();
                 // if id not set then create a new record in Msms_compound
            } else {
                $this->Msms_compound->id = $data['Msms_compound']['id'];
                //else if id exists update the  record
            }
            //$this->Msms_compound->create();    //setup to add new record
            if ($this->Msms_compound->save($data)){  //saves the msms compound data
                //return $this->redirect(['controller' => 'General', 'action' => 'welcome']);
            }
        }
        $this->render(false);
    }
    
    /**
     * Edit a compound
     * @param type $id
     * @return type
     * @throws NotFoundExcpetion
     */
    /**public function editMsmsCompound($id = null){
        
        if ($id == null) {
            $id = $this->request->params['url']['id'];
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
    //}
}

