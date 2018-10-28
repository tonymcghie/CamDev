<?php

App::uses('AppController', 'Controller');
App::uses('Importable', 'Controller/Behavior');

class SamplesController extends AppController{
    
    use Importable;
    
    public $helpers = array('Html' , 'Form' , 'My', 'Js');
    public $uses = array('Analysis', 'SampleSet', 'Sample');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'My', 'Pivot', 'RequestHandler', 'PhpExcel', 'Session');
    
    /**
     * @LIVE swap file URL
     */
    //private $file_URL = '/app/app/webroot/data/'; //live
    private $file_URL = 'data/';        //testing
    
    
    public function __construct($request = null, $response = null) {
        parent::__construct($request, $response);
        $this->components = array_merge($this->components, $this->getImportableComponents());
        $this->components = array_unique($this->components);
    }

    protected function getModel() {
        return $this->Sample;
    }
    
    
    /**
     * this happens before everything else
     */
    public function beforeFilter() {
        parent::beforeFilter();
        //by default users are not allowed
        $this->Auth->allow('editAnalysis');
        $this->set('group', 'sampleSets');
    }

    /**
     * returns weather the user is authorised to access this controller
     * @param type $user
     * @return type
     */
    public function isAuthorized($user) {
        return $this->My->isAuthorizedAnalysis($user, $this); //returns false if the user is not a chemist
    }

    public function viewSamples($id = null) {
		
		$this->paginate = array(
        'limit' => 20,
        'order' => array('Sample.sample_name' => 'asc'));     //sets up the pagination options

        $set = $this->SampleSet->findById($id); //find a sample set by id
        $this->set('info', $set);// passes the sample set info to the view
		$this->set('num', $this->Sample->find('count', array('conditions' => array('set_code' => 'TK94'))));// finds the num of results
		$results = $this->Sample->find('all', array('conditions' => array('set_code' => $set['SampleSet']['set_code']))); //gets the sample records for the specified set_code
		$this->set('results', $results);  //passes the sample record to the view
		$this->set('data', $this->request->data); //sends all the data (search criteria) to the view so it can be added to the ajax links 
    }
    
    public function editAnalysis($set_code = null){                    
        $data = $this->request->data;        
        if ($set_code == null){
            $set_code = $this->request->params['url']['set_code'];
        } //gets the set_code
        if (isset($data['Analysis']['key'])){ 
            $this->Analysis->create();
            $this->Analysis->save($data);
        }//creates a new row
        if (isset($data['Analysis'][0])){
            $set_code = $data['Analysis']['set_code'];
            unset($data['Analysis']['set_code']); //makes sure the set_code doesnt change
            foreach ($data['Analysis'] as &$row){ 
                //File upload stuff
                if (isset($row['newImg'])){
                    unset($row['newImg']);                    
                } //unsets the newImg value as the images are uplaoded through a separate iFrame      
                if (isset($row['p_data']['error'])&&$row['p_data']['error']=='0'){ //uplaods an img if there is one to upload
                    $row['processed'] = $this->uploadFile($row['p_data'],
                            $set_code.'_'.$row['title'].'_'.'additionalData'.'_'.$row['id'].'.'.substr(strtolower(strrchr($row['p_data']['name'], '.')), 1));
                }   //calls the functoin to upload a new additional data file and sets the name variable           
                if (isset($row['d_data']['error'])&&$row['d_data']['error']=='0'){ //uplaods an img if there is one to upload
                    $row['derived_results'] = $this->uploadDataFile($row['d_data'],
                            $set_code.'_'.$row['title'].'_'.'processedData'.'_'.$row['id'].'.xlsx',
                            $row,
                            $set_code);
                }   //calls the function to upload a new processed data file and sets the name variable
                if(isset($row['d_data'])){
                    unset($row['d_data']);
                } //unsets d_data as its not a column in the table
                if(isset($row['p_data'])){
                    unset($row['p_data']);
                } //unsets p_data as its not a column in the table
                //end file uploading stuff
                if (!isset($row['id'])){continue;}
                unset($row['imgURL']);
                
                $this->Analysis->id=$row['id']; //sets the row to save to 
                $this->Analysis->save($row);    //saves the row
            }           
        } //check to make sure that the analysis exists before trying to save it
        if (isset($set_code)){         
            $results = $this->Analysis->find('all', array('conditions' => array('set_code' => $set_code)));
            $this->set('results', $results);
            $this->set('set_code', $set_code);
        } //updates the values showing
    }
    
    /**
     * function to be called by Ajax that uploads a new image
     * @return type
     */
    public function uploadNewImg(){                
        $this->layout = 'ajax'; //sets the layout to a minimilistic one contains the bear minimum with as little formating as possible.
        $id = $this->request->params['url']['id'];
        $imgURL = $this->Analysis->find('first', ['feilds' => ['imgURL'], 'conditions' => ['id' => $id]])['Analysis']['imgURL']; //finds the current imgURL for the row
        $this->set('id', $id);
        $this->set('imgURL', $imgURL);
        if (isset($this->request->data['Analysis']['newImg']['error']) && $this->request->data['Analysis']['newImg']['error'] === 0){ 
            $this->Analysis->id = $id;       
            $newImgURL = $this->uploadImg(['id' => $id, 'newImg' => $this->request->data['Analysis']['newImg'], 'imgURL' => $imgURL]);
            if($newImgURL === false){ //if the uploading didnt work
                echo 'There was an Error uploading the file';
                return;
            }
            $this->Analysis->saveField('imgURL', $newImgURL); //updates just the imgURl field
            $this->set('imgURL', $newImgURL);
        } //if there is a files selected (an image) the upload it
    } 
}
