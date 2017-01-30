<?php
class FileController extends AppController {
    public $helpers = ['Html' , 'Form' , 'Js', 'BootstrapForm'];
    public $uses = [];
    public $layout = 'MinLayout';
    public $components = ['Session', 'Cookie', 'Auth'];

    private $file_areas = [
        'temp' => 'webroot/data/tmp/',
        'SampleSet_metadata' => 'webroot/data/SampleSet/metadata/'
    ];

    public function uploadFile(){
        if($this->request->is('post')){
            $file = $this->request->data['File']['file'];
            $new_url =  WWW_ROOT . DS . 'data' . DS . 'tmp' . DS . $file['name'];
            if (move_uploaded_file($file['tmp_name'], $new_url)) {
                chmod($new_url, 775);
                $this->set('file_url', $new_url);
                $this->set('name', $file['name']);
                $this->render('uploadResult');
            } else {
                $this->set('error', 'There was an error');
            }
        }
    }

    public function uploadResult() {

    }
}