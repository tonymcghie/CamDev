<?php

App::uses('Searchable', 'Controller/Behavior');

class CompoundsController extends AppController {
    use Searchable {
        Searchable::getComponents as public getSearchableComponents;
    }


    public $helpers = ['Html' , 'Form' , 'My', 'Js', 'Time', 'String', 'BootstrapForm'];
    public $uses = ['Compound'];
    public $layout = 'PageLayout';
    public $components = ['RequestHandler', 'My', 'Session', 'Cookie', 'Auth', 'File', 'Search'];
    
   /** Sets the options for pagination */
    public $paginate = array(
        'limit' => 50,
        'order' => array(
            'Compound.compound_name' => 'asc'
        )
    );
    
    /**
     * What to do before funcitons are called
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('group', 'compounds');
        //$this->Auth->deny('addCompound', 'editCompound'); //deny access from addCompound and editCompound by default
    }
    
    /**
     * Return weather the user is authorised to access the function
     * @param type $user
     * @return type
     */
    public function isAuthorized($user) {
        return $this->My->isAuthorizedCompound($user, $this);
    }

    protected function getModel() {
        return $this->Compound;
    }
    
    /**
     * This funciton adds a Compound to the table
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
                return;
            } //return if saved successfully
        } //save data if the form is being submitted
        if (!$this->request->data){
           $this->request->data = $compound;
        }//update the data to display
    }
    
    /**
     * This function contains the code for identifying unknown compounds by accurate mass.
     * 1) a csv file containing accurate masses is read;
     * 2) each mass is conpared with entries in the compound table;
     * 3) successful hits are written into an output file that is sent to Downloads
     */
    public function IdByMass(){
    } 
        
    /**
     * This function displays a message describing the process for identifying unknown compounds by accurate mass
     */
    public function idMass(){
    } 
    
    /**
     * Exports the search results to a CSV file
     * @param type $data
     */
    public function export($datastr = null){

        parse_str($datastr, $data);  //extract search parameters from the url
        $criteria = null;$value = null;$logic = null;$match = null;
        extract($data['Compound']);
        $query = $this->Search->build_query($this->Compound, $criteria, $value, $logic, $match); //build the search query
        $search_results = $this->Compound->find('all', ['conditions' => $query]);  //find the data
        $this->set('data', $search_results); //send data to export view
        $this->response->download("export_compounds.csv"); //download the named csv file
        $this->layout = 'ajax';
    }

    /**
     * This is the function for the substructre search
     */
    public function subSearch(){
        //empty as everything is done through ajax
    }
    
    /**
     * An Ajax function that checks to see of the result is in the database
     */
    public function filterSubStructRes(){
        $this->autoRender=false; //stops the page from rendering as this is ajax so it outputs data
        $this->layout = 'ajax';     //ajax layout is blank
        $CID = $this->request->data['CID']; 
        $comp = $this->Compound->find('first', ['conditions' => ['pub_chem' => $CID], 'fields' => ['Compound.pub_chem', 'Compound.compound_name', 'Compound.exact_mass']]);
        echo json_encode($comp);
    }
    
    /**
     * An Ajax function that checks to see that the CAS number is not already in use
     */
    public function checkCAS(){
        $this->autoRender=false; //stops the page from rendering as this is ajax so it outputs data
        $this->layout = 'ajax';     //ajax layout is blank
        $CAS = $this->request->data['CAS'];
        $num = $this->Compound->find('count', ['conditions' => ['cas' => $CAS]]);        
        if ($num == 0){
            echo 'true';    
        } else {
            echo 'false';
        }//returns true if unique and false if not
    }
    /**
     * A function to get input and compute the amounts of compound required to make a solution of a given concentration
     */
    public function reagentsCompound($id = null) {
        $compound = $this->Compound->findById($id); //find a compound by id
        $this->set('info', $compound);// passes the compound info to the view
    }
}

