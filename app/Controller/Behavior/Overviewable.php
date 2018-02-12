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

        if (!empty($this->request->query)) {
            var_dump($this->request->query);
            $this->Paginator->settings = $this->paginate;
            list($numResults) = $this->doOverview();
            //$this->doOverview();

            //$this->set('results', $resultObjects);
            $this->set('num', $numResults);
            $this->set('data', $this->request->query);
            $this->set('cols', $this->getModel()->getOverviewDisplayColumns());
        }

        $this->autoRender = false;
        $this->render('/Elements/overview_page');
    }

    private function doOverview() {
        //$query = "SELECT DISTINCT experiment_reference FROM cam_data.molecular_features as Molecular_features WHERE crop LIKE '%kiwi%';";
        //$query = $this->Search->build_overview_query($this->getModel(), $this->request->query);
        //var_dump('Overviewable ',$query);
        //$results = $this->LogfileRecord->find('all',
        //array('fields'=>array('DISTINCT date'), 
        //'order'=>array('date DESC'))
        //);
        
        // Cannot get the SQL working correclty
        // the second statment finds records but with no conditions
        //$results = $this->getModel()->find('all', array(
       //'fields' => 'DISTINCT experiment_reference',
       //'conditions' => array('crop' => '%kiwi%')
    //));
        $results = $this->getModel()->find('all',
                array('fields'=>array('DISTINCT experiment_reference')));
        //$results = $this->paginate($this->getModel(), $query);
        var_dump('Results: ', $results);

        //$resultObjects = $this->getModel()->buildObjects($results);
        $numResults = $this->getModel()->find('count', ['conditions' => $query]);

        return [$numResults];
    }
}