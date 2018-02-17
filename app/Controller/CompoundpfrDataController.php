<?php

App::uses('Searchable', 'Controller/Behavior');
App::uses('Viewable', 'Controller/Behavior');
App::uses('Exportable', 'Controller/Behavior');
App::uses('Importable', 'Controller/Behavior');
App::uses('Overviewable', 'Controller/Behavior');

class CompoundpfrDataController extends AppController {
    use Searchable;
    use Viewable;
    use Exportable;
    use Importable;
    use Overviewable;

    public $helpers = ['Html' , 'Form' , 'My', 'Js', 'Time', 'String', 'BootstrapForm', 'Mustache.Mustache'];
    public $uses = ['Compoundpfr_data','PubChemModel', 'Compound'];
    public $layout = 'PageLayout';
    public $components = ['My', 'Pivot', 'RequestHandler', 'Session', 'Cookie', 'Auth', 'File'];
    
    //sets the values for the pagination
    public $paginate = [
        'limit' => 100,
        'order' => [
            'Compoundpfr_data.exact_mass' => 'asc'
        ]
    ];
    
    /*
     *  @LIVE swap file url 
     */
    //private $file_URL = '/app/app/webroot/data/'; //Live
    private $file_URL = 'data/';  //testing

    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
        $this->components = array_merge($this->components, $this->getSearchableComponents());
        $this->components = array_merge($this->components, $this->getExportableComponents());
        $this->components = array_merge($this->components, $this->getImportableComponents());
        $this->components = array_unique($this->components);
    }

    public function beforeFilter() {
        $this->set('group', 'pfrData');
        parent::beforeFilter();
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
        return $this->Compoundpfr_data;
    }
    
    /**
     * this has graphs the data sinces everything is hadled through ajax and javascript it is empty
     * @param type $data
     */
    public function graphData($data = null){        
        
    }
    
    /**
     * Displays all the field entries for a selected record in the CompoundpfrData table
     *
     */
    public function viewData($id = null) {
        $this->layout = 'main';
        $data = $this->request->data;
        if ($id == null){
            $id = $this->params['url']['id'];
        } // gets $id from the url
        if (empty($id)) {
            $this->set('error', 'Invalid Sample Set');
            return;
        }
        $CompoundData = $this->Compoundpfr_data->findById($id);
        if (empty($CompoundData)) {
            $this->set('error', 'Compound data not found');
            return;
        }
        $this->set('info', $CompoundData); //passes the set information to the view and renders
    }
    
    /**
     * Displays the metadata for the Sample Set that the CompoundpfrData record is derived from
     *
     */        
    public function viewSet($reference = null) {
        $data = $this->request->data;
        if ($reference == null){
            $reference = $this->params['url']['reference'];
        } // gets $id from the url
        if (empty($id)) {
            $this->set('error', 'Invalid Sample Set');
            return;
        }
        $SetData = $this->SampleSet->findById($reference); 
        if (empty($SetData)) {
            $this->set('error', 'Sample Set not found');
            return;
        }
        $this->set('info', $SetData); //passes the set information to the view and renders
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
     * This will search the Compounds table with the name supplied and addes any synonims it finds to the conditions array
     * @param type $data (the data that was used to create the old search conditions)
     * @param array $search (old search conditions)
     * @return array (new search conditions)
     */
    private function addPsu($data, $search){
        for($i = 0;isset($data['Compoundpfr_data']['cri_'.$i]);$i++){
            if ($data['Compoundpfr_data']['cri_'.$i] == 'assigned_name'){                
                $name = $data['Compoundpfr_data']['val_'.$i]; //gets the name that pfr data was to be searched on   
                foreach (array_keys($search) as $key){
                    foreach ($search[$key] as &$pair){ 
                        if (key_exists('Compoundpfr_data.assigned_name LIKE', $pair)){
                            unset ($pair['Compoundpfr_data.assigned_name LIKE']);
                        } //removes the values for assinged name from the search array
                    }
                }                
                $compounds = $this->Compound->find('all', [
                    'fields' => ['id' ,'compound_name', 'pseudonyms', 'sys_name'],
                    'conditions' => [
                        'OR' => [
                            'compound_name LIKE' => '%'.$name.'%',
                            'pseudonyms LIKE' => '%'.$name.'%',
                            'sys_name LIKE' => '%'.$name.'%']]]); //finds the sysnonims of any matches of the name    
                $array = array();
                array_push($array, ['assigned_name LIKE' => '%'.$name.'%']);
                foreach($compounds as $row){
                    if($row['Compound']['compound_name'] != ''){array_push($array, ['assigned_name LIKE' => '%'.$row['Compound']['compound_name'].'%']);} //adds the compound name
                    if($row['Compound']['pseudonyms'] != ''){
                        foreach(explode(';', $row['Compound']['pseudonyms']) as $pseud){
                            while (substr($pseud, 0, 1) == ' '){$pseud = substr($pseud, 1);} //removes the spaces at the start of the psudinums
                            if($pseud == ''){continue;}
                            array_push($array, ['assigned_name LIKE' => '%'.$pseud.'%']);
                        } //splits the synonims by semi colon and removes the spaces at the front then adds each on to the array
                    } //adds all the values in the psuedonyms field
                    if($row['Compound']['sys_name'] != ''){array_push($array, ['assigned_name LIKE' => '%'.$row['Compound']['sys_name'].'%']);} //adds the system name
                } //adds the synonims to the search criteria array
                array_push($search[$data['Compoundpfr_data']['log_'.$i]],  ['OR' => $array]);    
            } //if serarching using assined name then add the sydonims
        } //adds synonims from compund table to the search in OR array
        return $search;
    }
}
