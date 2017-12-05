<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AnalysesController extends AppController{
    public $helpers = ['Html' , 'Form' , 'My' , 'Js', 'Time', 'String', 'BootstrapForm'];
    public $uses = array('Analysis', 'SampleSet');
    public $layout = 'PageLayout';
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
    
    /**
     * this is called when the save or create button is pressed. It will update the values in the database and/or create a new row
     */
    public function editAnalysis() {
        $set_code = $this->params['url']['set_code'];
        if (!isset($set_code)) {
            throw new Exception('the set_code parameter was not passed');
        }

        if ($this->request->is('post')) {
            $data = $this->request->data;
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

        if (!isset($this->params['url']['id'])) {
            $analysis = $this->Analysis->find('first', ['conditions' => ['set_code' => $set_code]]);
        } else {
            $analysis = $this->Analysis->find('first', ['conditions' => ['id' => $this->params['url']['id']]]);
        }

        $titles = $this->Analysis->find('all', ['conditions' => ['set_code' => $set_code], 'fields' => ['Analysis.id', 'Analysis.title']]);
        $this->set('titles', $titles);
        $this->set('currentAnalysis', $analysis);
        $this->set('set_code', $set_code);
    }

    public function newAnalysis() {
        $set_code = isset($this->params['url']['set_code']) ? $this->params['url']['set_code'] : $this->request->data['Analysis']['set_code'];
        $this->set('set_code', $set_code);
        $titles = $this->Analysis->find('all', ['conditions' => ['set_code' => $set_code], 'fields' => ['Analysis.id', 'Analysis.title']]);
        $this->set('titles', $titles);
        if ($this->request->is('post')) {
            $this->Analysis->create();
            $this->Analysis->save($this->request->data);
            $newId = $this->Analysis->id;

            $this->redirect(['controller' => 'Analyses', 'action' => 'editAnalysis', '?' => ['set_code' => $set_code, 'id' => $newId]]);
        }

    }
    
    /**
     * function to be called by Ajax that uploads a new image
     * @return type
     */
    public function uploadNewImg(){                
        $this->layout = 'ajax';
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

    /**
     * uploads the img and return the url of it
     * @param type $row
     * @return type
     * @todo change the url to the live URL
     */
    private function uploadImg($row) {
        $folderToSaveFiles = $this->file_URL.'images/analysis/'; //sets the place to save the image files
        $file = $row['newImg']; //put the data into a var for easy use
        $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension
        $arr_ext = array('jpg', 'jpeg', 'gif', 'png', 'bmp'); //set allowed extensions
        if(in_array($ext, $arr_ext)){ //makes sure the extension is valid  
            if (!isset($row['imgURL']) || $row['imgURL'] == ''){
                $row['imgURL'] = '0';
            }
            $newFilename = $row['id'].'_'.$row['imgURL'];       
            $result = move_uploaded_file($file['tmp_name'], $folderToSaveFiles.$newFilename );
            if (!$result){return $result;}//if the upload fails
            return ++$row['imgURL']; //sets the url to save to the database 
        } else {
            return 1;
        }
    }
    /**
     * Adds a cover sheet to the execl file. if there is alreadt on a cover sheet will not be added.
     * The cover sheet contains all the data in the analysis textfields.
     * only use of the phpExcel extension
     * It then calls the function to upload a file.
     * @param type $file (the DOM file data)
     * @param type $newName (the name it is to be saved as)
     * @param type $row (the data in that row of the table)
     * @param type $set_code (the set_code so for the cover sheet)
     */
    private function uploadDataFile($file, $newName, $row, $set_code){
        $this->PhpExcel->loadWorksheet($file['tmp_name']);
        $this->PhpExcel->setActiveSheet(0);
        if($this->PhpExcel->getSheetByName('Cover Sheet') == null){            
            $this->PhpExcel->createSheet(0);  
            $this->PhpExcel->setActiveSheet(0);
            $SSData = $this->SampleSet->find('all', ['conditions' => ['SampleSet.set_code' => $set_code]]);
            //print_r($SSData);
            if(isset($SSData[0]['SampleSet']['submitter'])){$this->PhpExcel->addData(['PFR Collaborator: ',$SSData[0]['SampleSet']['submitter']]);}
            if(isset($SSData[0]['SampleSet']['chemist'])){$this->PhpExcel->addData(['Chemist: ',$SSData[0]['SampleSet']['chemist']]);}
            if(isset($SSData[0]['SampleSet']['team'])){$this->PhpExcel->addData(['Team: ',$SSData[0]['SampleSet']['team']]);}
            if(isset($SSData[0]['SampleSet']['set_code'])){$this->PhpExcel->addData(['Set Code: ',$SSData[0]['SampleSet']['set_code']]);}
            if(isset($SSData[0]['SampleSet']['crop'])){$this->PhpExcel->addData(['Crop: ',$SSData[0]['SampleSet']['crop']]);}
            if(isset($SSData[0]['SampleSet']['type'])){$this->PhpExcel->addData(['Sample Type: ',$SSData[0]['SampleSet']['type']]);}
            if(isset($SSData[0]['SampleSet']['number'])){$this->PhpExcel->addData(['Number of Samples: ',$SSData[0]['SampleSet']['number']]);}
            if(isset($SSData[0]['SampleSet']['p_name'])){$this->PhpExcel->addData(['Program Name: ',$SSData[0]['SampleSet']['p_name']]);}
            if(isset($SSData[0]['SampleSet']['p_code'])){$this->PhpExcel->addData(['Program Code: ',$SSData[0]['SampleSet']['p_code']]);}
            if(isset($SSData[0]['SampleSet']['exp_reference'])){$this->PhpExcel->addData(['Experiment Reference: ',$SSData[0]['SampleSet']['exp_reference']]);}
            if(isset($SSData[0]['SampleSet']['compounds'])){$this->PhpExcel->addData(['Compounds for Analysis: ',$SSData[0]['SampleSet']['compounds']]);}
            if(isset($SSData[0]['SampleSet']['set_reason'])){$this->PhpExcel->addData(['Reason for Analysis: ',$SSData[0]['SampleSet']['set_reason']]);}
            if(isset($SSData[0]['SampleSet']['containment_details'])){$this->PhpExcel->addData(['Containment Details: ',$SSData[0]['SampleSet']['containment_details']]);}
            if(isset($SSData[0]['SampleSet']['confidential'])){$this->PhpExcel->addData(['Confidential: ',($SSData[0]['SampleSet']['confidential']==0 ? 'No' : 'Yes')]);}
                        if(isset($SSData[0]['SampleSet']['comments'])){$this->PhpExcel->addData(['Additional Comments: ',$SSData[0]['SampleSet']['comments']]);}
            
            
            
           /* if(isset($row['title'])){$this->PhpExcel->addData(['Analysis Title',$row['title']]);}
            if(isset($set_code)){$this->PhpExcel->addData(['Set Code',$set_code]);}
            if(isset($row['startdate'])){$this->PhpExcel->addData(['Start Date',$row['startdate']]);}
            if(isset($row['method'])){$this->PhpExcel->addData(['Method',$row['method']]);}
            if(isset($row['labbook_ref'])){$this->PhpExcel->addData(['Labbook Reference',$row['labbook_ref']]);}
            if(isset($row['prep'])){$this->PhpExcel->addData(['Sample Preparation',$row['prep']]);}
            if(isset($row['details'])){$this->PhpExcel->addData(['Details',$row['details']]);}*/
            $this->PhpExcel->setSheetName('Cover Sheet');
            $this->PhpExcel->save($file['tmp_name']);
        } //edits the  file
                
        $this->uploadFile($file, $newName); //uploads the file
        return $newName;
    }

    /**
     * gets a file from its temp location and addes it to the data directory
     * @param type $file (file object only needs temp_name)
     * @param type $newName (the new name of the file) 
     * @return type
     */
    private function uploadFile($file, $newName){
        $URL = $this->file_URL.'files/analysis/'.$newName;             
        $result = move_uploaded_file( $file['tmp_name'], $URL );
        if ($result){return $newName;}//if the upload fails
    }
}
