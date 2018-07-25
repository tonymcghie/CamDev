<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    public $components = array(
    'Auth' => array(
        'loginAction' => array(
            'controller' => 'Users',
            'action' => 'noPerm'
        ),
        'logoutRedirect' => array(
            'controller' => 'General',
            'action' => 'blank',
            '?' => 'alert=You+have+being+logged+out'
        ),
        'authError' => 'You do not have permission to access this page',
        'authenticate' => array(
            'Form' => array(
                'fields' => array(
                  'username' => 'my_user_model_username_field', //Default is 'username' in the userModel
                  'password' => 'my_user_model_password_field'  //Default is 'password' in the userModel
                )
            )
        ),
        'authorize' => array('Controller'),
        'redirect' => array('controller' => 'Users', 'action' => 'noPerm'),
        )
    );
    
    public function beforeFilter() {
        parent::beforeFilter();
        // Allow users to register and logout.
        $this->Auth->allow();
        $this->set('behaviour', class_uses($this));
        // setup Login status message
        $login_message = '';
        $login_name = '';
        if ($this->Auth->loggedIn()) {
            //$user_data = $this->Session->read('Auth.User');
            $login_message = 'Logged In. Hello '. $user_data['name'];
            $login_name = $user_data['name'];
            //var_dump($user_data);
        } else {
           $login_message = 'Logged Out';
           $login_name = 'no one logged in';
        }
        $this->set('login_message', $login_message);
        $this->set('login_name', $login_name);
    }
    
    /**
     * returns whether the user is allowed default to yes but is unused
     * @param type $user
     * @return boolean
     */
    public function isAuthorized($user) {
        return true;
    }
}
