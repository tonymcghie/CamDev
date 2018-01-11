<?php

App::uses('Searchable', 'Controller/Behavior');
App::uses('Viewable', 'Controller/Behavior');

class CompoundpfrDataController extends AppController {
    use Searchable {
        Searchable::getComponents as public getSearchableComponents;
    }
    use Viewable;

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
     * extorts the current search data as a csv file
     * @param type $data
     */
    public function export($datastr = null){
        parse_str($datastr, $data);  //extract search parameters from the url
        $criteria = null;$value = null;$logic = null;$match = null;
        extract($data['Compoundpfr_data']);
        $query = $this->Search->build_query($this->Compoundpfr_data, $criteria, $value, $logic, $match); //build the search query
        $search_results = $this->Compoundpfr_data->find('all', ['conditions' => $query]);  //find the data
        $this->set('data', $search_results); //send data to export view
        $this->response->download("export_pfrdata.csv"); //download the named csv file
        $this->layout = 'ajax';
        //$this->My->exportCSV('Compoundpfr_data', $this->Compoundpfr_data, $this, ['assigned_name', 'assigned_confid', 'exact_mass', 'intensity_description', 'reference', 'sample_ref', 'crop', 'species', 'tissue', 'genotype', 'analyst'], $data);  
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
     * Entry point for CompoundspfrData -> overview
     * Control transfers to the soverview_data view and onto to /Elements/overview_form
     * and then back to the overview() function below.
     * Search results are displayed as a modal as defined by /Elements/results table
     */
    public function overviewData(){
        
    }
    
    /**
     * Enables the user to obtain a summary review of the data in the CompoundPFR data table.  This is a large table and this tool is useful 
     * for getting an overview of the data in the table 
     */
    public function overview(){
        $this->autoRender = false;
        // Listed these here for auto complete reasons and to stop the IDE displaying errors
        $by = null;$value = null;$match = null;$for = null; $review_options=null;
        extract($this->request->data['Compoundpfr_data']);
        if ($match == 'contains')$review_by_value = '%'.$value.'%';
        if ($match == 'exact')$review_by_value = $value;
        if ($match == 'starts')$review_by_value = $value.'%';
        $query = "SELECT DISTINCT {$for} "
                . "FROM cam_data.compoundpfr_data as Compoundpfr_data"
                . " WHERE {$by} LIKE '{$review_by_value}';";

        //$db_name = ConnectionManager::getDataSource('default')->config['database'];
        $results = $this->Compoundpfr_data->query("SELECT DISTINCT {$for} "
                . "FROM cam_data.compoundpfr_data as Compoundpfr_data"
                    . " WHERE {$by} LIKE '{$review_by_value}';");

        // Makes the result array a 1 dimensional indexed array ie.
        //// does not seem to be needed but left in at present
        $squash_function = function($carry = [], $item) use ($for){
            if (empty($carry))$carry = [];
            $carry[] = $item['Compoundpfr_data'][$for];
            return $carry;
        };           
        $output = array_reduce($results, $squash_function);

            
        $this->set('results', $results);
        $this->set('for', $for);
        $this->set('value', $value);
        $this->set('by', $by);
        //$this->set('num', $this->Compoundpfr_data->find('count', ['conditions' => $query])); //passes the number of results to the view
        $this->set('model', 'Compoundpfr_data');
        $this->render('/Elements/overview_results_modal');
            
        //$this->set('output', $output);
        //$this->set('data', $this->request->data); //sends all the data(search criteria) to the view so it can be added to the ajax links
    }
    
    /**
     * This handles the importing of data
     * the uplaoding and prieview is already done all this does is add the colums to the data base that have being matched to a column in the table to the table
     */
    public function import(){
        if($this->request->is('post')){ 
            $data = $this->request->data['CompoundpfrData'];
            $cols = array();
            for($i = 0;isset($data[$i]);$i++){
                if ($data[$i] != 'none'){
                    array_push($cols, ['colNum' => $i, 'colName' => $data[$i]]);
                    unset($data[$i]);
                }
            } //creates array of column names and columns numbers that is used to match csv columns to table columns
            $file = fopen($this->request->data['CompoundpfrData']['fileUrl'],"r"); //gets the file
            fgetcsv($file); //skips the titles             
            $toSave = [];
            while (1==1){
                $line = fgetcsv($file);
                if ($line=== false){
                    break;
                } //when there are no more lines exit the loop               
                $newRow = [];
                foreach($cols as $pair){
                    $newRow[$pair['colName']] = $line[$pair['colNum']];
                } //adds the values from the CSV file into an array to save to the table
                $newRow['file'] = $data['fileName']; //adds the file name that it came from so all data from the file can be tracked together
                array_push($toSave, $newRow); //adds the array contining the values to save to an array containing all vlaues to save                
            } //loops through the CSV file an adds the appropriate values to an array
            if ($this->Compoundpfr_data->saveMany($toSave)){
                $this->set('message', 'Import Successful');
            } else {
                $this->set('message', 'Something went wrong');
            } // saves all the values and sets a success or failure message
        } //if you are trying to import data rather than the first display
    }
    
    /**
     * Uploads a CSV file from a iFrame within a page
     */
    public function getCsv(){
        $this->layout = 'ajax'; //minimilistic layout that has no formating
        if ($this->request->is('post')){            
            $newURL = $this->file_URL.'files/compoundpfrData/temp'.rand().'.csv'; //adds a random number to the end of the file name to avoid clashes           
            move_uploaded_file($this->request->data['CompoundpfrData']['csv_file']['tmp_name'], $newURL); //uploads the file
            $this->set('fileUrl', $newURL); //passes the new URL to the view
            $this->set('fileName', $this->request->data['CompoundpfrData']['csv_file']['name']); //passes the filename to the view so it can be later added to the table
        } //if the form is submitted then uplaod the csv file
    }
    
    /**
     * Ajax method that returns the first 6 lines of a CSV file 
     */
    public function getCsvPreview(){
        $this->autoRender=false;
        $this->layout = 'ajax';
        try{            
            $file = fopen($this->request->data['url'],"r");
            $array = array();  
            for ($i = 0; $i < 6;$i++){
                $line = fgetcsv($file, 0, ',', '"'); //gets a line from the CSV file with , separation and " arround the values
                if ($line != false && $line != ""){               
                    array_push($array, $line);
                } //if the line exists then push it to the array of lines
            } //adds the first 6 lines of data to an array
            echo('[');
            foreach($array as $line){
                if ($line != $array[count($array)-1]){                
                    echo($this->makeString($line).',');
                } else {               
                    echo($this->makeString($line).']');
                }
            } //echos the array as a string
            fclose($file);       
        }catch (Exception $e){//if there is a error echo the error message this should be commented out when going live   
            //print_r($e);
        }  //echo the first 6 lines of the data in the CSV file as a string of an array that can be Json decoded 
    }
    
    /**
     * This sanitises each string in the array then returns the Json string of the array
     * @param type $array
     * @return type
     */
    private function makeString($array){
        if (!isset($array) || $array === false){
            return;
        } //makes sure that some data has being passed
        foreach($array as &$val){
            $val = filter_var($val, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);            
        } //filters the string and sets it in the array
        return json_encode($array); //returns the encoded result
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
