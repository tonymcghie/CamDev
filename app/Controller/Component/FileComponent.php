<?php

/**
 * Created by PhpStorm.
 * User: mgoo
 * Date: 4/02/17
 * Time: 9:38 PM
 */
App::uses('Component', 'Controller');

class FileComponent extends Component {
    /** @var array holds all the file areas [name => path] */
    private $file_areas = [];

    /**
     * This is run before the controllers beforeFilter function
     * all it does is make sure that all the file areas exist.
     * @param Controller $controller
     */
    public function initialize(Controller $controller){
        $this->file_areas['SampleSet_Metadata'] = WWW_ROOT.'files'.DS.'sampleset'.DS.'metadata'.DS;
        $this->file_areas['Metabolites_Document'] = WWW_ROOT.'files'.DS.'unknowns'.DS;
        // Define more file areas here.

        // Creates the file areas if the do not exist.
        foreach ($this->file_areas as $file_area_path){
            if (!is_dir($file_area_path)) {
                mkdir($file_area_path, 0777, true);
            }
        }
        parent::initialize($controller);
    }

    /**
     * Creates a new file area on the fly.
     * Should not have to use this. If the file area is permanent then add it to the file_areas array
     * @param string $area_name
     * @param string $area_path in the form
     * @throws Exception
     */
    public function createFileArea($area_name, $area_path){
        if (strpos($area_path, '..') !== false){
            throw new Exception('Please do not use .. in a file area path');
        }
        if (!empty($this->file_areas[$area_name])){
            throw new Exception('A filearea with the name \''.$area_name.'\' already exists');
        }
        $area_path = WWW_ROOT.$area_path;
        if (!is_dir($area_path)) {
            mkdir($area_path, 0777, true);
        }
        $this->file_areas[$area_name] = $area_path;
    }

    /**
     * Moves the uploaded file into the file area
     * @param array $file
     * @param string $file_area index of the filearea
     * @param string $new_name the name of the file
     * @param bool $overwrite
     * @return mixed
     * @throws Exception
     */
    public function uploadFile($file, $file_area, $new_name, $overwrite = false){
        if (strpos($new_name, '..') !== false){
            throw new Exception('Please do not use .. in a file name');
        }
        if (!$overwrite && file_exists($this->get_file_area($file_area).$new_name)){
            throw new Exception('The file that as tried to be uploaded already exists. File: '.$this->get_file_area($file_area).$new_name);
        }
        if (move_uploaded_file($file['tmp_name'],  $this->get_file_area($file_area).$new_name)){
            chmod($this->get_file_area($file_area).$new_name, 0777);
            return $new_name;
        } else {
            throw new Exception('There was an error uploading the file');
        }
    }

    /**
     * Gets a file area throws exception when it doesnt exists
     * @param $area_name
     * @return mixed
     * @throws Exception
     */
    private function get_file_area($area_name){
        if (empty($this->file_areas[$area_name])){
            throw new Exception('The file area with the name \''.$area_name.'\' does not exist');
        } else {
            return $this->file_areas[$area_name];
        }
    }
}