<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MyHelperTest
 *
 * @author cfpajm
 */
App::uses('Controller', 'Controller');
App::uses('View', 'View');
App::uses('MyHelper', 'View/Helper');

class MyHelperTest extends CakeTestCase{
    public function setUp(){
        parent::setUp();
        $Controller = new Controller();
        $View = new View($Controller);
        $this->My = new MyHelper($View);
    }
    public function testMakeDataURL(){
        $url = $this->My->makeDataURL();
        $this->assertIsA($url, 'String');
    }
}
