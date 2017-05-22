<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('CakeEmail', 'Network/Email');

class FeedbacksController extends AppController{
    public $helpers = array('Html' , 'Form' , 'My' , 'Js', 'Time');
    public $uses = array('Analysis' , 'Feedback' , 'Chemist');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'RequestHandler', 'My', 'Session', 'Cookie', 'Auth');    
    
    /**
     * @LIVE Change loactions
     */    
    //private $file_URL = '/app/app/webroot/data/'; //live
    private $file_URL = 'data/';        //testing   
    
    /**
     * stuff that happens before everything
     */
    public function beforeFilter() {
        parent::beforeFilter();
        if (isset($this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'])){
            $this->SampleSet->username = $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'];
        }//sets the username of the user to a variable that can be used through out the contoller
        $this->Auth->allow('editSet','newSet'); //deny access to edit and new set by default // 'deny' changed to 'allow' for home testing
        $this->Cookie->name = 'View'; //sets a cookie with the name view
        $this->Cookie->time = '365 days'; //sets the time till it expires to be really long
    }
    
    /**
     * return weather or not the user is allowed to access the function
     * @param type $user
     * @return type
     */
    public function isAuthorized($user) {
        $this->set('user', $user);        
        return $this->My->isAuthorizedSampleSet($user, $this); //retrurns false if not logged in and action = new or edit
    }
    
    /**
     * Sends an email. The message is for when a new Sample Set is submitted
     * @param type $options
     */
    private function send_newFeedback_email($options){
        $Email = new CakeEmail($options); //creates an email object which will set most of the options
        $Email->subject('New Feedback: '.$options['priority']); //sets the subject
        $Email->send($options['submitter'].' has submitted new feedback: '.$options['issue']); //sets the message and sends the email
    }
           
    /**
     * Makes a new set and sends emails makes set code
     * @return type
     */
    public function new_feedback(){        
        if (isset($this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['name'])){
            $this->set('user', $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']);
        } //sets the username to the view
        
        $this->set('tabletView', 'false');
        $this->autoRender = true;
        //selects the view to not tablet)
        
        if ($this->request->is('post')){           
            $data = $this->request->data;      //gets the data
            echo var_dump($data), "<br>";
            $data['Feedback']['submitter_email'] = $this->Auth->Session->read($this->Auth->sessionKey)['Auth']['User']['email']; //sets the email of the user who submitted the sample set
             $this->Feedback->create(); //Need to add set code
            if ($this->Feedback->save($data)){ //saves the sample set                
                                
                /**$this->send_newSS_email(['from' => 'no_reply@plantandfood.co.nz',
                    'to' => $chemist['Chemist']['email'],
                    'submitter' => $data['SampleSet']['submitter'],
                    'set_code' => $data['SampleSet']['set_code'],
                    'attachments' => $this->file_URL.'files/samplesets/'.$data['SampleSet']['metaFile']]); //sets the values for the email to the chemist
                $this->send_newFeedback_email(['from' => 'no_reply@plantandfood.co.nz',
                    'to' =>  $data['Feedback']['submitter_email'],
                    'submitter' => $data['Feedback']['submitter'],
                    'issues' => $data['Feedback']['issue'],
                    'priority' => $data['Feedback']['priority']]); //sets the values for the email to the submitter*/
                
                return $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'Feedback successfully Saved!']]); //redirects the page to the blank page and makes an alert message containing the set code
            } else {
                $this->set('error', true);
            } //if the save was successful then send the emails if not send an error to the view
        } //check if the save button has being clicked and makes a new sample set if the form has being submitted   
    }  
    
}      
    

