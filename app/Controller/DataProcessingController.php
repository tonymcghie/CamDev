<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/* Added this autoloader to get PhpSpreadsheetworking
 * the code comes from http://www.dereuromark.de/2012/08/06/namespaces-in-vendor-files-and-cake2-x/
 */
// found this suggestion but does not work 
//App::build(array('Vendor/PhpOffice' => array('%s' . 'PhpOffice' . DS)), App::REGISTER);

/*
spl_autoload_register(function ($class) {
	foreach (App::path('Vendor') as $base) {
		$path = $base . str_replace('\\', DS, $class) . '.php';
		if (file_exists($path)) {
			include $path;
			return;
		}
	}
});
*/

//App::import('Vendor', 'PackageName', array('file' => 'PackageName/SubFolder/ClassName.php'));
//App::import('Vendor', 'Spreadsheet', array('file' => 'PhpOffice/PhpSpreadsheet/Spreadsheet.php'));
//abandon using Spreadsheet at present  - cannot get it to load

class DataProcessingController extends AppController{
    
    //use Spreadsheet;
    
    public $helpers = array('Html' , 'Form' , 'My', 'Js');
    public $uses = array('Compound');
    public $layout = 'PageLayout';
    public $components = array('Paginator', 'My', 'Session', 'PhpExcel');
        
    /**
     * What to do before functions are called
     */
    public function beforeFilter() {
        parent::beforeFilter();

        $this->set('group', 'met_chem');
    }
    
    /**
    * Checks to see if the Spreadsheet class exists
    */
    /**protected $_Engine;
    public function __construct($settings) {
	parent::__construct($settings);
	if (!class_exists('Spreadsheet')) {
            throw new RuntimeException('Spreadsheets library cannot be found');
	}
        //$this->_Engine = new PhpOffice\PhpSpreadsheet\Spreadsheet($settings);
    }
    */
    
    /**
     * Return weather the user is authorised to access the function
     * @param type $user
     * @return type
     */
    public function isAuthorized($user) {
        return $this->My->isAuthorizedCompound($user, $this);
    }
    
        
    /**
     * This function contains the code for matching compound names with compounds names in the database.
     * 1) a csv file containing compound names is read;
     * 2) each names is compared with the name entries in the compound table;
     * 3) successful hits are written into an output file that is sent to Downloads
     */
    public function SelectFile(){
        $filename = '';
        if ($this->request->is('post')) { // checks for the post values
            
            $uploadData = $this->data['Upload']['xlsx_path'];
            var_dump($uploadData);
            $processing_options = $this->data['Upload']['processing_options'];
            $upload_options = $this->data['Upload']['upload_options'];
            

            if ( $uploadData['size'] == 0 || $uploadData['error'] !== 0) { // checks for the errors and size of the uploaded file
                return false;
                }
            $filename = basename($uploadData['name']); // gets the base name of the uploaded file
            $uploadFolder = WWW_ROOT. 'data/files/data_processing';  // path where the uploaded file has to be saved
            $uploadPath =  $uploadFolder . DS . $filename;
            if( !file_exists($uploadFolder) ){
                mkdir($uploadFolder); // creates folder if  not found
            }
            if (!move_uploaded_file($uploadData['tmp_name'], $uploadPath)) {
                return false;
            }
            $processing_parms = array();
            //put all the parameters for matching into an array
            array_push($processing_parms, $filename); 
            array_push($processing_parms, $processing_options);
            array_push($processing_parms, $upload_options);
            $massdata = array();
            //$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
           //$spreadsheet = new PhpOffice/PhpSpreadsheet/Spreadsheet();
            //$spreadsheet = new PhpSpreadsheet/Spreadsheet();
            //$spreadsheet = new Spreadsheet();
            //$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            //$spreadsheet = $reader->load($uploadPath);
            //require_once 'PHPExcel/IOFactory.php';
            //$objPHPExcel = PHPExcel_IOFactory::load($uploadPath);
            $this->PhpExcel->loadWorksheet($uploadPath);
            $data=$this->PhpExcel->getSheetByName('SampleData');
            var_dump($data);
            
            //$data=$this->PhpExcel->importData('Excel5',$tmpPath);
            //$head=$this->My->NamechangeHeadings($uploadPath); //get the headings from the datafile
            //$data=$this->My->Namechange($uploadPath, $match_criteria, $data_column); //get compound from the data file; search compounds and return a compound name
            $this->set('processing_parms', $processing_parms); //passes the identify parameters to the view 
            //$this->set('head', $head); // pass table headings to the view 
            //$this->set('data', $data); // pass array with the mass data from file to the view 
            $this->render('data_processing'); //direct to the search_masses view and not the default select_file view
        }  
    }
        
    /**
     * Exports the search results to a CSV file
     * @param type $data
     */
    public function export($filename, $match_criteria, $data_column){
        //if ($identify_parms==null){
            //return;
        //}
        $filename= urldecode($filename);
        $filename=WWW_ROOT. 'data/files/namechanger'. DS . $filename; //set the correct path to the datafile
        $head=$this->My->NamechangeHeadings($filename); //get the headings from the datafile
        $data=$this->My->Namechange($filename, $match_criteria, $data_column); //get the masses from the data file; search compounds and return a compound name
        $this->set('head', $head); //send to view
        $this->set('masses', $data); //send to view
        $this->response->download("export.csv");
        $this->layout = 'ajax';
    }
    
}