<?php

/**
 * Class Importable
 * makes the controller able to import a file from csv
 *
 * @author Andrew McGhie
 */
trait Importable {
    private $linesToShow = 6;

    protected abstract function getModel();

    private function getImportableComponents() {
        return ['Flash'];
    }

    public function import() {
        $modelname = get_class($this->getModel());
        $this->set('model', $modelname);

        if ($this->request->is('post')) {
            $data = $this->request->data;

            $file = fopen($data[$modelname]['fileUrl'],"r");
            fgetcsv($file); // Skip titles
            $toSave = [];
            while ($line = fgetcsv($file)){
                $newRow = [];
                foreach($data[$modelname]['cols'] as $index => $dbCol){
                    if ($dbCol == 'exclude' || $dbCol == 'id') continue;
                    $newRow[$dbCol] = isset($line[$index]) ? $line[$index] : null;
                }
                $newRow['importfile'] = $data['importfile'];
                array_push($toSave, $newRow);
            }
            if ($this->getModel()->saveMany($toSave)){
                $this->set('class', 'alert-success');
                $this->set('message', 'Import Successful');
            } else {
                $this->set('class', 'alert-danger');
                $this->set('message', 'Something went wrong. Unable to save imported data');
            }
        }

        $this->render('/Elements/import/import');
    }

    public function uploadcsv() {
        $this->layout = 'ajax';
        $this->autoRender = false;

        $uploadedImageData = $this->request->params['form']['importfile'];
        if ($uploadedImageData['error'] != 0) {
            $this->response->statusCode(418);
            $this->response->send();
            return;
        }

        $extension = pathinfo($uploadedImageData['name'])['extension'];
        if ($extension != 'csv') {
            throw new Exception("The File Uploaded was not a csv file");
        }

        $modelname = get_class($this->getModel());
        $newFilePath = 'data/files/compoundpfrData/' . $modelname . '_' . time() . '.csv';
        $newFilePath = 'data/tmp/' . $modelname . '_' . time() . '.csv';
        $success = move_uploaded_file($uploadedImageData['tmp_name'], $newFilePath);

        if (!$success) {
            $this->response->statusCode(418);
            $this->response->send();
            return;
        }
        echo json_encode(['filename' => $newFilePath]);
    }

    public function preview() {
        $this->layout = 'ajax';
        $this->helpers[] = 'BootstrapForm';
        $this->helpers[] = 'String';

        $filename = json_decode($this->request->data['filename'], true)['filename'];
        $file = fopen($filename, 'r');
        $lines = [];
        for ($linenumber = 0; $linenumber < $this->linesToShow; $linenumber++) {
            $line = fgetcsv($file, 0, ',', '"');
            if (empty($line)) {
                continue;
            }
            $lines[] = $line;
        }
        fclose($file);

        $this->set('model', get_class($this->getModel()));
        $this->set('options', array_keys($this->getModel()->schema()));
        $this->set('data', $lines);

        $this->render('/Elements/import/preview');
    }

}