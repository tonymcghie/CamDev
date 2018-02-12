<?php

App::uses('ConnectionManager', 'Model');
App::uses('Searchable', 'Controller/Behavior');
App::uses('Viewable', 'Controller/Behavior');
App::uses('Exportable', 'Controller/Behavior');
App::uses('Importable', 'Controller/Behavior');
App::uses('Overviewable', 'Controller/Behavior');

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class MolecularFeaturesController extends AppController{
    use Searchable;
    use Viewable;
    use Exportable;
    use Importable;
    use Overviewable;
    
    public $helpers = ['Html' , 'Form' , 'My', 'Js', 'Time', 'String', 'BootstrapForm', 'Mustache.Mustache'];
    public $uses = ['Molecular_feature','PubChemModel', 'Compound'];
    public $layout = 'PageLayout';
    public $components = ['My', 'Pivot', 'RequestHandler', 'Session', 'Cookie', 'Auth', 'File', 'Search'];
    
    //sets the values for the pagination
    public $paginate = [
        'limit' => 100,
        'order' => [
            'Molecular_feature.sample_reference' => 'asc'
        ]
    ]; 
    
     public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
         parent::__construct($request, $response);
         $this->components = array_merge($this->components, $this->getSearchableComponents());
         $this->components = array_merge($this->components, $this->getExportableComponents());
         $this->components = array_merge($this->components, $this->getImportableComponents());
         $this->components = array_unique($this->components);
    }
        
    /*
     *  @LIVE swap file url 
     */
    //private $file_URL = '/app/app/webroot/data/'; //Live
    private $file_URL = 'data/';  //testing


    public function beforeFilter() {
        parent::beforeFilter();
        $this->set('group', 'metabolomicData');
    }
    
    /**
     * returns weather the the user is authorised to access the functions
     * @param type $user
     * @return type
     */
    public function isAuthorized($user) {
        return $this->My->isAuthorizedPFRData($user, $this);
    }
    
    function getModel() {
        return $this->Molecular_feature;
    }
    
    /**
     * Entry point for Metabolomic Data -> Find
     * Control transfers to the find_data view and onto to /Elements/search_form
     * and then back to the search() function below.
     * Search results are displayed as a modal as defined by /Elements/results table 
     */
    public function findData($data = null){   
        
    } 
    
    /**
    public function search(){
        $data = $this->request->data;
        $this->layout = 'ajax';
        $this->autoRender = false;
        $this->paginate = [
            'limit' => 100,
            'order' => array('Molecular_feature.date' => 'asc')
        ];
        // Listed these here for auto complete reasons and to stop the IDE displaying errors
        $criteria = null;$value = null;$logic = null;$match = null;
        extract($this->request->data['Molecular_feature']);
        $query = $this->Search->build_query($this->Molecular_feature, $criteria, $value, $logic, $match);
        $results = $this->paginate('Molecular_feature', $query);
        
        $resultObjects = $this->Molecular_feature->buildObjects($results);
        $this->set('cols', $this->Molecular_feature->getDisplayColumns());
        $this->set('num', $this->Molecular_feature->find('count', ['conditions' => $query])); //passes the number of results to the view
        $this->set('results', $resultObjects);
        
        $this->set('model', 'Molecular_feature');
        $this->set('data', $data); //pass the search parameters to view so that is can get passed back to controller for action=>export
        $this->render('/Elements/search_results_modal');

    }
    */

    /**
     * this has graphs the data sinces everything is hadled through ajax and javascript it is empty
     * @param type $data
     */
    public function graphData($data = null){        
        
    }
    /**
     * shows all the field entries for a selected record in the Molecular_features table
     *
     */
	public function viewData($id = null) {
		$data = $this->Molecular_feature->findById($id); //if the id is passed then find on that
        if (!$data){ //if the set does not exist
            throw new NotFoundExcpetion(__('Invalid Data Record'));
        } //if the sample set with that id exists
        $this->set('info', $data);// passes the set to the page
	}

    /**
     * this is the Ajax function for getting the data from the graphing search routine
     * it returns the data in a Json formated string
     */
    public function getData(){  
        $this->autoRender=false; //tells Cake no to render the page as only the Json string should be rendered
        $this->layout = 'ajax'; 
        
        $data = ['Compoundpfr_data' => []];
        $count = 0;
        foreach ($this->request->data['info'] as $pair){
            $data['Compoundpfr_data']['cri_'.$count] = $pair['cri'];
            $data['Compoundpfr_data']['val_'.$count] = $pair['val'];
            $data['Compoundpfr_data']['log_'.$count] = $pair['log'];
            $data['Compoundpfr_data']['match_'.$count] = $pair['match'];
            $count++;
        } //adds the search criteia value and logic to an array in the same structure as if it came from a form
        $options = $this->request->data['options']; // contains the options such as the pivot
        //gets the criteria for the search
        $search = $this->My->extractSearchTerm($data, ['assigned_name', 'assigned_confid', 'exact_mass', 'intensity_description', 'reference', 'sample_ref', 'crop', 'species', 'tissue', 'genotype', 'analyst'], 'Compoundpfr_data');               
        $search = $this->addPsu($data, $search); //adds psydonims from compund table to the search in OR array
        $data = $this->Compoundpfr_data->find('all', ['conditions' => $search]); //finds the data 
        //return;
        if ($options['pivot']!='none'){
            $results = $this->Pivot->FormatGraphData($data, $options['pivot'], 'intensity_value', 'Compoundpfr_data');
        } else {
            $results = $this->My->resultsToGraph($data, 'Compoundpfr_data', $options['xAxis'], $options['yAxis']);
        } //if there is a pivot set then pivot the data if not format the data into a format friendlier to the google charts API
        echo json_encode($results); //echos the Json string back to the ajax call
    }
    
    /**
     * Entry point for CompoundspfrData -> overview
     * Control transfers to the overview_data view and onto to /Elements/overview_form
     * and then back to the overview() function below.
     * Search results are displayed as a modal as defined by /Elements/results table
     */
    
    public function overviewData(){
        
    }
    
    /**
     * Enables the user to obtain a summary review of the data in the CompoundPFR data table.  This is a large table and this tool is useful 
     * for getting an overview of the data in the table 
     *
    public function overview(){
        $this->layout = 'ajax';
        //$this->autoRender = false;
        // Listed these here for auto complete reasons and to stop the IDE displaying errors
        $by = null;$value = null;$match = null;$for = null; $review_options=null;
        extract($this->request->data['molecular_features']);
        if ($match == 'contains')$review_by_value = '%'.$value.'%';
        if ($match == 'exact')$review_by_value = $value;
        if ($match == 'starts')$review_by_value = $value.'%';
        //pr($review_by_value);
        $query = "SELECT DISTINCT {$for} "
                . "FROM cam_data.molecular_features as Molecular_feature"
                . " WHERE {$by} LIKE '{$review_by_value}';";
        //var_dump($query);
        //$db_name = ConnectionManager::getDataSource('default')->config['database'];
        $results = $this->Molecular_feature->query("SELECT DISTINCT {$for} "
                . "FROM cam_data.molecular_features as Molecular_feature"
                . " WHERE {$by} LIKE '{$review_by_value}';");
        //var_dump($results);        
        //send everything to the view and display as a modal            
        $this->set('results', $results);
        $this->set('for', $for);
        $this->set('value', $value);
        $this->set('by', $by);
        $this->set('model', 'Molecular_feature');
        $this->render('/Elements/overview_results_modal');    
    }*/
}
