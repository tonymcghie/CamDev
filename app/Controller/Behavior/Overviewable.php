<?php

/**
 * This is a trait that should only be applied to AppController classes
 * requires model variable to be set
 * Class Overviewable
 */
trait Overviewable {

    protected abstract function getModel();

    private function getOverviewableComponents() {
        return ['Search', 'Paginator'];
    }


    /**
     * This will search the model for some data based on
     */
    public function overview(){
        assert(is_subclass_of($this, 'AppController'),
            'This method must be attached to a controller');
        assert(in_array('OverviewableModel', class_implements($this->getModel())),
            'The model needs to implement OverviewableModel');

        $this->set('model', get_class($this->getModel()));
        $this->set('options', $this->getModel()->getOverviewOptions());
        $this->helpers[] = 'Mustache.Mustache';
        $this->doOverview(); //this should be in the if statment below; moved here for testing
        var_dump($this->request->query);  //this seems to be empty - need to find out why?
        if (!empty($this->request->query)) {
            //$this->Paginator->settings = $this->paginate;
            //list($resultObjects, $numResults) = $this->doOverview();
            $this->doOverview();

            $this->set('results', $resultObjects);
            $this->set('num', $numResults);
            $this->set('data', $this->request->query);
            $this->set('cols', $this->getModel()->getOverviewDisplayColumns());
        }

        $this->autoRender = false;
        $this->render('/Elements/overview_page');
    }

    private function doOverview() {
        $query = "SELECT DISTINCT experiment_reference FROM cam_data.molecular_features as Molecular_features WHERE crop LIKE '%kiwi%';";
        //$query = $this->Search->build_overview_query($this->getModel(), $this->request->query);
        var_dump('Overviewable ',$query);
        //$results = $this->LogfileRecord->find('all',
    //array('fields'=>array('DISTINCT date'), 
          //'order'=>array('date DESC'))
//);
        $results = $this->paginate($this->getModel(), $query);

        //$resultObjects = $this->getModel()->buildObjects($results);
        $numResults = $this->getModel()->find('count', ['conditions' => $query]);

        return [$resultObjects, $numResults];
    }
}