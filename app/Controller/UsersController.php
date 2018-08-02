<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

App::uses('AppController', 'Controller');

/**
 * CakePHP loginController
 * @author cfpajm
 */
class UsersController extends AppController {
    public $components = ['Session', 'LDAP', 'Cookie'];
    public $uses = ['Contact', 'SampleSet', 'Chemist'];
    public $layout = 'PageLayout';
   

    /**
     * Stuff that happens before other functions are called
     */
    public function beforeFilter() {
        parent::beforeFilter();
        //$this->Auth->allow('login', 'logout'); //allow all access by default
        $this->set('group', 'sampleSets');
        
        $this->Cookie->name = 'User'; //set the User cookie
        $this->Cookie->time = '365 days'; //long expiration time
        //$this->Cookie->key = getenv('COOKIE_KEY'); //set the security key
        $this->Cookie->key = 'qSI232qs*&sXOw!adre@34SAv!@*(XSL#$%)asGb$@11~_+!@#HKis~#^';
        $this->Cookie->type('aes'); //sets the encription type
        
        
    }
    
    public function cam4_login() {
        $data = $this->request->data;
        //var_dump($data);   
        //var_dump($data);
    }
    
    
    /**
     * Logs a user in. Commented out when login not wanted
     */
    public function login() {
        // if already logged in display a message
        if ($this->Auth->loggedIn()) {
            //return to main page -i.e nothing happpens
            return $this->redirect(['controller' => 'general', 'action' => 'welcome']);       
        }
        // sets the $user array with values normally obtained from LDAP.
        // For use in home dev.  Comment out when using on PFR systems with  LDAP.
        $user['first_name'] = 'Tony';
        $user['last_name'] = 'McGhie';
        $user['name'] = 'Tony McGhie';
        $user['user'] = 'HRPTKM';
        $user['location'] = 'Palmerston North Research Centre';
        $user['groups'] = 'PFR-GP-Biological Chemistry and Bioactives Group';
        //var_dump($user);
        
        if (!$this->Auth->loggedIn()) {
            $User = $this->request->data;   //get data from login form
        }
        //var_dump($User);
        //var_dump($User['username']);
        
        /**
         * cannot get cookies to save due to encryption problems
         * so commented out to stop errors from showing
        
        if ($this->request->data) { //set Cookie if 'RememberMe is checked
            if ($User['rememberMe'] ==='remember-me') {
                $this->Cookie->write('User.username', $User['username'], true);
                $this->Cookie->write('User.password', $User['password'], true);                
            }
         * 
         */
        
        // comment out LDAP access for home dev
        //if ($this->request->data) {  //access LDAP if form has been posted
        //if ($this->LDAP->auth($User['username'], $User['password'])) {
        //    $user = $this->findByUsername($User['username']); //gets the user data from LDAP
        //}
        if (isset($user['name'])) {  //complete the login to CAM if a named user has been found
            $this->Auth->Session->write($this->Auth->sessionKey, $user); //sets the session
            $this->Auth->loggedIn = true; //sets the user to be logged in
            $this->Auth->login($user); //logs in the user
            $this->Session->write('first', true); //set the session first to true to stop an infinite loop
            //Find the CAMuserType from the Chemists table and write the userType 
            //to the Session variable
            $this->Session->write('Auth.User.CAMuserType', $this->findCAMUserType($user));
        }
        //var_dump($_SESSION);
        
	/**            
    if ($this->Session->read('Auth.User')) {
        $data = http_build_query(['alert' => 'You are already Logged in as '.$this->Session->read('Auth.User')['name']]);        
        $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => $data]);        
    } elseif (!empty($this->data || $this->Cookie->check('User'))) {
        if ($this->Cookie->check('User')){
            $this->request->data['User']['username'] = $this->Cookie->read('User.username');
            $this->request->data['User']['password'] = $this->Cookie->read('User.password');
        } //if cookie exists then adjust the login details to that of the Cookie
        if ($this->LDAP->auth($this->request->data['User']['username'], $this->request->data['User']['password'])) {
            $user = $this->findByUsername($this->data['User']['username']); //gets the user data              
            if ($this->Chemist->find('count', ['conditions' => ['name' => $user['name']]]) > 0){
                array_push($user['groups'], "PFR-GP-Biological Chemistry and Bioactives Group"); //This searches the Chemsist database and adds the user to the admins if they are found
            }
            $this->Auth->Session->write($this->Auth->sessionKey, $user); //sets the session
            $this->Auth->_loggedIn = true; //sets the user to be logged in
            $this->Auth->login($user); //logs in the user
            if (isset($this->request->data['User']['rememberMe']) && $this->request->data['User']['rememberMe'] == 1){
                $this->Cookie->write('User.username', $this->request->data['User']['username'], true);
                $this->Cookie->write('User.password', $this->request->data['User']['password'], true);                
            }  //set Cookie if remeber me is checked
            $this->Session->write('first', true); //set the session first to true to stop an infinate loop
            $data = http_build_query(['alert' => 'You have logged in as '.$user['name']]); //the message to show after loging in           
            $this->redirect(['controller' => 'General', 'action' => 'blank', '?' => $data]); //redirect to blank page
        } else {
            $this->Cookie->destroy();
            echo "<script>alert('Username or Password Incorrect');</script>";
        } //if login successful then set session cookie and redirect if not then display error
    } //if user is laready logged in then redirect if not try to log the user in
	*/
        //$this->redirect(['controller' => 'general', 'action' => 'welcome']);
    //}
    
    /**
     * Gets the User info from a user name
     * @param type $username
     * @return type
     */
    private function findByUsername($username){
        return $this->LDAP->getInfo($username);
    } 
    
    /**
     * Gets the User Type from the Chemists Table
     * @param type $user
     * @return type
     */
    private function findCAMUserType($user){
        $data = $this->Chemist->find('first',
        array('conditions' => array('Chemist.name' => $user['name'])
        ));
        $userType = $data['Chemist']['type'];
        return $userType;
    } 
    
    /**
     * logsout the current user and destroys the cookie
     * @return type
     */
    public function logout() {        
        $this->Cookie->destroy();  //destroy the cookie
        //$this->Auth->logoutRedirect = ['controller' => 'General', 'action' => 'blank', '?' => ['alert' => 'You haved logged out']];        
        session_destroy();  //remove a session variables
        $this->Session->write('first', true); //makes the while page refesh once  
        $this->Auth->logout();
    return $this->redirect(['controller' => 'general', 'action' => 'welcome']);
    }    
    
    /**
     * View for when the user does not have the permissions to view the page
     */
    public function noPerm(){
        
    }
    
    /**
     * this allows access to set and get the first Session variable
     */
    public function Session_first(){
        $this->autoRender=false;
        $this->layout = 'ajax';
        
        if (isset($this->request->data['first'])){
            $this->Session->write('first', $this->request->data['first']);
        } //if first is passed then update the value in the session    
        echo $this->Session->read('first');
    }
}
