<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ItemsController extends AppController{
    public $helpers = array('Html' , 'Form' , 'My');
    public $uses = array('Analysis', 'SampleSet');
    public $layout = 'content';
    public $components = ['My', 'RequestHandler', 'PhpExcel'];
    
    /**
     * @LIVE swap file URL
     */
    private $file_URL = '/app/app/webroot/data/'; //live
    //private $file_URL = 'data/';        //testing
    
    /**
     * this happens before everything else
     */
    public function beforeFilter() {
        parent::beforeFilter();
        //by default users are not allowed
        $this->Auth->allow('editAnalysis');
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
        $set = $this->SampleSet->findById($id); //find on id
        $this->set('info', $set);// passes the set info to the page
		//$results = $this->Sample->find('all', array('conditions' => array('set_code' => $set_code)));
		//$results = $this->Sample->find('all', array('conditions' => array('set_code' => 'TK94')));
		$results = $this->Sample->find('all');
        $this->set('results', $results);
    }
	/**
	* displays sample set code but rest does not work. temporay save incase needed
	*    
	public function view_samples($set_code = null) {
        $data = $this->request->data;        
        if ($set_code == null){
            $set_code = $this->params['url']['set_code'];
		}
		$this->set('set_code', $set_code);
    }*/
    /**
     * this is called when the save or create button is pressed. It will update the values in the database and/or create a new row
     * @param type $set_code
     */
    public function editAnalysis($set_code = null){                    
        $data = $this->request->data;        
        if ($set_code == null){
            $set_code = $this->params['url']['set_code'];
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
        if (isset($this->params['url']['isTablet']) && $this->params['url']['isTablet']==='true'){
            $this->autoRender = false;
            $this->set('tabletView', 'true');
            $this->layout= 'TabletLayout';
            $this->render('edit_analysis_tablet');
        } else {
            $this->set('tabletView', 'false');
            $this->autoRender = true;
        } //choose weather to render the tablet view or the desktop view
    }
    
    /**
     * function to be called by Ajax that uploads a new image
     * @return type
     */
    public function uploadNewImg(){                
        $this->layout = 'MinLayout'; //sets the layout to a minimilistic one contains the bear minimum with as little formating as possible.
        $id = $this->params['url']['id'];
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
