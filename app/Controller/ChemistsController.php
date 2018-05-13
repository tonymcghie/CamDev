<?php

App::uses('Searchable', 'Controller/Behavior');
App::uses('Viewable', 'Controller/Behavior');
App::uses('Exportable', 'Controller/Behavior');

class ChemistsController extends AppController {
    
    use Searchable;
    use Viewable;
    use Exportable;
    
    public $helpers = array('Html' , 'Form' , 'My', 'Js', 'Time', 'String', 'BootstrapForm', 'Html' , 'Mustache.Mustache');
    public $uses = array('Chemist');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'RequestHandler', 'My', 'Session', 'Cookie', 'Auth', 'File', 'Search');
    
    function getModel() {
        return $this->Chemist;
    }
    
    public $paginate = array(
        'limit' => 20,
        'order' => array(
            'Chemist.name' => 'asc'
        ));
    
    
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
        $this->set('group', 'admin');
        parent::beforeFilter();
        //$this->Auth->deny('addMetabolite','editMetabolite','editProposedMetabolite','editMsmsMetabolite');
        $this->Auth->allow('newAnalyst','addMetabolite');
        $this->set('group', 'tools');
    }
    
    /**
     * Returns weather the user is authorized to access the page
     * @param type $user
     * @return type
     */
    //public function isAuthorized($user) {
        //return $this->My->isAuthorizedMetabolite($user, $this); //removed to stop login popup appearing
    //}

    /**
     * adds a new Analyst to the Chemists table
     * @return null
     */
    public function newAnalyst(){
        if (isset($this->request->data['Chemist'])){ //check if the save button has being clicked            
            $data = $this->request->data;      //gets the data
            var_dump($data);
            $this->Chemist->create();            //Need to add
            if ($this->Chemist->save($data)){                 //saves the new Analyst
                return $this->redirect(['controller' => 'General', 'action' => 'welcome']);
            }
        } 
    }
    
    /**
     * Edit an existing Analyst and saves the results to the Chemists table
     * @param type $id
     * @return type
     * @throws NotFoundExcpetion
     */
    public function editAnalyst($id = null){
        if ($id == null){
            $id = $this->params['url']['id'];
        } // gets $id from the url
        $analyst = $this->Chemist->findById($id);
        if (!$analyst){
            throw new NotFoundExcpetion(__('Invalid Analyst'));
        } //throw error if the id does not belong to an Analyst
        if ($this->request->is(array('post', 'put'))){ //gets edited data from the view
            $this->Chemist->id = $id;
            if ($this->Chemist->save($this->request->data)){
                echo "<script>window.close();</script>";
            } //if saved successfully redirect to Compounds->search
        } //save data if the form is being submitted
        if (!$this->request->data){
           $this->request->data = $analyst;
        }//update the data to display
    }
    
}