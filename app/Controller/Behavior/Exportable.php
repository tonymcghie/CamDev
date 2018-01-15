<?php

/**
 * Class Exportable
 * makes a controller able to export data as csv
 *
 * @author Andrew McGhie
 */
trait Exportable {

    public abstract function getModel();

    private function getExportableComponents() {
        return ['Search'];
    }

    public function export() {
        $query = $this->Search->build_query($this->getModel(), $this->request->query);
        $search_results = $this->getModel()->find('all', ['conditions' => $query]);
        $modelname = get_class($this->getModel());
        $this->set('model', $modelname);
        $this->set('data', $search_results);
        $this->response->download("{$modelname}_data_export.csv");
        $this->layout = 'ajax';
        $this->render('/Elements/export');
    }

}