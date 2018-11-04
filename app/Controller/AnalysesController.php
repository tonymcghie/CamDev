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
    public $components = ['My', 'RequestHandler', 'PhpExcel', 'Session'];
    
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
        //$set_code = $this->request->params['url']['set_code'];
        $set_code = $this->request->query['set_code'];
        if (!isset($set_code)) {
            throw new Exception('the set_code parameter was not passed');
        }

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->data;
            $set_code = $data['Analysis']['set_code'];
            $id = $data['Analysis']['id'];

            $this->Analysis->id = $data['Analysis']['id'];
            $this->Analysis->save($data);
        }

        if (!isset($id) && !isset($this->request->params['url']['id'])) {
            $analysis = $this->Analysis->find('first', ['conditions' => ['set_code' => $set_code]]);
        } else if (isset($id)) {
            $analysis = $this->Analysis->find('first', ['conditions' => ['id' => $id]]);
        } else {
            $analysis = $this->Analysis->find('first', ['conditions' => ['id' => $this->request->params['url']['id']]]);
        }

        $titles = $this->Analysis->find('all', ['conditions' => ['set_code' => $set_code], 'fields' => ['Analysis.id', 'Analysis.title']]);
        $this->set('titles', $titles);
        $this->set('currentAnalysis', $analysis);
        $this->set('set_code', $set_code);
    }

    public function newAnalysis() {
        $set_code = isset($this->request->query['set_code']) ? $this->request->query['set_code'] : $this->request->data['Analysis']['set_code'];
        //$set_code = isset($this->request->params['url']['set_code']) ? $this->request->params['url']['set_code'] : $this->request->data['Analysis']['set_code'];
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

    public function uploadNewImage() {
        $this->layout = 'ajax';
        $this->autoRender = false;
        $uploadedImageData = $this->request->params['form']['newImage'];
        $id = $this->request->data['Analysis']['id'];
        if ($uploadedImageData['error'] != 0) {
            $this->response->statusCode(418);
            $this->response->send();
            return;
        }

        $numImages = intval($this->Analysis->find('first',
            ['conditions' => ['id' => $id], 'fields' => ['Analysis.imgURL']])['Analysis']['imgURL']);
        $extension = pathinfo($uploadedImageData['name'])['extension'];
        $newFilePath = 'data/images/analysis/' . $id . '_' . $numImages;
        $success = move_uploaded_file($uploadedImageData['tmp_name'], $newFilePath);

        if (!$success) {
            $this->response->statusCode(418);
            $this->response->send();
            return;
        }
        $this->Analysis->id = $id;
        $this->Analysis->saveField('imgURL', $numImages + 1);
        echo json_encode(['filename' => $newFilePath]);
    }

    public function uploadProcessedData() {
        $this->layout = 'ajax';
        $this->autoRender = false;
        $uploadedProcessedData = $this->request->params['form']['derived_results_file'];
        $set_code = $this->request->data['Analysis']['set_code'];
        $title = $this->request->data['Analysis']['title'];
        $id = $this->request->data['Analysis']['id'];

        if ($uploadedProcessedData ['error'] != 0
            || pathinfo($uploadedProcessedData['name'])['extension'] != 'xlsx') { // Can only upload an xlsx file
            $this->response->statusCode(418);
            $this->response->send();
            return;
        }

        $newPath = 'data/files/analysis/' . $set_code . '_' . $title . '_' . 'processedData' . '_' . $id . '.xlsx';
        //$res = move_uploaded_file($uploadedProcessedData['tmp_name'], $newPath); //upload file without adding cover tab
        $data['Analysis']['derived_results'] = $this->uploadDataFile($uploadedProcessedData,
            $newPath,
            $set_code);

        echo json_encode(['filename' => Router::getPaths()['base'] . '/' . $newPath]);
    }

    public function uploadResultsData() {
        $this->layout = 'ajax';  //nothing visiable on screen
        $this->autoRender = false;
        $uploadedDerivedData = $this->request->params['form']['processed_file'];
        $set_code = $this->request->data['Analysis']['set_code'];
        $title = $this->request->data['Analysis']['title'];
        $id = $this->request->data['Analysis']['id'];
        
        if ($uploadedDerivedData['error'] != 0) {
            $this->response->statusCode(418);
            $this->response->send();
            return;
        }

        $newName = $set_code . '_' . $title . '_' . 'additionalData' . '_' . $id . '.' . pathinfo($uploadedDerivedData['name'])['extension'];
        $newPath = 'data/files/analysis/' . $newName;
        $res = move_uploaded_file($uploadedDerivedData['tmp_name'], $newPath);

        echo json_encode(['filename' => Router::getPaths()['base'] . '/' . $newPath]);
    }

    /**
     * Adds a cover sheet to the excel file. if there is already on a cover sheet will not be added.
     * The cover sheet contains all the data in the analysis textfields.
     * only use of the phpExcel extension
     * It then calls the function to upload a file.
     * @param array $file (the DOM file data)
     * @param string $newPath (the name it is to be saved as)
     * @param string $set_code (the set_code so for the cover sheet)
     */
    private function uploadDataFile($file, $newPath, $set_code){
        $this->PhpExcel->loadWorksheet($file['tmp_name']);
        $this->PhpExcel->setActiveSheet(0);
        if($this->PhpExcel->getSheetByName('CoverSheet') == null){            
            $this->PhpExcel->createSheet(0);  
            $this->PhpExcel->setActiveSheet(0);
            $SSData = $this->SampleSet->find('all', ['conditions' => ['SampleSet.set_code' => $set_code]]);
            if(isset($SSData[0]['SampleSet']['submitter'])){$this->PhpExcel->addData(['PFR Collaborator: ',$SSData[0]['SampleSet']['submitter']]);}
            if(isset($SSData[0]['SampleSet']['chemist'])){$this->PhpExcel->addData(['Analyst: ',$SSData[0]['SampleSet']['chemist']]);}
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
            $this->PhpExcel->setSheetName('CoverSheet');
            $this->PhpExcel->save($file['tmp_name']);
        } //edits the  file
        move_uploaded_file($file['tmp_name'], $newPath);
    }
}
