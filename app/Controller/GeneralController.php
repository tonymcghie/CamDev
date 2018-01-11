<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

// added by TKM to allow loading of larger images

ini_set('memory_limit', '1024M');

/**
 * CakePHP General
 * @author cfpajm
 */
class GeneralController extends AppController {
    public $helpers = array('Html' , 'Form' , 'My' , 'Js', 'Time');
    public $uses = array();
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'RequestHandler', 'My', 'Session', 'Cookie', 'Auth');  
    
    //@LIVE swap the URLS for both of them
    //private $file_URL = '/app/app/webroot/data/'; //live
    private $file_URL = 'data/';        //testing
    
    private $python_location = '/app/app/webroot/files/pythonScripts/'; //live
    //private $python_location = 'C:/wamp/www/CAMcake/app/webroot/files/pythonScripts/'; //testing
    
    /**
     * checks if the user is authorised to the controller functions
     * @param type $user
     * @return type
     */
    public function isAuthorized($user) {
        $this->set('user', $user);        
        return $this->My->isAuthorizedSampleSet($user, $this); //retrurns false if not logged in and action = new or edit
    }
    
    /**
     * stuff that happens before everything
     */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Cookie->name = 'View'; //sets a cookie with the name view
        $this->Cookie->time = '365 days'; //sets the time till it expires to be really long
        $this->set('group', 'tools');
    }
    
    /**
     * defualt function and is unused
     * @param type $id
     */
    public function index($id) {
        
    }
    
    /**
     * doesnt need anything usually contains tests for things like email and python.
     * These should be deleted or commented out when going live
     */
    public function info(){
        $this->set('group', 'help');
    } 
 
	public function howto(){
        $this->set('group', 'help');
    }    
    /**
     * almost a blank page
     * will redirect to a login page if the user is not logged in and its the first time accessing it. This is to stop it getting in a loop
     */
    public function blank(){                
        if ($this->Session->read('Auth.User')== null && $this->Session->read('first') != true){
            $this->redirect(['controller' => 'users', 'action' => 'login']); //redirects to the login page
        } //checks if there is no one logged in
//        $this->layout = ''; //sets the layout to blank so there is no divs or anything so the page looks blank
    }
    
    /**
     * the main page that contains the sidebar and the iFrame
     * updates the isTablet cookie
     */
    public function main(){
        $this->layout = 'PageLayout'; //sets the layout to be different from the pages
        $isTablet = isset($this->params['url']['isTablet']) ? $this->params['url']['isTablet'] : ''; //gets isTablet value from the URL 
        if ($this->Cookie->check('View.isTablet') && $isTablet === ''){ 
            $isTablet = $this->Cookie->read('View.isTablet');
        } //if isTablet is not in the URL and its in the Cookie then read it from the cookie
        if ($isTablet != ''){
            $this->set('isTablet', $isTablet);
            $this->Cookie->write('View.isTablet', $isTablet);
        } else {
            $this->set('isTablet', 'false');
            $this->Cookie->write('View.isTablet', 'false');
        } //sets the view to use 
    }
    
    /**
     * Allows the user to download template .xlxs files for specific tasks
     * Template must be loaded into /output/chemistry/cam... or a local drive if testing
     */
    public function templates(){  
        
    } 
    
    /**
     * Allows the user to use links that open pages with utilities for
     * processing gcms data, especially from the Akl Leco gcms
     */
    public function gcms(){  
        
    } 
    
    /**
     * This will start a download of a file
     * @return type
     */
    public function download(){
        $this->autoRender = false; //stops the page being rendered unless render is called
        if ($this->request->is('post')){ //checks that the form is being submitted
            $path = $this->request->data['General']['path']; //the path of the file is passed from the form
            $this->response->file($path, [
                'download' => true,
                'name' => $this->request->data['General']['name'], //name default name of the file is passed from the form
            ]);
            return $this->response;
        }        
    }
    
    /**
     * This is the controller for the scripts since the file uploads and running the script is handled separatly it only handles downloading the file
     * @return type
     */
    public function scripts(){   
        if ($this->request->is('post')){           
            $path = $this->request->data['General']['temp_name']; //get the name of the file to download
            $this->response->file($path, array(
                'download' => true,
                'name' => $this->request->data['General']['name'], //get the name of the file to go to the users computer
            ));
            return $this->response;
        } //if the form is submitted
    }
    
    /**
     * The Controller method for an iframe that looks like part of the page used to submit files with out submitting the whole page
     */
    public function getCsv(){
        $this->layout = 'PageLayout'; //sets the layout to a minimal layout that contains almost no formating so looks invisible
        if ($this->request->is('post')){            
            $newURL = $this->file_URL.'files/samplesets/temp'.rand().'.csv';               
            move_uploaded_file($this->request->data['General']['csv_file']['tmp_name'], $newURL); //upload file
            $this->set('fileUrl', $newURL); //set new location
            $this->set('fileName', $this->request->data['General']['csv_file']['name']); //set old name
        } //upload the file and set the new location and old name
    }
        
    /**
     * Ajax function that runs the selected script
     */
    public function runScript(){
        $this->autoRender=false; //stops the page from rendering as this is ajax so it outputs data
        $this->layout = 'ajax';     //ajax layout is blank
                
        $command = $this->python_location.$this->request->data['name'].' '; // adds the file location to the command
        foreach ($this->request->data['args'] as $arg){
            $command .= $arg.' ';
        } //adds values to pass to the python script by defualt first one is input file location and the second one is output file location
        echo shell_exec('python '.$command); //@LIVE add 'python '. for live //executes the commad and passes the output back to the View         
    }
    
    /**
     * Ajax function the gets the help text for the script
     */
    public function ScriptHelp(){
        $this->layout = 'ajax'; //makes sure there is not head or body tags round the output
        $this->render('ScriptHelp/'.$this->params['url']['name']); //this will render the html code in the help file to javascript on the page wich will then set it in the help DIV
    }

    public function QunitTests(){
        $this->layout = 'QUnitLayout';
    }
}
