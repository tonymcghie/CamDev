<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MetabolitesController extends AppController{
    public $helpers = array('Html' , 'Form' , 'My', 'Js');
    public $uses = array('Metabolite','Msms_Metabolite','Proposed_Metabolite');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'RequestHandler', 'My');
    
    public $paginate = array(
        'limit' => 2,
        'order' => array(
            'Metabolite.exact_mass' => 'asc'
        ));
    
    /**
     * Happens before stuff is called
     * by default deny accesss to all functions
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->deny('addMetabolite','editMetabolite','editProposedMetabolite','editMsmsMetabolite');
    }
    
    /**
     * Returns weather the user is authorised to access the page
     * @param type $user
     * @return type
     */
    public function isAuthorized($user) {
        return $this->My->isAuthorizedMetabolite($user, $this);
    }

    /**
     * adds a meatbolite
     * @return null
     */
    public function addMetabolite(){
        if (isset($this->params['url']['isTablet']) && $this->params['url']['isTablet']==='true'){
            $this->autoRender = false;
            $this->set('tabletView', 'true');
            $this->layout= 'TabletLayout';
            $this->render('add_metabolite_tablet');
        } else {
            $this->set('tabletView', 'false');
            $this->autoRender = true;
        } //sets the view (tablet or not tablet)
        
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
     * updates a row in the metabolite table
     * @param String $id
     */
    public function editMetabolite($id = null){
        $this->save($this->Metabolite, $id);        
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
     * Search the metabolites
     * @param array $data
     * @return null
     */
    public function searchMetabolite($data = null){   
        if ($data!=null&&!isset($this->request->data['Metabolite'])){ //if the data passed is through the url rather than post then set the data variable to the data passed from the url
            parse_str($data);
            $this->request->data['Metabolite'] = $Metabolite;
        }
        if (!isset($this->request->data['Metabolite'])){ //if data == null and request->data ==null
            return;
        }
        $this->paginate = array(
        'limit' => 20,
        'order' => array('Metabolite.exact_mass' => 'asc'));     //sets up the pagination options
        
        $this->request->data['Metabolite']['num_boxes'] = (isset($this->request->data['Metabolite']['num_boxes']) ? $this->request->data['Metabolite']['num_boxes'] : 1); //sets boxnum to 1 if its not already set
        $this->set('box_nums',$this->request->data['Metabolite']['num_boxes']);  //passes the box num to the view 
        if ($this->request->data['Metabolite']['isDate']==='1'){ //checks if there is a date to search on
            $this->request->data['Metabolite']['start_date'] = $this->request->data['Metabolite']['start_date']['year'].'-'.$this->request->data['Metabolite']['start_date']['month'].'-'.$this->request->data['Metabolite']['start_date']['day'];//makes date in  format where sql can compare time helper
            $this->request->data['Metabolite']['end_date'] = $this->request->data['Metabolite']['end_date']['year'].'-'.$this->request->data['Metabolite']['end_date']['month'].'-'.$this->request->data['Metabolite']['end_date']['day'];
        }
        //gets the criteria for the search
        $search = $this->My->extractSearchTerm($this->request->data, ['exact_mass', 'experiment_ref', 'sources', 'tissue', 'chemist'], 'Metabolite');        
        $results = $this->paginate('Metabolite', $search); //search for the data for the page
        $this->set('num', $this->Metabolite->find('count', ['conditions' =>$search]));// finds the num of results
        $this->set('results' ,$results); //sends the reuslts to the page  
        $this->set('data', $this->request->data); //sends all the data(search criteria) to the view so it can be added to the ajax links               
    }
    
    /**
     * Passes values the view to display them
     * @param String $id
     */
    public function viewMetabolite($id = null){
        if ($id==null){echo "Metabolite is not found";}
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
}